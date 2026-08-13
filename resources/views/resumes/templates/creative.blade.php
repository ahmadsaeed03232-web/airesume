<div class="h-full flex flex-col gap-5 text-[9.5pt] leading-normal font-sans text-slate-900 template-creative">
    <!-- Top Teal Header Card -->
    <div class="bg-teal-600 text-white p-6 rounded-xl flex justify-between items-center" :class="highlightSection === 'personal' ? 'ring-4 ring-teal-300' : ''">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-sm font-medium text-teal-100 uppercase tracking-widest mt-1" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8.5pt] text-teal-50 space-y-0.5 shrink-0 ml-4">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'Location, State'"></div>
        </div>
    </div>

    <!-- Outer Grid -->
    <div class="grid grid-cols-3 gap-6 flex-grow">
        <!-- Sidebar -->
        <div class="col-span-1 space-y-5">
            <!-- Contact profiles -->
            <div x-show="personal_info.linkedin || personal_info.github || personal_info.website" class="bg-teal-50/50 p-4 rounded-xl space-y-2 border border-teal-100/50">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-teal-800 border-b border-teal-200/60 pb-1">Web Profiles</h4>
                <div class="space-y-1.5 text-[8.5pt] text-slate-700 break-all">
                    <div x-show="personal_info.linkedin" class="flex flex-col">
                        <span class="text-[7.5pt] uppercase font-bold text-teal-700">LinkedIn</span>
                        <span x-text="personal_info.linkedin"></span>
                    </div>
                    <div x-show="personal_info.github" class="flex flex-col mt-1">
                        <span class="text-[7.5pt] uppercase font-bold text-teal-700">GitHub</span>
                        <span x-text="personal_info.github"></span>
                    </div>
                    <div x-show="personal_info.website" class="flex flex-col mt-1">
                        <span class="text-[7.5pt] uppercase font-bold text-teal-700">Portfolio</span>
                        <span x-text="personal_info.website"></span>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div :class="highlightSection === 'skills' ? 'bg-teal-50 p-4 -m-2 rounded-xl border border-teal-200' : ''" class="space-y-4">
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-800 border-b border-slate-200 pb-1">Technical Skills</h4>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="skill in getSplitSkills(skills.technical)">
                            <span class="px-2 py-0.5 bg-teal-50 text-teal-900 text-[8pt] rounded-md font-medium border border-teal-100" x-text="skill"></span>
                        </template>
                    </div>
                </div>

                <div x-show="skills.soft" class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-800 border-b border-slate-200 pb-1">Soft Skills</h4>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="skill in getSplitSkills(skills.soft)">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[8pt] rounded-md font-medium" x-text="skill"></span>
                        </template>
                    </div>
                </div>

                <div x-show="skills.tools" class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-800 border-b border-slate-200 pb-1">Tools & Platforms</h4>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="skill in getSplitSkills(skills.tools)">
                            <span class="px-2 py-0.5 bg-teal-600 text-white text-[8pt] rounded-md font-medium" x-text="skill"></span>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content column -->
        <div class="col-span-2 space-y-5">
            <!-- Summary -->
            <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-teal-50/50 p-3 -m-3 rounded-xl' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-teal-800 border-b-2 border-teal-600 pb-1 mb-2">Professional Summary</h4>
                <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
            </div>

            <!-- Experience -->
            <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-teal-50/50 p-3 -m-3 rounded-xl' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-teal-800 border-b-2 border-teal-600 pb-1 mb-3">Work History</h4>
                <div class="space-y-4">
                    <template x-for="(exp, index) in experience" :key="index">
                        <div class="relative pl-4 border-l-2 border-teal-200 hover:border-teal-500 transition-colors">
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span class="text-teal-950 font-bold" x-text="(exp.position || 'Position') + ' at ' + (exp.company || 'Company')"></span>
                                <span class="text-[8.5pt] font-medium text-teal-700 shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                            </div>
                            <div class="text-[8.5pt] text-slate-500 italic mt-0.5" x-text="exp.location"></div>
                            <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="exp.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Projects -->
            <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-teal-50/50 p-3 -m-3 rounded-xl' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-teal-800 border-b-2 border-teal-600 pb-1 mb-3">Featured Projects</h4>
                <div class="space-y-3.5">
                    <template x-for="(proj, index) in projects" :key="index">
                        <div>
                            <div class="flex justify-between items-start font-semibold text-slate-900">
                                <span x-text="proj.title || 'Project Title'"></span>
                                <span class="text-[8.5pt] font-normal text-teal-600 shrink-0 ml-4" x-text="proj.link"></span>
                            </div>
                            <div class="text-[8.5pt] font-bold text-teal-600 mt-0.5" x-text="proj.technologies"></div>
                            <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-relaxed" x-text="proj.description"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Education -->
            <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-teal-50/50 p-3 -m-3 rounded-xl' : ''">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-teal-800 border-b-2 border-teal-600 pb-1 mb-3">Education</h4>
                <div class="space-y-3">
                    <template x-for="(edu, index) in education" :key="index">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-bold text-slate-900" x-text="edu.school || 'Institution'"></div>
                                <div class="text-[8.5pt] text-slate-650 mt-0.5" x-text="edu.degree || 'Degree & Major'"></div>
                                <div class="text-[8pt] text-teal-700 font-bold mt-0.5" x-text="edu.gpa ? 'GPA: ' + edu.gpa : ''"></div>
                            </div>
                            <div class="text-right shrink-0 ml-4">
                                <div class="text-[8.5pt] text-slate-500" x-text="edu.graduation_date"></div>
                                <div class="text-[8pt] text-slate-400" x-text="edu.location"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
