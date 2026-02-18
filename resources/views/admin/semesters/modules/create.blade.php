<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.modules.index', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Modules</a>
                <h2 class="text-lg font-bold tracking-tight">Add Module</h2>
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
            <form method="POST" action="{{ route('admin.semesters.modules.store', $semester) }}" enctype="multipart/form-data" class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf

                <div>
                    <label for="week_number" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Week (1–12) *</label>
                    <select
                        id="week_number"
                        name="week_number"
                        required
                        data-week-windows='@json($weekWindows)'
                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white focus:ring-primary focus:border-primary"
                    >
                        @foreach($weeks as $w)
                            <option value="{{ $w }}" {{ old('week_number') == $w ? 'selected' : '' }}>Week {{ $w }}</option>
                        @endforeach
                    </select>
                    @if($weeks->isEmpty())
                        <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">No valid module weeks are available for this semester date range.</p>
                    @endif
                    <p id="week_window_hint" class="mt-1 text-xs text-slate-500 dark:text-[#93adc8]"></p>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Title *</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">{{ old('description') }}</textarea>
                </div>

                @php
                    $lifeApplicationQuestions = old('life_application_questions', ['']);
                    if (!is_array($lifeApplicationQuestions) || count($lifeApplicationQuestions) === 0) {
                        $lifeApplicationQuestions = [''];
                    }
                @endphp
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Life application question</label>
                    <p class="text-xs text-slate-500 dark:text-[#93adc8] mb-2">Add one or more questions. Coordinators can see all questions; mentees only see questions that coordinators choose to show.</p>
                    <div id="life_application_questions_container" class="space-y-3">
                        @foreach($lifeApplicationQuestions as $question)
                            <div class="life-application-question-item rounded-lg border border-slate-200 dark:border-[#344d65] p-3">
                                <textarea name="life_application_questions[]" rows="3" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary" placeholder="Type a life application question...">{{ $question }}</textarea>
                                <div class="mt-2">
                                    <button type="button" class="remove-life-question rounded-lg border border-slate-300 dark:border-[#344d65] px-3 py-1.5 text-xs font-medium text-slate-600 dark:text-[#93adc8] hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add_life_application_question" class="mt-3 rounded-lg border border-slate-300 dark:border-[#344d65] px-3 py-2 text-sm font-medium text-slate-700 dark:text-[#93adc8] hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                        Add another question
                    </button>
                </div>

                <div>
                    <label for="audio" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Audio (MP3)</label>
                    <input id="audio" name="audio" type="file" accept=".mp3,.mpeg" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/20 file:text-primary">
                </div>

                <div>
                    <label for="video_url" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Video URL (YouTube or MP4 link)</label>
                    <input id="video_url" name="video_url" type="url" value="{{ old('video_url') }}" placeholder="https://..." class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="pdf" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">PDF</label>
                    <input id="pdf" name="pdf" type="file" accept=".pdf" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/20 file:text-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Module session schedule (optional)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="scheduled_start_at" class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Start</label>
                            <input id="scheduled_start_at" name="scheduled_start_at" type="datetime-local" value="{{ old('scheduled_start_at') }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="scheduled_end_at" class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">End</label>
                            <input id="scheduled_end_at" name="scheduled_end_at" type="datetime-local" value="{{ old('scheduled_end_at') }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-[#93adc8]">Example: Monday Feb 7, 2:30 PM - 3:30 PM.</p>
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Publish on (optional; leave blank for auto-publish on Monday)</label>
                    <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at') }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Create Module
                    </button>
                    <a href="{{ route('admin.semesters.modules.index', $semester) }}" class="rounded-lg border border-slate-300 dark:border-[#344d65] px-4 py-2 text-slate-600 dark:text-[#93adc8] text-sm font-medium hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const weekSelect = document.getElementById('week_number');
                const publishedAtInput = document.getElementById('published_at');
                const scheduledStartInput = document.getElementById('scheduled_start_at');
                const scheduledEndInput = document.getElementById('scheduled_end_at');
                const weekWindowHint = document.getElementById('week_window_hint');

                if (!weekSelect || !publishedAtInput || !scheduledStartInput || !scheduledEndInput || !weekWindowHint) {
                    return;
                }

                const weekWindows = JSON.parse(weekSelect.dataset.weekWindows || '{}');

                function clampDateTimeInput(input, min, max) {
                    if (!input.value) {
                        return;
                    }

                    if (input.value < min) {
                        input.value = min;
                    } else if (input.value > max) {
                        input.value = max;
                    }
                }

                function clearDateTimeInputConstraints(input) {
                    input.removeAttribute('min');
                    input.removeAttribute('max');
                }

                function applyConstraintsForSelectedWeek() {
                    const selectedWeek = weekSelect.value;
                    const selectedWindow = weekWindows[selectedWeek];

                    if (!selectedWindow) {
                        clearDateTimeInputConstraints(publishedAtInput);
                        clearDateTimeInputConstraints(scheduledStartInput);
                        clearDateTimeInputConstraints(scheduledEndInput);
                        weekWindowHint.textContent = '';
                        return;
                    }

                    const minDateTime = selectedWindow.start_datetime;
                    const maxDateTime = selectedWindow.end_datetime;

                    [publishedAtInput, scheduledStartInput, scheduledEndInput].forEach(function (input) {
                        input.min = minDateTime;
                        input.max = maxDateTime;
                        clampDateTimeInput(input, minDateTime, maxDateTime);
                    });

                    weekWindowHint.textContent = `Allowed dates for Week ${selectedWeek}: ${selectedWindow.start_display} to ${selectedWindow.end_display}`;
                }

                weekSelect.addEventListener('change', applyConstraintsForSelectedWeek);
                applyConstraintsForSelectedWeek();

                const questionsContainer = document.getElementById('life_application_questions_container');
                const addQuestionButton = document.getElementById('add_life_application_question');

                if (questionsContainer && addQuestionButton) {
                    function createQuestionItem(value = '') {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'life-application-question-item rounded-lg border border-slate-200 dark:border-[#344d65] p-3';
                        wrapper.innerHTML = `
                            <textarea name="life_application_questions[]" rows="3" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary" placeholder="Type a life application question..."></textarea>
                            <div class="mt-2">
                                <button type="button" class="remove-life-question rounded-lg border border-slate-300 dark:border-[#344d65] px-3 py-1.5 text-xs font-medium text-slate-600 dark:text-[#93adc8] hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                                    Remove
                                </button>
                            </div>
                        `;
                        wrapper.querySelector('textarea').value = value;
                        return wrapper;
                    }

                    function ensureAtLeastOneQuestionInput() {
                        if (!questionsContainer.querySelector('.life-application-question-item')) {
                            questionsContainer.appendChild(createQuestionItem());
                        }
                    }

                    addQuestionButton.addEventListener('click', function () {
                        questionsContainer.appendChild(createQuestionItem());
                    });

                    questionsContainer.addEventListener('click', function (event) {
                        const button = event.target.closest('.remove-life-question');
                        if (!button) {
                            return;
                        }
                        const item = button.closest('.life-application-question-item');
                        if (item) {
                            item.remove();
                        }
                        ensureAtLeastOneQuestionInput();
                    });

                    ensureAtLeastOneQuestionInput();
                }
            });
        </script>
    </main>
</x-admin-layout>
