<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-800 template-charcoal">
    <!-- Header -->
    <div class="pb-3 border-b border-slate-300" :class="highlightSection === 'personal' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h1 class="text-3xl font-light text-slate-800 tracking-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
        <p class="text-xs uppercase tracking-widest text-slate-500 font-bold mt-1.5" x-text="target_role || 'Target Role'"></p>
        <div class="text-[8.5pt] text-slate-600 flex flex-wrap gap-x-4 mt-2 font-mono">
            <span x-text="personal_info.email || 'email@example.com'"></span>
            <span x-text="personal_info.phone || '+1 (555) 0123'"></span>
            <span x-text="personal_info.location || 'Location, State'"></span>
        </div>
        <div x-show="personal_info.linkedin || personal_info.github || personal_info.website" class="text-[8pt] text-slate-500 flex flex-wrap gap-x-4 mt-1">
            <span x-show="personal_info.linkedin" x-text="'linkedin: ' + personal_info.linkedin"></span>
            <span x-show="personal_info.github" x-text="'github: ' + personal_info.github"></span>
            <span x-show="personal_info.website" x-text="'portfolio: ' + personal_info.website"></span>
        </div>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 mb-1.5">Profile Summary</h4>
        <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2.5">Experience History</h4>
        <div class="space-y-4">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-slate-800">
                        <span x-text="(exp.position || 'Position') + ' at ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-normal text-slate-500 italic" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
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
                    <div class="flex justify-between items-baseline font-bold text-slate-800">
                        <span x-text="proj.title || 'Project'"></span>
                        <span class="text-[8.5pt] font-normal text-slate-500 italic" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-semibold text-slate-600 italic" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-0.5 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2.5">Education</h4>
        <div class="space-y-2.5">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-slate-850" x-text="edu.school || 'Institution'"></span>
                        <span class="text-slate-600" x-text="' &mdash; ' + (edu.degree || 'Degree')"></span>
                        <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <span class="text-[8.5pt] font-bold text-slate-850" x-text="edu.graduation_date"></span>
                        <div class="text-[8pt] text-slate-500" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills -->
    <div :class="highlightSection === 'skills' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-700 border-b border-slate-200 pb-0.5 mb-2">Qualifications & Skills</h4>
        <div class="space-y-1 text-[9pt] text-slate-700">
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
