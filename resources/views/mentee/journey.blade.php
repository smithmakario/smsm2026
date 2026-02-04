@extends('layouts.mentee')

@section('title', 'My Journey – Mentee Learning')

@section('content')
{{-- Heading & Global Progress --}}
<div class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
    <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 dark:text-white text-3xl font-black tracking-tight">Learning Journey</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Path to Master UI/UX Architect</p>
        </div>
        <button class="flex items-center gap-2 px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white text-sm font-bold rounded-lg transition-all">
            <span class="material-symbols-outlined text-lg">workspace_premium</span>
            View Certificate
        </button>
    </div>
    <div class="flex flex-col gap-3">
        <div class="flex justify-between items-end">
            <p class="text-slate-700 dark:text-slate-300 text-sm font-medium">Overall Completion</p>
            <span class="text-primary text-xl font-bold">42%</span>
        </div>
        <div class="h-3 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: 42%"></div>
        </div>
    </div>
</div>

{{-- Content Timeline --}}
<div class="relative flex flex-col gap-0 px-4">
    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-slate-200 dark:bg-slate-800 z-0"></div>

    {{-- Step 1: Completed Video --}}
    <div class="relative z-10 grid grid-cols-[48px_1fr] gap-6 pb-12">
        <div class="flex flex-col items-center">
            <div class="size-12 rounded-full bg-emerald-500/10 border-4 border-background-light dark:border-background-dark flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined fill-icon">check_circle</span>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col">
                <p class="text-emerald-500 text-xs font-bold uppercase tracking-wider">Completed</p>
                <h3 class="text-slate-900 dark:text-white text-xl font-bold">Module 1: Introduction to Frameworks</h3>
            </div>
            <div class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-md group">
                <div class="relative aspect-video w-full bg-slate-900 flex items-center justify-center cursor-pointer">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="size-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl text-white fill-icon">play_arrow</span>
                    </div>
                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center text-white text-xs">
                        <span class="bg-black/40 px-2 py-1 rounded">12:45</span>
                        <span class="bg-primary px-2 py-1 rounded font-bold">REWATCH</span>
                    </div>
                </div>
                <div class="p-4 flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="text-slate-400 text-xs">Lesson Video</span>
                        <span class="text-slate-700 dark:text-slate-200 text-sm font-medium">Core Architecture Concepts</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400">download</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Step 2: In Progress Podcast --}}
    <div class="relative z-10 grid grid-cols-[48px_1fr] gap-6 pb-12">
        <div class="flex flex-col items-center">
            <div class="size-12 rounded-full bg-primary/20 border-4 border-background-light dark:border-background-dark flex items-center justify-center text-primary animate-pulse">
                <span class="material-symbols-outlined fill-icon">play_circle</span>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col">
                <p class="text-primary text-xs font-bold uppercase tracking-wider">In Progress</p>
                <h3 class="text-slate-900 dark:text-white text-xl font-bold">Module 2: Industry Trends 2024</h3>
            </div>
            <div class="bg-white dark:bg-surface-dark border-2 border-primary/30 rounded-xl p-5 shadow-lg shadow-primary/5">
                <div class="flex items-center gap-4 mb-4">
                    <div class="size-16 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shrink-0">
                        <span class="material-symbols-outlined text-white text-3xl">podcasts</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-slate-900 dark:text-white font-bold leading-tight">Mastering Modern Tooling</h4>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">Host: Sarah Drasner • 24 mins left</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="button" class="size-8 flex items-center justify-center text-slate-400 hover:text-white"><span class="material-symbols-outlined">skip_previous</span></button>
                        <button type="button" class="size-10 rounded-full bg-primary flex items-center justify-center text-white shadow-md"><span class="material-symbols-outlined fill-icon">pause</span></button>
                        <button type="button" class="size-8 flex items-center justify-center text-slate-400 hover:text-white"><span class="material-symbols-outlined">skip_next</span></button>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="relative h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="absolute h-full bg-primary rounded-full" style="width: 35%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase">
                        <span>12:10</span>
                        <div class="flex gap-4">
                            <button type="button" class="hover:text-primary transition-colors">1.5x</button>
                            <span>36:45</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Step 3: Upcoming Assignment --}}
    <div class="relative z-10 grid grid-cols-[48px_1fr] gap-6 pb-12">
        <div class="flex flex-col items-center">
            <div class="size-12 rounded-full bg-amber-500/10 border-4 border-background-light dark:border-background-dark flex items-center justify-center text-amber-500">
                <span class="material-symbols-outlined">assignment</span>
            </div>
        </div>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col">
                <p class="text-amber-500 text-xs font-bold uppercase tracking-wider">Up Next • Due in 2 Days</p>
                <h3 class="text-slate-900 dark:text-white text-xl font-bold">Module 3: Project Proposal</h3>
            </div>
            <div class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-slate-800 rounded-xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex gap-4">
                    <div class="size-12 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 shrink-0">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-900 dark:text-white font-bold text-sm">Design System Documentation</span>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">PDF or Figma link required</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="px-2 py-0.5 bg-amber-500/10 text-amber-500 text-[10px] font-bold rounded uppercase">Pending Upload</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="w-full md:w-auto px-6 py-2.5 bg-primary hover:bg-primary/90 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-primary/20">
                    Submit Work
                </button>
            </div>
        </div>
    </div>

    {{-- Step 4: Locked Content --}}
    <div class="relative z-10 grid grid-cols-[48px_1fr] gap-6">
        <div class="flex flex-col items-center">
            <div class="size-12 rounded-full bg-slate-200 dark:bg-slate-800 border-4 border-background-light dark:border-background-dark flex items-center justify-center text-slate-400 dark:text-slate-600">
                <span class="material-symbols-outlined">lock</span>
            </div>
        </div>
        <div class="flex flex-col gap-2 opacity-40">
            <div class="flex flex-col">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Unlocks in 3 days</p>
                <h3 class="text-slate-900 dark:text-white text-xl font-bold">Module 4: Advanced Architectures</h3>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Deep dive into micro-frontends and scalable component libraries.</p>
        </div>
    </div>
</div>
@endsection
