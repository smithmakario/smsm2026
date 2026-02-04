@extends('layouts.mentee')

@section('title', 'Dashboard – Mentee Portal')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
        <h2 class="text-slate-900 dark:text-white text-2xl font-bold mb-2">Welcome, {{ auth()->user()?->full_name ?? 'Mentee' }}</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Here's your learning overview.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="rounded-xl p-4 bg-primary/5 dark:bg-primary/10 border border-primary/20">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">Overall Progress</p>
                <p class="text-primary text-2xl font-bold">–</p>
                <span class="mt-1 inline-block px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
            </div>
            <div class="rounded-xl p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">Current Module</p>
                <p class="text-slate-900 dark:text-white text-lg font-bold">–</p>
                <span class="mt-1 inline-block px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
            </div>
            <div class="rounded-xl p-4 bg-emerald-500/10 border border-emerald-500/20">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">Day Streak</p>
                <p class="text-emerald-600 dark:text-emerald-400 text-2xl font-bold">–</p>
                <span class="mt-1 inline-block px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
            </div>
        </div>
        <a href="{{ route('mentee.journey') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined">route</span>
            Continue My Journey
        </a>
    </div>

    @php $cohort = auth()->user()?->cohort(); @endphp
    @if($cohort)
        {{-- Cohort Details: Fellow Mentees, Mentor, Meeting Time & Link --}}
        <div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary text-xl">groups</span>
                <h3 class="text-slate-900 dark:text-white text-lg font-bold">My Cohort: {{ $cohort->name }}</h3>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Fellow Mentees</h4>
                    <ul class="space-y-2">
                        @foreach($cohort->members->where('id', '!=', auth()->id()) as $member)
                            <li class="flex items-center gap-3 py-2">
                                <div class="size-9 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-lg">person</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $member->full_name }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 block">{{ $member->email }}</span>
                                </div>
                            </li>
                        @endforeach
                        @if($cohort->members->where('id', '!=', auth()->id())->isEmpty())
                            <li class="text-slate-500 dark:text-slate-400 text-sm py-2">You're the only mentee in this cohort.</li>
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Meeting Details</h4>
                    @if($cohort->mentor)
                        <div class="flex items-center gap-3 mb-4">
                            <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary">school</span>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $cohort->mentor->full_name }}</span>
                                <span class="text-xs text-slate-500 dark:text-slate-400 block">Your Mentor</span>
                            </div>
                        </div>
                    @endif
                    @if($cohort->meeting_time)
                        <p class="text-slate-600 dark:text-slate-300 text-sm flex items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-lg">schedule</span>
                            {{ $cohort->meeting_time->format('l, M j, Y \a\t g:i A') }}
                        </p>
                    @endif
                    @if($cohort->meeting_link)
                        <a href="{{ $cohort->meeting_link }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 transition-all">
                            <span class="material-symbols-outlined">videocam</span>
                            Join Meeting
                        </a>
                    @elseif(!$cohort->meeting_time && !$cohort->meeting_link)
                        <p class="text-slate-500 dark:text-slate-400 text-sm">No meeting scheduled yet.</p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
            <p class="text-slate-500 dark:text-slate-400 text-sm">You're not assigned to a cohort yet. An admin will add you to a cohort.</p>
        </div>
    @endif
</div>
@endsection
