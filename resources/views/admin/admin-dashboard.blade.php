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
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Total Engagement</p>
                        <span class="material-symbols-outlined text-primary">analytics</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">–</p>
                    <p class="text-slate-400 text-xs font-normal mt-2"><span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span></p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Active Users</p>
                        <span class="material-symbols-outlined text-primary">person_check</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">{{ $adminCount + $coordinatorCount + $menteeCount }}</p>
                    <p class="text-slate-400 text-xs font-normal mt-2">Total registered users</p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Avg. Completion</p>
                        <span class="material-symbols-outlined text-primary">task_alt</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">–</p>
                    <p class="text-slate-400 text-xs font-normal mt-2"><span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span></p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Active Coordinators</p>
                        <span class="material-symbols-outlined text-primary">school</span>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">{{ $coordinatorCount }}</p>
                    <p class="text-slate-400 text-xs font-normal mt-2">{{ $menteeCount }} mentees</p>
                </div>
            </div>
            <!-- Main Grid Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Cohort Progress Table -->
                <div class="lg:col-span-2 flex flex-col bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-5 border-b border-slate-100 dark:border-[#243647] flex justify-between items-center">
                        <h3 class="font-bold text-lg">Cohort Overview</h3>
                        <a href="{{ route('admin.cohorts.index') }}" class="text-sm font-semibold text-primary hover:underline">View all</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Cohort Name</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Mentor</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Members</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Progress</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                                @forelse($cohorts as $cohort)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                        <td class="px-6 py-5 text-sm font-medium">
                                            <a href="{{ route('admin.cohorts.show', $cohort) }}" class="text-primary hover:underline">{{ $cohort->name }}</a>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-slate-500 dark:text-[#93adc8]">{{ $cohort->coordinator?->full_name ?? '–' }}</td>
                                        <td class="px-6 py-5 text-sm font-medium">{{ $cohort->members_count }}</td>
                                        <td class="px-6 py-5">
                                            <span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">
                                            No cohorts yet. <a href="{{ route('admin.cohorts.create') }}" class="text-primary hover:underline">Create a cohort</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Right: RBAC & Audit Log Summary -->
                <div class="flex flex-col gap-6">
                    <!-- Role Summary -->
                    <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm">
                        <h3 class="font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">security</span>
                            User Roles
                        </h3>
                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-[#93adc8]">Admins</span>
                                <span class="text-sm font-bold">{{ $adminCount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-[#93adc8]">Coordinators</span>
                                <span class="text-sm font-bold">{{ $coordinatorCount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-600 dark:text-[#93adc8]">Mentees</span>
                                <span class="text-sm font-bold">{{ $menteeCount }}</span>
                            </div>
                            <div class="pt-4 mt-2 border-t border-slate-100 dark:border-[#243647]">
                                <a href="{{ route('admin.users.index') }}" class="block w-full text-center text-sm font-bold text-primary py-1.5 bg-primary/5 rounded-lg hover:bg-primary/10 transition-colors">Manage Users</a>
                            </div>
                        </div>
                    </div>
                    <!-- Audit Log Recent -->
                    <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm flex-1">
                        <h3 class="font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">list_alt</span>
                            Recent Activity
                        </h3>
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-slate-400 dark:text-slate-500 mb-3">history</span>
                            <p class="text-sm text-slate-500 dark:text-[#93adc8]">Activity tracking</p>
                            <span class="mt-2 px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
                            <a href="{{ route('admin.logs') }}" class="mt-4 text-xs font-bold text-primary hover:underline">View Audit Logs</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Engagement Chart Placeholder -->
            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl p-8 shadow-sm">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="font-bold text-lg leading-tight">Weekly User Engagement</h3>
                        <p class="text-sm text-slate-500 dark:text-[#93adc8]">Real-time sessions and activity tracking</p>
                    </div>
                    <span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
                </div>
                <div class="h-64 w-full flex items-center justify-center rounded-lg bg-slate-50 dark:bg-[#1c2836] border border-dashed border-slate-200 dark:border-[#344d65]">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm">Engagement charts will appear here</p>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
