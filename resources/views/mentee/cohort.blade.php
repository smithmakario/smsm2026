@extends('layouts.mentee')

@section('title', 'Cohort – Mentee Portal')

@section('content')
@if($cohort)
    <div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-primary text-xl">groups</span>
            <h2 class="text-slate-900 dark:text-white text-xl font-bold">{{ $cohort->name }}</h2>
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
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Assigned Coordinator</h4>
                @if($cohort->coordinator)
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-primary">school</span>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $cohort->coordinator->full_name }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 block">{{ $cohort->coordinator->email }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-slate-500 dark:text-slate-400 text-sm">No coordinator assigned yet.</p>
                @endif
                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 mt-4">Meeting Details</h4>
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
@endsection
