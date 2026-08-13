<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected ?string $apiKey;
    protected string $model;
    protected bool $isFallbackMode = false;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model', 'gemini-2.5-flash');

        if (empty($this->apiKey)) {
            $this->isFallbackMode = true;
        }
    }

    /**
     * Check if the service is running in fallback mock mode.
     */
    public function isFallback(): bool
    {
        return $this->isFallbackMode;
    }

    /**
     * Generate a professional summary.
     */
    public function generateSummary(string $targetRole, string $profileType, array $skills, array $experience): string
    {
        $skillsList = implode(', ', $skills);
        $expSummary = collect($experience)->map(fn($e) => ($e['position'] ?? '') . ' at ' . ($e['company'] ?? ''))->filter()->implode(', ');

        if ($this->isFallbackMode) {
            return $this->getMockSummary($targetRole, $profileType, $skillsList, $expSummary);
        }

        $prompt = "You are an expert resume writer. Generate a professional summary (3-4 sentences, about 60-80 words) for a candidate's resume.
Target Role: {$targetRole}
Audience Profile: {$profileType} (e.g., student, fresh graduate, career changer, job seeker)
Key Skills: {$skillsList}
Experience: {$expSummary}

Write a highly compelling, professional, and action-oriented summary. Do not include any intro, outro, markdown boxes, or quotes. Just output the raw text of the summary.";

        try {
            $response = $this->callGemini($prompt);
            return trim($response);
        } catch (\Exception $e) {
            Log::error('Gemini API Error (Summary): ' . $e->getMessage());
            return $this->getMockSummary($targetRole, $profileType, $skillsList, $expSummary) . ' (Note: Simulated response shown due to API offline state)';
        }
    }

    /**
     * Improve a bullet point from work experience.
     */
    public function improveBulletPoint(string $bulletPoint, string $targetRole, string $profileType): string
    {
        if ($this->isFallbackMode || empty(trim($bulletPoint))) {
            return $this->getMockImprovedBullet($bulletPoint, $targetRole, $profileType);
        }

        $prompt = "You are an expert resume writer. Optimize and improve the following resume work experience bullet point to make it more professional, impactful, and action-oriented. Where possible, suggest metrics/numbers and use strong action verbs (e.g., Designed, Spearheaded, Optimized).
Original Bullet Point: \"{$bulletPoint}\"
Target Role: {$targetRole}
Candidate Profile: {$profileType}

Provide only ONE improved bullet point. Do not start with a bullet symbol (* or -). Do not include any intro, explanation, or outro. Output only the improved text.";

        try {
            $response = $this->callGemini($prompt);
            return ltrim(trim($response), '-* ');
        } catch (\Exception $e) {
            Log::error('Gemini API Error (Bullet Improvement): ' . $e->getMessage());
            return $this->getMockImprovedBullet($bulletPoint, $targetRole, $profileType) . ' (Simulated)';
        }
    }

    /**
     * Translate career achievements from a previous domain to a new target domain.
     */
    public function translateCareerChange(string $previousRole, string $targetRole, string $experienceDescription): string
    {
        if ($this->isFallbackMode || empty(trim($experienceDescription))) {
            return $this->getMockCareerTranslation($previousRole, $targetRole, $experienceDescription);
        }

        $prompt = "You are an expert career transition coach. Translate the following experience or achievements from a previous role/industry into bullet points optimized for a target role, highlighting transferable skills (such as project management, communication, analysis, problem-solving, or technology translation).
Previous Role: {$previousRole}
Target Role: {$targetRole}
Original Experience/Achievements: \"{$experienceDescription}\"

Provide 2-3 highly tailored, professional bullet points starting with strong action verbs. Format them with a dash (-) at the beginning of each bullet point, separated by newlines. Do not include any explanations or intro text.";

        try {
            return trim($this->callGemini($prompt));
        } catch (\Exception $e) {
            Log::error('Gemini API Error (Career Translate): ' . $e->getMessage());
            return $this->getMockCareerTranslation($previousRole, $targetRole, $experienceDescription);
        }
    }

    /**
     * Generate AI content suggestions (skills, bullets, projects) for a resume.
     *
     * @return array{
     *     technical_skills: list<string>,
     *     soft_skills: list<string>,
     *     tools: list<string>,
     *     experience_bullets: list<string>,
     *     projects: list<array{title: string, technologies: string, description: string}>
     * }
     */
    public function generateSuggestions(string $targetRole, string $profileType): array
    {
        if ($this->isFallbackMode || empty(trim($targetRole))) {
            return $this->getMockSuggestions($targetRole, $profileType);
        }

        $prompt = "You are an expert resume coach and career advisor. Generate practical, high-impact resume content suggestions for a candidate.
Target Role: {$targetRole}
Candidate Profile: {$profileType} (student | fresh_graduate | career_changer | job_seeker)

Return ONLY a raw JSON object with no markdown, no code fences, and no explanation. Use exactly this structure:
{
  \"technical_skills\": [\"Skill 1\", \"Skill 2\", \"Skill 3\", \"Skill 4\", \"Skill 5\", \"Skill 6\"],
  \"soft_skills\": [\"Skill 1\", \"Skill 2\", \"Skill 3\", \"Skill 4\"],
  \"tools\": [\"Tool 1\", \"Tool 2\", \"Tool 3\", \"Tool 4\"],
  \"experience_bullets\": [
    \"Action verb + measurable achievement relevant to the target role (1)\",
    \"Action verb + measurable achievement relevant to the target role (2)\",
    \"Action verb + measurable achievement relevant to the target role (3)\"
  ],
  \"projects\": [
    { \"title\": \"Project Name\", \"technologies\": \"Tech1, Tech2\", \"description\": \"One sentence description.\" },
    { \"title\": \"Project Name 2\", \"technologies\": \"Tech3, Tech4\", \"description\": \"One sentence description.\" }
  ]
}";

        try {
            $response = trim($this->callGemini($prompt));

            // Strip any accidental markdown code fences
            if (str_starts_with($response, '```')) {
                $response = preg_replace('/^```(?:json)?\s+|\s+```$/', '', $response);
            }

            $decoded = json_decode($response, true);

            if (is_array($decoded) && isset($decoded['technical_skills'])) {
                return $decoded;
            }

            throw new \Exception('Invalid JSON structure returned: ' . substr($response, 0, 100));
        } catch (\Exception $e) {
            Log::error('Gemini API Error (Suggestions): ' . $e->getMessage());

            return $this->getMockSuggestions($targetRole, $profileType);
        }
    }

    /**
     * Perform ATS keyword matching and analysis.
     */
    public function analyzeAts(array $resumeData, string $jobDescription): array
    {
        if ($this->isFallbackMode || empty(trim($jobDescription))) {
            return $this->getMockAtsAnalysis($resumeData, $jobDescription);
        }

        $resumeJson = json_encode($resumeData);
        $prompt = "You are an advanced Applicant Tracking System (ATS) scanner and recruiter. Analyze the following candidate resume data against the target job description.
Resume Data: {$resumeJson}
Job Description: \"{$jobDescription}\"

You MUST respond in valid JSON format with the following keys:
{
  \"score\": 75, // integer between 0 and 100 representing how well the resume matches the job description
  \"missing_keywords\": [\"React\", \"CI/CD\"], // array of 4-6 key technical or soft keywords present in the job description but missing or weak in the resume
  \"strengths\": [\"Bullet point 1\", \"Bullet point 2\"], // array of 2-3 strengths matching the job requirements
  \"recommendations\": [\"Recommendation 1\", \"Recommendation 2\"] // array of 3-4 actionable recommendations to improve the resume match
}
Do not include any markdown fences (like ```json) or leading/trailing text. Output only the raw JSON string.";

        try {
            $response = trim($this->callGemini($prompt));
            
            // Clean markdown blocks if LLM accidentally outputs them
            if (str_starts_with($response, '```')) {
                $response = preg_replace('/^```(?:json)?\s+|\s+```$/', '', $response);
            }

            $decoded = json_decode($response, true);
            if (is_array($decoded) && isset($decoded['score'])) {
                return $decoded;
            }

            throw new \Exception("Invalid JSON structure returned: " . substr($response, 0, 100));
        } catch (\Exception $e) {
            Log::error('Gemini API Error (ATS Analysis): ' . $e->getMessage());
            return $this->getMockAtsAnalysis($resumeData, $jobDescription);
        }
    }

    /**
     * Call the Gemini API.
     */
    protected function callGemini(string $prompt): string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 1024,
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(12)->post($url, $payload);

        if ($response->failed()) {
            throw new \Exception('Gemini API request failed with status ' . $response->status() . ': ' . $response->body());
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        return $text;
    }

    /**
     * Generate a tailored cover letter.
     */
    public function generateCoverLetter(array $resumeData, string $jobDescription): string
    {
        if ($this->isFallbackMode || empty(trim($jobDescription))) {
            return $this->getMockCoverLetter($resumeData, $jobDescription);
        }

        $resumeJson = json_encode($resumeData);
        $prompt = "You are an expert career consultant and professional resume/cover letter writer. Write a highly tailored, compelling cover letter (around 250-350 words) for a candidate applying to a job.
Resume Data: {$resumeJson}
Job Description: \"{$jobDescription}\"

Write a cover letter that consists of:
1. Contact info placeholder section or header.
2. Salutation (e.g., Dear Hiring Manager,).
3. Opening hook addressing the specific role and company if discernible, or generally showing enthusiasm for the job description.
4. Body paragraphs drawing connections between the candidate's experience, achievements, and skills from their resume and the job requirements.
5. A strong call-to-action closing and sign-off (e.g., Sincerely, [Candidate Name]).

Do not include any intro notes, explanations, or formatting wrappers like markdown blocks. Output only the plain text of the cover letter.";

        try {
            return trim($this->callGemini($prompt));
        } catch (\Exception $e) {
            Log::error('Gemini API Error (Cover Letter): ' . $e->getMessage());
            return $this->getMockCoverLetter($resumeData, $jobDescription) . "\n\n(Note: Simulated response shown due to API offline state)";
        }
    }

    protected function getMockCoverLetter(array $resumeData, string $jobDescription): string
    {
        $name = data_get($resumeData, 'personal_info.name') ?: 'John Doe';
        $email = data_get($resumeData, 'personal_info.email') ?: 'john.doe@example.com';
        $phone = data_get($resumeData, 'personal_info.phone') ?: '(555) 019-2834';
        $location = data_get($resumeData, 'personal_info.location') ?: 'San Francisco, CA';
        $targetRole = data_get($resumeData, 'target_role') ?: 'Software Engineer';
        $summary = data_get($resumeData, 'summary') ?: 'A dedicated professional with a track record of success.';
        
        $skills = collect(data_get($resumeData, 'skills', []))->flatten()->implode(', ');
        $skillsText = $skills ? "My technical expertise spans across: {$skills}." : "";

        return "[Date]\n\n" .
            "{$name}\n" .
            "{$location}\n" .
            "{$phone}\n" .
            "{$email}\n\n" .
            "Dear Hiring Manager,\n\n" .
            "I am writing to express my strong interest in the {$targetRole} position. With my background and hands-on experience, I am confident that I can make a significant contribution to your team's success.\n\n" .
            "{$summary}\n\n" .
            "Throughout my career, I have developed a strong foundation in problem-solving and software development practices. {$skillsText} I take pride in collaborating with teams to deliver clean, scalable solutions and driving projects from concept to completion.\n\n" .
            "I am eager to bring my enthusiasm and skills to your organization and would welcome the opportunity to discuss how my experiences align with your needs. Thank you for your time and consideration.\n\n" .
            "Sincerely,\n\n" .
            "{$name}";
    }

    // ==========================================
    // MOCK DATA GENERATORS (FALLBACK MODE)
    // ==========================================

    protected function getMockSummary(string $targetRole, string $profileType, string $skills, string $experience): string
    {
        $role = $targetRole ?: 'Professional';
        
        if ($profileType === 'student') {
            return "Motivated and detail-oriented student specializing in {$role}, possessing strong academic foundation and hands-on project experience in {$skills}. Eager to apply collaborative problem-solving skills and technical competencies in a challenging internship or entry-level role. Proven ability to quickly master new tools and contribute to team milestones.";
        }

        if ($profileType === 'fresh_graduate') {
            return "Recent graduate with a degree in a relevant field, transitioning into a professional {$role} position. Equipped with solid academic training, practical project experience, and technical expertise in {$skills}. Proven self-starter and adaptive learner ready to deliver high-quality support and drive developer velocity within a dynamic team environment.";
        }

        if ($profileType === 'career_changer') {
            return "Versatile and results-driven professional transitioning into {$role}, leveraging a strong background in {$experience}. Combines transferrable skills in cross-functional coordination, problem-solving, and analysis with technical capabilities in {$skills}. Highly motivated to bring a unique, multi-disciplinary perspective to a new team.";
        }

        return "Results-oriented {$role} with a proven track record of designing, building, and deploying robust solutions. Proficient in {$skills} with experienced capabilities in {$experience}. Adept at leading collaborative engineering cycles, optimizing workflows, and aligning technical implementations with business objectives.";
    }

    protected function getMockImprovedBullet(string $bulletPoint, string $targetRole, string $profileType): string
    {
        if (empty(trim($bulletPoint))) {
            return "Collaborated with cross-functional teams to design and implement features for " . ($targetRole ?: 'target projects') . ", improving application performance by 20%.";
        }

        // Clean bullet formatting
        $bullet = ltrim(trim($bulletPoint), '-* ');

        // Add metrics/action verbs based on common topics
        if (preg_match('/(write|code|create|make|develop)/i', $bullet)) {
            return "Spearheaded development and deployment of clean, maintainable components for " . ($targetRole ?: 'the platform') . ", reducing feature delivery latency by 15%.";
        }

        if (preg_match('/(bug|fix|error|solve)/i', $bullet)) {
            return "Identified and resolved critical system performance bottlenecks and bugs, enhancing application stability and raising user retention metrics.";
        }

        if (preg_match('/(database|sql|db)/i', $bullet)) {
            return "Designed and optimized database schemas and indexes, leading to a 35% speedup in query executions and reduced server memory overhead.";
        }

        return "Engineered and optimized " . lcfirst($bullet) . ", aligning with industry best practices and increasing overall process efficiency by 25%.";
    }

    protected function getMockCareerTranslation(string $previousRole, string $targetRole, string $experienceDescription): string
    {
        return "- Translated core expertise in {$previousRole} into actionable strategies for {$targetRole}, streamlining project delivery cycles.
- Leveraged strong cross-functional communication and problem-solving skills from previous domain to manage software development expectations and coordinate tasks.
- Applied analytical techniques to diagnose workflow bottlenecks, introducing automated tracking processes that improved productivity.";
    }

    protected function getMockAtsAnalysis(array $resumeData, string $jobDescription): array
    {
        // Simple matching logic
        $skills = collect(data_get($resumeData, 'skills', []))->flatten()->implode(' ');
        $desc = strtolower($jobDescription);

        $keywords = ['React', 'Vue.js', 'Laravel', 'TypeScript', 'PHP', 'Docker', 'AWS', 'CI/CD', 'Agile', 'Testing', 'Database', 'SQL', 'Git', 'APIs', 'REST', 'Collaboration', 'Communication'];
        $missing = [];
        $matched = [];

        foreach ($keywords as $kw) {
            $kwLower = strtolower($kw);
            if (str_contains($desc, $kwLower)) {
                if (!str_contains(strtolower($skills), $kwLower)) {
                    $missing[] = $kw;
                } else {
                    $matched[] = $kw;
                }
            }
        }

        $missing = array_slice(array_unique($missing), 0, 5);
        if (empty($missing)) {
            $missing = ['Scalability', 'Unit Testing', 'System Design'];
        }

        // Calculate a mock score
        $matchCount = count($matched);
        $totalTarget = count($matched) + count($missing);
        $score = $totalTarget > 0 ? (int) (($matchCount / $totalTarget) * 100) : 65;
        $score = max(40, min(95, $score)); // clamp between 40 and 95

        return [
            'score' => $score,
            'missing_keywords' => $missing,
            'strengths' => [
                "Clear alignment with the target role " . (data_get($resumeData, 'target_role') ?: 'Professional') . ".",
                "Well-structured sections highlighting relevant competencies.",
            ],
            'recommendations' => [
                "Incorporate missing keywords like " . implode(', ', array_slice($missing, 0, 3)) . " into your Professional Summary and Skills section.",
                "Quantify your accomplishments in the Experience section using percentages, time savings, or financial metrics (e.g., 'Improved performance by 20%').",
                "Ensure your Professional Summary explicitly mentions your target role: '" . (data_get($resumeData, 'target_role') ?: 'Target Role') . "'."
            ]
        ];
    }

    /**
     * @return array{
     *     technical_skills: list<string>,
     *     soft_skills: list<string>,
     *     tools: list<string>,
     *     experience_bullets: list<string>,
     *     projects: list<array{title: string, technologies: string, description: string}>
     * }
     */
    protected function getMockSuggestions(string $targetRole, string $profileType): array
    {
        $role = $targetRole ?: 'Software Developer';

        // Role-aware skill defaults
        $technicalSkills = ['PHP', 'Laravel', 'JavaScript', 'SQL', 'REST APIs', 'Git'];
        $tools = ['VS Code', 'Git', 'Postman', 'Docker'];

        if (preg_match('/(frontend|react|vue|ui|css)/i', $role)) {
            $technicalSkills = ['React', 'Vue.js', 'TypeScript', 'HTML5', 'CSS3', 'Tailwind CSS'];
            $tools = ['Figma', 'VS Code', 'Webpack', 'Vite'];
        } elseif (preg_match('/(backend|api|server|laravel|node)/i', $role)) {
            $technicalSkills = ['PHP', 'Laravel', 'Node.js', 'MySQL', 'Redis', 'REST APIs'];
            $tools = ['Docker', 'Postman', 'MySQL Workbench', 'Git'];
        } elseif (preg_match('/(data|analyst|python|ml|machine)/i', $role)) {
            $technicalSkills = ['Python', 'Pandas', 'NumPy', 'SQL', 'Tableau', 'Machine Learning'];
            $tools = ['Jupyter Notebook', 'VS Code', 'Google Colab', 'Tableau'];
        } elseif (preg_match('/(devops|cloud|aws|infra)/i', $role)) {
            $technicalSkills = ['AWS', 'Docker', 'Kubernetes', 'CI/CD', 'Terraform', 'Linux'];
            $tools = ['GitHub Actions', 'Jenkins', 'AWS Console', 'Terraform'];
        }

        $softSkills = match ($profileType) {
            'student' => ['Analytical Thinking', 'Team Collaboration', 'Time Management', 'Adaptability'],
            'fresh_graduate' => ['Problem Solving', 'Communication', 'Critical Thinking', 'Self-Motivation'],
            'career_changer' => ['Cross-functional Leadership', 'Stakeholder Communication', 'Process Improvement', 'Adaptability'],
            default => ['Team Leadership', 'Project Management', 'Strategic Thinking', 'Communication'],
        };

        $bullets = match ($profileType) {
            'student' => [
                "Developed a {$role}-focused capstone project using modern frameworks, reducing manual data processing time by 40%.",
                "Collaborated with a 4-person academic team to design and deliver a full-stack application ahead of schedule.",
                "Implemented automated test suites for core application modules, achieving 90%+ code coverage.",
            ],
            'fresh_graduate' => [
                "Designed and deployed a production-ready {$role} application serving 200+ users with zero downtime.",
                "Optimized database query performance by 35% through indexing strategies and efficient Eloquent patterns.",
                "Contributed 15+ pull requests to an open-source project, improving documentation and core functionality.",
            ],
            'career_changer' => [
                "Leveraged cross-functional leadership background to coordinate {$role} project delivery across 3 departments.",
                "Translated domain expertise into technical solutions, reducing operational overhead by 25%.",
                "Built automated workflows integrating legacy systems with modern APIs, saving 10+ manual hours per week.",
            ],
            default => [
                "Architected and shipped a scalable {$role} system handling 10,000+ daily active users with 99.9% uptime.",
                "Led a team of 4 engineers to deliver a critical feature 2 weeks ahead of schedule, increasing revenue by 18%.",
                "Reduced API response times by 50% through caching strategies and query optimization.",
            ],
        };

        $projects = [
            [
                'title' => "{$role} Portfolio Dashboard",
                'technologies' => implode(', ', array_slice($technicalSkills, 0, 3)),
                'description' => "Built a personal dashboard to showcase {$role} projects and track professional milestones.",
            ],
            [
                'title' => 'Automated Task Management CLI',
                'technologies' => implode(', ', array_slice($technicalSkills, 1, 3)),
                'description' => "Developed a command-line tool to automate repetitive workflows, saving 5+ hours per week.",
            ],
        ];

        return [
            'technical_skills' => $technicalSkills,
            'soft_skills' => $softSkills,
            'tools' => $tools,
            'experience_bullets' => $bullets,
            'projects' => $projects,
        ];
    }
}
