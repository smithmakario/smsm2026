<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Event Management</h2>
            <a href="{{ route('admin.events.create') }}" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-lg">add</span>
                Create Event
            </a>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            @if (session('status'))
                <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" action="{{ route('admin.events.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label for="type" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Type</label>
                    <select id="type" name="type" class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm">
                        <option value="">All</option>
                        <option value="free" {{ request('type') === 'free' ? 'selected' : '' }}>Free</option>
                        <option value="paid" {{ request('type') === 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div>
                    <label for="format" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Format</label>
                    <select id="format" name="format" class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm">
                        <option value="">All</option>
                        <option value="onsite" {{ request('format') === 'onsite' ? 'selected' : '' }}>Onsite</option>
                        <option value="virtual" {{ request('format') === 'virtual' ? 'selected' : '' }}>Virtual</option>
                    </select>
                </div>
                <div>
                    <label for="from" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">From</label>
                    <input type="date" id="from" name="from" value="{{ request('from') }}" class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm">
                </div>
                <div>
                    <label for="to" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">To</label>
                    <input type="date" id="to" name="to" value="{{ request('to') }}" class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90">Filter</button>
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 bg-slate-200 dark:bg-[#243647] text-slate-700 dark:text-white text-sm font-bold rounded-lg">Clear</a>
            </form>

            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Event</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Format</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Attendees</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($events as $event)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <a href="{{ route('admin.events.show', $event) }}" class="text-sm font-bold text-primary hover:underline">{{ $event->title }}</a>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">
                                        {{ $event->start_at->format('M j, Y g:i A') }}
                                    </td>
                                    <td class="px-6 py-5 text-sm">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ $event->type === 'paid' ? 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400' : 'bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]' }}">{{ ucfirst($event->type) }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-sm">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]">{{ ucfirst($event->format) }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium">
                                        {{ $event->registrations()->where('status', '!=', \App\Models\EventRegistration::STATUS_CANCELLED)->count() }}
                                        @if($event->capacity)
                                            / {{ $event->capacity }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.events.show', $event) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="View">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event?');">
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
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">
                                        No events yet. <a href="{{ route('admin.events.create') }}" class="text-primary hover:underline">Create your first event</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($events->hasPages())
                    <div class="px-6 py-4 bg-slate-50 dark:bg-[#1a2632]/50 flex justify-between items-center border-t border-slate-100 dark:border-[#243647]">
                        <span class="text-xs text-slate-500 dark:text-[#93adc8] font-medium">Showing {{ $events->firstItem() ?? 0 }} to {{ $events->lastItem() ?? 0 }} of {{ $events->total() }} events</span>
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-admin-layout>
