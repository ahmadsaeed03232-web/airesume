<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-900 template-ruby">
    <!-- Header -->
    <div class="pb-3 border-b-2 border-red-700 flex justify-between items-end" :class="highlightSection === 'personal' ? 'bg-red-50/50 p-2 -m-2 rounded' : ''">
        <div>
            <h1 class="text-2xl font-black text-red-950 tracking-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-xs uppercase font-extrabold tracking-widest text-red-700 mt-1" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8.5pt] text-slate-650 space-y-0.5 shrink-0 ml-4 font-medium">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'Location, State'"></div>
        </div>
    </div>

    <!-- Contact links horizontal bar -->
    <div x-show="personal_info.linkedin || personal_info.github || personal_info.website" class="flex flex-wrap gap-4 text-[8pt] text-slate-500 justify-center">
        <span x-show="personal_info.linkedin" x-text="'linkedin.com/in/' + personal_info.linkedin"></span>
        <span x-show="personal_info.github" x-text="'github.com/' + personal_info.github"></span>
        <span x-show="personal_info.website" x-text="'portfolio: ' + personal_info.website"></span>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-red-50/50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-black tracking-wider text-red-800 border-b border-red-200 pb-0.5 mb-1.5">Profile Summary</h4>
        <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-red-50/50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-black tracking-wider text-red-800 border-b border-red-200 pb-0.5 mb-2.5">Professional Experience</h4>
        <div class="space-y-4">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-900">
                        <span class="text-red-950" x-text="(exp.position || 'Position') + ' at ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-semibold text-red-700" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                    <p class="text-slate-700 mt-1.5 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-red-50/50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-black tracking-wider text-red-800 border-b border-red-200 pb-0.5 mb-2.5">Selected Projects</h4>
        <div class="space-y-3.5">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-900">
                        <span x-text="proj.title || 'Project'"></span>
                        <span class="text-[8.5pt] font-normal text-red-700 italic" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-bold text-slate-600 mt-0.5" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-red-50/50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-black tracking-wider text-red-800 border-b border-red-200 pb-0.5 mb-2.5">Academic Background</h4>
        <div class="space-y-2.5">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-slate-900" x-text="edu.school || 'Institution'"></span>
                        <span class="text-slate-650" x-text="' &mdash; ' + (edu.degree || 'Degree')"></span>
                        <div class="text-[8.5pt] text-red-700 italic mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <span class="text-[8.5pt] font-bold text-slate-900" x-text="edu.graduation_date || 'Graduation'"></span>
                        <div class="text-[8pt] text-slate-500" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills -->
    <div :class="highlightSection === 'skills' ? 'bg-red-50/50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-black tracking-wider text-red-800 border-b border-red-200 pb-0.5 mb-2">Skills Profiles</h4>
        <div class="space-y-1.5 text-[8.5pt] text-slate-700">
            <div x-show="skills.technical">
                <strong class="text-red-900">Technical Competencies:</strong> <span x-text="skills.technical"></span>
            </div>
            <div x-show="skills.soft">
                <strong class="text-red-900">Interpersonal Strengths:</strong> <span x-text="skills.soft"></span>
            </div>
            <div x-show="skills.tools">
                <strong class="text-red-900">Platforms & Tools:</strong> <span x-text="skills.tools"></span>
            </div>
        </div>
    </div>
</div>
