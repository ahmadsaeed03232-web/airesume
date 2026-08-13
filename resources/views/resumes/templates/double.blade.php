<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-900 template-double">
    <!-- Header -->
    <div class="border-b border-slate-200 pb-4" :class="highlightSection === 'personal' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900" x-text="personal_info.name || 'Your Full Name'"></h1>
        <p class="text-xs font-bold text-slate-550 uppercase tracking-widest mt-1" x-text="target_role || 'Target Role'"></p>
        <div class="text-[8.5pt] text-slate-600 flex flex-wrap gap-x-4 mt-2">
            <span x-text="personal_info.email || 'email@example.com'"></span>
            <span x-text="personal_info.phone || '+1 (555) 0123'"></span>
            <span x-text="personal_info.location || 'Location, State'"></span>
        </div>
        <div class="text-[8.5pt] text-slate-500 flex flex-wrap gap-x-4 mt-1">
            <span x-show="personal_info.linkedin" x-text="'linkedin.com/in/' + personal_info.linkedin"></span>
            <span x-show="personal_info.github" x-text="'github.com/' + personal_info.github"></span>
            <span x-show="personal_info.website" x-text="'web: ' + personal_info.website"></span>
        </div>
    </div>

    <!-- 2 Column Body -->
    <div class="grid grid-cols-5 gap-6 flex-grow">
        <!-- Left Side: Experience & Projects (3/5) -->
        <div class="col-span-3 space-y-5 border-r border-slate-200 pr-5">
            <!-- Experience -->
            <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Work Experience</h4>
                <div class="space-y-4">
                    <template x-for="(exp, index) in experience" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span class="font-extrabold" x-text="exp.position || 'Position'"></span>
                                <span class="text-[8.5pt] font-medium text-slate-500 shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                            </div>
                            <div class="text-[8.5pt] text-slate-550 italic" x-text="exp.company + (exp.location ? ' | ' + exp.location : '')"></div>
                            <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-snug" x-text="exp.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Projects -->
            <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Projects</h4>
                <div class="space-y-3.5">
                    <template x-for="(proj, index) in projects" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span x-text="proj.title || 'Project'"></span>
                                <span class="text-[8.5pt] font-semibold text-slate-500 truncate max-w-[120px]" x-text="proj.link"></span>
                            </div>
                            <div class="text-[8pt] font-bold text-slate-650 mt-0.5" x-text="proj.technologies"></div>
                            <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-snug" x-text="proj.description"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Side: Summary, Education, Skills (2/5) -->
        <div class="col-span-2 space-y-5">
            <!-- Summary -->
            <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-2">Summary</h4>
                <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
            </div>

            <!-- Education -->
            <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Education</h4>
                <div class="space-y-3">
                    <template x-for="(edu, index) in education" :key="index">
                        <div>
                            <div class="font-bold text-slate-900" x-text="edu.school || 'Institution'"></div>
                            <div class="text-[8.5pt] text-slate-650" x-text="edu.degree"></div>
                            <div class="text-[8pt] text-slate-500" x-text="(edu.graduation_date || '') + (edu.gpa ? ' | GPA: ' + edu.gpa : '')"></div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Skills -->
            <div :class="highlightSection === 'skills' ? 'bg-slate-50 p-2 -m-2 rounded' : ''" class="space-y-3">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1">Skills</h4>
                
                <div x-show="skills.technical">
                    <span class="text-xs font-bold text-slate-950 block">TECHNICAL</span>
                    <span class="text-[8.5pt] text-slate-700" x-text="skills.technical"></span>
                </div>

                <div x-show="skills.soft" class="mt-2">
                    <span class="text-xs font-bold text-slate-950 block">SOFT</span>
                    <span class="text-[8.5pt] text-slate-700" x-text="skills.soft"></span>
                </div>

                <div x-show="skills.tools" class="mt-2">
                    <span class="text-xs font-bold text-slate-950 block">TOOLS</span>
                    <span class="text-[8.5pt] text-slate-700" x-text="skills.tools"></span>
                </div>
            </div>
        </div>
    </div>
</div>
