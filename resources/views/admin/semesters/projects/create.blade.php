<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.projects.index', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Projects</a>
                <h2 class="text-lg font-bold tracking-tight">Add Project</h2>
            </div>
        </header>
        <div class="p-8 max-w-2xl">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.semesters.projects.store', $semester) }}" class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Title *</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="e.g. Organize community clean-up" required class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="points" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Points *</label>
                    <input id="points" name="points" type="number" min="0" max="1000" value="{{ old('points', 50) }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Sort order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Add Project
                    </button>
                    <a href="{{ route('admin.semesters.projects.index', $semester) }}" class="rounded-lg border border-slate-300 dark:border-[#344d65] px-4 py-2 text-slate-600 dark:text-[#93adc8] text-sm font-medium hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>
