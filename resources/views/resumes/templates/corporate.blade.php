<div class="h-full flex flex-col gap-4 text-[9.5pt] leading-relaxed font-serif text-black template-corporate">
    <!-- Centered Header -->
    <div class="text-center pb-2 border-b-2 border-black" :class="highlightSection === 'personal' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h1 class="text-2xl font-bold uppercase tracking-wider text-black" x-text="personal_info.name || 'YOUR FULL NAME'"></h1>
        <p class="text-xs uppercase tracking-widest text-slate-800 font-bold mt-1" x-text="target_role || 'TARGET ROLE'"></p>
        <div class="text-[8.5pt] text-slate-800 flex flex-wrap justify-center items-center gap-x-2.5 mt-2 font-mono">
            <span x-text="personal_info.email || 'email@example.com'"></span>
            <span>|</span>
            <span x-text="personal_info.phone || '+1 (555) 0123'"></span>
            <span>|</span>
            <span x-text="personal_info.location || 'City, State'"></span>
        </div>
        <div class="text-[8pt] text-slate-700 flex flex-wrap justify-center items-center gap-x-2.5 mt-1 font-mono">
            <span x-show="personal_info.linkedin" x-text="'LI: ' + personal_info.linkedin"></span>
            <span x-show="personal_info.linkedin && personal_info.github">|</span>
            <span x-show="personal_info.github" x-text="'GH: ' + personal_info.github"></span>
            <span x-show="personal_info.github && personal_info.website">|</span>
            <span x-show="personal_info.website" x-text="'Web: ' + personal_info.website"></span>
        </div>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-black border-b border-black pb-0.5 mb-1.5">PROFESSIONAL SUMMARY</h4>
        <p class="text-slate-900 text-justify font-serif leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-black border-b border-black pb-0.5 mb-2.5">PROFESSIONAL EXPERIENCE</h4>
        <div class="space-y-3.5">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-black">
                        <span class="uppercase tracking-wide" x-text="(exp.position || 'Position') + ' — ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-semibold text-slate-800 tracking-tight shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-650 italic mt-0.5 flex justify-between font-serif">
                        <span x-text="exp.location || 'Location'"></span>
                    </div>
                    <p class="text-slate-900 mt-1 whitespace-pre-line text-justify leading-snug" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-black border-b border-black pb-0.5 mb-2.5">SELECTED PROJECTS</h4>
        <div class="space-y-3">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-black">
                        <span class="uppercase tracking-wide" x-text="proj.title || 'Project'"></span>
                        <span class="text-[8.5pt] font-semibold text-slate-700 italic ml-4" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-semibold text-slate-600 italic" x-text="proj.technologies"></div>
                    <p class="text-slate-900 mt-1 whitespace-pre-line text-justify leading-snug" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-black border-b border-black pb-0.5 mb-2.5">EDUCATION</h4>
        <div class="space-y-2.5">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-black uppercase tracking-wide" x-text="edu.school || 'Institution'"></span>
                        <span class="text-slate-800" x-text="' &mdash; ' + (edu.degree || 'Degree')"></span>
                        <div class="text-[8.5pt] text-slate-700 italic mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <span class="text-[8.5pt] font-bold text-black" x-text="edu.graduation_date || 'Date'"></span>
                        <div class="text-[8pt] text-slate-600" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills -->
    <div :class="highlightSection === 'skills' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-widest text-black border-b border-black pb-0.5 mb-2">ADDITIONAL SKILLS</h4>
        <div class="space-y-1 text-[9pt] text-slate-900">
            <div x-show="skills.technical">
                <strong>Technical Competencies:</strong> <span x-text="skills.technical"></span>
            </div>
            <div x-show="skills.soft">
                <strong>Interpersonal Strengths:</strong> <span x-text="skills.soft"></span>
            </div>
            <div x-show="skills.tools">
                <strong>Developer Tools:</strong> <span x-text="skills.tools"></span>
            </div>
        </div>
    </div>
</div>
