@extends('layouts.app')

@section('title', $resume->title . ' - Builder')

@section('content')
<div x-data="resumeBuilder({{ json_encode($resume) }})" x-init="init()" class="min-h-[calc(100vh-4rem)] flex flex-col bg-slate-950">
    
    <!-- Top Workspace Header -->
    <div class="no-print bg-slate-900/40 border-b border-slate-900 px-4 py-3 flex flex-wrap items-center justify-between gap-4 sticky top-16 z-40 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="p-1.5 rounded-xl bg-slate-950 border border-slate-850 hover:bg-slate-900 text-slate-400 hover:text-slate-200 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <input type="text" x-model="title" 
                       class="bg-transparent border-0 font-bold text-slate-100 focus:outline-none focus:ring-0 text-lg px-0 py-0 w-64 hover:bg-slate-950/20 focus:bg-slate-950/40 rounded px-2" 
                       placeholder="Untitled Resume">
                <div class="flex items-center gap-1.5 mt-0.5 px-2">
                    <span class="text-[10px] uppercase font-extrabold tracking-wider px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                        {{ str_replace('_', ' ', $resume->target_profile) }}
                    </span>
                    <!-- Autosave Indicator -->
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 ml-2">
                        <template x-if="saveStatus === 'saved'">
                            <span class="flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Autosaved
                            </span>
                        </template>
                        <template x-if="saveStatus === 'saving'">
                            <span class="flex items-center gap-1">
                                <svg class="animate-spin w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </template>
                        <template x-if="saveStatus === 'error'">
                            <span class="flex items-center gap-1 text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Save Error
                            </span>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <!-- Template Switcher Dropdown -->
            <div class="relative no-print" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="inline-flex items-center justify-between gap-2 px-4 py-2.5 bg-slate-950 hover:bg-slate-900 border border-slate-850 rounded-xl text-xs font-semibold text-slate-350 hover:text-white transition-colors min-w-[170px]">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                        <span x-text="{'modern': 'Impact Modern', 'classic': 'Classic Executive', 'minimal': 'Minimalist Tech', 'slate': 'Professional Slate', 'creative': 'Creative Teal', 'emerald': 'Emerald Professional', 'royal': 'Royal Executive', 'border': 'Minimalist Border', 'warm': 'Warm Editorial', 'ruby': 'Ruby Elite', 'sidebar': 'Modern Sidebar', 'double': 'Double Column', 'corporate': 'Compact Corporate', 'charcoal': 'Elegant Charcoal', 'startup': 'Tech Startup', 'bold': 'Bold Header'}[template_style] || 'Select Template'"></span>
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-56 rounded-xl bg-slate-900 border border-slate-800 shadow-xl z-50 max-h-80 overflow-y-auto p-1.5 scroll-smooth">
                    @foreach($templates as $key => $name)
                        <button @click="template_style = '{{ $key }}'; open = false" 
                                :class="template_style === '{{ $key }}' ? 'bg-indigo-600 text-white font-semibold' : 'text-slate-450 hover:text-slate-200 hover:bg-slate-850'" 
                                class="w-full text-left px-3 py-2 rounded-lg text-xs transition-colors flex items-center justify-between">
                            <span>{{ $name }}</span>
                            <template x-if="template_style === '{{ $key }}'">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </template>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- ATS Scan -->
            <button @click="openAtsModal = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-950 hover:bg-slate-900 border border-slate-850 rounded-xl text-xs font-semibold text-slate-350 hover:text-white transition-colors">
                <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                ATS Match Check
            </button>

            <!-- Cover Letter Generator -->
            <button @click="openCoverLetterModal = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-950 hover:bg-slate-900 border border-slate-850 rounded-xl text-xs font-semibold text-slate-350 hover:text-white transition-colors">
                <svg class="w-4 h-4 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Write Cover Letter
            </button>

            <!-- Share Link -->
            <button @click="shareResume()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-950 hover:bg-slate-900 border border-slate-850 rounded-xl text-xs font-semibold text-slate-350 hover:text-white transition-colors">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 10.742l-2.618-1.51M8.684 13.258l-2.618 1.51m8.684-3.5a3.372 3.372 0 100-3.358 3.372 3.372 0 000 3.358zm0 5a3.372 3.372 0 100-3.358 3.372 3.372 0 000 3.358zm-9.368-5a3.372 3.372 0 100-3.358 3.372 3.372 0 000 3.358z" />
                </svg>
                Share Link
            </button>

            <!-- Export Resume (PDF) -->
            <button @click="window.print()" 
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-gradient-to-tr from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 rounded-xl text-xs font-bold text-white shadow-lg shadow-indigo-500/10 active:scale-[0.98] transition-all no-print">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Export PDF
            </button>
        </div>
    </div>

    <!-- Workspace Main Body -->
    <div class="flex-grow flex flex-row overflow-hidden">
        
        <!-- Left Panel: Form Editor -->
        <div class="no-print w-1/2 border-r border-slate-900 overflow-hidden h-[calc(100vh-7.5rem)] flex">
            
            <!-- Icon Sidebar Menu -->
            <div class="w-16 bg-slate-950 border-r border-slate-900 flex flex-col items-center py-6 gap-6 shrink-0">
                <button @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Personal Info">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </button>
                <button @click="activeTab = 'summary'" :class="activeTab === 'summary' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Professional Summary">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                <button @click="activeTab = 'experience'" :class="activeTab === 'experience' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Work Experience">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </button>
                <button @click="activeTab = 'education'" :class="activeTab === 'education' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Education">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </button>
                <button @click="activeTab = 'projects'" :class="activeTab === 'projects' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Projects">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </button>
                <button @click="activeTab = 'skills'" :class="activeTab === 'skills' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Skills">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </button>
                <button @click="activeTab = 'sections'" :class="activeTab === 'sections' ? 'bg-indigo-500/10 text-indigo-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all" title="Manage Section Order">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <!-- AI Suggestions Tab -->
                <button @click="activeTab = 'suggestions'" :class="activeTab === 'suggestions' ? 'bg-gradient-to-b from-violet-500/20 to-indigo-500/10 text-violet-400' : 'text-slate-500 hover:text-slate-350'" class="p-3 rounded-xl transition-all relative" title="AI Content Suggestions">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-violet-500 rounded-full border-2 border-slate-950 animate-pulse"></span>
                </button>
            </div>

            <!-- Tab Content Pane -->
            <div class="flex-grow p-6 overflow-y-auto bg-slate-950/20" @mouseenter="highlightSection = activeTab" @mouseleave="highlightSection = ''">
                
                <!-- PERSONAL TAB -->
                <div x-show="activeTab === 'personal'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3">
                        <h3 class="text-lg font-bold text-slate-200">Personal Information</h3>
                        <p class="text-xs text-slate-500 mt-1">This forms the header contact section of your resume.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Full Name</label>
                            <input type="text" x-model="personal_info.name" class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm transition-colors">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Email Address</label>
                                <input type="email" x-model="personal_info.email" class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Phone Number</label>
                                <input type="text" x-model="personal_info.phone" class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm transition-colors">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Location (City, State)</label>
                                <input type="text" x-model="personal_info.location" class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Target Role / Subtitle</label>
                                <input type="text" x-model="target_role" class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm transition-colors">
                            </div>
                        </div>

                        <div class="border-t border-slate-900 pt-4 mt-6">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Links & Profiles</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold">LinkedIn Slug</label>
                                    <input type="text" x-model="personal_info.linkedin" placeholder="in/username" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3.5 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold">GitHub Username</label>
                                    <input type="text" x-model="personal_info.github" placeholder="username" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3.5 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                </div>
                                <div>
                                    <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold">Personal Website</label>
                                    <input type="text" x-model="personal_info.website" placeholder="portfolio.com" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3.5 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUMMARY TAB -->
                <div x-show="activeTab === 'summary'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-200">Professional Summary</h3>
                            <p class="text-xs text-slate-500 mt-1">Brief pitch outlining your career direction and core values.</p>
                        </div>
                        <button @click="generateAiSummary()" :disabled="aiSummaryLoading"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 rounded-xl text-xs font-semibold disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            <span x-show="!aiSummaryLoading">✨ AI Generate</span>
                            <span x-show="aiSummaryLoading">⚡ Generating...</span>
                        </button>
                    </div>

                    <div>
                        <textarea x-model="summary" rows="8" placeholder="Draft your professional summary here, or click the AI Generate button to create one customized to your skills and role..."
                                  class="block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed transition-colors"></textarea>
                    </div>
                </div>

                <!-- EXPERIENCE TAB -->
                <div x-show="activeTab === 'experience'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-200">Work Experience</h3>
                            <p class="text-xs text-slate-500 mt-1">Add previous employment, internships, or leadership positions.</p>
                        </div>
                        <button @click="addExperience()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-slate-850 border border-slate-800 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            + Add Entry
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(exp, index) in experience" :key="index">
                            <div draggable="true"
                                 @dragstart="draggedEntryIndex = index"
                                 @dragover.prevent
                                 @drop="moveEntry('experience', draggedEntryIndex, index); draggedEntryIndex = null"
                                 class="p-5 rounded-2xl border border-slate-900 bg-slate-950/40 relative group cursor-grab active:cursor-grabbing hover:border-indigo-500/30 transition-all">
                                <div class="absolute top-4 right-12 flex items-center">
                                    <span class="p-1 rounded-lg text-slate-600 hover:text-indigo-400 cursor-move" title="Drag to reorder">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </span>
                                </div>
                                <button @click="removeExperience(index)" class="absolute top-4 right-4 p-1.5 rounded-lg text-slate-600 hover:text-red-400 transition-colors" title="Delete Entry">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Company</label>
                                        <input type="text" x-model="exp.company" placeholder="e.g. Acme Corp" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Job Title</label>
                                        <input type="text" x-model="exp.position" placeholder="e.g. Intern Developer" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 mt-3">
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Location</label>
                                        <input type="text" x-model="exp.location" placeholder="e.g. Remote" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Start Date</label>
                                        <input type="text" x-model="exp.start_date" placeholder="e.g. Jun 2025" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">End Date</label>
                                        <input type="text" x-model="exp.end_date" placeholder="e.g. Present" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                </div>

                                <div class="mt-4 border-t border-slate-900 pt-4">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold">Description / Achievements</label>
                                        <div class="flex items-center gap-2">
                                            <!-- Career Changer Translator -->
                                            @if($resume->target_profile === 'career_changer')
                                            <button @click="triggerCareerChangeModal(index)" type="button"
                                                    class="inline-flex items-center gap-1 text-[10px] px-2 py-1 bg-violet-500/10 hover:bg-violet-500/20 text-violet-400 border border-violet-500/20 rounded transition-all">
                                                🔄 AI Career Translate
                                            </button>
                                            @endif
                                            <!-- Bullet Optimizer -->
                                            <button @click="improveExperienceBullet(index)" type="button" :disabled="aiBulletLoading[index]"
                                                    class="inline-flex items-center gap-1 text-[10px] px-2 py-1 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 rounded disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                                                <span x-show="!aiBulletLoading[index]">✨ AI Polish</span>
                                                <span x-show="aiBulletLoading[index]">⚡ Polishing...</span>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea x-model="exp.description" rows="4" placeholder="- Developed application backends...&#10;- Configured relational databases..." 
                                              class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs leading-relaxed transition-colors"></textarea>
                                </div>
                            </div>
                        </template>

                        <template x-if="experience.length === 0">
                            <div class="text-center py-10 border border-dashed border-slate-900 rounded-2xl bg-slate-950/20">
                                <p class="text-xs text-slate-500">No work experience entries yet. Click "+ Add Entry" to start.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- EDUCATION TAB -->
                <div x-show="activeTab === 'education'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-200">Education</h3>
                            <p class="text-xs text-slate-500 mt-1">Specify your degree, school, and academic highlights.</p>
                        </div>
                        <button @click="addEducation()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-slate-850 border border-slate-800 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            + Add Entry
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(edu, index) in education" :key="index">
                            <div draggable="true"
                                 @dragstart="draggedEntryIndex = index"
                                 @dragover.prevent
                                 @drop="moveEntry('education', draggedEntryIndex, index); draggedEntryIndex = null"
                                 class="p-5 rounded-2xl border border-slate-900 bg-slate-950/40 relative group cursor-grab active:cursor-grabbing hover:border-indigo-500/30 transition-all">
                                <div class="absolute top-4 right-12 flex items-center">
                                    <span class="p-1 rounded-lg text-slate-600 hover:text-indigo-400 cursor-move" title="Drag to reorder">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </span>
                                </div>
                                <button @click="removeEducation(index)" class="absolute top-4 right-4 p-1.5 rounded-lg text-slate-600 hover:text-red-400 transition-colors" title="Delete Entry">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Institution / School</label>
                                        <input type="text" x-model="edu.school" placeholder="e.g. Stanford University" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Degree & Major</label>
                                        <input type="text" x-model="edu.degree" placeholder="e.g. BS Computer Science" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 mt-3">
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Location</label>
                                        <input type="text" x-model="edu.location" placeholder="e.g. Stanford, CA" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Graduation Date</label>
                                        <input type="text" x-model="edu.graduation_date" placeholder="e.g. May 2026" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">GPA / Honors (Optional)</label>
                                        <input type="text" x-model="edu.gpa" placeholder="e.g. 3.8 / Cum Laude" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="education.length === 0">
                            <div class="text-center py-10 border border-dashed border-slate-900 rounded-2xl bg-slate-950/20">
                                <p class="text-xs text-slate-500">No education entries yet. Click "+ Add Entry" to start.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- PROJECTS TAB -->
                <div x-show="activeTab === 'projects'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-200">Projects</h3>
                            <p class="text-xs text-slate-500 mt-1">Include key engineering efforts or freelance jobs.</p>
                        </div>
                        <button @click="addProject()" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-slate-850 border border-slate-800 text-slate-300 rounded-xl text-xs font-semibold transition-colors">
                            + Add Entry
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(proj, index) in projects" :key="index">
                            <div draggable="true"
                                 @dragstart="draggedEntryIndex = index"
                                 @dragover.prevent
                                 @drop="moveEntry('projects', draggedEntryIndex, index); draggedEntryIndex = null"
                                 class="p-5 rounded-2xl border border-slate-900 bg-slate-950/40 relative group cursor-grab active:cursor-grabbing hover:border-indigo-500/30 transition-all">
                                <div class="absolute top-4 right-12 flex items-center">
                                    <span class="p-1 rounded-lg text-slate-600 hover:text-indigo-400 cursor-move" title="Drag to reorder">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </span>
                                </div>
                                <button @click="removeProject(index)" class="absolute top-4 right-4 p-1.5 rounded-lg text-slate-600 hover:text-red-400 transition-colors" title="Delete Entry">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Project Name</label>
                                        <input type="text" x-model="proj.title" placeholder="e.g. AI Resume Builder" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Technologies Used</label>
                                        <input type="text" x-model="proj.technologies" placeholder="e.g. Laravel, PHP, SQLite" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="block text-[10px] text-slate-500 uppercase tracking-widest font-bold">Project Link (Optional)</label>
                                    <input type="text" x-model="proj.link" placeholder="e.g. github.com/username/project" class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                </div>

                                <div class="mt-4">
                                    <label class="block text-[10px] text-slate-400 uppercase tracking-widest font-bold">Project Summary</label>
                                    <textarea x-model="proj.description" rows="3" placeholder="Designed and built a self-contained AI web app using Gemini..." 
                                              class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-3 py-2 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-xs leading-relaxed transition-colors"></textarea>
                                </div>
                            </div>
                        </template>

                        <template x-if="projects.length === 0">
                            <div class="text-center py-10 border border-dashed border-slate-900 rounded-2xl bg-slate-950/20">
                                <p class="text-xs text-slate-500">No project entries yet. Click "+ Add Entry" to start.</p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- SKILLS TAB -->
                <div x-show="activeTab === 'skills'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-200">Skills</h3>
                            <p class="text-xs text-slate-500 mt-1">Highlight technical, soft, and tool capabilities.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Technical Skills</label>
                            <span class="text-[10px] text-slate-500 block mt-0.5">Separate with commas (e.g. PHP, Laravel, Tailwind, Javascript, Git)</span>
                            <textarea x-model="skills.technical" rows="3" placeholder="e.g. PHP, Laravel, SQL, Git, API Development"
                                      class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed transition-colors"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Soft Skills</label>
                            <span class="text-[10px] text-slate-500 block mt-0.5">e.g. Collaboration, Active Listening, Project Coordination</span>
                            <textarea x-model="skills.soft" rows="3" placeholder="e.g. Team Collaboration, Critical Thinking, Project Management"
                                      class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed transition-colors"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Tools & Platforms</label>
                            <span class="text-[10px] text-slate-500 block mt-0.5">e.g. Docker, AWS, Laragon, Vite, JIRA</span>
                            <textarea x-model="skills.tools" rows="3" placeholder="e.g. Docker, AWS, VS Code, Git, Figma"
                                      class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed transition-colors"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION ORDER TAB -->
                <div x-show="activeTab === 'sections'" class="space-y-6">
                    <div class="border-b border-slate-900 pb-3">
                        <h3 class="text-lg font-bold text-slate-200">Manage Section Order</h3>
                        <p class="text-xs text-slate-500 mt-1">Drag and drop the sections below to reorder how they appear on your resume.</p>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(sec, index) in section_order" :key="sec">
                            <div draggable="true"
                                 @dragstart="draggedSectionIndex = index"
                                 @dragover.prevent
                                 @drop="moveSection(draggedSectionIndex, index); draggedSectionIndex = null"
                                 class="flex items-center justify-between p-4 bg-slate-900/40 border border-slate-800 rounded-xl cursor-grab active:cursor-grabbing hover:border-indigo-500/50 transition-all">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                    <span class="text-sm font-semibold text-slate-250" x-text="{
                                        'summary': 'Professional Summary',
                                        'experience': 'Work Experience',
                                        'projects': 'Key Projects',
                                        'education': 'Education',
                                        'skills': 'Skills'
                                    }[sec]"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- AI SUGGESTIONS TAB -->
                <div x-show="activeTab === 'suggestions'" class="space-y-5">
                    <!-- Header -->
                    <div class="border-b border-slate-900 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg bg-gradient-to-br from-violet-500 to-indigo-500 shadow-lg shadow-violet-500/20">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </span>
                            <h3 class="text-lg font-bold text-slate-200">AI Content Suggestions</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1.5">Generate role-specific skills, experience bullets, and project ideas. Click any suggestion to instantly add it to your resume.</p>
                    </div>

                    <!-- Generate Panel -->
                    <div class="bg-gradient-to-br from-violet-500/5 to-indigo-500/5 border border-violet-500/15 rounded-2xl p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Target Role</label>
                                <input type="text" x-model="suggestionsRole" placeholder="e.g. Laravel Developer"
                                       class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-800 px-3 py-2 text-slate-200 focus:border-violet-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Profile Type</label>
                                <select x-model="suggestionsProfile"
                                        class="mt-1.5 block w-full rounded-xl bg-slate-950 border border-slate-800 px-3 py-2 text-slate-200 focus:border-violet-500 focus:outline-none focus:ring-0 text-xs transition-colors">
                                    <option value="student">Student</option>
                                    <option value="fresh_graduate">Fresh Graduate</option>
                                    <option value="career_changer">Career Changer</option>
                                    <option value="job_seeker">Job Seeker</option>
                                </select>
                            </div>
                        </div>
                        <button id="btn-generate-suggestions"
                                @click="generateSuggestions()"
                                :disabled="aiSuggestionsLoading || !suggestionsRole.trim()"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-xl text-xs font-bold shadow-lg shadow-violet-500/20 active:scale-[0.98] transition-all">
                            <template x-if="!aiSuggestionsLoading">
                                <span class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Generate Suggestions
                                </span>
                            </template>
                            <template x-if="aiSuggestionsLoading">
                                <span class="flex items-center gap-2">
                                    <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Generating...
                                </span>
                            </template>
                        </button>
                    </div>

                    <!-- Results Area -->
                    <div x-show="aiSuggestionsGenerated" class="space-y-5">

                        <!-- Skills Suggestions -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <span class="w-4 h-4 rounded bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-[9px]">⚡</span>
                                Technical Skills
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="skill in aiSuggestionsData.technical_skills" :key="skill">
                                    <button @click="addSuggestedSkill('technical', skill)"
                                            class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 hover:border-indigo-500/40 text-indigo-300 hover:text-indigo-200 rounded-full text-xs font-medium transition-all active:scale-95">
                                        <span x-text="skill"></span>
                                        <span class="opacity-0 group-hover:opacity-100 text-indigo-400 transition-opacity">+</span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <span class="w-4 h-4 rounded bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-[9px]">✓</span>
                                Soft Skills
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="skill in aiSuggestionsData.soft_skills" :key="skill">
                                    <button @click="addSuggestedSkill('soft', skill)"
                                            class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 hover:border-emerald-500/40 text-emerald-300 hover:text-emerald-200 rounded-full text-xs font-medium transition-all active:scale-95">
                                        <span x-text="skill"></span>
                                        <span class="opacity-0 group-hover:opacity-100 text-emerald-400 transition-opacity">+</span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <span class="w-4 h-4 rounded bg-amber-500/20 text-amber-400 flex items-center justify-center text-[9px]">🔧</span>
                                Tools & Platforms
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="tool in aiSuggestionsData.tools" :key="tool">
                                    <button @click="addSuggestedSkill('tools', tool)"
                                            class="group inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 hover:border-amber-500/40 text-amber-300 hover:text-amber-200 rounded-full text-xs font-medium transition-all active:scale-95">
                                        <span x-text="tool"></span>
                                        <span class="opacity-0 group-hover:opacity-100 text-amber-400 transition-opacity">+</span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Experience Bullets -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <span class="w-4 h-4 rounded bg-violet-500/20 text-violet-400 flex items-center justify-center text-[9px]">★</span>
                                Experience Bullets
                            </h4>
                            <div class="space-y-2">
                                <template x-for="bullet in aiSuggestionsData.experience_bullets" :key="bullet">
                                    <div class="flex items-start gap-2 p-3 bg-slate-950/60 border border-slate-900 hover:border-violet-500/30 rounded-xl group transition-all">
                                        <p class="text-xs text-slate-300 leading-relaxed flex-grow" x-text="bullet"></p>
                                        <button @click="addSuggestedExperience(bullet)"
                                                class="shrink-0 px-2.5 py-1 bg-violet-500/10 hover:bg-violet-500/20 border border-violet-500/20 text-violet-400 rounded-lg text-[10px] font-semibold opacity-0 group-hover:opacity-100 transition-all active:scale-95 whitespace-nowrap">
                                            + Add
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Project Ideas -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                <span class="w-4 h-4 rounded bg-rose-500/20 text-rose-400 flex items-center justify-center text-[9px]">◈</span>
                                Project Ideas
                            </h4>
                            <div class="space-y-2">
                                <template x-for="project in aiSuggestionsData.projects" :key="project.title">
                                    <div class="p-3.5 bg-slate-950/60 border border-slate-900 hover:border-rose-500/30 rounded-xl group transition-all">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex-grow">
                                                <p class="text-xs font-bold text-slate-200" x-text="project.title"></p>
                                                <p class="text-[10px] text-violet-400 font-medium mt-0.5" x-text="project.technologies"></p>
                                                <p class="text-[10px] text-slate-400 mt-1 leading-relaxed" x-text="project.description"></p>
                                            </div>
                                            <button @click="addSuggestedProject(project)"
                                                    class="shrink-0 px-2.5 py-1 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 text-rose-400 rounded-lg text-[10px] font-semibold opacity-0 group-hover:opacity-100 transition-all active:scale-95 whitespace-nowrap">
                                                + Add
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div x-show="!aiSuggestionsGenerated && !aiSuggestionsLoading" class="text-center py-10 border border-dashed border-slate-900 rounded-2xl bg-slate-950/20">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500/10 to-indigo-500/10 border border-violet-500/10 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-violet-400/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Enter your target role and click<br><span class="text-violet-400">"Generate Suggestions"</span> to get started.</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Panel: Live Resume Preview -->
        <div class="w-1/2 bg-slate-900/30 overflow-y-auto h-[calc(100vh-7.5rem)] flex justify-center py-6 px-4 scroll-smooth">
            <div id="print-sheet-content" class="print-sheet w-full max-w-[21cm] bg-white text-slate-900 shadow-2xl rounded-sm transition-all duration-300"
                 :class="{
                     ['template-' + template_style]: true,
                     'border-2 border-indigo-500/50 shadow-indigo-500/5': highlightSection !== ''
                 }">

                @foreach($templates as $key => $name)
                    <template x-if="template_style === '{{ $key }}'">
                        @include('resumes.templates.' . $key)
                    </template>
                @endforeach

                <!-- Footer: Centered page count or custom text -->
                <div class="text-[8pt] text-slate-400 text-center border-t border-slate-100 pt-3 mt-6 px-[1.5cm] pb-4 no-print">
                    Page 1 of 1 &bull; Generated with AI Resume Builder
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- OVERLAY MODAL: ATS MATCH SCAN -->
    <!-- ========================================== -->
    <div class="fixed inset-0 z-50 overflow-y-auto no-print" x-show="openAtsModal" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="openAtsModal = false"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl p-6 sm:p-8"
                 x-show="openAtsModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        ATS Compatibility Scan
                    </h3>
                    <button @click="openAtsModal = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 space-y-6" x-show="!atsLoading && !atsScanned">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Target Job Description</label>
                        <p class="text-[10px] text-slate-500 mt-0.5">Copy/paste the exact text from the job listing to scan for keyword compliance.</p>
                        <textarea x-model="jobDescription" rows="8" placeholder="Paste the job description here (e.g. requirements, responsibilities, technical stacks)..."
                                  class="mt-2.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed focus:outline-none transition-colors"></textarea>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-800">
                        <button type="button" @click="openAtsModal = false"
                                class="px-5 py-2.5 bg-slate-950 hover:bg-slate-900 border border-slate-850 text-slate-350 rounded-xl text-sm font-semibold transition-colors">
                            Cancel
                        </button>
                        <button type="button" @click="runAtsScan()" :disabled="!jobDescription.trim()"
                                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/20 active:scale-[0.98] transition-all">
                            Scan Resume
                        </button>
                    </div>
                </div>

                <!-- ATS Loader -->
                <div class="mt-8 text-center py-12" x-show="atsLoading">
                    <svg class="animate-spin h-10 w-10 text-indigo-500 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-sm text-slate-400 font-medium">AI is analyzing keyword density and matching competencies...</p>
                </div>

                <!-- ATS Results -->
                <div class="mt-6 space-y-6" x-show="!atsLoading && atsScanned" x-cloak>
                    <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-2xl bg-slate-950/40 border border-slate-850">
                        <!-- Score circle -->
                        <div class="relative w-24 h-24 flex items-center justify-center shrink-0">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="48" cy="48" r="40" stroke="#1e293b" stroke-width="8" fill="transparent" />
                                <circle cx="48" cy="48" r="40" stroke="#6366f1" stroke-width="8" fill="transparent"
                                        :stroke-dasharray="2 * Math.PI * 40"
                                        :stroke-dashoffset="2 * Math.PI * 40 * (1 - atsResult.score / 100)"
                                        stroke-linecap="round" />
                            </svg>
                            <span class="absolute text-2xl font-black text-slate-100" x-text="atsResult.score + '%'"></span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-200" x-text="atsResult.score >= 80 ? 'Excellent Match!' : (atsResult.score >= 60 ? 'Moderate Match' : 'Weak Alignment')"></h4>
                            <p class="text-xs text-slate-400 mt-1">This compatibility score evaluates keywords, experience headers, and skills listings against your target job post.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Missing Keywords -->
                        <div class="p-5 rounded-2xl border border-slate-850/60 bg-slate-950/10">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-red-400">Missing Keywords</h5>
                            <p class="text-[10px] text-slate-500 mt-1">Consider adding these terms to pass automated recruiters:</p>
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                <template x-for="kw in atsResult.missing_keywords">
                                    <span class="px-2.5 py-0.5 bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-semibold rounded" x-text="kw"></span>
                                </template>
                            </div>
                        </div>

                        <!-- Strengths -->
                        <div class="p-5 rounded-2xl border border-slate-850/60 bg-slate-950/10">
                            <h5 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Matching Strengths</h5>
                            <ul class="mt-3 space-y-2 text-xs text-slate-350">
                                <template x-for="str in atsResult.strengths">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span x-text="str"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <!-- Recommendations -->
                    <div class="p-5 rounded-2xl border border-slate-850 bg-slate-950/20">
                        <h5 class="text-xs font-bold uppercase tracking-wider text-indigo-400">AI Recommendations</h5>
                        <ul class="mt-3 space-y-2.5 text-xs text-slate-350">
                            <template x-for="rec in atsResult.recommendations">
                                <li class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mt-1.5 shrink-0"></span>
                                    <span x-text="rec"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="pt-4 flex items-center justify-between border-t border-slate-800">
                        <button type="button" @click="atsScanned = false"
                                class="px-4 py-2 bg-slate-950 hover:bg-slate-900 border border-slate-850 text-slate-350 rounded-xl text-xs font-semibold transition-colors">
                            &larr; Re-scan
                        </button>
                        <button type="button" @click="openAtsModal = false"
                                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition-colors">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- OVERLAY MODAL: CAREER CHANGER TRANSLATOR -->
    <!-- ========================================== -->
    <div class="fixed inset-0 z-50 overflow-y-auto no-print" x-show="openCareerModal" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="openCareerModal = false"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-6 sm:p-8"
                 x-show="openCareerModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                        🔄 Transferable Skills Translator
                    </h3>
                    <button @click="openCareerModal = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 space-y-5" x-show="!careerLoading">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Previous Role Title</label>
                        <input type="text" x-model="careerChangerInput.previous_role" placeholder="e.g. Sales Associate"
                               class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Target Role Title</label>
                        <input type="text" x-model="careerChangerInput.target_role" placeholder="e.g. Technical Support Engineer"
                               class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-2.5 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">What did you do there? (Explain in simple terms)</label>
                        <textarea x-model="careerChangerInput.experience_description" rows="4" placeholder="e.g. I helped customers with their problems, wrote reports, and taught new staff how to use our sales software."
                                  class="mt-2 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed focus:outline-none transition-colors"></textarea>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-800 mt-6">
                        <button type="button" @click="openCareerModal = false"
                                class="px-5 py-2.5 bg-slate-950 hover:bg-slate-900 border border-slate-850 text-slate-350 rounded-xl text-sm font-semibold transition-colors">
                            Cancel
                        </button>
                        <button type="button" @click="translateCareerChange()"
                                :disabled="!careerChangerInput.previous_role || !careerChangerInput.target_role || !careerChangerInput.experience_description"
                                class="px-5 py-2.5 bg-violet-600 hover:bg-violet-500 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-xl text-sm font-semibold shadow-lg shadow-violet-500/20 active:scale-[0.98] transition-all">
                            Translate to Target Role
                        </button>
                    </div>
                </div>

                <!-- Career Changer Loader -->
                <div class="mt-8 text-center py-12" x-show="careerLoading">
                    <svg class="animate-spin h-10 w-10 text-violet-500 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-sm text-slate-400 font-medium">Rephrasing accomplishments to target domain standards...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile/Tablet Toggle Button for Preview -->
    <div class="lg:hidden fixed bottom-6 right-6 z-50 no-print">
        <button @click="showPreviewOnMobile = !showPreviewOnMobile" 
                class="flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-bold rounded-full shadow-lg shadow-indigo-500/30 active:scale-95 transition-all text-sm">
            <template x-if="!showPreviewOnMobile">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Preview
                </span>
            </template>
            <template x-if="showPreviewOnMobile">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Resume
                </span>
            </template>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- OVERLAY MODAL: COVER LETTER GENERATOR -->
    <!-- ========================================== -->
    <div class="fixed inset-0 z-50 overflow-y-auto no-print" x-show="openCoverLetterModal" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="openCoverLetterModal = false"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl p-6 sm:p-8"
                 x-show="openCoverLetterModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                    <h3 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        AI Cover Letter Generator
                    </h3>
                    <button @click="openCoverLetterModal = false; coverLetterResult = ''" class="p-1 rounded-lg text-slate-400 hover:text-slate-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 space-y-6" x-show="!coverLetterLoading && !coverLetterResult">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400">Target Job Description</label>
                        <p class="text-[10px] text-slate-500 mt-0.5">Paste the details of the job you are applying to. The AI will align your cover letter specifically to this job.</p>
                        <textarea x-model="coverLetterJobDescription" rows="8" placeholder="Paste target job requirements and role description here..."
                                  class="mt-2.5 block w-full rounded-xl bg-slate-950 border border-slate-850 px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-0 text-sm leading-relaxed transition-colors"></textarea>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-800">
                        <button type="button" @click="openCoverLetterModal = false"
                                class="px-5 py-2.5 bg-slate-950 hover:bg-slate-900 border border-slate-850 text-slate-350 rounded-xl text-sm font-semibold transition-colors">
                            Cancel
                        </button>
                        <button type="button" @click="generateCoverLetter()" :disabled="!coverLetterJobDescription.trim()"
                                class="px-5 py-2.5 bg-violet-600 hover:bg-violet-500 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-xl text-sm font-semibold shadow-lg shadow-violet-500/20 active:scale-[0.98] transition-all">
                            Generate Cover Letter
                        </button>
                    </div>
                </div>

                <!-- Cover Letter Loader -->
                <div class="mt-8 text-center py-12" x-show="coverLetterLoading">
                    <svg class="animate-spin h-10 w-10 text-violet-500 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-4 text-sm text-slate-400 font-medium">Crafting a tailored cover letter from your resume details...</p>
                </div>

                <!-- Cover Letter Results -->
                <div class="mt-6 space-y-6" x-show="!coverLetterLoading && coverLetterResult" x-cloak>
                    <div class="p-5 rounded-2xl border border-slate-850 bg-slate-950/20">
                        <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-900">
                            <span class="text-xs font-bold uppercase tracking-wider text-violet-400">Generated Cover Letter</span>
                            <button @click="navigator.clipboard.writeText(coverLetterResult); alert('Cover letter copied to clipboard!')"
                                    class="px-3 py-1 bg-slate-900 border border-slate-800 hover:bg-slate-850 text-slate-350 hover:text-white rounded-lg text-xs font-medium transition-colors">
                                Copy to Clipboard
                            </button>
                        </div>
                        <div class="text-slate-300 text-sm leading-relaxed whitespace-pre-wrap select-all font-mono max-h-96 overflow-y-auto pr-2" x-text="coverLetterResult"></div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-800">
                        <button type="button" @click="coverLetterResult = ''"
                                class="px-5 py-2.5 bg-slate-950 hover:bg-slate-900 border border-slate-850 text-slate-350 rounded-xl text-sm font-semibold transition-colors">
                            Back
                        </button>
                        <button type="button" @click="openCoverLetterModal = false; coverLetterResult = ''"
                                class="px-5 py-2.5 bg-violet-600 hover:bg-violet-500 text-white rounded-xl text-sm font-semibold transition-all">
                            Done
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- AlpineJS Resume Builder Logic -->
<script>
    function resumeBuilder(initialData) {
        return {
            id: initialData.id,
            title: initialData.title || 'Draft Resume',
            template_style: initialData.template_style || 'modern',
            target_role: initialData.target_role || '',
            section_order: Array.isArray(initialData.section_order) ? initialData.section_order : ['summary', 'experience', 'projects', 'education', 'skills'],
            draggedSectionIndex: null,
            draggedEntryIndex: null,
            showPreviewOnMobile: false,
            
            personal_info: {
                name: initialData.personal_info?.name || '',
                email: initialData.personal_info?.email || '',
                phone: initialData.personal_info?.phone || '',
                location: initialData.personal_info?.location || '',
                linkedin: initialData.personal_info?.linkedin || '',
                github: initialData.personal_info?.github || '',
                website: initialData.personal_info?.website || '',
            },
            summary: initialData.summary || '',
            experience: Array.isArray(initialData.experience) ? initialData.experience : [],
            education: Array.isArray(initialData.education) ? initialData.education : [],
            projects: Array.isArray(initialData.projects) ? initialData.projects : [],
            skills: {
                technical: initialData.skills?.technical || '',
                soft: initialData.skills?.soft || '',
                tools: initialData.skills?.tools || '',
            },

            // Editor State
            activeTab: 'personal',
            highlightSection: '',
            saveStatus: 'saved',
            saveTimeout: null,

            // AI State
            aiSummaryLoading: false,
            aiBulletLoading: {},

            // AI Suggestions State
            aiSuggestionsLoading: false,
            aiSuggestionsGenerated: false,
            aiSuggestionsData: {
                technical_skills: [],
                soft_skills: [],
                tools: [],
                experience_bullets: [],
                projects: []
            },
            suggestionsRole: '',
            suggestionsProfile: 'student',

            // ATS State
            openAtsModal: false,
            jobDescription: '',
            atsLoading: false,
            atsScanned: false,
            atsResult: {
                score: 0,
                missing_keywords: [],
                strengths: [],
                recommendations: []
            },

            // Career Changer State
            openCareerModal: false,
            careerLoading: false,
            activeExperienceIndex: null,
            careerChangerInput: {
                previous_role: '',
                target_role: '',
                experience_description: ''
            },

            // Cover Letter State
            openCoverLetterModal: false,
            coverLetterJobDescription: '',
            coverLetterLoading: false,
            coverLetterResult: '',

            init() {
                // Set up watchers for autosave
                this.$watch('title', () => this.queueSave());
                this.$watch('template_style', () => this.queueSave());
                this.$watch('target_role', () => this.queueSave());
                this.$watch('personal_info', () => this.queueSave(), { deep: true });
                this.$watch('summary', () => this.queueSave());
                this.$watch('experience', () => this.queueSave(), { deep: true });
                this.$watch('education', () => this.queueSave(), { deep: true });
                this.$watch('projects', () => this.queueSave(), { deep: true });
                this.$watch('skills', () => this.queueSave(), { deep: true });
                this.$watch('section_order', () => this.queueSave(), { deep: true });

                // Fill target role as previous role defaults for career changer
                if (this.target_role) {
                    this.careerChangerInput.target_role = this.target_role;
                }

                // Pre-populate suggestion fields from resume data
                this.suggestionsRole = this.target_role || '';
                this.suggestionsProfile = this.target_profile || 'student';
            },

            // Helper to split skill strings by comma
            getSplitSkills(str) {
                if (!str || typeof str !== 'string') return [];
                return str.split(',')
                    .map(s => s.trim())
                    .filter(s => s.length > 0);
            },

            // Add/Remove experience
            addExperience() {
                this.experience.push({
                    company: '',
                    position: '',
                    location: '',
                    start_date: '',
                    end_date: '',
                    description: ''
                });
            },
            removeExperience(index) {
                if (confirm('Are you sure you want to delete this experience entry?')) {
                    this.experience.splice(index, 1);
                }
            },

            // Add/Remove education
            addEducation() {
                this.education.push({
                    school: '',
                    degree: '',
                    location: '',
                    graduation_date: '',
                    gpa: ''
                });
            },
            removeEducation(index) {
                if (confirm('Are you sure you want to delete this education entry?')) {
                    this.education.splice(index, 1);
                }
            },

            // Add/Remove projects
            addProject() {
                this.projects.push({
                    title: '',
                    technologies: '',
                    link: '',
                    description: ''
                });
            },
            removeProject(index) {
                if (confirm('Are you sure you want to delete this project entry?')) {
                    this.projects.splice(index, 1);
                }
            },

            moveSection(fromIdx, toIdx) {
                if (fromIdx === null || toIdx === null || fromIdx === toIdx) return;
                const item = this.section_order.splice(fromIdx, 1)[0];
                this.section_order.splice(toIdx, 0, item);
                this.queueSave();
            },

            moveEntry(arrayName, fromIdx, toIdx) {
                if (fromIdx === null || toIdx === null || fromIdx === toIdx) return;
                const arr = this[arrayName];
                const item = arr.splice(fromIdx, 1)[0];
                arr.splice(toIdx, 0, item);
                this.queueSave();
            },

            // Autosave logic
            queueSave() {
                this.saveStatus = 'saving';
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                this.saveTimeout = setTimeout(() => {
                    this.saveData();
                }, 1000);
            },

            async saveData() {
                try {
                    const response = await fetch(`/resumes/${this.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            title: this.title,
                            template_style: this.template_style,
                            target_profile: this.target_profile,
                            target_role: this.target_role,
                            personal_info: this.personal_info,
                            summary: this.summary,
                            experience: this.experience,
                            education: this.education,
                            projects: this.projects,
                            skills: this.skills,
                            section_order: this.section_order
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Autosave request failed');
                    }

                    this.saveStatus = 'saved';
                } catch (error) {
                    console.error('Autosave error:', error);
                    this.saveStatus = 'error';
                }
            },

            // AI Operations
            async generateAiSummary() {
                this.aiSummaryLoading = true;
                try {
                    // Extract tech skills as array
                    const skillsArray = this.getSplitSkills(this.skills.technical);

                    const response = await fetch(`/resumes/${this.id}/ai/summary`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            target_role: this.target_role || 'Professional',
                            target_profile: this.target_profile,
                            skills: skillsArray,
                            experience: this.experience
                        })
                    });

                    if (!response.ok) throw new Error('AI Summary request failed');

                    const data = await response.json();
                    this.summary = data.summary;
                } catch (error) {
                    console.error('AI Summary error:', error);
                    alert('Could not generate summary. Please try again.');
                } finally {
                    this.aiSummaryLoading = false;
                }
            },

            async improveExperienceBullet(index) {
                const bulletText = this.experience[index].description;
                if (!bulletText.trim()) {
                    alert('Please enter some text in the description before polishing.');
                    return;
                }

                this.aiBulletLoading[index] = true;
                try {
                    const response = await fetch(`/resumes/${this.id}/ai/improve-bullet`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            bullet: bulletText,
                            target_role: this.target_role || 'Professional',
                            target_profile: this.target_profile
                        })
                    });

                    if (!response.ok) throw new Error('AI Bullet polish failed');

                    const data = await response.json();
                    this.experience[index].description = data.improved;
                } catch (error) {
                    console.error('AI Bullet error:', error);
                    alert('Could not polish bullet point. Please try again.');
                } finally {
                    this.aiBulletLoading[index] = false;
                }
            },

            // Career Change Modal triggers
            triggerCareerChangeModal(index) {
                this.activeExperienceIndex = index;
                this.careerChangerInput.previous_role = this.experience[index].company || '';
                this.careerChangerInput.experience_description = this.experience[index].description || '';
                this.openCareerModal = true;
            },

            async translateCareerChange() {
                this.careerLoading = true;
                try {
                    const response = await fetch(`/resumes/${this.id}/ai/career-translate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            previous_role: this.careerChangerInput.previous_role,
                            target_role: this.careerChangerInput.target_role || this.target_role || 'New Target Role',
                            experience_description: this.careerChangerInput.experience_description
                        })
                    });

                    if (!response.ok) throw new Error('AI Career Translate request failed');

                    const data = await response.json();
                    this.experience[this.activeExperienceIndex].description = data.translated;
                    this.openCareerModal = false;
                } catch (error) {
                    console.error('AI Career Translate error:', error);
                    alert('Could not translate achievements. Please try again.');
                } finally {
                    this.careerLoading = false;
                }
            },

            async generateCoverLetter() {
                if (!this.coverLetterJobDescription.trim()) return;

                this.coverLetterLoading = true;
                try {
                    const response = await fetch(`/resumes/${this.id}/ai/cover-letter`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            job_description: this.coverLetterJobDescription
                        })
                    });

                    if (!response.ok) throw new Error('Cover letter generation failed');

                    const data = await response.json();
                    this.coverLetterResult = data.cover_letter;
                } catch (error) {
                    console.error('Cover letter error:', error);
                    alert('Could not generate cover letter. Please try again.');
                } finally {
                    this.coverLetterLoading = false;
                }
            },

            shareResume() {
                const shareUrl = `${window.location.origin}/resumes/${this.id}/share`;
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(shareUrl).then(() => {
                        alert('Public read-only link copied to clipboard:\n' + shareUrl);
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                        prompt('Copy this link to share your resume:', shareUrl);
                    });
                } else {
                    prompt('Copy this link to share your resume:', shareUrl);
                }
            },

            // ATS Operations
            async runAtsScan() {
                if (!this.jobDescription.trim()) return;

                this.atsLoading = true;
                try {
                    const response = await fetch(`/resumes/${this.id}/ai/ats-analyze`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            job_description: this.jobDescription
                        })
                    });

                    if (!response.ok) throw new Error('ATS Scan request failed');

                    const data = await response.json();
                    this.atsResult = data;
                    this.atsScanned = true;
                } catch (error) {
                    console.error('ATS analysis error:', error);
                    alert('Could not perform ATS scan. Please try again.');
                } finally {
                    this.atsLoading = false;
                }
            },

            // AI Suggestions Operations
            async generateSuggestions() {
                if (!this.suggestionsRole.trim()) return;

                this.aiSuggestionsLoading = true;
                this.aiSuggestionsGenerated = false;
                try {
                    const response = await fetch(`/resumes/${this.id}/ai/suggestions`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            target_role: this.suggestionsRole,
                            target_profile: this.suggestionsProfile
                        })
                    });

                    if (!response.ok) throw new Error('Suggestions request failed');

                    const data = await response.json();
                    this.aiSuggestionsData = data;
                    this.aiSuggestionsGenerated = true;
                } catch (error) {
                    console.error('AI Suggestions error:', error);
                    alert('Could not generate suggestions. Please try again.');
                } finally {
                    this.aiSuggestionsLoading = false;
                }
            },

            addSuggestedSkill(type, skill) {
                const current = (this.skills[type] || '').trim();
                const existing = current.split(',').map(s => s.trim().toLowerCase()).filter(s => s.length > 0);
                if (!existing.includes(skill.toLowerCase())) {
                    this.skills[type] = current ? current + ', ' + skill : skill;
                }
            },

            addSuggestedExperience(bullet) {
                // If no experience entries exist, create one then append
                if (this.experience.length === 0) {
                    this.experience.push({
                        company: '',
                        position: this.suggestionsRole || '',
                        location: '',
                        start_date: '',
                        end_date: '',
                        description: bullet
                    });
                    return;
                }
                // Append to the last entry
                const last = this.experience[this.experience.length - 1];
                const existing = (last.description || '').trim();
                last.description = existing ? existing + '\n- ' + bullet : '- ' + bullet;
            },

            addSuggestedProject(project) {
                this.projects.push({
                    title: project.title,
                    technologies: project.technologies,
                    link: '',
                    description: project.description
                });
                // Switch to projects tab to show the newly added item
                this.activeTab = 'projects';
            }
        };
    }
</script>
@endsection

