<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-900 template-slate">
    <!-- Header -->
    <div class="pb-3 border-b border-slate-300" :class="highlightSection === 'personal' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h1 class="text-2xl font-bold tracking-tight text-slate-800" x-text="personal_info.name || 'Your Full Name'"></h1>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mt-1" x-text="target_role || 'Target Role'"></p>
        <div class="text-[8.5pt] text-slate-650 flex flex-wrap gap-x-4 mt-2">
            <span x-text="'Email: ' + (personal_info.email || 'email@example.com')"></span>
            <span x-text="'Phone: ' + (personal_info.phone || '+1 (555) 0123')"></span>
            <span x-text="'Location: ' + (personal_info.location || 'Location, State')"></span>
            <span x-show="personal_info.linkedin" x-text="'LinkedIn: ' + personal_info.linkedin"></span>
        </div>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 mb-1.5">Profile Summary</h4>
        <p class="text-slate-750 text-justify leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2.5">Professional Experience</h4>
        <div class="space-y-3.5">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-800">
                        <span x-text="(exp.position || 'Position') + ' — ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-normal text-slate-500" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                    <p class="text-slate-750 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2.5">Key Projects</h4>
        <div class="space-y-3">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-800">
                        <span x-text="proj.title || 'Project Title'"></span>
                        <span class="text-[8.5pt] font-normal text-slate-500" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-semibold text-slate-600 italic" x-text="proj.technologies"></div>
                    <p class="text-slate-750 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education & Skills Side-by-Side -->
    <div class="grid grid-cols-2 gap-6">
        <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2">Education</h4>
            <div class="space-y-2.5">
                <template x-for="(edu, index) in education" :key="index">
                    <div>
                        <div class="font-bold text-slate-800" x-text="edu.school || 'Institution'"></div>
                        <div class="text-[8.5pt] text-slate-600" x-text="(edu.degree || 'Degree') + (edu.gpa ? ' (GPA: ' + edu.gpa + ')' : '')"></div>
                        <div class="text-[8.5pt] text-slate-500" x-text="edu.graduation_date || 'Graduation'"></div>
                    </div>
                </template>
            </div>
        </div>

        <div :class="highlightSection === 'skills' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2">Skills Profile</h4>
            <div class="space-y-1.5 text-[8.5pt] text-slate-750">
                <div x-show="skills.technical">
                    <strong>Technical:</strong> <span x-text="skills.technical"></span>
                </div>
                <div x-show="skills.soft">
                    <strong>Interpersonal:</strong> <span x-text="skills.soft"></span>
                </div>
                <div x-show="skills.tools">
                    <strong>Tools:</strong> <span x-text="skills.tools"></span>
                </div>
            </div>
        </div>
    </div>
</div>
