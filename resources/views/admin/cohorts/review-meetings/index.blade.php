<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.cohorts.show', $cohort) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← {{ $cohort->name }}</a>
                <h2 class="text-lg font-bold tracking-tight">Review Meetings</h2>
            </div>
            <a href="{{ route('admin.cohorts.review-meetings.create', $cohort) }}" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Record Meeting
            </a>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            @if (session('status'))
                <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Week</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Occurred</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($meetings as $meeting)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm text-slate-900 dark:text-white">{{ $meeting->semester->name ?? '–' }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">Week {{ $meeting->week_number }}</td>
                                    <td class="px-6 py-5 text-sm">
                                        @if($meeting->user_id)
                                            <span class="text-slate-600 dark:text-[#93adc8]">Individual – {{ $meeting->user?->full_name ?? '–' }}</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-primary/10 text-primary">Group</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">{{ $meeting->occurred_at->format('M j, Y g:i A') }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8] max-w-xs truncate">{{ Str::limit($meeting->notes, 60) ?: '–' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">
                                        No review meetings recorded yet. <a href="{{ route('admin.cohorts.review-meetings.create', $cohort) }}" class="text-primary hover:underline">Record the first meeting</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($meetings->hasPages())
                    <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632]/50 flex justify-between items-center border-t border-slate-100 dark:border-[#243647]">
                        <span class="text-xs text-slate-500 dark:text-[#93adc8] font-medium">Showing {{ $meetings->firstItem() ?? 0 }} to {{ $meetings->lastItem() ?? 0 }} of {{ $meetings->total() }}</span>
                        {{ $meetings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-admin-layout>
