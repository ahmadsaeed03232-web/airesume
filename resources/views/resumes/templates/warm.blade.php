<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-relaxed font-serif text-slate-800 template-warm">
    <!-- Centered Header -->
    <div class="text-center pb-3 border-b border-amber-200" :class="highlightSection === 'personal' ? 'bg-amber-50/50 p-2 -m-2 rounded' : ''">
        <h1 class="text-2xl font-bold tracking-normal text-amber-900 font-serif" x-text="personal_info.name || 'Your Full Name'"></h1>
        <p class="text-xs uppercase tracking-widest text-amber-700 font-semibold italic mt-1" x-text="target_role || 'Target Role'"></p>
        <div class="text-[8.5pt] text-slate-650 flex flex-wrap justify-center items-center gap-x-3 gap-y-1 mt-2">
            <span x-text="personal_info.email || 'email@example.com'"></span>
            <span class="text-amber-400">&bull;</span>
            <span x-text="personal_info.phone || '+1 (555) 0123'"></span>
            <span class="text-amber-400">&bull;</span>
            <span x-text="personal_info.location || 'Location, State'"></span>
        </div>
        <div class="text-[8pt] text-slate-500 flex flex-wrap justify-center items-center gap-x-2.5 mt-1">
            <span x-show="personal_info.linkedin" x-text="'LinkedIn: ' + personal_info.linkedin"></span>
            <span x-show="personal_info.linkedin && personal_info.github" class="text-amber-300">&bull;</span>
            <span x-show="personal_info.github" x-text="'GitHub: ' + personal_info.github"></span>
            <span x-show="personal_info.github && personal_info.website" class="text-amber-300">&bull;</span>
            <span x-show="personal_info.website" x-text="'Portfolio: ' + personal_info.website"></span>
        </div>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-amber-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-amber-800 pb-0.5 mb-1">Introduction</h4>
        <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-amber-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-amber-800 border-b border-amber-100 pb-0.5 mb-2.5">Experience</h4>
        <div class="space-y-4">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-slate-900">
                        <span class="text-amber-950 font-bold" x-text="(exp.position || 'Position') + ' — ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-normal text-slate-650 italic" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                    <p class="text-slate-700 mt-1.5 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-amber-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-amber-800 border-b border-amber-100 pb-0.5 mb-2.5">Selected Projects</h4>
        <div class="space-y-3.5">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-slate-900">
                        <span x-text="proj.title || 'Project'"></span>
                        <span class="text-[8.5pt] font-normal text-slate-500 italic" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-semibold text-amber-800 italic" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-amber-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-amber-800 border-b border-amber-100 pb-0.5 mb-2.5">Education</h4>
        <div class="space-y-2.5">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-slate-900" x-text="edu.school || 'Institution'"></span>
                        <span class="text-slate-650" x-text="' &mdash; ' + (edu.degree || 'Degree')"></span>
                        <div class="text-[8.5pt] text-amber-900 font-medium italic mt-0.5" x-text="edu.gpa ? 'GPA / Achievements: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <span class="text-[8.5pt] font-bold text-slate-900" x-text="edu.graduation_date"></span>
                        <div class="text-[8pt] text-slate-500" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills -->
    <div :class="highlightSection === 'skills' ? 'bg-amber-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-amber-800 border-b border-amber-100 pb-0.5 mb-2">Skills & Knowledge</h4>
        <div class="space-y-1.5 text-[8.5pt] text-slate-700">
            <div x-show="skills.technical">
                <strong class="text-amber-900 font-bold">Technical Skills:</strong>
                <span x-text="skills.technical"></span>
            </div>
            <div x-show="skills.soft">
                <strong class="text-amber-900 font-bold">Soft Skills:</strong>
                <span x-text="skills.soft"></span>
            </div>
            <div x-show="skills.tools">
                <strong class="text-amber-900 font-bold">Tools & Platforms:</strong>
                <span x-text="skills.tools"></span>
            </div>
        </div>
    </div>
</div>
