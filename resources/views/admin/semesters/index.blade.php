<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Semesters</h2>
            <a href="{{ route('admin.semesters.create') }}" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Create Semester
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
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Start</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">End</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($semesters as $semester)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <a href="{{ route('admin.semesters.show', $semester) }}" class="text-sm font-bold text-primary hover:underline">{{ $semester->name }}</a>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">
                                        {{ $semester->starts_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">
                                        {{ $semester->ends_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($semester->is_active)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Active</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.semesters.show', $semester) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="View">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.semesters.edit', $semester) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">edit</span>
                                        </a>
                                        @if(!$semester->is_active)
                                            <form action="{{ route('admin.semesters.set-active', $semester) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 hover:bg-primary/10 rounded transition-colors text-primary" title="Set as active">
                                                    <span class="material-symbols-outlined text-lg">check_circle</span>
                                                </button>
                                            </form>
                                        @endif
                                        @if(!$semester->is_active && $semester->ends_at->isPast())
                                            <form action="{{ route('admin.semesters.archive', $semester) }}" method="POST" class="inline" onsubmit="return confirm('Archive this semester?');">
                                                @csrf
                                                <button type="submit" class="p-1.5 hover:bg-amber-500/10 rounded transition-colors text-amber-600 dark:text-amber-400" title="Archive">
                                                    <span class="material-symbols-outlined text-lg">archive</span>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.semesters.destroy', $semester) }}" method="POST" class="inline" onsubmit="return confirm('Delete this semester? This will remove all modules and project data.');">
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
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">
                                        No semesters yet. <a href="{{ route('admin.semesters.create') }}" class="text-primary hover:underline">Create your first semester</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($semesters->hasPages())
                    <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632]/50 flex justify-between items-center border-t border-slate-100 dark:border-[#243647]">
                        <span class="text-xs text-slate-500 dark:text-[#93adc8] font-medium">Showing {{ $semesters->firstItem() ?? 0 }} to {{ $semesters->lastItem() ?? 0 }} of {{ $semesters->total() }} semesters</span>
                        {{ $semesters->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-admin-layout>
