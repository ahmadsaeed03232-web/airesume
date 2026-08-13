<div class="h-full flex flex-col gap-6 text-[10pt] leading-normal font-sans">
    <!-- Header -->
    <div class="border-b-2 border-indigo-600 pb-4 flex justify-between items-end" :class="highlightSection === 'personal' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-950" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wider mt-1" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8.5pt] text-slate-650 space-y-0.5">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'Location, State'"></div>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-3 gap-6 flex-grow">
        <!-- Sidebar (1/3 width) -->
        <div class="col-span-1 border-r border-slate-200 pr-5 space-y-5">
            <!-- Contact Links -->
            <div x-show="personal_info.linkedin || personal_info.github || personal_info.website" class="space-y-2">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1">Profiles</h4>
                <div class="space-y-1 text-[8.5pt] text-slate-700 break-all">
                    <div x-show="personal_info.linkedin">
                        <strong class="text-slate-900 font-semibold">LinkedIn:</strong> 
                        <span x-text="personal_info.linkedin"></span>
                    </div>
                    <div x-show="personal_info.github">
                        <strong class="text-slate-900 font-semibold">GitHub:</strong> 
                        <span x-text="personal_info.github"></span>
                    </div>
                    <div x-show="personal_info.website">
                        <strong class="text-slate-900 font-semibold">Web:</strong> 
                        <span x-text="personal_info.website"></span>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div :class="highlightSection === 'skills' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''" class="space-y-4">
                <div>
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1">Technical Skills</h4>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="skill in getSplitSkills(skills.technical)">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-800 text-[8pt] rounded font-medium" x-text="skill"></span>
                        </template>
                    </div>
                </div>

                <div x-show="skills.soft">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1">Soft Skills</h4>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="skill in getSplitSkills(skills.soft)">
                            <span class="px-2 py-0.5 bg-slate-50 text-slate-700 text-[8pt] border border-slate-200 rounded font-medium" x-text="skill"></span>
                        </template>
                    </div>
                </div>

                <div x-show="skills.tools">
                    <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1">Tools & Platforms</h4>
                    <div class="flex flex-wrap gap-1 mt-2">
                        <template x-for="skill in getSplitSkills(skills.tools)">
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-900 text-[8pt] rounded font-medium" x-text="skill"></span>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Body (2/3 width) -->
        <div class="col-span-2 space-y-5">
            <template x-for="sec in section_order" :key="sec">
                <div>
                    <!-- Summary -->
                    <template x-if="sec === 'summary'">
                        <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''" class="mb-4">
                            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-2">Professional Summary</h4>
                            <p class="text-slate-700 text-justify leading-relaxed" x-text="summary"></p>
                        </div>
                    </template>

                    <!-- Experience -->
                    <template x-if="sec === 'experience'">
                        <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''" class="mb-4">
                            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Work Experience</h4>
                            <div class="space-y-4">
                                <template x-for="(exp, index) in experience" :key="index">
                                    <div>
                                        <div class="flex justify-between items-start font-semibold text-slate-900">
                                            <span x-text="(exp.position || 'Position') + ' at ' + (exp.company || 'Company')"></span>
                                            <span class="text-[9pt] font-normal text-slate-500 shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                                        </div>
                                        <div class="text-[9pt] text-slate-500 italic mt-0.5" x-text="exp.location || 'Location'"></div>
                                        <p class="text-slate-700 mt-1.5 whitespace-pre-line leading-relaxed text-justify" x-text="exp.description"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Projects -->
                    <template x-if="sec === 'projects'">
                        <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''" class="mb-4">
                            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Key Projects</h4>
                            <div class="space-y-3">
                                <template x-for="(proj, index) in projects" :key="index">
                                    <div>
                                        <div class="flex justify-between items-start font-semibold text-slate-900">
                                            <span x-text="proj.title || 'Project Title'"></span>
                                            <span class="text-[9.5pt] font-normal text-slate-500 shrink-0 ml-4 x-show='proj.link'" x-text="proj.link"></span>
                                        </div>
                                        <div class="text-[8.5pt] font-bold text-indigo-600 mt-0.5" x-text="proj.technologies"></div>
                                        <p class="text-slate-700 mt-1 whitespace-pre-line leading-relaxed text-justify" x-text="proj.description"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Education -->
                    <template x-if="sec === 'education'">
                        <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-indigo-50/50 p-2 -m-2 rounded' : ''" class="mb-4">
                            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-950 border-b border-slate-200 pb-1 mb-3">Education</h4>
                            <div class="space-y-3">
                                <template x-for="(edu, index) in education" :key="index">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-semibold text-slate-900" x-text="edu.school || 'Institution'"></div>
                                            <div class="text-[9pt] text-slate-655 mt-0.5" x-text="edu.degree || 'Degree & Major'"></div>
                                            <div class="text-[8.5pt] text-indigo-600 italic mt-0.5" x-text="edu.gpa ? 'GPA/Achievements: ' + edu.gpa : ''"></div>
                                        </div>
                                        <div class="text-right shrink-0 ml-4">
                                            <div class="text-[9pt] text-slate-500" x-text="edu.graduation_date || 'Date'"></div>
                                            <div class="text-[8.5pt] text-slate-400" x-text="edu.location || 'Location'"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>
