@extends('layouts.coordinator')

@section('title', 'Events – CoordinatorHub')

@php $activeSidebar = 'events'; @endphp

@section('content')
<div class="p-6">
    <h2 class="text-slate-900 dark:text-white text-xl font-bold mb-4">Events</h2>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($events as $event)
            <a href="{{ route($area . '.events.show', $event) }}" class="block bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-5 hover:border-primary/50 transition-all shadow-sm">
                <div class="flex flex-wrap justify-between items-start gap-2">
                    <h3 class="text-slate-900 dark:text-white font-bold">{{ $event->title }}</h3>
                    <span class="material-symbols-outlined text-slate-400 text-lg">chevron_right</span>
                </div>
                <p class="text-slate-500 dark:text-[#93adc8] text-sm mt-2 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $event->start_at->format('M j, Y g:i A') }}
                </p>
                <div class="flex flex-wrap gap-2 mt-3">
                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $event->type === 'paid' ? 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400' : 'bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]' }}">{{ ucfirst($event->type) }}</span>
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]">{{ ucfirst($event->format) }}</span>
                </div>
                <p class="text-slate-500 dark:text-[#93adc8] text-xs mt-2">{{ $event->registrations_count }} attendee(s)@if($event->capacity) · Capacity {{ $event->capacity }}@endif</p>
            </a>
        @empty
            <div class="col-span-full bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-8 text-center">
                <p class="text-slate-500 dark:text-[#93adc8] text-sm">No events at the moment.</p>
                <p class="text-slate-500 dark:text-[#93adc8] text-xs mt-1">Check back later for upcoming events.</p>
            </div>
        @endforelse
    </div>
    @if($events->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection
