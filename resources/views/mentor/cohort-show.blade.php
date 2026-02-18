@extends('layouts.mentor')

@section('title', $cohort->name . ' – MentorHub')

@section('content')
<div class="p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('mentor.cohorts') }}" class="text-slate-500 dark:text-[#93adc8] hover:text-primary">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-slate-900 dark:text-white text-xl font-bold">{{ $cohort->name }}</h2>
    </div>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif

    {{-- Meeting Time & Link --}}
    <div class="bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 mb-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Meeting Details</h3>
        <form method="POST" action="{{ route('mentor.cohorts.update', $cohort) }}" class="space-y-4">
            @csrf
            @method('PUT')
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
            <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Update Meeting Details</button>
        </form>
    </div>

    {{-- Record attendance --}}
    <div class="bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 mb-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Record attendance</h3>
        <form method="POST" action="{{ route('mentor.cohorts.attendance.store', $cohort) }}" class="space-y-4">
            @csrf
            <div class="flex flex-wrap items-end gap-4 mb-4">
                <div>
                    <label for="week_number" class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Week</label>
                    <select id="week_number" name="week_number" required class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary">
                        @for ($w = 1; $w <= 10; $w++)
                            <option value="{{ $w }}" {{ (int) old('week_number', 1) === $w ? 'selected' : '' }}>Week {{ $w }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">Save attendance</button>
            </div>
            @if($cohort->members->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-[#243647]">
                                <th class="pb-2 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Mentee</th>
                                <th class="pb-2 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-[#93adc8]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @foreach($cohort->members as $member)
                                @php
                                    $currentWeek = (int) old('week_number', 1);
                                    $currentStatus = $attendanceByMember[$member->id][$currentWeek] ?? '';
                                @endphp
                                <tr>
                                    <td class="py-2">
                                        <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $member->full_name }}</span>
                                    </td>
                                    <td class="py-2">
                                        <select name="attendances[{{ $member->id }}]" class="rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm focus:ring-primary focus:border-primary min-w-[120px]">
                                            <option value="none" {{ $currentStatus === '' ? 'selected' : '' }}>—</option>
                                            <option value="present" {{ $currentStatus === 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="late" {{ $currentStatus === 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="absent" {{ $currentStatus === 'absent' ? 'selected' : '' }}>Absent</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-500 dark:text-[#93adc8]">No members in this cohort. Add members from the admin cohort page to record attendance.</p>
            @endif
        </form>
    </div>

    {{-- Members --}}
    <div class="bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Cohort Members</h3>
        <ul class="divide-y divide-slate-100 dark:divide-[#243647]">
            @forelse($cohort->members as $member)
                <li class="flex items-center gap-4 py-3">
                    <div class="size-10 rounded-full bg-slate-200 dark:bg-[#243647] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">person</span>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $member->full_name }}</span>
                        <span class="text-xs text-slate-500 dark:text-[#93adc8] block">{{ $member->email }}</span>
                    </div>
                </li>
            @empty
                <li class="py-6 text-center text-slate-500 dark:text-[#93adc8] text-sm">No members in this cohort.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
