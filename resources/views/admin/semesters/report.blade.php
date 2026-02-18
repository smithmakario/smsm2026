<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.show', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← {{ $semester->name }}</a>
                <h2 class="text-lg font-bold tracking-tight">Semester Report</h2>
            </div>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium mb-1">Total Mentees</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $totalMentees }}</p>
                </div>
                <div class="rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium mb-1">Project completion</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $projectCompletionRate }}%</p>
                    <p class="text-xs text-slate-500 dark:text-[#93adc8] mt-1">{{ $completedOrVerified }} mentees completed or verified</p>
                </div>
                <div class="rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium mb-1">Top contributors</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $topContributors->count() }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Participation rate per module (week)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Week</th>
                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @foreach($participationByWeek as $week => $data)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">Week {{ $week }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-[#93adc8]">{{ $data['submitted'] }} / {{ $data['total'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium {{ $data['rate'] >= 80 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($data['rate'] >= 50 ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]') }}">
                                            {{ $data['rate'] }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Top contributors (by points)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Mentee</th>
                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Points</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($topContributors as $i => $row)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-[#93adc8]">{{ $i + 1 }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $row->user?->full_name ?? '–' }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $row->points }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">No points recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(!empty($reviewThemes))
                <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Behavioral growth insights (frequent words in reviews)</h3>
                    </div>
                    <div class="p-6 flex flex-wrap gap-2">
                        @foreach($reviewThemes as $word)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">{{ $word }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>
</x-admin-layout>
