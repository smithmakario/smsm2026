<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Cohort Management</h2>
            <a href="{{ route('admin.cohorts.create') }}" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Create New Cohort
            </a>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            @if (session('status'))
                <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Total Cohorts</p>
                        <div class="p-2 bg-primary/10 rounded-lg">
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">{{ $cohorts->total() }}</p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Active Mentees</p>
                        <div class="p-2 bg-indigo-500/10 rounded-lg">
                            <span class="material-symbols-outlined text-indigo-500">person</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">{{ \App\Models\User::where('user_type', \App\Models\User::TYPE_MENTEE)->count() }}</p>
                </div>
                <div class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Assigned Mentors</p>
                        <div class="p-2 bg-orange-500/10 rounded-lg">
                            <span class="material-symbols-outlined text-orange-500">badge</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold tracking-tight">{{ \App\Models\Cohort::whereNotNull('mentor_id')->distinct('mentor_id')->count('mentor_id') }}</p>
                </div>
            </div>
            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Cohort Name</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Mentor</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Meeting Time</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Members</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($cohorts as $cohort)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <a href="{{ route('admin.cohorts.show', $cohort) }}" class="text-sm font-bold text-primary hover:underline">{{ $cohort->name }}</a>
                                    </td>
                                    <td class="px-6 py-5 text-sm">
                                        {{ $cohort->mentor?->full_name ?? '–' }}
                                    </td>
                                    <td class="px-6 py-5 text-xs text-slate-500 dark:text-[#93adc8]">
                                        {{ $cohort->meeting_time?->format('M j, Y g:i A') ?? '–' }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        {{ $cohort->members->count() }}
                                    </td>
                                    <td class="px-6 py-5 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.cohorts.show', $cohort) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="View & Edit">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('admin.cohorts.destroy', $cohort) }}" method="POST" class="inline" onsubmit="return confirm('Delete this cohort?');">
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
                                        No cohorts yet. <a href="{{ route('admin.cohorts.create') }}" class="text-primary hover:underline">Create your first cohort</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($cohorts->hasPages())
                    <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632]/50 flex justify-between items-center border-t border-slate-100 dark:border-[#243647]">
                        <span class="text-xs text-slate-500 dark:text-[#93adc8] font-medium">Showing {{ $cohorts->firstItem() ?? 0 }} to {{ $cohorts->lastItem() ?? 0 }} of {{ $cohorts->total() }} cohorts</span>
                        {{ $cohorts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-admin-layout>
