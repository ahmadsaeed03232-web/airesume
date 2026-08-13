<div class="h-full flex flex-col gap-4 text-[9pt] leading-relaxed font-sans text-slate-900">
    <!-- High density Header -->
    <div class="flex justify-between items-start pb-2 border-b border-slate-300" :class="highlightSection === 'personal' ? 'bg-slate-50 p-2 -m-2 rounded' : ''">
        <div>
            <h1 class="text-xl font-extrabold text-slate-950 tracking-tight" x-text="personal_info.name || 'Your Full Name'"></h1>
            <p class="text-xs font-bold text-slate-500 uppercase mt-0.5" x-text="target_role || 'Target Role'"></p>
        </div>
        <div class="text-right text-[8pt] text-slate-650 leading-snug">
            <div x-text="personal_info.email || 'email@example.com'"></div>
            <div x-text="personal_info.phone || '+1 (555) 0123'"></div>
            <div x-text="personal_info.location || 'City, State'"></div>
            <div class="flex gap-1.5 justify-end mt-1 text-slate-400 font-medium">
                <span x-show="personal_info.github" x-text="'github.com/' + personal_info.github"></span>
                <span x-show="personal_info.linkedin" x-text="' | ln/' + personal_info.linkedin"></span>
            </div>
        </div>
    </div>

    <!-- Dynamic Sections -->
    <template x-for="sec in section_order" :key="sec">
        <div>
            <!-- Summary -->
            <template x-if="sec === 'summary'">
                <div x-show="summary" :class="highlightSection === 'summary' ? 'bg-slate-50 p-2 -m-2 rounded' : ''" class="mb-4">
                    <p class="text-slate-700 text-justify" x-text="summary"></p>
                </div>
            </template>

            <!-- Experience -->
            <template x-if="sec === 'experience'">
                <div x-show="experience.length > 0" :class="highlightSection === 'experience' ? 'bg-slate-50 p-2 -m-2 rounded' : ''" class="mb-4">
                    <h4 class="text-[9pt] font-extrabold text-slate-950 border-b border-slate-200 pb-0.5 mb-2">EXPERIENCE</h4>
                    <div class="space-y-3">
                        <template x-for="(exp, index) in experience" :key="index">
                            <div>
                                <div class="flex justify-between font-bold text-slate-950">
                                    <span x-text="(exp.position || 'Position') + ' @ ' + (exp.company || 'Company')"></span>
                                    <span class="text-[8pt] font-semibold text-slate-500 shrink-0 ml-4" x-text="(exp.start_date || 'Start') + ' - ' + (exp.end_date || 'End')"></span>
                                </div>
                                <div class="text-[8pt] text-slate-500 italic" x-text="exp.location || 'Location'"></div>
                                <p class="text-slate-700 mt-1 whitespace-pre-line text-justify leading-snug" x-text="exp.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Projects -->
            <template x-if="sec === 'projects'">
                <div x-show="projects.length > 0" :class="highlightSection === 'projects' ? 'bg-slate-50 p-2 -m-2 rounded' : ''" class="mb-4">
                    <h4 class="text-[9pt] font-extrabold text-slate-950 border-b border-slate-200 pb-0.5 mb-2">PROJECTS</h4>
                    <div class="space-y-2">
                        <template x-for="(proj, index) in projects" :key="index">
                            <div>
                                <div class="flex justify-between font-bold text-slate-950">
                                    <span x-text="proj.title || 'Project'"></span>
                                    <span class="text-[8pt] font-medium text-slate-400 hover:underline cursor-pointer truncate max-w-[200px]" x-text="proj.link"></span>
                                </div>
                                <div class="text-[8pt] font-semibold text-slate-500" x-text="proj.technologies"></div>
                                <p class="text-slate-700 mt-0.5 whitespace-pre-line text-justify leading-snug" x-text="proj.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Education -->
            <template x-if="sec === 'education'">
                <div x-show="education.length > 0" :class="highlightSection === 'education' ? 'bg-slate-50 p-2 -m-2 rounded' : ''" class="mb-4">
                    <h4 class="text-[9pt] font-extrabold text-slate-950 border-b border-slate-200 pb-0.5 mb-2">EDUCATION</h4>
                    <div class="space-y-1.5">
                        <template x-for="(edu, index) in education" :key="index">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-bold text-slate-950" x-text="edu.school || 'School'"></span>
                                    <span class="text-slate-650" x-text="' &bull; ' + (edu.degree || 'Degree')"></span>
                                    <span class="text-[8pt] font-semibold text-slate-400 ml-2" x-text="edu.gpa ? '('+edu.gpa+')' : ''"></span>
                                </div>
                                <span class="text-[8pt] font-semibold text-slate-500 text-right shrink-0 ml-4" x-text="edu.graduation_date"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Skills -->
            <template x-if="sec === 'skills'">
                <div :class="highlightSection === 'skills' ? 'bg-slate-50 p-2 -m-2 rounded' : ''" class="mb-4">
                    <h4 class="text-[9pt] font-extrabold text-slate-950 border-b border-slate-200 pb-0.5 mb-1.5">SKILLS</h4>
                    <div class="grid grid-cols-3 gap-2 text-[8.5pt] text-slate-700">
                        <div x-show="skills.technical">
                            <span class="font-bold text-slate-950 block">TECHNICAL</span>
                            <span x-text="skills.technical"></span>
                        </div>
                        <div x-show="skills.soft">
                            <span class="font-bold text-slate-950 block">SOFT</span>
                            <span x-text="skills.soft"></span>
                        </div>
                        <div x-show="skills.tools">
                            <span class="font-bold text-slate-950 block">TOOLS</span>
                            <span x-text="skills.tools"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div>
