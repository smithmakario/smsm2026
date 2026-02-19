<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.show', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← {{ $semester->name }}</a>
                <h2 class="text-lg font-bold tracking-tight">Weekly Modules</h2>
            </div>
            <a href="{{ route('admin.semesters.modules.create', $semester) }}" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Add Module
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
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Week</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Content</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Activities</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Scheduled</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Published</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($modules as $module)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 font-medium text-slate-900 dark:text-white">{{ $module->week_number }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-900 dark:text-white">{{ $module->title }}</td>
                                    <td class="px-6 py-5 text-xs text-slate-500 dark:text-[#93adc8]">
                                        @if($module->audio_path) <span class="inline-block mr-2">Audio</span> @endif
                                        @if($module->video_url) <span class="inline-block mr-2">Video</span> @endif
                                        @if($module->pdf_path) <span class="inline-block">PDF</span> @endif
                                        @if(!$module->audio_path && !$module->video_url && !$module->pdf_path) – @endif
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-600 dark:text-[#93adc8]">
                                        @php
                                            $activitiesCount = $module->activities->count();
                                            $nextActivity = $module->activities->sortBy('occurs_at')->first();
                                        @endphp
                                        @if($activitiesCount > 0)
                                            <div>{{ $activitiesCount }} {{ \Illuminate\Support\Str::plural('activity', $activitiesCount) }}</div>
                                            @if($nextActivity?->occurs_at)
                                                <div class="mt-0.5 text-[11px] text-slate-500 dark:text-[#93adc8]">
                                                    Next: {{ $nextActivity->occurs_at->format('D j M, g:i A') }}
                                                </div>
                                            @endif
                                        @else
                                            –
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-600 dark:text-[#93adc8]">
                                        @if($module->scheduled_start_at && $module->scheduled_end_at)
                                            @if($module->scheduled_start_at->isSameDay($module->scheduled_end_at))
                                                {{ $module->scheduled_start_at->format('l j M, g:i A') }} - {{ $module->scheduled_end_at->format('g:i A') }}
                                            @else
                                                {{ $module->scheduled_start_at->format('l j M, g:i A') }} to {{ $module->scheduled_end_at->format('l j M, g:i A') }}
                                            @endif
                                        @else
                                            –
                                        @endif
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($module->isPublished())
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                                {{ $module->published_at?->format('M j, Y') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]">Not published</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.semesters.modules.edit', [$semester, $module]) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('admin.semesters.modules.destroy', [$semester, $module]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this module?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 hover:bg-red-500/10 rounded transition-colors text-red-500" title="Delete">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">
                                        No modules yet. <a href="{{ route('admin.semesters.modules.create', $semester) }}" class="text-primary hover:underline">Add the first module</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
