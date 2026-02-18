<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <h2 class="text-lg font-bold tracking-tight">Create Semester</h2>
            <a href="{{ route('admin.semesters.index') }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Back to Semesters</a>
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
            <form method="POST" action="{{ route('admin.semesters.store') }}" class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Name *</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="e.g. Semester 1 – Jan 2026" required
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Start Date *</label>
                        <input id="starts_at" name="starts_at" type="date" value="{{ old('starts_at') }}" required
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">End Date *</label>
                        <input id="ends_at" name="ends_at" type="date" value="{{ old('ends_at') }}" required
                            class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Create Semester
                    </button>
                    <a href="{{ route('admin.semesters.index') }}" class="rounded-lg border border-slate-300 dark:border-[#344d65] px-4 py-2 text-slate-600 dark:text-[#93adc8] text-sm font-medium hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const startsAtInput = document.getElementById('starts_at');
                const endsAtInput = document.getElementById('ends_at');

                if (!startsAtInput || !endsAtInput) {
                    return;
                }

                function daysInMonth(year, monthIndex) {
                    return new Date(Date.UTC(year, monthIndex + 1, 0)).getUTCDate();
                }

                function addMonthsNoOverflow(dateString, months) {
                    const [year, month, day] = dateString.split('-').map(Number);
                    const targetMonthIndex = (month - 1) + months;
                    const targetYear = year + Math.floor(targetMonthIndex / 12);
                    const normalizedMonthIndex = ((targetMonthIndex % 12) + 12) % 12;
                    const targetDay = Math.min(day, daysInMonth(targetYear, normalizedMonthIndex));

                    return new Date(Date.UTC(targetYear, normalizedMonthIndex, targetDay));
                }

                function formatDate(date) {
                    const year = date.getUTCFullYear();
                    const month = String(date.getUTCMonth() + 1).padStart(2, '0');
                    const day = String(date.getUTCDate()).padStart(2, '0');

                    return `${year}-${month}-${day}`;
                }

                function updateEndDateConstraints() {
                    const startsAtValue = startsAtInput.value;

                    if (!startsAtValue) {
                        endsAtInput.removeAttribute('min');
                        endsAtInput.removeAttribute('max');
                        return;
                    }

                    const maxEndDate = formatDate(addMonthsNoOverflow(startsAtValue, 3));
                    endsAtInput.min = startsAtValue;
                    endsAtInput.max = maxEndDate;

                    if (!endsAtInput.value) {
                        return;
                    }

                    if (endsAtInput.value < endsAtInput.min) {
                        endsAtInput.value = endsAtInput.min;
                    } else if (endsAtInput.value > endsAtInput.max) {
                        endsAtInput.value = endsAtInput.max;
                    }
                }

                startsAtInput.addEventListener('change', updateEndDateConstraints);
                updateEndDateConstraints();
            });
        </script>
    </main>
</x-admin-layout>
