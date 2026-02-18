<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-4 sm:px-8 py-3 pl-16 sm:pl-8 gap-3">
            <div class="flex items-center gap-3 sm:gap-4">
                <h2 class="text-lg font-bold tracking-tight">{{ $semester->name }}</h2>
                @if($semester->is_active)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">Active</span>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:flex sm:items-center gap-2 w-full sm:w-auto">
                @if(!$semester->is_active)
                    <form action="{{ route('admin.semesters.set-active', $semester) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                            <span class="material-symbols-outlined text-lg">check_circle</span>
                            Set as Active
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.semesters.edit', $semester) }}" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg border border-slate-300 dark:border-[#344d65] px-4 py-2 text-slate-600 dark:text-[#93adc8] text-sm font-medium hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit
                </a>
                <a href="{{ route('admin.semesters.index') }}" class="inline-flex w-full sm:w-auto items-center justify-center text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Semesters</a>
            </div>
        </header>
        <div class="p-4 sm:p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-6 sm:gap-8">
            @if (session('status'))
                <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium mb-1">Dates</p>
                    <p class="text-slate-900 dark:text-white font-bold">{{ $semester->starts_at->format('M j, Y') }} – {{ $semester->ends_at->format('M j, Y') }}</p>
                </div>
                <div class="rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium mb-1">Current Week</p>
                    <p class="text-slate-900 dark:text-white font-bold">{{ $semester->currentWeekNumber() ?? '–' }}</p>
                </div>
                <div class="rounded-xl p-6 bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] shadow-sm">
                    <p class="text-slate-500 dark:text-[#93adc8] text-sm font-medium mb-1">Modules</p>
                    <p class="text-slate-900 dark:text-white font-bold">{{ $semester->modules->count() }} / 12</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap gap-3 sm:gap-4">
                <a href="{{ route('admin.semesters.modules.index', $semester) }}" class="inline-flex w-full lg:w-auto items-center justify-center gap-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary px-4 py-2.5 text-sm font-medium hover:bg-primary/20 dark:hover:bg-primary/30 transition-all">
                    <span class="material-symbols-outlined">folder_open</span>
                    Weekly Modules
                </a>
                <a href="{{ route('admin.semesters.module-reviews.index', $semester) }}" class="inline-flex w-full lg:w-auto items-center justify-center gap-2 rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-700 dark:text-[#93adc8] px-4 py-2.5 text-sm font-medium hover:bg-slate-200 dark:hover:bg-[#344d65] transition-all">
                    <span class="material-symbols-outlined">rate_review</span>
                    Module Reviews
                </a>
                <a href="{{ route('admin.semesters.projects.index', $semester) }}" class="inline-flex w-full lg:w-auto items-center justify-center gap-2 rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-700 dark:text-[#93adc8] px-4 py-2.5 text-sm font-medium hover:bg-slate-200 dark:hover:bg-[#344d65] transition-all">
                    <span class="material-symbols-outlined">task_alt</span>
                    Semester Projects
                </a>
                <a href="{{ route('admin.semesters.report', $semester) }}" class="inline-flex w-full lg:w-auto items-center justify-center gap-2 rounded-lg bg-slate-100 dark:bg-[#243647] text-slate-700 dark:text-[#93adc8] px-4 py-2.5 text-sm font-medium hover:bg-slate-200 dark:hover:bg-[#344d65] transition-all">
                    <span class="material-symbols-outlined">summarize</span>
                    Semester Report
                </a>
            </div>
        </div>
    </main>
</x-admin-layout>
