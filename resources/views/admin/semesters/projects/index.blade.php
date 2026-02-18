<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.show', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← {{ $semester->name }}</a>
                <h2 class="text-lg font-bold tracking-tight">Semester Projects</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.semesters.mentee-projects', $semester) }}" class="flex items-center gap-2 rounded-lg bg-slate-100 dark:bg-[#243647] px-4 py-2 text-slate-700 dark:text-[#93adc8] text-sm font-medium hover:bg-slate-200 dark:hover:bg-[#344d65] transition-all">
                    <span class="material-symbols-outlined text-lg">person_check</span>
                    Mentee Assignments
                </a>
                <a href="{{ route('admin.semesters.projects.create', $semester) }}" class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Add Project
                </a>
            </div>
        </header>
        <div class="p-8 max-w-[1600px] mx-auto w-full flex flex-col gap-8">
            @if (session('status'))
                <div class="rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            <div class="bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-[#1a2632] border-b border-slate-100 dark:border-[#243647]">
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Description</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Points</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @forelse($projects as $project)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm font-medium text-slate-900 dark:text-white">{{ $project->title }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8] max-w-md truncate">{{ Str::limit($project->description, 80) ?: '–' }}</td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-900 dark:text-white">{{ $project->points }}</td>
                                    <td class="px-6 py-5 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.semesters.projects.edit', [$semester, $project]) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-[#243647] rounded transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-slate-400 text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('admin.semesters.projects.destroy', [$semester, $project]) }}" method="POST" class="inline" onsubmit="return confirm('Remove this project? Mentees who selected it will be unaffected but the option will no longer be available.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 hover:bg-red-500/10 rounded transition-colors text-red-500" title="Delete">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 dark:text-[#93adc8]">
                                        No projects yet. <a href="{{ route('admin.semesters.projects.create', $semester) }}" class="text-primary hover:underline">Add approved projects</a> for mentees to choose from.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
