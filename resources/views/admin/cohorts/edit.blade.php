<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.cohorts.show', $cohort) }}" class="text-slate-500 dark:text-[#93adc8] hover:text-primary">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-lg font-bold tracking-tight">Edit {{ $cohort->name }}</h2>
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
            <form method="POST" action="{{ route('admin.cohorts.update', $cohort) }}" class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Cohort Name *</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $cohort->name) }}" required
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="mentor_id" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Mentor</label>
                    <select id="mentor_id" name="mentor_id" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white focus:ring-primary focus:border-primary">
                        <option value="">– Select Mentor –</option>
                        @foreach($mentors as $m)
                            <option value="{{ $m->id }}" {{ old('mentor_id', $cohort->mentor_id) == $m->id ? 'selected' : '' }}>{{ $m->full_name }} ({{ $m->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="meeting_time" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Meeting Time</label>
                        <input id="meeting_time" name="meeting_time" type="datetime-local" value="{{ old('meeting_time', $cohort->meeting_time?->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="meeting_link" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Meeting Link</label>
                        <input id="meeting_link" name="meeting_link" type="url" value="{{ old('meeting_link', $cohort->meeting_link) }}" placeholder="https://meet.google.com/..."
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-2">Members (Mentees)</label>
                    <div class="max-h-48 overflow-y-auto rounded-lg border border-slate-200 dark:border-[#344d65] p-3 space-y-2">
                        @foreach($mentees as $mentee)
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 dark:hover:bg-[#243647] p-2 rounded">
                                <input type="checkbox" name="members[]" value="{{ $mentee->id }}"
                                    {{ in_array($mentee->id, old('members', $cohort->members->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span class="text-sm text-slate-900 dark:text-white">{{ $mentee->full_name }}</span>
                                <span class="text-xs text-slate-500 dark:text-[#93adc8]">({{ $mentee->email }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.cohorts.show', $cohort) }}" class="rounded-lg bg-slate-200 dark:bg-[#243647] px-4 py-2 text-slate-700 dark:text-white text-sm font-bold hover:bg-slate-300 dark:hover:bg-[#344d65] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>
