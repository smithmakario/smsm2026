<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.cohorts.index') }}" class="text-slate-500 dark:text-[#93adc8] hover:text-primary">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-lg font-bold tracking-tight">{{ $cohort->name }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.cohorts.edit', $cohort) }}" class="flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-bold hover:bg-primary/20 transition-all">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit Cohort
                </a>
                <form action="{{ route('admin.cohorts.destroy', $cohort) }}" method="POST" class="inline" onsubmit="return confirm('Delete this cohort?');">
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

            {{-- Meeting Time & Link --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Meeting Details</h3>
                <form method="POST" action="{{ route('admin.cohorts.update', $cohort) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ $cohort->name }}">
                    <input type="hidden" name="mentor_id" value="{{ $cohort->mentor_id }}">
                    <input type="hidden" name="members[]" value="">
                    @foreach($cohort->members as $m)
                        <input type="hidden" name="members[]" value="{{ $m->id }}">
                    @endforeach
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="meeting_time" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Meeting Time</label>
                            <input id="meeting_time" name="meeting_time" type="datetime-local"
                                value="{{ $cohort->meeting_time?->format('Y-m-d\TH:i') }}"
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="meeting_link" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Meeting Link</label>
                            <input id="meeting_link" name="meeting_link" type="url" value="{{ old('meeting_link', $cohort->meeting_link) }}" placeholder="https://meet.google.com/..."
                                class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Save Meeting Details</button>
                </form>
            </div>

            {{-- Mentor --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Assigned Mentor</h3>
                <form method="POST" action="{{ route('admin.cohorts.update', $cohort) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="name" value="{{ $cohort->name }}">
                    <input type="hidden" name="meeting_time" value="{{ $cohort->meeting_time?->format('Y-m-d\TH:i') }}">
                    <input type="hidden" name="meeting_link" value="{{ $cohort->meeting_link }}">
                    @foreach($cohort->members as $m)
                        <input type="hidden" name="members[]" value="{{ $m->id }}">
                    @endforeach
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label for="mentor_id" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Mentor</label>
                            <select id="mentor_id" name="mentor_id" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                                <option value="">– Select Mentor –</option>
                                @foreach($mentors as $m)
                                    <option value="{{ $m->id }}" {{ $cohort->mentor_id == $m->id ? 'selected' : '' }}>{{ $m->full_name }} ({{ $m->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Update Mentor</button>
                    </div>
                </form>
            </div>

            {{-- Members --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Members</h3>
                {{-- Add member --}}
                <form method="POST" action="{{ route('admin.cohorts.members.add', $cohort) }}" class="flex gap-3 mb-6">
                    @csrf
                    <select name="user_id" required class="flex-1 rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        <option value="">– Select mentee to add –</option>
                        @foreach($availableMentees->reject(fn($u) => $cohort->members->contains('id', $u->id)) as $u)
                            <option value="{{ $u->id }}">{{ $u->full_name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Add Member</button>
                </form>
                {{-- Member list --}}
                <ul class="divide-y divide-slate-100 dark:divide-[#243647]">
                    @forelse($cohort->members as $member)
                        <li class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">person</span>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $member->full_name }}</span>
                                    <span class="text-xs text-slate-500 dark:text-[#93adc8] block">{{ $member->email }}</span>
                                </div>
                            </div>
                            <form action="{{ route('admin.cohorts.members.remove', [$cohort, $member]) }}" method="POST" class="inline" onsubmit="return confirm('Remove {{ $member->full_name }} from this cohort?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-500/10 rounded transition-colors" title="Remove">
                                    <span class="material-symbols-outlined text-lg">person_remove</span>
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="py-6 text-center text-slate-500 dark:text-[#93adc8] text-sm">No members yet. Add mentees above.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </main>
</x-admin-layout>
