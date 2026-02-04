<x-admin-layout>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <!-- Top Navbar -->
        <header
            class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-8">
                <h2 class="text-lg font-bold tracking-tight">Analytics Dashboard</h2>
                <div class="relative w-64">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-[#93adc8] text-xl">search</span>
                    <input
                        class="w-full bg-slate-100 dark:bg-[#243647] border-none rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/50 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-[#93adc8]"
                        placeholder="Search data..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex gap-2">
                    <button
                        class="p-2 rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-white hover:bg-slate-200 dark:hover:bg-[#344d65] transition-colors relative">
                        <span class="material-symbols-outlined text-xl">notifications</span>
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-[#243647]"></span>
                    </button>
                    <button
                        class="p-2 rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-white hover:bg-slate-200 dark:hover:bg-[#344d65] transition-colors">
                        <span class="material-symbols-outlined text-xl">forum</span>
                    </button>
                </div>
                <div class="h-8 w-px bg-slate-200 dark:border-[#243647]"></div>
                <div class="flex items-center gap-3 pl-2">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold leading-none">{{ auth()->user()?->full_name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-500 dark:text-[#93adc8] mt-1">{{ ucfirst(auth()->user()?->user_type ?? 'Admin') }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-[#243647] border-2 border-white dark:border-[#243647] bg-cover bg-center"
                        data-alt="Admin user avatar"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB4cDDCVYIB2xR3KaCMSf8DvSW1ElfMA7N25u0p6sWEvubpukWS2W54keHPBzViijEmdyvp8rgBIT3EUxFx4VYt62BpdFbKoFsQ4w076MGbmGuvBN5IgBMUWUgt7pR7SEHPGXxH5bJKUas4FMkFbKR8jzfnZ2imY7AnSr5DgjLd9tyGAO_QoP30I2CgTkFqJ8FxhZR_D1oSmRmNMKr5BmsZFmBSG-Fa3xfVCne909VlrNYDpOwYHWyIAqRwlXIiAjDDXZYNSQXItqk')">
                    </div>
                </div>
            </div>
        </header>
        <!-- Dashboard Body -->
        <div class="p-8 max-w-7xl mx-auto w-full flex flex-col gap-8">
            <!-- Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Total Engagement</p>
                        <span class="material-symbols-outlined text-primary">analytics</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">84.2k</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="flex items-center text-emerald-500 text-sm font-semibold">
                            <span class="material-symbols-outlined text-sm">trending_up</span> 12%
                        </span>
                        <span class="text-slate-400 text-xs font-normal">vs last month</span>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Active Users</p>
                        <span class="material-symbols-outlined text-primary">person_check</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">1,240</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="flex items-center text-emerald-500 text-sm font-semibold">
                            <span class="material-symbols-outlined text-sm">trending_up</span> 5%
                        </span>
                        <span class="text-slate-400 text-xs font-normal">vs last month</span>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Avg. Completion</p>
                        <span class="material-symbols-outlined text-primary">task_alt</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">76.5%</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="flex items-center text-red-500 text-sm font-semibold">
                            <span class="material-symbols-outlined text-sm">trending_down</span> 2%
                        </span>
                        <span class="text-slate-400 text-xs font-normal">vs last month</span>
                    </div>
                </div>
                <div
                    class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Active Mentors</p>
                        <span class="material-symbols-outlined text-primary">school</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">142</p>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="flex items-center text-emerald-500 text-sm font-semibold">
                            <span class="material-symbols-outlined text-sm">trending_up</span> 8%
                        </span>
                        <span class="text-slate-400 text-xs font-normal">vs last month</span>
                    </div>
                </div>
            </div>
            <!-- Main Grid Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Cohort Progress Table -->
                <div
                    class="lg:col-span-2 flex flex-col bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                    <div
                        class="px-6 py-5 border-b border-slate-100 dark:border-[#243647] flex justify-between items-center">
                        <h3 class="font-bold text-lg">Cohort Progress Overview</h3>
                        <button class="text-sm font-semibold text-primary hover:underline">View all</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">
                                        Cohort Name</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">
                                        Start Date</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">
                                        Progress</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm font-medium">Summer 2024 BootCamp</td>
                                    <td class="px-6 py-5 text-sm text-slate-500 dark:text-[#93adc8]">June 15, 2024
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-1 h-1.5 rounded-full bg-slate-200 dark:bg-[#344d65] overflow-hidden min-w-[100px]">
                                                <div class="h-full bg-primary rounded-full" style="width: 85%">
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold">85%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">ACTIVE</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm font-medium">Advanced UX Design</td>
                                    <td class="px-6 py-5 text-sm text-slate-500 dark:text-[#93adc8]">July 01, 2024
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-1 h-1.5 rounded-full bg-slate-200 dark:bg-[#344d65] overflow-hidden min-w-[100px]">
                                                <div class="h-full bg-primary rounded-full" style="width: 42%">
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold">42%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">ON
                                            TRACK</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm font-medium">Data Science Intro</td>
                                    <td class="px-6 py-5 text-sm text-slate-500 dark:text-[#93adc8]">Aug 10, 2024
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-1 h-1.5 rounded-full bg-slate-200 dark:bg-[#344d65] overflow-hidden min-w-[100px]">
                                                <div class="h-full bg-orange-500 rounded-full" style="width: 15%">
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold">15%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-500/10 dark:text-orange-400">AT
                                            RISK</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm font-medium">Web Dev Masters</td>
                                    <td class="px-6 py-5 text-sm text-slate-500 dark:text-[#93adc8]">May 20, 2024
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex-1 h-1.5 rounded-full bg-slate-200 dark:bg-[#344d65] overflow-hidden min-w-[100px]">
                                                <div class="h-full bg-primary rounded-full" style="width: 98%">
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold">98%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-500/10 dark:text-slate-400">NEAR
                                            END</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Right: RBAC & Audit Log Summary -->
                <div class="flex flex-col gap-6">
                    <!-- Role Summary -->
                    <div
                        class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm">
                        <h3 class="font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">security</span>
                            User Roles
                        </h3>
                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-[#93adc8]">System Admins</span>
                                <span class="text-sm font-bold">12</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-[#93adc8]">Mentors</span>
                                <span class="text-sm font-bold">142</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-[#93adc8]">Mentees</span>
                                <span class="text-sm font-bold">1,086</span>
                            </div>
                            <div class="pt-4 mt-2 border-t border-slate-100 dark:border-[#243647]">
                                <button
                                    class="w-full text-center text-sm font-bold text-primary py-1.5 bg-primary/5 rounded-lg hover:bg-primary/10 transition-colors">Manage
                                    Permissions</button>
                            </div>
                        </div>
                    </div>
                    <!-- Audit Log Recent -->
                    <div
                        class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm flex-1">
                        <h3 class="font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">list_alt</span>
                            Recent Activity
                        </h3>
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-3">
                                <div
                                    class="size-8 rounded-full bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm text-blue-500">add</span>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-xs font-semibold leading-tight">Admin Alex created 'Summer 2024'
                                    </p>
                                    <p class="text-[10px] text-slate-400 dark:text-[#93adc8] mt-0.5">2 minutes ago
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div
                                    class="size-8 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm text-emerald-500">login</span>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-xs font-semibold leading-tight">System: Backup successful</p>
                                    <p class="text-[10px] text-slate-400 dark:text-[#93adc8] mt-0.5">1 hour ago</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div
                                    class="size-8 rounded-full bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm text-orange-500">lock_reset</span>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-xs font-semibold leading-tight">Mentor Sara reset password</p>
                                    <p class="text-[10px] text-slate-400 dark:text-[#93adc8] mt-0.5">3 hours ago
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div
                                    class="size-8 rounded-full bg-slate-50 dark:bg-[#243647] flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm text-slate-400">edit</span>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-xs font-semibold leading-tight">Updated RBAC Policy v2.1</p>
                                    <p class="text-[10px] text-slate-400 dark:text-[#93adc8] mt-0.5">Yesterday</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Engagement Chart Placeholder (Styled Div) -->
            <div
                class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl p-8 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="font-bold text-lg leading-tight">Weekly User Engagement</h3>
                        <p class="text-sm text-slate-500 dark:text-[#93adc8]">Real-time sessions and activity
                            tracking</p>
                    </div>
                    <div class="flex gap-2">
                        <span
                            class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg cursor-pointer">Last
                            7 Days</span>
                        <span
                            class="px-3 py-1 hover:bg-slate-100 dark:hover:bg-[#243647] text-slate-500 text-xs font-bold rounded-lg cursor-pointer transition-colors">Last
                            Month</span>
                    </div>
                </div>
                <div
                    class="h-64 w-full flex items-end justify-between gap-4 px-4 border-b border-l border-slate-100 dark:border-[#243647]">
                    <!-- Abstract "Chart" Bars -->
                    <div
                        class="w-full bg-primary/20 rounded-t h-[40%] hover:bg-primary transition-colors cursor-pointer group relative">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            12k</div>
                    </div>
                    <div
                        class="w-full bg-primary/20 rounded-t h-[65%] hover:bg-primary transition-colors cursor-pointer group relative">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            18k</div>
                    </div>
                    <div
                        class="w-full bg-primary/20 rounded-t h-[55%] hover:bg-primary transition-colors cursor-pointer group relative">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            15k</div>
                    </div>
                    <div class="w-full bg-primary rounded-t h-[90%] group relative cursor-pointer">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            24k</div>
                    </div>
                    <div
                        class="w-full bg-primary/20 rounded-t h-[75%] hover:bg-primary transition-colors cursor-pointer group relative">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            21k</div>
                    </div>
                    <div
                        class="w-full bg-primary/20 rounded-t h-[60%] hover:bg-primary transition-colors cursor-pointer group relative">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            16k</div>
                    </div>
                    <div
                        class="w-full bg-primary/20 rounded-t h-[80%] hover:bg-primary transition-colors cursor-pointer group relative">
                        <div
                            class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            22k</div>
                    </div>
                </div>
                <div
                    class="flex justify-between mt-4 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
