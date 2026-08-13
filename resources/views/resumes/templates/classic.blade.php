<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-relaxed font-serif text-slate-900">
    <!-- Centered Header -->
    <div class="text-center space-y-1.5 pb-2" :class="highlightSection === 'personal' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h1 class="text-2xl font-bold uppercase tracking-wide text-slate-950" x-text="personal_info.name || 'Your Full Name'"></h1>
        <p class="text-xs uppercase tracking-widest text-slate-600 font-semibold" x-text="target_role || 'Target Role'"></p>
        <div class="text-[8.5pt] text-slate-600 flex flex-wrap justify-center items-center gap-x-2 gap-y-1">
            <span x-text="personal_info.email || 'email@example.com'"></span>
            <span>&bull;</span>
            <span x-text="personal_info.phone || '+1 (555) 0123'"></span>
            <span>&bull;</span>
            <span x-text="personal_info.location || 'City, State'"></span>
        </div>
        <div class="text-[8pt] text-slate-500 flex flex-wrap justify-center items-center gap-x-2">
            <span x-show="personal_info.linkedin" x-text="'LinkedIn: ' + personal_info.linkedin"></span>
            <span x-show="personal_info.linkedin && personal_info.github">&bull;</span>
            <span x-show="personal_info.github" x-text="'GitHub: ' + personal_info.github"></span>
            <span x-show="personal_info.github && personal_info.website">&bull;</span>
            <span x-show="personal_info.website" x-text="'Website: ' + personal_info.website"></span>
        </div>
    </div>

    <!-- Professional Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-slate-950 border-b-2 border-slate-900 pb-0.5 mb-1.5">Summary</h4>
        <p class="text-slate-700 text-justify font-serif" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-slate-950 border-b-2 border-slate-900 pb-0.5 mb-2">Experience</h4>
        <div class="space-y-3.5">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-end font-bold text-slate-950">
                        <span x-text="(exp.position || 'Position') + ' - ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-normal text-slate-600 italic ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic flex justify-between mt-0.5">
                        <span x-text="exp.location || 'Location'"></span>
                    </div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-slate-950 border-b-2 border-slate-900 pb-0.5 mb-2">Projects</h4>
        <div class="space-y-3">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-end font-bold text-slate-950">
                        <span x-text="proj.title || 'Project'"></span>
                        <span class="text-[8.5pt] font-normal text-slate-500 ml-4 italic" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-semibold text-slate-600 italic" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-slate-950 border-b-2 border-slate-900 pb-0.5 mb-2">Education</h4>
        <div class="space-y-2.5">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-slate-950" x-text="edu.school || 'Institution'"></span>
                        <span class="text-slate-600" x-text="' &mdash; ' + (edu.degree || 'Degree')"></span>
                        <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="edu.gpa ? 'GPA / Honors: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <span class="text-[8.5pt] font-bold text-slate-950" x-text="edu.graduation_date || 'Date'"></span>
                        <div class="text-[8pt] text-slate-500" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills -->
    <div :class="highlightSection === 'skills' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-slate-950 border-b-2 border-slate-900 pb-0.5 mb-2">Skills & Qualifications</h4>
        <div class="space-y-1.5 text-[9pt] text-slate-700">
            <div x-show="skills.technical">
                <strong class="text-slate-950 font-bold">Technical Competencies:</strong>
                <span x-text="skills.technical"></span>
            </div>
            <div x-show="skills.soft">
                <strong class="text-slate-950 font-bold">Interpersonal Skills:</strong>
                <span x-text="skills.soft"></span>
            </div>
            <div x-show="skills.tools">
                <strong class="text-slate-950 font-bold">Developer Tools:</strong>
                <span x-text="skills.tools"></span>
            </div>
        </div>
    </div>
</div>
