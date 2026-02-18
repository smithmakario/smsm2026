<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto bg-background-light dark:bg-background-dark">
        {{-- Breadcrumbs & heading --}}
        <div class="p-6 max-w-6xl mx-auto w-full space-y-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-slate-500 dark:text-[#93adc8] text-sm">
                    <a class="hover:text-primary" href="{{ route('admin.cohorts.index') }}">Cohorts</a>
                    <span>/</span>
                    <span class="text-slate-900 dark:text-white font-medium">{{ $cohort->name }}</span>
                </div>
                <div class="flex flex-wrap justify-between items-end gap-4">
                    <div class="flex flex-col gap-1">
                        <h2 class="text-slate-900 dark:text-white text-3xl font-black tracking-tight">Cohort Performance &amp; Attendance</h2>
                        <p class="text-slate-500 dark:text-[#93adc8] text-base">Detailed analytics and engagement tracking for the current term</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <a href="{{ route('admin.cohorts.review-meetings.index', $cohort) }}" class="px-4 py-2 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#243647] rounded-lg text-sm font-bold text-slate-700 dark:text-white hover:bg-slate-50 dark:hover:bg-[#1a2632]">
                            Review Meetings
                        </a>
                        <a href="{{ route('admin.cohorts.edit', $cohort) }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold shadow-lg shadow-primary/20">
                            Manage Cohort
                        </a>
                        <form action="{{ route('admin.cohorts.destroy', $cohort) }}" method="POST" class="inline" onsubmit="return confirm('Delete this cohort?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500/10 text-red-500 rounded-lg text-sm font-bold hover:bg-red-500/20 transition-all">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Stats/KPI Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-[#111a22] flex flex-col gap-2 rounded-xl p-6 border border-slate-200 dark:border-[#243647] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Average Attendance</p>
                        <span class="text-slate-400 dark:text-slate-500 text-xs font-bold px-2 py-0.5 rounded-full">—</span>
                    </div>
                    <p class="text-slate-900 dark:text-white tracking-tight text-3xl font-black">{{ $averageAttendance !== null ? round($averageAttendance) . '%' : '—' }}</p>
                    <div class="w-full bg-slate-100 dark:bg-[#243647] h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-primary h-full" style="width: {{ $averageAttendance ?? 0 }}%"></div>
                    </div>
                </div>
                {{-- Completion Rate: static until feature exists --}}
                <div class="bg-white dark:bg-[#111a22] flex flex-col gap-2 rounded-xl p-6 border border-slate-200 dark:border-[#243647] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Completion Rate</p>
                        <span class="text-red-500 flex items-center text-xs font-bold bg-red-500/10 px-2 py-0.5 rounded-full">-1.1%</span>
                    </div>
                    <p class="text-slate-900 dark:text-white tracking-tight text-3xl font-black">92%</p>
                    <div class="w-full bg-slate-100 dark:bg-[#243647] h-1.5 rounded-full mt-2 overflow-hidden">
                        <div class="bg-green-500 h-full" style="width: 92%"></div>
                    </div>
                </div>
                {{-- Coordinator Rating: static until feature exists --}}
                <div class="bg-white dark:bg-[#111a22] flex flex-col gap-2 rounded-xl p-6 border border-slate-200 dark:border-[#243647] shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Coordinator Rating</p>
                        <span class="text-green-500 flex items-center text-xs font-bold bg-green-500/10 px-2 py-0.5 rounded-full">+0.2%</span>
                    </div>
                    <p class="text-slate-900 dark:text-white tracking-tight text-3xl font-black">4.8<span class="text-lg text-slate-400">/5.0</span></p>
                    <div class="flex gap-1 mt-2">
                        <span class="material-symbols-outlined text-primary text-sm">star</span>
                        <span class="material-symbols-outlined text-primary text-sm">star</span>
                        <span class="material-symbols-outlined text-primary text-sm">star</span>
                        <span class="material-symbols-outlined text-primary text-sm">star</span>
                        <span class="material-symbols-outlined text-primary text-sm">star_half</span>
                    </div>
                </div>
            </div>

            {{-- Main Grid: Attendance Log & Timeline Sidebar --}}
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                {{-- Left: Attendance Heat-map (3/4 width) --}}
                <div class="xl:col-span-3 space-y-6">
                    <div class="bg-white dark:bg-[#111a22] rounded-xl border border-slate-200 dark:border-[#243647] overflow-hidden shadow-sm">
                        <div class="p-6 border-b border-slate-200 dark:border-[#243647] flex justify-between items-center bg-slate-50/50 dark:bg-[#111a22]/50">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Attendance Heat-map</h3>
                                <p class="text-xs text-slate-500 dark:text-[#93adc8]">Weekly session participation (Check-ins via QR/Geofence)</p>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-slate-600 dark:text-[#93adc8]">
                                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded bg-primary"></div><span>Present</span></div>
                                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded bg-primary/30"></div><span>Late</span></div>
                                <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded bg-slate-200 dark:bg-[#243647]"></div><span>Absent</span></div>
                            </div>
                        </div>
                        <div class="overflow-x-auto scrollbar-hide">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 dark:bg-background-dark/30 border-b border-slate-200 dark:border-[#243647]">
                                        <th class="p-4 text-xs font-bold uppercase tracking-wider text-slate-500 sticky left-0 bg-white dark:bg-[#111a22] z-10 w-48">Mentee</th>
                                        @for ($w = 1; $w <= 10; $w++)
                                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">W{{ $w }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                                    @forelse($cohort->members as $member)
                                        <tr>
                                            <td class="p-4 sticky left-0 bg-white dark:bg-[#111a22] z-10">
                                                <div class="flex items-center gap-3">
                                                    <div class="size-8 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-sm">person</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold truncate max-w-[120px] text-slate-900 dark:text-white">{{ $member->full_name }}</p>
                                                        <p class="text-[10px] text-slate-500 dark:text-[#93adc8]">{{ $member->occupation ?? '—' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            @for ($w = 1; $w <= 10; $w++)
                                                @php
                                                    $weekStatus = data_get($attendanceByMember, "{$member->id}.{$w}");
                                                @endphp
                                                <td class="p-2">
                                                    @if($weekStatus === 'present')
                                                        <div class="h-8 w-full rounded bg-primary flex items-center justify-center text-white"><span class="material-symbols-outlined text-xs">check</span></div>
                                                    @elseif($weekStatus === 'late')
                                                        <div class="h-8 w-full rounded bg-primary/30 flex items-center justify-center text-primary"><span class="material-symbols-outlined text-xs">schedule</span></div>
                                                    @elseif($weekStatus === 'absent')
                                                        <div class="h-8 w-full rounded bg-primary/20 flex items-center justify-center text-primary/40"><span class="material-symbols-outlined text-xs">close</span></div>
                                                    @else
                                                        <div class="h-8 w-full rounded bg-slate-100 dark:bg-background-dark/50"></div>
                                                    @endif
                                                </td>
                                            @endfor
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="p-6 text-center text-slate-500 dark:text-[#93adc8] text-sm">No mentees in this cohort yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- At-Risk Learners Alert Box --}}
                    <div class="bg-red-500/5 dark:bg-red-500/10 border border-red-500/20 rounded-xl p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-red-500">warning</span>
                            <h3 class="text-lg font-bold text-red-700 dark:text-red-400">At-Risk Learners ({{ $atRiskCount }})</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @if($atRiskCount > 0)
                                @foreach($atRiskMembers as $entry)
                                    <div class="flex items-center gap-3 p-3 bg-white/50 dark:bg-[#111a22]/50 rounded-lg border border-red-500/10">
                                        <div class="size-10 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">person</span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $entry['user']->full_name }}</p>
                                            <p class="text-xs text-red-600 dark:text-red-400">{{ $entry['reason'] }}</p>
                                        </div>
                                        <form action="{{ route('admin.cohorts.at-risk.send-email', [$cohort, $entry['user']]) }}" method="POST" class="shrink-0">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary/90">Send reminder</button>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-slate-500 dark:text-[#93adc8] col-span-full">No at-risk learners identified for this cohort.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right: Milestone Timeline Sidebar (1/4 width) --}}
                <div class="xl:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-[#111a22] rounded-xl border border-slate-200 dark:border-[#243647] p-6 shadow-sm">
                        <h3 class="text-lg font-bold mb-6 text-slate-900 dark:text-white">Milestone Timeline</h3>
                        <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-200 dark:before:bg-[#243647]">
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 size-6 rounded-full bg-primary flex items-center justify-center text-white ring-4 ring-white dark:ring-[#111a22]">
                                    <span class="material-symbols-outlined text-[14px]">check</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Foundations of Trust</h4>
                                    <p class="text-xs text-slate-500 dark:text-[#93adc8]">Completed Mar 12</p>
                                    <div class="mt-2 text-xs bg-primary/10 text-primary px-2 py-1 rounded inline-block">100% Submissions</div>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div class="absolute left-0 top-1 size-6 rounded-full bg-primary flex items-center justify-center text-white ring-4 ring-white dark:ring-[#111a22] animate-pulse">
                                    <span class="material-symbols-outlined text-[14px]">play_arrow</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-primary">Strategic Decision Making</h4>
                                    <p class="text-xs text-slate-500 dark:text-[#93adc8]">Current Week (W6)</p>
                                    <div class="mt-2 text-xs bg-slate-100 dark:bg-background-dark px-2 py-1 rounded inline-block text-slate-600 dark:text-[#93adc8]">64% In Progress</div>
                                </div>
                            </div>
                            <div class="relative pl-10 opacity-50">
                                <div class="absolute left-0 top-1 size-6 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center text-slate-500 ring-4 ring-white dark:ring-[#111a22]">
                                    <span class="material-symbols-outlined text-[14px]">lock</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Conflict Transformation</h4>
                                    <p class="text-xs text-slate-500 dark:text-[#93adc8]">Unlocks Mar 26 (Drip)</p>
                                </div>
                            </div>
                            <div class="relative pl-10 opacity-50">
                                <div class="absolute left-0 top-1 size-6 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center text-slate-500 ring-4 ring-white dark:ring-[#111a22]">
                                    <span class="material-symbols-outlined text-[14px]">lock</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Coaching for Impact</h4>
                                    <p class="text-xs text-slate-500 dark:text-[#93adc8]">Unlocks Apr 02</p>
                                </div>
                            </div>
                            <div class="relative pl-10 opacity-50">
                                <div class="absolute left-0 top-1 size-6 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center text-slate-500 ring-4 ring-white dark:ring-[#111a22]">
                                    <span class="material-symbols-outlined text-[14px]">emoji_events</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Final Certification</h4>
                                    <p class="text-xs text-slate-500 dark:text-[#93adc8]">Apr 15 - Graduation</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-[#111a22] rounded-xl border border-slate-200 dark:border-[#243647] p-6 shadow-sm">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8] mb-4">Quick Insights</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 dark:text-[#93adc8]">Highest Engagement</span>
                                <span class="text-xs font-bold text-green-500">{{ $cohort->members->first()?->full_name ?? '—' }} (98%)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 dark:text-[#93adc8]">Avg Session Time</span>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">54 Minutes</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-500 dark:text-[#93adc8]">Active Mentees</span>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $activeMenteeCount ?? 0 }} / {{ $cohort->members->count() }}</span>
                            </div>
                            <div class="pt-4 border-t border-slate-100 dark:border-[#243647]">
                                <button type="button" class="w-full py-2 bg-slate-100 dark:bg-background-dark text-slate-700 dark:text-slate-300 rounded text-xs font-bold hover:bg-slate-200 dark:hover:bg-[#1a2632] transition-colors">
                                    Generate Full Analysis
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 max-w-6xl mx-auto w-full flex flex-col gap-8">
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
                    <input type="hidden" name="coordinator_id" value="{{ $cohort->coordinator_id }}">
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

            {{-- Coordinator --}}
            <div class="rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Assigned Coordinator</h3>
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
                            <label for="coordinator_id" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Coordinator</label>
                            <select id="coordinator_id" name="coordinator_id" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                                <option value="">– Select Coordinator –</option>
                                @foreach($coordinators as $m)
                                    <option value="{{ $m->id }}" {{ $cohort->coordinator_id == $m->id ? 'selected' : '' }}>{{ $m->full_name }} ({{ $m->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Update Coordinator</button>
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
