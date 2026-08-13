<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-800 template-startup">
    <!-- Header -->
    <div class="flex justify-between items-start border-b-2 border-purple-500 pb-4" :class="highlightSection === 'personal' ? 'bg-purple-50/50 p-2 -m-2 rounded' : ''">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-sm font-bold text-purple-600 mt-1 uppercase tracking-wider" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8.5pt] text-slate-650 space-y-0.5 shrink-0 ml-4 font-mono">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'Location, State'"></div>
        </div>
    </div>

    <!-- Web profiles inline -->
    <div x-show="personal_info.linkedin || personal_info.github || personal_info.website" class="flex gap-4 justify-start text-[8.5pt] font-mono text-purple-650">
        <span x-show="personal_info.linkedin" x-text="'ln: ' + personal_info.linkedin"></span>
        <span x-show="personal_info.github" x-text="'gh: ' + personal_info.github"></span>
        <span x-show="personal_info.website" x-text="'web: ' + personal_info.website"></span>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-purple-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-purple-700 mb-1.5">TL;DR Summary</h4>
        <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-purple-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-purple-700 border-b border-purple-100 pb-0.5 mb-2.5">Work History</h4>
        <div class="space-y-4">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-slate-900">
                        <span class="text-purple-950 font-bold" x-text="(exp.position || 'Position') + ' @ ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-normal text-slate-550 shrink-0 ml-4 font-mono" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-snug" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-purple-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-purple-700 border-b border-purple-100 pb-0.5 mb-2.5">Builds & Projects</h4>
        <div class="space-y-3.5">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-baseline font-bold text-slate-900">
                        <span x-text="proj.title || 'Project'"></span>
                        <span class="text-[8.5pt] font-mono text-purple-650 italic shrink-0 ml-4" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-semibold text-slate-500" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-snug" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-purple-50/40 p-2 -m-2 rounded' : ''">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-purple-700 border-b border-purple-100 pb-0.5 mb-2.5">Education</h4>
        <div class="space-y-2.5">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="font-bold text-slate-900" x-text="edu.school || 'School'"></span>
                        <span class="text-slate-650" x-text="' &bull; ' + (edu.degree || 'Degree')"></span>
                        <div class="text-[8.5pt] text-purple-600 font-bold mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <span class="text-[8.5pt] font-bold text-slate-900 font-mono" x-text="edu.graduation_date"></span>
                        <div class="text-[8pt] text-slate-500" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills section using pills -->
    <div :class="highlightSection === 'skills' ? 'bg-purple-50/40 p-2 -m-2 rounded' : ''" class="space-y-3">
        <h4 class="text-xs uppercase font-extrabold tracking-wider text-purple-700 border-b border-purple-100 pb-0.5">Stack & Skills</h4>
        
        <div x-show="skills.technical" class="flex items-center gap-2 flex-wrap">
            <span class="text-[8.5pt] font-extrabold text-slate-950 shrink-0">Stack:</span>
            <div class="flex flex-wrap gap-1">
                <template x-for="skill in getSplitSkills(skills.technical)">
                    <span class="px-2 py-0.5 bg-purple-50 border border-purple-200 text-purple-900 text-[8pt] rounded-full font-medium" x-text="skill"></span>
                </template>
            </div>
        </div>

        <div x-show="skills.soft" class="flex items-center gap-2 flex-wrap mt-2">
            <span class="text-[8.5pt] font-extrabold text-slate-950 shrink-0">Soft:</span>
            <div class="flex flex-wrap gap-1">
                <template x-for="skill in getSplitSkills(skills.soft)">
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-800 text-[8pt] rounded-full font-medium" x-text="skill"></span>
                </template>
            </div>
        </div>

        <div x-show="skills.tools" class="flex items-center gap-2 flex-wrap mt-2">
            <span class="text-[8.5pt] font-extrabold text-slate-950 shrink-0">Tools:</span>
            <div class="flex flex-wrap gap-1">
                <template x-for="skill in getSplitSkills(skills.tools)">
                    <span class="px-2 py-0.5 bg-purple-600 text-white text-[8pt] rounded-full font-medium" x-text="skill"></span>
                </template>
            </div>
        </div>
    </div>
</div>
