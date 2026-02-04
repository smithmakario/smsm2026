<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header
            class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-card-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-border-dark px-8 py-3">
            <div class="flex items-center gap-8">
                <h2 class="text-lg font-bold tracking-tight">Cohort Management</h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex gap-2">
                    <button
                        class="p-2 rounded-lg bg-slate-100 dark:bg-border-dark text-slate-600 dark:text-white hover:bg-slate-200 dark:hover:bg-[#344d65] transition-colors">
                        <span class="material-symbols-outlined text-xl">notifications</span>
                    </button>
                    <button
                        class="p-2 rounded-lg bg-slate-100 dark:bg-border-dark text-slate-600 dark:text-white hover:bg-slate-200 dark:hover:bg-[#344d65] transition-colors">
                        <span class="material-symbols-outlined text-xl">help</span>
                    </button>
                </div>
                <button
                    class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Create New Cohort
                </button>
            </div>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-card-dark border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-text-muted text-sm font-medium">Total Cohorts</p>
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">24</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="text-emerald-500 text-xs font-semibold">+2 this month</span>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-card-dark border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-text-muted text-sm font-medium">Active Mentees</p>
                        <div class="p-2 bg-indigo-500/10 rounded-lg">
                            <span class="material-symbols-outlined text-indigo-500">person</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">1,086</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="text-emerald-500 text-xs font-semibold">94% engagement rate</span>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-card-dark border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-text-muted text-sm font-medium">Upcoming Milestones
                        </p>
                        <div class="p-2 bg-orange-500/10 rounded-lg">
                            <span class="material-symbols-outlined text-orange-500">event_upcoming</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">8</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="text-orange-500 text-xs font-semibold">3 due this week</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <div
                    class="xl:col-span-3 flex flex-col bg-white dark:bg-card-dark border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="px-6 py-5 border-b border-slate-100 dark:border-border-dark flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="relative w-full sm:w-80">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-text-muted text-xl">search</span>
                            <input
                                class="w-full bg-slate-100 dark:bg-border-dark border-none rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/50 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder-text-muted"
                                placeholder="Search cohorts, mentors..." type="text" />
                        </div>
                        <div class="flex items-center gap-3">
                            <button
                                class="flex items-center gap-2 px-3 py-2 bg-slate-100 dark:bg-border-dark rounded-lg text-sm font-medium hover:bg-slate-200 dark:hover:bg-[#344d65] transition-colors">
                                <span class="material-symbols-outlined text-sm">filter_list</span>
                                Filter
                            </button>
                            <button
                                class="flex items-center gap-2 px-3 py-2 bg-slate-100 dark:bg-border-dark rounded-lg text-sm font-medium hover:bg-slate-200 dark:hover:bg-[#344d65] transition-colors">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Export
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-border-dark">
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-text-muted uppercase tracking-wider">
                                        Cohort Name</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-text-muted uppercase tracking-wider">
                                        Mentor Assigned</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-text-muted uppercase tracking-wider">
                                        Dates</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-text-muted uppercase tracking-wider">
                                        Enrollment</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-text-muted uppercase tracking-wider">
                                        Health</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-text-muted uppercase tracking-wider text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-border-dark">
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">UX/UI Design Immersive</span>
                                            <span
                                                class="text-[10px] text-primary font-medium tracking-wide">DESIGN-2024-A</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="size-7 rounded-full bg-slate-200 dark:bg-border-dark flex items-center justify-center overflow-hidden">
                                                <img alt="avatar" class="w-full h-full object-cover"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGmmJ7I_2nq5EhRMcEw28DMsvQsTzhOvrHE3r6B_j8yPBZpoEFjDmlEtDIbYMJLxKEeWLnZ5erBZohn_BjwIUYeI7vFPWF_ptWRbhO9QbUmIE5bS1oQj00CYFNwqwE5snGh9r6HhmkeLWdD0KfjA2m0kqc0t1Qo9ELIoMgy3aNeV1vXWZSScZnH1dVihkZM8C1LfcZhroIWazWF9wJ4qzp78UMcYAUiWDAhjNKbJ9wr5bUHFk2l7skj1cS5gWvKvRwR23-SFTTg1g" />
                                            </div>
                                            <span class="text-sm">Elena Rodriguez</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-500 dark:text-text-muted">
                                        Jun 15 - Sep 15, 2024
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        124 / 150
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                            ON TRACK
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <button
                                            class="p-1 hover:bg-slate-100 dark:hover:bg-border-dark rounded transition-colors">
                                            <span class="material-symbols-outlined text-slate-400">more_vert</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">Data Science Essentials</span>
                                            <span
                                                class="text-[10px] text-primary font-medium tracking-wide">DATA-2024-C</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="size-7 rounded-full bg-slate-200 dark:bg-border-dark flex items-center justify-center overflow-hidden">
                                                <img alt="avatar" class="w-full h-full object-cover"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiY-YU8Lb7ZhG_yMNCoOcGiUZfElOFjcPaRQNGnyyk9ifRaPcpBPsJ0kujoZFaalpWyMOtDOMVWOm0WaslygVHY6_YNujhTyNOczYdskZtK6CBIG9k1wVmfiHTvzie8kZc2S0prBtjmfB4buWy6HEzhCjIn5x1vStXNcybO9l3zPwDCFCAKkOGBAPNp3i2rvufMjWOoWrujH8UnRTqxP-qPjoi7M2XqrDZjYUm30KedEPuNuWEvH7SHxyzP28E_o_-5NSx6g_3nk8" />
                                            </div>
                                            <span class="text-sm">Marcus Chen</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-500 dark:text-text-muted">
                                        Jul 01 - Dec 20, 2024
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        88 / 100
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-500/10 dark:text-orange-400">
                                            <span class="size-1.5 rounded-full bg-orange-500"></span>
                                            AT RISK
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <button
                                            class="p-1 hover:bg-slate-100 dark:hover:bg-border-dark rounded transition-colors">
                                            <span class="material-symbols-outlined text-slate-400">more_vert</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">Advanced Web Dev</span>
                                            <span
                                                class="text-[10px] text-primary font-medium tracking-wide">WEB-2024-B</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="size-7 rounded-full bg-slate-200 dark:bg-border-dark flex items-center justify-center overflow-hidden">
                                                <img alt="avatar" class="w-full h-full object-cover"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuArp7HakJmcMawREcqp7XJj6PILNpkXkU8ZFQAbyPEaI5h-VITHdw8RvG0ldkJTE6q2XbsxcqLQTFJFVjSzvo5YTnGMblSxL1mL92sIy6pYzKyCLoReo8Xd9y6Upt-_GjS1Uw1OLrupQBv1KCLvIZjdcyxmKcs43io2Xr7XOaqpG5r6UHX0VowY2Qrjhs52ITUul1amlqqId8PW0ENKAmCZ0uu8kVEofOoJEWAjCITKow2xAnj4I0NY-ukCVsV_4MBJ0cyR44d5Z8g" />
                                            </div>
                                            <span class="text-sm">David Miller</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-500 dark:text-text-muted">
                                        Aug 10 - Nov 10, 2024
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        45 / 50
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                            ON TRACK
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <button
                                            class="p-1 hover:bg-slate-100 dark:hover:bg-border-dark rounded transition-colors">
                                            <span class="material-symbols-outlined text-slate-400">more_vert</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold">Product Strategy</span>
                                            <span
                                                class="text-[10px] text-primary font-medium tracking-wide">PM-2024-D</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="size-7 rounded-full bg-slate-200 dark:bg-border-dark flex items-center justify-center overflow-hidden">
                                                <img alt="avatar" class="w-full h-full object-cover"
                                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2s1c9yZ3h-EZ82nCmu-Uaj8sig924HW_10PnreIezCpAnd6kN5Roiri75hlNqIBNgxlTE6g9JpCcuSI12NQ_pRgjjD18X5ssPqzL9kD872tLEMLVJU_gVhV4jQTfbqt5VhHq0HZnEy0iEROIMmYx7pHSZ4AuzAp8KayDpgV7I0npvBycMMpzXsrdUWqxFwzc0jRbUIoMJ_LGNURx1UyY9ZTaqZnwmbHX4CnzXJbWMOTmH4aEef9c16M9WRDk4n3fHyRE8FTMGyqQ" />
                                            </div>
                                            <span class="text-sm">Sarah Jenkins</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-500 dark:text-text-muted">
                                        Sep 01 - Oct 30, 2024
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        20 / 30
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-500/10 dark:text-slate-400">
                                            <span class="size-1.5 rounded-full bg-slate-400"></span>
                                            PENDING
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <button
                                            class="p-1 hover:bg-slate-100 dark:hover:bg-border-dark rounded transition-colors">
                                            <span class="material-symbols-outlined text-slate-400">more_vert</span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632]/50 flex justify-between items-center border-t border-slate-100 dark:border-border-dark">
                        <span class="text-xs text-slate-500 dark:text-text-muted font-medium">Showing 1 to 4 of
                            24 cohorts</span>
                        <div class="flex gap-2">
                            <button
                                class="px-3 py-1 bg-white dark:bg-border-dark border border-slate-200 dark:border-[#344d65] rounded text-xs font-bold hover:bg-slate-100 disabled:opacity-50"
                                disabled="">Prev</button>
                            <button class="px-3 py-1 bg-primary text-white rounded text-xs font-bold">1</button>
                            <button
                                class="px-3 py-1 bg-white dark:bg-border-dark border border-slate-200 dark:border-[#344d65] rounded text-xs font-bold hover:bg-slate-100">2</button>
                            <button
                                class="px-3 py-1 bg-white dark:bg-border-dark border border-slate-200 dark:border-[#344d65] rounded text-xs font-bold hover:bg-slate-100">3</button>
                            <button
                                class="px-3 py-1 bg-white dark:bg-border-dark border border-slate-200 dark:border-[#344d65] rounded text-xs font-bold hover:bg-slate-100">Next</button>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-6">
                    <div
                        class="bg-white dark:bg-card-dark border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-sm flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">calendar_month</span>
                                Cohort Calendar
                            </h3>
                            <button class="text-xs text-primary font-bold hover:underline">View All</button>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-3 pb-3 border-b border-slate-100 dark:border-border-dark">
                                <div
                                    class="flex flex-col items-center justify-center bg-primary/10 rounded-lg p-2 min-w-[44px]">
                                    <span class="text-[10px] font-bold text-primary uppercase">Jun</span>
                                    <span class="text-lg font-bold leading-none">15</span>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <p class="text-xs font-bold">Bootcamp Kickoff</p>
                                    <p class="text-[10px] text-text-muted mt-0.5">UX/UI Cohort A</p>
                                </div>
                            </div>
                            <div class="flex gap-3 pb-3 border-b border-slate-100 dark:border-border-dark">
                                <div
                                    class="flex flex-col items-center justify-center bg-orange-500/10 rounded-lg p-2 min-w-[44px]">
                                    <span class="text-[10px] font-bold text-orange-500 uppercase">Jun</span>
                                    <span class="text-lg font-bold leading-none">22</span>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <p class="text-xs font-bold">Module 1 Review</p>
                                    <p class="text-[10px] text-text-muted mt-0.5">Data Essentials</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div
                                    class="flex flex-col items-center justify-center bg-indigo-500/10 rounded-lg p-2 min-w-[44px]">
                                    <span class="text-[10px] font-bold text-indigo-500 uppercase">Jul</span>
                                    <span class="text-lg font-bold leading-none">01</span>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <p class="text-xs font-bold">Mid-term Project</p>
                                    <p class="text-[10px] text-text-muted mt-0.5">Web Dev Masters</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-card-dark border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm">
                        <h3 class="font-bold text-sm mb-4">Quick Resources</h3>
                        <div class="grid grid-cols-1 gap-2">
                            <a class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-border-dark transition-colors group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-slate-400 group-hover:text-primary">library_books</span>
                                <span class="text-xs font-medium">Curriculum Templates</span>
                            </a>
                            <a class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-border-dark transition-colors group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-slate-400 group-hover:text-primary">person_add</span>
                                <span class="text-xs font-medium">Invite New Mentors</span>
                            </a>
                            <a class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-border-dark transition-colors group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-slate-400 group-hover:text-primary">assignment_ind</span>
                                <span class="text-xs font-medium">Enrollment Bulk Upload</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
