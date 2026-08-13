<div class="h-full flex flex-col gap-4 text-[9pt] leading-normal font-sans text-slate-900 template-border">
    <!-- Header Box -->
    <div class="border border-slate-350 p-4 rounded-lg flex justify-between items-center" :class="highlightSection === 'personal' ? 'bg-slate-50 border-slate-950' : ''">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-950" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-0.5" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8pt] text-slate-600 space-y-0.5 shrink-0 ml-4">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'Location, State'"></div>
        </div>
    </div>

    <!-- Summary Box -->
    <div x-show="summary" class="border border-slate-350 p-4 rounded-lg" :class="highlightSection === 'summary' ? 'bg-slate-50 border-slate-950' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 mb-1">About Me</h4>
        <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience Box -->
    <div x-show="experience.length > 0" class="border border-slate-350 p-4 rounded-lg" :class="highlightSection === 'experience' ? 'bg-slate-50 border-slate-950' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 mb-3 border-b border-slate-200 pb-1">Work Experience</h4>
        <div class="space-y-4">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-900">
                        <span x-text="(exp.position || 'Position') + ' at ' + (exp.company || 'Company')"></span>
                        <span class="text-[8pt] font-semibold text-slate-500" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8pt] text-slate-450 italic mt-0.5" x-text="exp.location"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-snug" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects Box -->
    <div x-show="projects.length > 0" class="border border-slate-350 p-4 rounded-lg" :class="highlightSection === 'projects' ? 'bg-slate-50 border-slate-950' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 mb-3 border-b border-slate-200 pb-1">Key Projects</h4>
        <div class="space-y-3">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-900">
                        <span x-text="proj.title || 'Project'"></span>
                        <span class="text-[8pt] font-normal text-slate-500" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8pt] font-semibold text-slate-500" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-0.5 whitespace-pre-line text-justify leading-snug" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Footer Grid: Education & Skills -->
    <div class="grid grid-cols-2 gap-4">
        <div x-show="education.length > 0" class="border border-slate-350 p-4 rounded-lg" :class="highlightSection === 'education' ? 'bg-slate-50 border-slate-950' : ''">
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 mb-2 border-b border-slate-200 pb-1">Education</h4>
            <div class="space-y-2">
                <template x-for="(edu, index) in education" :key="index">
                    <div>
                        <div class="font-bold text-slate-900" x-text="edu.school || 'School'"></div>
                        <div class="text-[8.5pt] text-slate-650" x-text="edu.degree"></div>
                        <div class="text-[8pt] text-slate-500" x-text="(edu.graduation_date || '') + (edu.gpa ? ' | GPA: ' + edu.gpa : '')"></div>
                    </div>
                </template>
            </div>
        </div>

        <div class="border border-slate-350 p-4 rounded-lg" :class="highlightSection === 'skills' ? 'bg-slate-50 border-slate-950' : ''">
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 mb-2 border-b border-slate-200 pb-1">Skills</h4>
            <div class="space-y-1.5 text-[8.5pt] text-slate-700">
                <div x-show="skills.technical">
                    <strong>Technical:</strong> <span x-text="skills.technical"></span>
                </div>
                <div x-show="skills.soft">
                    <strong>Soft:</strong> <span x-text="skills.soft"></span>
                </div>
                <div x-show="skills.tools">
                    <strong>Tools:</strong> <span x-text="skills.tools"></span>
                </div>
            </div>
        </div>
    </div>
</div>
