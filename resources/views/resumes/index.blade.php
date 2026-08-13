@extends('layouts.app')

@section('title', 'Dashboard - AI Resume Builder')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ showCreateModal: false }">
    
    <!-- Fallback Mode Banner -->
    @if($isFallback)
    <div class="mb-8 p-4 rounded-2xl bg-indigo-950/40 border border-indigo-800/40 backdrop-blur-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-400 mt-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <div>
                <h4 class="font-semibold text-indigo-200">AI Demo Mode Active</h4>
                <p class="text-sm text-slate-400 mt-0.5">The app is using high-quality local templates. Add your <code class="px-1.5 py-0.5 bg-slate-900 rounded border border-slate-800 text-indigo-300 text-xs">GEMINI_API_KEY</code> in the <code class="px-1.5 py-0.5 bg-slate-900 rounded border border-slate-800 text-indigo-300 text-xs">.env</code> file to enable live Google Gemini AI recommendations!</p>
            </div>
        </div>
        <a href="https://aistudio.google.com/" target="_blank" class="text-xs font-semibold px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-white transition-colors shrink-0 text-center">
            Get Free Gemini Key &rarr;
        </a>
    </div>
    @endif

    <!-- Hero Section -->
    <div class="text-center py-8">
        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400">
            Create an ATS-Optimized Resume in Minutes
        </h1>
        <p class="mt-4 text-lg text-slate-400 max-w-2xl mx-auto">
            AI-powered suggestions, tailored bullet points, career translators, and ATS analytics. Specially curated for job success.
        </p>
        <button @click="showCreateModal = true" class="mt-8 inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-tr from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white rounded-2xl font-semibold shadow-xl shadow-indigo-500/10 hover:shadow-indigo-500/20 active:scale-[0.98] transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Build Your Resume
        </button>
    </div>

    <!-- Audience Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
        <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-900 hover:border-slate-800/80 transition-all flex flex-col justify-between group">
            <div>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-200">Students</h3>
                <p class="text-sm text-slate-400 mt-2">Highlight academic projects, courses, club leadership, and internships with custom guidance.</p>
            </div>
            <span class="text-xs text-blue-400 font-semibold mt-4 block">Student Profiles &rarr;</span>
        </div>

        <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-900 hover:border-slate-800/80 transition-all flex flex-col justify-between group">
            <div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-200">Fresh Graduates</h3>
                <p class="text-sm text-slate-400 mt-2">Focus on core capabilities, certifications, and GPA metrics to bridge the lack of industry experience.</p>
            </div>
            <span class="text-xs text-emerald-400 font-semibold mt-4 block">Graduate Templates &rarr;</span>
        </div>

        <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-900 hover:border-slate-800/80 transition-all flex flex-col justify-between group">
            <div>
                <div class="w-10 h-10 rounded-xl bg-violet-500/10 text-violet-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-200">Career Changers</h3>
                <p class="text-sm text-slate-400 mt-2">Translate achievements from your previous field into high-impact, transferable skills for your target role.</p>
            </div>
            <span class="text-xs text-violet-400 font-semibold mt-4 block">AI Skill Translator &rarr;</span>
        </div>

        <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-900 hover:border-slate-800/80 transition-all flex flex-col justify-between group">
            <div>
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-200">Job Seekers</h3>
                <p class="text-sm text-slate-400 mt-2">Perfect your formatting, run real-time ATS match reviews, and generate compelling summaries.</p>
            </div>
            <span class="text-xs text-amber-400 font-semibold mt-4 block">ATS Optimization &rarr;</span>
        </div>
    </div>

    <!-- Saved Resumes Section -->
    <div class="mt-16">
        <div class="flex items-center justify-between border-b border-slate-900 pb-4 mb-6">
            <h2 class="text-2xl font-bold text-slate-100">Your Resumes</h2>
            <span class="text-sm text-slate-400">{{ $resumes->count() }} Resumes saved</span>
        </div>

        @if($resumes->isEmpty())
        <div class="text-center py-16 px-6 border border-dashed border-slate-800 rounded-3xl bg-slate-900/10">
            <svg class="w-12 h-12 text-slate-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <h3 class="text-lg font-bold text-slate-300">No resumes found</h3>
            <p class="text-sm text-slate-500 mt-2 max-w-sm mx-auto">Create a professional resume using AI tools by clicking the button below.</p>
            <button @click="showCreateModal = true" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600/90 hover:bg-indigo-500 text-white rounded-xl font-medium text-sm transition-colors">
                Create Draft
            </button>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($resumes as $resume)
            <div class="p-6 rounded-2xl border border-slate-900 bg-slate-950/60 hover:bg-slate-900/20 hover:border-slate-800 transition-all flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] uppercase font-bold tracking-widest px-2.5 py-0.5 rounded-full bg-slate-900 text-slate-400 border border-slate-800">
                            {{ str_replace('_', ' ', $resume->target_profile) }}
                        </span>
                        <span class="text-xs text-slate-500">
                            {{ $resume->updated_at->diffForHumans() }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-200 group-hover:text-indigo-400 transition-colors">
                        {{ $resume->title }}
                    </h3>

                    @if($resume->target_role)
                    <p class="text-sm text-slate-400 mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $resume->target_role }}
                    </p>
                    @endif

                    <div class="mt-4 flex gap-1.5 text-xs">
                        <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-850 text-slate-400">
                            Template: {{ ucfirst($resume->template_style) }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between border-t border-slate-900 pt-4">
                    <a href="{{ route('resumes.show', $resume->id) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-400 hover:text-indigo-300 transition-colors">
                        Edit Resume
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <div class="flex items-center gap-1">
                        <!-- Duplicate Version Button -->
                        <form action="{{ route('resumes.duplicate', $resume->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-slate-600 hover:text-indigo-400 transition-colors" title="Create New Version (Duplicate)">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                </svg>
                            </button>
                        </form>

                        <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this resume?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-600 hover:text-red-400 transition-colors" title="Delete Resume">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Create Modal Overlay -->
    <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showCreateModal" x-cloak>
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="showCreateModal = false"></div>

        <!-- Modal Dialog -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 sm:p-8"
                 x-show="showCreateModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-100">Create New Resume</h3>
                    <button @click="showCreateModal = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('resumes.store') }}" method="POST" class="mt-6 space-y-5">
                    @csrf
                    <div>
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Resume Document Title</label>
                        <input type="text" name="title" id="title" required placeholder="e.g. Software Engineer Resume 2026"
                               class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-100 placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm focus:outline-none transition-colors">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="target_profile" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Target Profile</label>
                            <select name="target_profile" id="target_profile" required
                                    class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm focus:outline-none transition-colors">
                                <option value="student">Student</option>
                                <option value="fresh_graduate">Fresh Graduate</option>
                                <option value="job_seeker">Job Seeker</option>
                                <option value="career_changer">Career Changer</option>
                            </select>
                        </div>

                        <div>
                            <label for="template_style" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Visual Layout</label>
                            <select name="template_style" id="template_style" required
                                    class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm focus:outline-none transition-colors">
                                @foreach($templates as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="target_role" class="block text-xs font-bold uppercase tracking-wider text-slate-400">Target Role / Occupation (Optional)</label>
                        <input type="text" name="target_role" id="target_role" placeholder="e.g. Junior Web Developer"
                               class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-100 placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm focus:outline-none transition-colors">
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-800 mt-6">
                        <button type="button" @click="showCreateModal = false"
                                class="px-5 py-2.5 bg-slate-950 hover:bg-slate-900 border border-slate-850 text-slate-350 rounded-xl text-sm font-semibold transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/20 active:scale-[0.98] transition-all">
                            Start Building
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
