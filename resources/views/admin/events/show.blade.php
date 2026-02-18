<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.events.index') }}" class="text-slate-500 dark:text-[#93adc8] hover:text-primary">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-lg font-bold tracking-tight">{{ $event->title }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.events.edit', $event) }}" class="flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-all">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit Event
                </a>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-500/10 text-red-500 rounded-lg text-sm font-bold hover:bg-red-500/20 transition-all">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Delete
                    </button>
                </form>
            </div>
        </header>
        <div class="p-8 max-w-4xl flex flex-col gap-8">
            @if (session('status'))
                <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Event details --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Event Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Start</dt>
                        <dd class="text-slate-900 dark:text-white font-medium">{{ $event->start_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 dark:text-[#93adc8] font-medium">End</dt>
                        <dd class="text-slate-900 dark:text-white font-medium">{{ $event->end_at?->format('M j, Y g:i A') ?? '–' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Type</dt>
                        <dd class="text-slate-900 dark:text-white font-medium">{{ ucfirst($event->type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Format</dt>
                        <dd class="text-slate-900 dark:text-white font-medium">{{ ucfirst($event->format) }}</dd>
                    </div>
                    @if($event->isPaid() && $event->price)
                        <div>
                            <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Price</dt>
                            <dd class="text-slate-900 dark:text-white font-medium">{{ number_format($event->price, 2) }}</dd>
                        </div>
                    @endif
                    @if($event->capacity)
                        <div>
                            <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Capacity</dt>
                            <dd class="text-slate-900 dark:text-white font-medium">{{ $event->attendees()->count() }} / {{ $event->capacity }}</dd>
                        </div>
                    @endif
                    <div class="sm:col-span-2">
                        <dt class="text-slate-500 dark:text-[#93adc8] font-medium">{{ $event->format === 'virtual' ? 'Meeting Link' : 'Location' }}</dt>
                        <dd class="text-slate-900 dark:text-white font-medium">
                            @if($event->format === 'virtual' && $event->meeting_link)
                                <a href="{{ $event->meeting_link }}" target="_blank" rel="noopener" class="text-primary hover:underline">{{ $event->meeting_link }}</a>
                            @else
                                {{ $event->location ?? '–' }}
                            @endif
                        </dd>
                    </div>
                    @if($event->description)
                        <div class="sm:col-span-2">
                            <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Description</dt>
                            <dd class="text-slate-900 dark:text-white mt-1 whitespace-pre-wrap">{{ $event->description }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Notifications (placeholders; wired in step 6) --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Send Notifications</h3>
                <div class="flex flex-wrap gap-3">
                    <form method="POST" action="{{ route('admin.events.notifications.reminder', $event) }}" class="inline" onsubmit="return confirm('Send reminder to all attendees who have not received one?');">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-all">
                            Send Reminder (before event)
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.events.notifications.post-event', $event) }}" class="inline" onsubmit="return confirm('Send post-event notification to all attendees?');">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-slate-200 dark:bg-[#243647] text-slate-700 dark:text-white rounded-lg text-sm font-bold hover:bg-slate-300 dark:hover:bg-[#344d65] transition-all">
                            Send Post-Event
                        </button>
                    </form>
                </div>
            </div>

            {{-- Attendees --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Attendees</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase">Name</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase">Email</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase">Status</th>
                                @if($event->isPaid())
                                    <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase">Payment</th>
                                @endif
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase">Invited by</th>
                                <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($event->registrations as $reg)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50">
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $reg->attendee_name }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-[#93adc8]">{{ $reg->attendee_email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium
                                            @if($reg->status === \App\Models\EventRegistration::STATUS_CHECKED_IN) bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400
                                            @elseif($reg->status === \App\Models\EventRegistration::STATUS_CANCELLED) bg-slate-100 dark:bg-[#243647] text-slate-500 dark:text-[#93adc8]
                                            @else bg-primary/10 text-primary
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $reg->status)) }}
                                        </span>
                                    </td>
                                    @if($event->isPaid())
                                        <td class="px-4 py-3">
                                            @if($reg->payment_status)
                                                <span class="px-2 py-0.5 rounded text-xs font-medium
                                                    @if($reg->payment_status === \App\Models\EventRegistration::PAYMENT_PAID) bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400
                                                    @elseif($reg->payment_status === \App\Models\EventRegistration::PAYMENT_WAIVED) bg-slate-100 dark:bg-[#243647] text-slate-500 dark:text-[#93adc8]
                                                    @else bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400
                                                    @endif">
                                                    {{ ucfirst($reg->payment_status) }}
                                                </span>
                                            @else
                                                –
                                            @endif
                                        </td>
                                    @endif
                                    <td class="px-4 py-3 text-slate-600 dark:text-[#93adc8]">{{ $reg->inviter?->full_name ?? '–' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        @if($reg->status === \App\Models\EventRegistration::STATUS_REGISTERED)
                                            <form action="{{ route('admin.events.registrations.check-in', $reg) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded text-xs font-bold hover:bg-emerald-500/20">Check in</button>
                                            </form>
                                        @endif
                                        @if($event->isPaid() && $reg->payment_status !== \App\Models\EventRegistration::PAYMENT_PAID && $reg->payment_status !== \App\Models\EventRegistration::PAYMENT_WAIVED)
                                            <form action="{{ route('admin.events.registrations.mark-paid', $reg) }}" method="POST" class="inline ml-1">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 bg-primary/10 text-primary rounded text-xs font-bold hover:bg-primary/20">Mark paid</button>
                                            </form>
                                            <form action="{{ route('admin.events.registrations.mark-waived', $reg) }}" method="POST" class="inline ml-1">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 bg-slate-200 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8] rounded text-xs font-bold hover:bg-slate-300 dark:hover:bg-[#344d65]">Waive</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $event->isPaid() ? 6 : 5 }}" class="px-4 py-8 text-center text-slate-500 dark:text-[#93adc8]">No attendees yet. Coordinators and mentees can register; guests can use the public registration link.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
