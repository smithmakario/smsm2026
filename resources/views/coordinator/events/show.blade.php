@extends('layouts.coordinator')

@section('title', $event->title . ' – CoordinatorHub')

@php $activeSidebar = 'events'; @endphp

@section('content')
<div class="p-6 max-w-3xl">
    <a href="{{ route($area . '.events.index') }}" class="inline-flex items-center gap-1 text-slate-500 dark:text-[#93adc8] hover:text-primary text-sm mb-4">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Back to Events
    </a>
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="bg-white dark:bg-[#1a2632] border border-slate-200 dark:border-[#344d65] rounded-xl p-6 shadow-sm mb-6">
        <h1 class="text-slate-900 dark:text-white text-xl font-bold mb-4">{{ $event->title }}</h1>
        @if($event->description)
            <p class="text-slate-600 dark:text-[#93adc8] text-sm mb-4 whitespace-pre-wrap">{{ $event->description }}</p>
        @endif
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
            <div>
                <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Date & time</dt>
                <dd class="text-slate-900 dark:text-white font-medium">{{ $event->start_at->format('M j, Y g:i A') }}@if($event->end_at) – {{ $event->end_at->format('g:i A') }}@endif</dd>
            </div>
            <div>
                <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Type</dt>
                <dd class="text-slate-900 dark:text-white font-medium">{{ ucfirst($event->type) }}@if($event->isPaid() && $event->price) · {{ number_format($event->price, 2) }}@endif</dd>
            </div>
            <div>
                <dt class="text-slate-500 dark:text-[#93adc8] font-medium">Format</dt>
                <dd class="text-slate-900 dark:text-white font-medium">{{ ucfirst($event->format) }}</dd>
            </div>
            <div>
                <dt class="text-slate-500 dark:text-[#93adc8] font-medium">{{ $event->format === 'virtual' ? 'Meeting link' : 'Location' }}</dt>
                <dd class="text-slate-900 dark:text-white font-medium">
                    @if($event->format === 'virtual' && $event->meeting_link)
                        <a href="{{ $event->meeting_link }}" target="_blank" rel="noopener" class="text-primary hover:underline truncate block">Join online</a>
                    @else
                        {{ $event->location ?? '–' }}
                    @endif
                </dd>
            </div>
        </dl>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-[#344d65] flex flex-wrap gap-4 items-center">
            @if($registration)
                <p class="text-emerald-600 dark:text-emerald-400 text-sm font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span> You're registered for this event
                </p>
                <form action="{{ route($area . '.events.unregister', $event) }}" method="POST" class="inline" onsubmit="return confirm('Unregister from this event?');">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-slate-200 dark:bg-[#243647] text-slate-700 dark:text-[#93adc8] rounded-lg text-sm font-bold hover:bg-slate-300 dark:hover:bg-[#344d65] transition-all">Unregister</button>
                </form>
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-medium text-slate-500 dark:text-[#93adc8] mb-1">Share guest registration link</label>
                    <div class="flex gap-2">
                        <input type="text" readonly value="{{ $guestRegisterUrl }}" class="flex-1 min-w-0 rounded-lg border border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm px-3 py-2">
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $guestRegisterUrl }}'); this.textContent='Copied!'; setTimeout(() => this.textContent='Copy', 2000)" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 shrink-0">Copy</button>
                    </div>
                </div>
            @else
                @if($event->isAtCapacity())
                    <p class="text-amber-600 dark:text-amber-400 text-sm font-bold">This event is at capacity.</p>
                @else
                    <form action="{{ route($area . '.events.register', $event) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary/90 shadow-lg shadow-primary/20 transition-all">Register for this event</button>
                    </form>
                @endif
                <p class="text-slate-500 dark:text-[#93adc8] text-xs">After registering, you can share a link for guests to register.</p>
            @endif
        </div>
    </div>
</div>
@endsection
