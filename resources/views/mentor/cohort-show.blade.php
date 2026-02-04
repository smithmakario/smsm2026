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
