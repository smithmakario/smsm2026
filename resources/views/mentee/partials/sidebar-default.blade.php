@php
    $menteeCohort = auth()->user()?->cohort();
@endphp
{{-- Coordinator Card --}}
<div class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 rounded-xl p-6">
    <h3 class="text-slate-900 dark:text-white font-bold text-sm mb-4">Assigned Coordinator</h3>
    @if($menteeCohort?->coordinator)
        <div class="flex items-center gap-4">
            <div class="size-14 rounded-full bg-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-2xl">person</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="text-slate-900 dark:text-white font-bold text-base">{{ $menteeCohort->coordinator->full_name }}</span>
                <span class="text-slate-500 dark:text-slate-400 text-xs">{{ $menteeCohort->coordinator->email }}</span>
                <a href="{{ route('mentee.messages') }}" class="mt-2 text-primary text-xs font-bold flex items-center gap-1 hover:underline">
                    <span class="material-symbols-outlined text-sm">chat_bubble</span> Send Message
                </a>
            </div>
        </div>
        @if($menteeCohort->meeting_time || $menteeCohort->meeting_link)
            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                @if($menteeCohort->meeting_time)
                    <p class="text-slate-500 dark:text-slate-400 text-xs flex items-center gap-1 mb-1">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        {{ $menteeCohort->meeting_time->format('M j, g:i A') }}
                    </p>
                @endif
                @if($menteeCohort->meeting_link)
                    <a href="{{ $menteeCohort->meeting_link }}" target="_blank" rel="noopener" class="text-primary text-xs font-bold flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-sm">videocam</span> Join Meeting
                    </a>
                @endif
            </div>
        @endif
    @else
        <p class="text-slate-500 dark:text-slate-400 text-sm">No coordinator assigned yet.</p>
    @endif
</div>

{{-- Schedule / Upcoming Events --}}
<div class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
    <div class="p-6 flex items-center justify-between">
        <h3 class="text-slate-900 dark:text-white font-bold text-sm">Schedule</h3>
        <span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
    </div>
    <div class="px-6 pb-6 text-center">
        <p class="text-slate-500 dark:text-slate-400 text-sm">Upcoming events will appear here.</p>
    </div>
</div>

{{-- Messages --}}
<div class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
    <div class="p-6 flex items-center justify-between">
        <h3 class="text-slate-900 dark:text-white font-bold text-sm">Messages</h3>
        <span class="px-2 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded text-[10px] font-bold">Coming soon</span>
    </div>
    <div class="px-6 pb-6 text-center">
        <p class="text-slate-500 dark:text-slate-400 text-sm">Conversations will appear here.</p>
    </div>
</div>

{{-- Gamification Widget --}}
<div class="bg-gradient-to-br from-primary to-blue-600 rounded-xl p-6 text-white shadow-xl shadow-primary/20">
    <div class="flex items-start justify-between mb-4">
        <div class="size-10 rounded-lg bg-white/20 flex items-center justify-center">
            <span class="material-symbols-outlined">auto_awesome</span>
        </div>
        <span class="bg-black/20 px-2 py-1 rounded text-[10px] font-bold uppercase">Coming soon</span>
    </div>
    <h4 class="text-xl font-bold mb-1">Daily Streak</h4>
    <p class="text-white/80 text-xs mb-4">Track your learning consistency and earn rewards.</p>
    <div class="flex -space-x-2">
        <div class="size-8 rounded-full border-2 border-primary bg-slate-300" aria-hidden="true"></div>
        <div class="size-8 rounded-full border-2 border-primary bg-slate-400" aria-hidden="true"></div>
        <div class="size-8 rounded-full border-2 border-primary bg-slate-500" aria-hidden="true"></div>
        <div class="size-8 rounded-full border-2 border-primary bg-slate-700 flex items-center justify-center text-[10px] font-bold">+12</div>
    </div>
</div>
