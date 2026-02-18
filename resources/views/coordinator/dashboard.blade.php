@extends('layouts.coordinator')

@section('title', 'Coordinator Collaboration Hub')

@section('content')
<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6">
    <div class="flex flex-col gap-2 rounded-xl p-6 border border-slate-200 dark:border-[#344d65] bg-white dark:bg-[#1a2632] shadow-sm">
        <div class="flex justify-between items-start">
            <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">My Cohorts</p>
            <span class="material-symbols-outlined text-primary">groups</span>
        </div>
        <p class="text-slate-900 dark:text-white text-3xl font-bold">{{ $cohorts->count() }}</p>
        <a href="{{ route('coordinator.cohorts') }}" class="text-primary text-xs font-bold hover:underline mt-2">View all cohorts →</a>
    </div>
    <div class="flex flex-col gap-2 rounded-xl p-6 border border-slate-200 dark:border-[#344d65] bg-white dark:bg-[#1a2632] shadow-sm">
        <div class="flex justify-between items-start">
            <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Pending Reviews</p>
            <span class="material-symbols-outlined text-primary">pending_actions</span>
        </div>
        <p class="text-slate-900 dark:text-white text-3xl font-bold">–</p>
        <p class="text-slate-400 text-xs font-normal mt-2"><span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span></p>
    </div>
    <div class="flex flex-col gap-2 rounded-xl p-6 border border-slate-200 dark:border-[#344d65] bg-white dark:bg-[#1a2632] shadow-sm">
        <div class="flex justify-between items-start">
            <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium">Avg. Response Time</p>
            <span class="material-symbols-outlined text-primary">speed</span>
        </div>
        <p class="text-slate-900 dark:text-white text-3xl font-bold">–</p>
        <p class="text-slate-400 text-xs font-normal mt-2"><span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span></p>
    </div>
</div>

@if($cohorts->isNotEmpty())
<!-- My Cohorts Quick Links -->
<div class="px-6 mb-4">
    <h3 class="text-slate-900 dark:text-white font-bold mb-3">My Cohorts</h3>
    <div class="flex flex-wrap gap-3">
        @foreach($cohorts as $cohort)
            <a href="{{ route('coordinator.cohorts.show', $cohort) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] hover:border-primary/50 transition-all text-sm font-medium text-slate-900 dark:text-white">
                <span class="material-symbols-outlined text-primary text-lg">groups</span>
                {{ $cohort->name }} ({{ $cohort->members->count() }} mentees)
            </a>
        @endforeach
    </div>
</div>
@endif

<!-- Assignment Queue -->
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-slate-900 dark:text-white text-xl font-bold">Assignment Queue</h2>
        <span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
    </div>
    <div class="bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-8 text-center">
        <span class="material-symbols-outlined text-4xl text-slate-400 dark:text-slate-500 mb-3">assignment</span>
        <p class="text-slate-500 dark:text-[#93adc8] text-sm">Assignment submissions and grading</p>
        <p class="text-slate-500 dark:text-[#93adc8] text-xs mt-1">This feature will show pending reviews and allow you to grade mentee work.</p>
        <a href="{{ route('coordinator.assignments') }}" class="inline-block mt-4 text-primary text-sm font-bold hover:underline">Go to Assignments →</a>
    </div>
</div>
@endsection
