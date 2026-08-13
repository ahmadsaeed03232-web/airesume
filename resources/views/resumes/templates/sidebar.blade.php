<div class="flex gap-0 text-[9.5pt] leading-normal font-sans text-slate-900 template-sidebar">
    <!-- Left Column (Dark Sidebar) -->
    <div class="w-1/3 bg-slate-950 text-slate-200 flex flex-col gap-6 shrink-0 border-r border-slate-800" style="padding: clamp(0.4cm, 3.5vw, 1cm);">
        <div :class="highlightSection === 'personal' ? 'bg-slate-800/40 p-2 -m-2 rounded' : ''">
            <h1 class="text-xl font-extrabold tracking-tight text-white leading-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-xs font-bold text-indigo-400 uppercase tracking-wider mt-1.5" x-text="target_role || 'Target Role'"></p>
        </div>

        <div class="space-y-3.5 text-[8.5pt] text-slate-300">
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-white border-b border-slate-800 pb-1">Contact</h4>
            <div class="space-y-2 break-all">
                <div>
                    <div class="text-slate-400 font-semibold text-[7pt] uppercase tracking-wider">Email</div>
                    <div x-text="personal_info.email || 'email@example.com'"></div>
                </div>
                <div>
                    <div class="text-slate-400 font-semibold text-[7pt] uppercase tracking-wider">Phone</div>
                    <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
                </div>
                <div>
                    <div class="text-slate-400 font-semibold text-[7pt] uppercase tracking-wider">Location</div>
                    <div x-text="personal_info.location || 'Location, State'"></div>
                </div>
                <div x-show="personal_info.linkedin">
                    <div class="text-slate-400 font-semibold text-[7pt] uppercase tracking-wider">LinkedIn</div>
                    <div x-text="personal_info.linkedin"></div>
                </div>
                <div x-show="personal_info.github">
                    <div class="text-slate-400 font-semibold text-[7pt] uppercase tracking-wider">GitHub</div>
                    <div x-text="personal_info.github"></div>
                </div>
                <div x-show="personal_info.website">
                    <div class="text-slate-400 font-semibold text-[7pt] uppercase tracking-wider">Website</div>
                    <div x-text="personal_info.website"></div>
                </div>
            </div>
        </div>

        <div :class="highlightSection === 'skills' ? 'bg-slate-800/40 p-2 -m-2 rounded' : ''" class="space-y-4">
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-white border-b border-slate-800 pb-1">Key Skills</h4>
            
            <div x-show="skills.technical">
                <span class="text-slate-400 font-semibold text-[7.5pt] uppercase tracking-wider block mb-1">Technical</span>
                <div class="flex flex-wrap gap-1">
                    <template x-for="skill in getSplitSkills(skills.technical)">
                        <span class="px-1.5 py-0.5 bg-slate-900 border border-slate-800 text-slate-300 text-[7.5pt] rounded" x-text="skill"></span>
                    </template>
                </div>
            </div>

            <div x-show="skills.soft" class="mt-3">
                <span class="text-slate-400 font-semibold text-[7.5pt] uppercase tracking-wider block mb-1">Soft Skills</span>
                <div class="flex flex-wrap gap-1">
                    <template x-for="skill in getSplitSkills(skills.soft)">
                        <span class="px-1.5 py-0.5 bg-slate-900 border border-slate-800 text-slate-350 text-[7.5pt] rounded" x-text="skill"></span>
                    </template>
                </div>
            </div>

            <div x-show="skills.tools" class="mt-3">
                <span class="text-slate-400 font-semibold text-[7.5pt] uppercase tracking-wider block mb-1">Tools</span>
                <div class="flex flex-wrap gap-1">
                    <template x-for="skill in getSplitSkills(skills.tools)">
                        <span class="px-1.5 py-0.5 bg-indigo-950 text-indigo-300 text-[7.5pt] rounded" x-text="skill"></span>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column (White Content Area) -->
    <div class="w-2/3 bg-white flex flex-col gap-5" style="padding: clamp(0.4cm, 3.5vw, 1cm);">
        <div class="space-y-5">
            <!-- Summary -->
            <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-2">Professional Summary</h4>
                <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
            </div>

            <!-- Experience -->
            <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Work Experience</h4>
                <div class="space-y-4">
                    <template x-for="(exp, index) in experience" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span class="font-extrabold text-slate-950" x-text="(exp.position || 'Position') + ' — ' + (exp.company || 'Company')"></span>
                                <span class="text-[8.5pt] font-semibold text-slate-500 shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                            </div>
                            <div class="text-[8.5pt] text-slate-450 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                            <p class="text-slate-750 mt-1.5 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Projects -->
            <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Key Projects</h4>
                <div class="space-y-3">
                    <template x-for="(proj, index) in projects" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span x-text="proj.title || 'Project Title'"></span>
                                <span class="text-[8.5pt] font-semibold text-indigo-650" x-text="proj.link"></span>
                            </div>
                            <div class="text-[8pt] font-bold text-indigo-600 mt-0.5" x-text="proj.technologies"></div>
                            <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Education -->
            <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Education</h4>
                <div class="space-y-3">
                    <template x-for="(edu, index) in education" :key="index">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-extrabold text-slate-950" x-text="edu.school || 'Institution'"></div>
                                <div class="text-[8.5pt] text-slate-650 mt-0.5" x-text="edu.degree || 'Degree'"></div >
                                <div class="text-[8.5pt] text-indigo-650 italic mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                            </div>
                            <div class="text-right shrink-0 ml-4">
                                <div class="text-[8.5pt] text-slate-500" x-text="edu.graduation_date"></div>
                                <div class="text-[8pt] text-slate-455" x-text="edu.location"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
