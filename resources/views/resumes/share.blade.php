@extends('layouts.app')

@section('title', $resume->title . ' - Shared Resume')

@section('content')
<div x-data="resumeBuilder({{ json_encode($resume) }})" x-init="init()" class="min-h-[calc(100vh-4rem)] bg-slate-950 py-12 px-4 flex flex-col items-center">
    
    <!-- Header actions -->
    <div class="w-full max-w-[21cm] flex items-center justify-between mb-6 no-print">
        <div>
            <h1 class="text-xl font-bold text-slate-100" x-text="title"></h1>
            <p class="text-xs text-slate-500 mt-1">Shared via AI Resume Builder</p>
        </div>
        <button @click="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-tr from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 rounded-xl text-xs font-bold text-white shadow-lg shadow-indigo-500/10 active:scale-[0.98] transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print / Save PDF
        </button>
    </div>

    <!-- Preview sheet -->
    <div id="print-sheet-content" class="print-sheet w-full max-w-[21cm] bg-white text-slate-900 shadow-2xl rounded-sm transition-all duration-300"
         :class="'template-' + template_style">
        @foreach($templates as $key => $name)
            <template x-if="template_style === '{{ $key }}'">
                @include('resumes.templates.' . $key)
            </template>
        @endforeach

        <div class="text-[8pt] text-slate-400 text-center border-t border-slate-100 pt-3 mt-6 px-[1.5cm] pb-4 no-print">
            Page 1 of 1 &bull; Shared via AI Resume Builder
        </div>
    </div>
</div>

<script>
    function resumeBuilder(initialData) {
        return {
            id: initialData.id,
            title: initialData.title || 'Resume',
            template_style: initialData.template_style || 'modern',
            target_role: initialData.target_role || '',
            section_order: Array.isArray(initialData.section_order) ? initialData.section_order : ['summary', 'experience', 'projects', 'education', 'skills'],
            
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
            highlightSection: '',

            init() {
                // Read-only public preview logic
            },

            getSplitSkills(skillsString) {
                if (!skillsString) return [];
                return skillsString.split(',').map(s => s.trim()).filter(s => s.length > 0);
            }
        };
    }
</script>
@endsection
