<div class="flex flex-col gap-0 text-[9.5pt] leading-normal font-sans text-slate-900 template-bold">
    <!-- Top Dark Banner -->
    <div class="bg-slate-950 text-white flex justify-between items-center border-b border-indigo-900 shrink-0" style="padding: clamp(0.4cm, 3.5vw, 1cm);" :class="highlightSection === 'personal' ? 'bg-indigo-950/80' : ''">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-white" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-xs font-bold uppercase tracking-widest text-indigo-400 mt-1" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8.5pt] text-slate-350 space-y-0.5 shrink-0 ml-4">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'Location, State'"></div>
        </div>
    </div>

    <!-- Bottom Content Area -->
    <div class="space-y-5 bg-white flex-grow" style="padding: clamp(0.4cm, 3.5vw, 1cm);">
        <div class="space-y-5">
            <!-- Contact profiles inline block -->
            <div x-show="personal_info.linkedin || personal_info.github || personal_info.website" class="flex gap-4 text-[8.5pt] text-slate-500 font-medium justify-center pb-2 border-b border-slate-100">
                <span x-show="personal_info.linkedin" x-text="'LinkedIn: ' + personal_info.linkedin"></span>
                <span x-show="personal_info.github" x-text="'GitHub: ' + personal_info.github"></span>
                <span x-show="personal_info.website" x-text="'Portfolio: ' + personal_info.website"></span>
            </div>

            <!-- Summary -->
            <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-2">Executive Summary</h4>
                <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
            </div>

            <!-- Experience -->
            <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Work History</h4>
                <div class="space-y-4">
                    <template x-for="(exp, index) in experience" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span class="font-extrabold text-slate-950" x-text="(exp.position || 'Position') + ' — ' + (exp.company || 'Company')"></span>
                                <span class="text-[8.5pt] font-semibold text-slate-500 shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                            </div>
                            <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                            <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Projects -->
            <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Selected Projects</h4>
                <div class="space-y-3.5">
                    <template x-for="(proj, index) in projects" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span x-text="proj.title || 'Project'"></span>
                                <span class="text-[8.5pt] font-semibold text-indigo-650" x-text="proj.link"></span>
                            </div>
                            <div class="text-[8pt] font-bold text-slate-500 mt-0.5" x-text="proj.technologies"></div>
                            <p class="text-slate-750 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Education & Skills Side-by-Side -->
            <div class="grid grid-cols-2 gap-6 pt-2 border-t border-slate-100">
                <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-2">Education</h4>
                    <div class="space-y-2.5">
                        <template x-for="(edu, index) in education" :key="index">
                            <div>
                                <div class="font-bold text-slate-900" x-text="edu.school || 'School'"></div>
                                <div class="text-[8.5pt] text-slate-650" x-text="edu.degree"></div>
                                <div class="text-[8pt] text-slate-500" x-text="(edu.graduation_date || '') + (edu.gpa ? ' | GPA: ' + edu.gpa : '')"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <div :class="highlightSection === 'skills' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''" class="space-y-2">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-2">Skills Profiles</h4>
                    <div class="space-y-1.5 text-[8.5pt] text-slate-700">
                        <div x-show="skills.technical">
                            <strong class="text-slate-950">Technical:</strong> <span x-text="skills.technical"></span>
                        </div>
                        <div x-show="skills.soft">
                            <strong class="text-slate-950">Soft:</strong> <span x-text="skills.soft"></span>
                        </div>
                        <div x-show="skills.tools">
                            <strong class="text-slate-950">Tools:</strong> <span x-text="skills.tools"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
