<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-900 template-royal">
    <!-- Header -->
    <div class="border-l-4 border-blue-700 pl-4 py-1" :class="highlightSection === 'personal' ? 'bg-blue-50/50 rounded' : ''">
        <h1 class="text-2xl font-black text-blue-900 uppercase tracking-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
        <p class="text-sm font-bold text-blue-700 uppercase tracking-wider mt-0.5" x-text="target_role || 'Target Role'"></p>
        <div class="text-[8.5pt] text-slate-650 flex flex-wrap gap-x-4 mt-1">
            <span x-text="personal_info.email || 'email@example.com'"></span>
            <span x-text="personal_info.phone || '+1 (555) 0123'"></span>
            <span x-text="personal_info.location || 'Location, State'"></span>
        </div>
        <div class="text-[8.5pt] text-slate-500 flex flex-wrap gap-x-4 mt-0.5">
            <span x-show="personal_info.linkedin" x-text="'linkedin.com/in/' + personal_info.linkedin"></span>
            <span x-show="personal_info.github" x-text="'github.com/' + personal_info.github"></span>
            <span x-show="personal_info.website" x-text="'web: ' + personal_info.website"></span>
        </div>
    </div>

    <!-- Summary -->
    <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-blue-50/50 p-2 -m-2 rounded' : ''" class="grid grid-cols-4 gap-4 items-start">
        <div class="col-span-1 text-xs uppercase font-extrabold text-blue-800 tracking-wider">Summary</div>
        <div class="col-span-3 text-slate-700 text-justify leading-relaxed" x-text="summary"></div>
    </div>

    <!-- Experience -->
    <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-blue-50/50 p-2 -m-2 rounded' : ''" class="grid grid-cols-4 gap-4 items-start border-t border-slate-200 pt-4">
        <div class="col-span-1 text-xs uppercase font-extrabold text-blue-800 tracking-wider">Experience</div>
        <div class="col-span-3 space-y-4">
            <template x-for="(exp, index) in experience" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-900">
                        <span x-text="(exp.position || 'Position') + ' — ' + (exp.company || 'Company')"></span>
                        <span class="text-[8.5pt] font-semibold text-blue-700" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                    </div>
                    <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Projects -->
    <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-blue-50/50 p-2 -m-2 rounded' : ''" class="grid grid-cols-4 gap-4 items-start border-t border-slate-200 pt-4">
        <div class="col-span-1 text-xs uppercase font-extrabold text-blue-800 tracking-wider">Projects</div>
        <div class="col-span-3 space-y-3">
            <template x-for="(proj, index) in projects" :key="index">
                <div>
                    <div class="flex justify-between items-start font-bold text-slate-900">
                        <span x-text="proj.title || 'Project Title'"></span>
                        <span class="text-[8.5pt] font-normal text-blue-600" x-text="proj.link"></span>
                    </div>
                    <div class="text-[8.5pt] font-bold text-blue-700 mt-0.5" x-text="proj.technologies"></div>
                    <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                </div>
            </template>
        </div>
    </div>

    <!-- Education -->
    <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-blue-50/50 p-2 -m-2 rounded' : ''" class="grid grid-cols-4 gap-4 items-start border-t border-slate-200 pt-4">
        <div class="col-span-1 text-xs uppercase font-extrabold text-blue-800 tracking-wider">Education</div>
        <div class="col-span-3 space-y-3">
            <template x-for="(edu, index) in education" :key="index">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-bold text-slate-900" x-text="edu.school || 'Institution'"></div>
                        <div class="text-[8.5pt] text-slate-600 mt-0.5" x-text="edu.degree || 'Degree'"></div >
                        <div class="text-[8.5pt] font-semibold text-blue-700 italic mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <div class="text-[8.5pt] font-bold text-slate-900" x-text="edu.graduation_date || 'Graduation'"></div>
                        <div class="text-[8pt] text-slate-500" x-text="edu.location"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Skills -->
    <div :class="highlightSection === 'skills' ? 'bg-blue-50/50 p-2 -m-2 rounded' : ''" class="grid grid-cols-4 gap-4 items-start border-t border-slate-200 pt-4">
        <div class="col-span-1 text-xs uppercase font-extrabold text-blue-800 tracking-wider">Skills</div>
        <div class="col-span-3 grid grid-cols-3 gap-4 text-[8.5pt] text-slate-750">
            <div x-show="skills.technical">
                <span class="font-extrabold text-blue-900 block">TECHNICAL</span>
                <span x-text="skills.technical"></span>
            </div>
            <div x-show="skills.soft">
                <span class="font-extrabold text-blue-900 block">SOFT</span>
                <span x-text="skills.soft"></span>
            </div>
            <div x-show="skills.tools">
                <span class="font-extrabold text-blue-900 block">TOOLS</span>
                <span x-text="skills.tools"></span>
            </div>
        </div>
    </div>
</div>
