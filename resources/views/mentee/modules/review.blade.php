@extends('layouts.mentee')

@section('title', 'Module Review – Mentee Portal')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('mentee.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary">← Dashboard</a>
        </div>
        <h2 class="text-slate-900 dark:text-white text-xl font-bold mb-1">Week {{ $module->week_number }}: {{ $module->title }}</h2>
        @if($module->scheduled_start_at && $module->scheduled_end_at)
            <p class="text-slate-600 dark:text-slate-300 text-sm mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-base">schedule</span>
                @if($module->scheduled_start_at->isSameDay($module->scheduled_end_at))
                    {{ $module->scheduled_start_at->format('l j M, g:i A') }} - {{ $module->scheduled_end_at->format('g:i A') }}
                @else
                    {{ $module->scheduled_start_at->format('l j M, g:i A') }} to {{ $module->scheduled_end_at->format('l j M, g:i A') }}
                @endif
            </p>
        @endif
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Submit your reflection or review for this module.</p>

        @if (session('error'))
            <div class="rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($module->lifeApplicationQuestions->isNotEmpty())
            <div class="rounded-xl border border-slate-200 dark:border-slate-700 p-4 bg-slate-50 dark:bg-slate-800/40 mb-4">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Life application questions</h3>
                <ul class="list-disc list-inside space-y-1 text-sm text-slate-700 dark:text-slate-300">
                    @foreach($module->lifeApplicationQuestions as $question)
                        <li>{{ $question->question }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('mentee.modules.review.store', $module) }}" class="space-y-4">
            @csrf
            <div>
                <label for="content" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Your review / reflection *</label>
                <textarea id="content" name="content" rows="6" required placeholder="Share your thoughts, key takeaways, or how you applied this week's lesson..."
                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white shadow-sm focus:ring-primary focus:border-primary">{{ old('content', $review?->content) }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">check</span>
                    {{ $review ? 'Update review' : 'Submit review' }}
                </button>
                <a href="{{ route('mentee.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-400 text-sm font-medium rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
