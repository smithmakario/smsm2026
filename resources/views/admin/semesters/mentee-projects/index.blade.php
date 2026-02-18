<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.projects.index', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Projects</a>
                <h2 class="text-lg font-bold tracking-tight">Mentee Project Assignments</h2>
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
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Mentee</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Project</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider">Selected at</th>
                                <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-[#93adc8] uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-[#243647]">
                            @foreach($mentees as $mentee)
                                @php $assignment = $assignments->get($mentee->id); @endphp
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-[#1a2632]/50 transition-colors">
                                    <td class="px-6 py-5 text-sm font-medium text-slate-900 dark:text-white">{{ $mentee->full_name }}</td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">
                                        {{ $assignment?->semesterProject?->title ?? '–' }}
                                    </td>
                                    <td class="px-6 py-5">
                                        @if($assignment)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                                                {{ $assignment->status === \App\Models\MenteeSemesterProject::STATUS_VERIFIED ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : '' }}
                                                {{ $assignment->status === \App\Models\MenteeSemesterProject::STATUS_COMPLETED ? 'bg-primary/10 text-primary' : '' }}
                                                {{ $assignment->status === \App\Models\MenteeSemesterProject::STATUS_IN_PROGRESS ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : '' }}
                                                {{ $assignment->status === \App\Models\MenteeSemesterProject::STATUS_NOT_STARTED ? 'bg-slate-100 dark:bg-[#243647] text-slate-600 dark:text-[#93adc8]' : '' }}
                                            ">
                                                {{ str_replace('_', ' ', ucfirst($assignment->status)) }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 dark:text-slate-500 text-xs">No selection</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-[#93adc8]">
                                        {{ $assignment?->selected_at?->format('M j, Y') ?? '–' }}
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        @if($assignment)
                                            <form action="{{ route('admin.semesters.mentee-projects.update', [$semester, $assignment]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" onchange="this.form.submit()" class="rounded border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-xs py-1 focus:ring-primary focus:border-primary">
                                                    @foreach(\App\Models\MenteeSemesterProject::STATUSES as $s)
                                                        <option value="{{ $s }}" {{ $assignment->status === $s ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($s)) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @else
                                            –
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
