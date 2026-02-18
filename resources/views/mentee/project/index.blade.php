@extends('layouts.mentee')

@section('title', 'My Project – Mentee Portal')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('mentee.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary">← Dashboard</a>
        </div>
        <h2 class="text-slate-900 dark:text-white text-xl font-bold mb-1">Semester Project</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">{{ $activeSemester->name }}</p>

        @if (session('status'))
            <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm mb-4">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($existing)
            <div class="rounded-xl p-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 mb-6">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-medium mb-1">Your project</p>
                <p class="text-slate-900 dark:text-white text-lg font-bold">{{ $existing->semesterProject->title }}</p>
                @if($existing->semesterProject->description)
                    <p class="text-slate-600 dark:text-slate-300 text-sm mt-2">{{ $existing->semesterProject->description }}</p>
                @endif
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-2">
                    Status: <span class="font-medium text-slate-700 dark:text-slate-300">{{ str_replace('_', ' ', ucfirst($existing->status)) }}</span>
                    @if($existing->selected_at)
                        · Selected {{ $existing->selected_at->format('M j, Y') }}
                    @endif
                </p>
            </div>
        @elseif($canSelect && $projects->isNotEmpty())
            <p class="text-slate-600 dark:text-slate-300 text-sm mb-4">Select ONE project to complete this semester. Selection is open during the first 2 weeks only.</p>
            <form method="POST" action="{{ route('mentee.project.store') }}" class="space-y-4">
                @csrf
                <div class="space-y-3">
                    @foreach($projects as $project)
                        <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 cursor-pointer transition-colors">
                            <input type="radio" name="semester_project_id" value="{{ $project->id }}" required class="mt-1 rounded-full border-slate-300 dark:border-slate-600 text-primary focus:ring-primary">
                            <div>
                                <p class="text-slate-900 dark:text-white font-bold">{{ $project->title }}</p>
                                @if($project->description)
                                    <p class="text-slate-600 dark:text-slate-300 text-sm mt-1">{{ $project->description }}</p>
                                @endif
                                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">{{ $project->points }} pts</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-lg">check</span>
                    Select this project
                </button>
            </form>
        @elseif(!$canSelect && !$existing)
            <div class="rounded-lg bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 px-4 py-3 text-sm">
                Project selection is only open during the first 2 weeks of the semester. You did not select a project this semester.
            </div>
        @elseif($projects->isEmpty())
            <p class="text-slate-500 dark:text-slate-400 text-sm">No projects have been published for this semester yet. Check back later.</p>
        @endif
    </div>
</div>
@endsection
