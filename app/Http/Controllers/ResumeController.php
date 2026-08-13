<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Display a listing of the resumes.
     */
    public function index(): View
    {
        $resumes = Resume::when(auth()->check(), function ($query) {
            $query->where('user_id', auth()->id());
        }, function ($query) {
            $query->whereNull('user_id');
        })->orderBy('updated_at', 'desc')->get();

        $isFallback = $this->gemini->isFallback();
        $templates = Resume::$templates;

        return view('resumes.index', compact('resumes', 'isFallback', 'templates'));
    }

    /**
     * Store a newly created resume in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'target_profile' => 'required|string|in:student,fresh_graduate,career_changer,job_seeker',
            'target_role' => 'nullable|string|max:255',
            'template_style' => 'required|string|in:' . implode(',', array_keys(Resume::$templates)),
        ]);

        // Pre-populate structural arrays to avoid UI errors and provide a clean start
        $resume = Resume::create([
            'title' => $validated['title'],
            'target_profile' => $validated['target_profile'],
            'target_role' => $validated['target_role'] ?? '',
            'template_style' => $validated['template_style'],
            'user_id' => auth()->id(),
            'personal_info' => [
                'name' => '',
                'email' => '',
                'phone' => '',
                'location' => '',
                'linkedin' => '',
                'github' => '',
                'website' => '',
            ],
            'summary' => '',
            'experience' => [],
            'education' => [],
            'projects' => [],
            'skills' => [
                'technical' => '',
                'soft' => '',
                'tools' => '',
            ],
            'section_order' => ['summary', 'experience', 'projects', 'education', 'skills'],
            'hidden_sections' => [],
        ]);

        return redirect()->route('resumes.show', $resume->id);
    }

    /**
     * Display the specified resume.
     */
    public function show(Resume $resume): View
    {
        $this->authorizeResume($resume);
        $isFallback = $this->gemini->isFallback();
        $templates = Resume::$templates;
        return view('resumes.show', compact('resume', 'isFallback', 'templates'));
    }

    /**
     * Update the specified resume in storage (Autosave endpoint).
     */
    public function update(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'template_style' => 'nullable|string|in:' . implode(',', array_keys(Resume::$templates)),
            'target_profile' => 'nullable|string|in:student,fresh_graduate,career_changer,job_seeker',
            'target_role' => 'nullable|string|max:255',
            'personal_info' => 'nullable|array',
            'summary' => 'nullable|string',
            'experience' => 'nullable|array',
            'education' => 'nullable|array',
            'projects' => 'nullable|array',
            'skills' => 'nullable|array',
            'section_order' => 'nullable|array',
            'hidden_sections' => 'nullable|array',
        ]);

        // Clean arrays
        if (isset($validated['experience'])) {
            $validated['experience'] = array_values($validated['experience']);
        }
        if (isset($validated['education'])) {
            $validated['education'] = array_values($validated['education']);
        }
        if (isset($validated['projects'])) {
            $validated['projects'] = array_values($validated['projects']);
        }

        $resume->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Resume autosaved successfully.',
            'updated_at' => $resume->updated_at->toIso8601String(),
        ]);
    }

    /**
     * Remove the specified resume from storage.
     */
    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorizeResume($resume);
        $resume->delete();

        return redirect()->route('resumes.index')->with('success', 'Resume deleted successfully.');
    }

    /**
     * AI Endpoint: Generate Summary.
     */
    public function aiSummary(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'target_role' => 'required|string',
            'target_profile' => 'required|string',
            'skills' => 'nullable|array',
            'experience' => 'nullable|array',
        ]);

        $summary = $this->gemini->generateSummary(
            $validated['target_role'],
            $validated['target_profile'],
            $validated['skills'] ?? [],
            $validated['experience'] ?? []
        );

        return response()->json(['summary' => $summary]);
    }

    /**
     * AI Endpoint: Improve Bullet Point.
     */
    public function aiImproveBullet(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'bullet' => 'required|string',
            'target_role' => 'required|string',
            'target_profile' => 'required|string',
        ]);

        $improved = $this->gemini->improveBulletPoint(
            $validated['bullet'],
            $validated['target_role'],
            $validated['target_profile']
        );

        return response()->json(['improved' => $improved]);
    }

    /**
     * AI Endpoint: Translate Career Change.
     */
    public function aiCareerTranslate(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'previous_role' => 'required|string',
            'target_role' => 'required|string',
            'experience_description' => 'required|string',
        ]);

        $translated = $this->gemini->translateCareerChange(
            $validated['previous_role'],
            $validated['target_role'],
            $validated['experience_description']
        );

        return response()->json(['translated' => $translated]);
    }

    /**
     * AI Endpoint: Analyze ATS Compatibility.
     */
    public function aiAtsAnalyze(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'job_description' => 'required|string',
        ]);

        $analysis = $this->gemini->analyzeAts($resume->toArray(), $validated['job_description']);

        return response()->json($analysis);
    }

    /**
     * AI Endpoint: Generate Content Suggestions.
     */
    public function aiSuggestions(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'target_role' => 'required|string|max:255',
            'target_profile' => 'required|string|in:student,fresh_graduate,career_changer,job_seeker',
        ]);

        $suggestions = $this->gemini->generateSuggestions(
            $validated['target_role'],
            $validated['target_profile']
        );

        return response()->json($suggestions);
    }

    /**
     * AI Endpoint: Generate Cover Letter.
     */
    public function aiGenerateCoverLetter(Request $request, Resume $resume): JsonResponse
    {
        $this->authorizeResume($resume);
        $validated = $request->validate([
            'job_description' => 'required|string',
        ]);

        $coverLetter = $this->gemini->generateCoverLetter($resume->toArray(), $validated['job_description']);

        return response()->json([
            'cover_letter' => $coverLetter
        ]);
    }
    /**
     * Duplicate the specified resume as a new version.
     */
    public function duplicate(Resume $resume): RedirectResponse
    {
        $this->authorizeResume($resume);

        $newResume = $resume->replicate();
        $newResume->title = $resume->title . ' (Copy)';
        $newResume->save();

        return redirect()->route('resumes.index')->with('success', 'Resume version created successfully.');
    }

    /**
     * Display the public share view of a resume.
     */
    public function share(Resume $resume): View
    {
        $templates = Resume::$templates;
        return view('resumes.share', compact('resume', 'templates'));
    }
    /**
     * Authorize access to a resume.
     */
    protected function authorizeResume(Resume $resume): void
    {
        if ($resume->user_id !== null && (!auth()->check() || $resume->user_id !== auth()->id())) {
            abort(403, 'Unauthorized action.');
        }
    }
}
