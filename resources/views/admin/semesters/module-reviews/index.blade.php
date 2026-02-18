<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.show', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← {{ $semester->name }}</a>
                <h2 class="text-lg font-bold tracking-tight">Module Reviews</h2>
            </div>
            <form method="GET" action="{{ route('admin.semesters.module-reviews.index', $semester) }}" class="flex items-center gap-2">
                <label for="week" class="text-sm text-slate-600 dark:text-[#93adc8]">Week</label>
                <select id="week" name="week" onchange="this.form.submit()" class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                    @foreach($weeks as $w)
                        <option value="{{ $w }}" {{ $week == $w ? 'selected' : '' }}>Week {{ $w }}</option>
                    @endforeach
                </select>
            </form>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            @if (!$module)
                <div class="rounded-lg bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 px-4 py-3 text-sm">
                    No module for Week {{ $week }} yet. Add one in <a href="{{ route('admin.semesters.modules.index', $semester) }}" class="underline">Weekly Modules</a>.
                </div>
            @else
                <p class="text-slate-600 dark:text-[#93adc8] text-sm">Module: <strong class="text-slate-900 dark:text-white">{{ $module->title }}</strong></p>
            @endif

            @foreach($byCohort as $row)
                <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647] flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $row['cohort']->name }}</h3>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium {{ $row['rate'] >= 80 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($row['rate'] >= 50 ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]') }}">
                            {{ $row['rate'] }}% reviewed ({{ $row['submitted']->count() }}/{{ $row['total'] }})
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-[#243647]">
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Mentee</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Review</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                                @foreach($row['mentees'] as $mentee)
                                    @php $review = $row['reviews']->get($mentee->id); @endphp
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $mentee->full_name }}</td>
                                        <td class="px-6 py-4">
                                            @if($review)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Submitted</span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-[#93adc8] max-w-md">
                                            @if($review)
                                                <details class="cursor-pointer">
                                                    <summary class="text-primary hover:underline">View review</summary>
                                                    <p class="mt-2 whitespace-pre-wrap text-slate-700 dark:text-slate-300">{{ Str::limit($review->content, 500) }}</p>
                                                </details>
                                            @else
                                                –
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($row['mentees']->isEmpty())
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-slate-500 dark:text-[#93adc8] text-sm">No mentees in this cohort.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</x-admin-layout>
