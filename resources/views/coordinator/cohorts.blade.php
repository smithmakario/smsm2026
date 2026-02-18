@extends('layouts.coordinator')

@section('title', 'Cohorts – CoordinatorHub')

@section('content')
<div class="p-6">
    <h2 class="text-slate-900 dark:text-white text-xl font-bold mb-4">My Cohorts</h2>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif
    @forelse($cohorts as $cohort)
        <a href="{{ route('coordinator.cohorts.show', $cohort) }}" class="block mb-4 bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-5 hover:border-primary/50 transition-all shadow-sm">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div>
                    <h3 class="text-slate-900 dark:text-white font-bold">{{ $cohort->name }}</h3>
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm mt-1">{{ $cohort->members->count() }} mentee(s)</p>
                    @if($cohort->meeting_time)
                        <p class="text-slate-500 dark:text-[#93adc8] text-xs mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $cohort->meeting_time->format('M j, Y g:i A') }}
                        </p>
                    @endif
                </div>
                <span class="material-symbols-outlined text-slate-400">chevron_right</span>
            </div>
        </a>
    @empty
        <div class="bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-8 text-center">
            <p class="text-slate-500 dark:text-[#93adc8] text-sm">No cohorts assigned to you yet.</p>
            <p class="text-slate-500 dark:text-[#93adc8] text-xs mt-1">An admin will assign you to cohorts.</p>
        </div>
    @endforelse
</div>
@endsection
