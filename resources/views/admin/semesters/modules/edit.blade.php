<x-admin-layout>
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="flex items-center justify-between sticky top-0 z-10 bg-white/80 dark:bg-[#111a22]/80 backdrop-blur-md border-b border-slate-200 dark:border-[#243647] px-8 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.semesters.modules.index', $semester) }}" class="text-sm text-slate-600 dark:text-[#93adc8] hover:text-primary">← Modules</a>
                <h2 class="text-lg font-bold tracking-tight">Edit Week {{ $module->week_number }}</h2>
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
            <form method="POST" action="{{ route('admin.semesters.modules.update', [$semester, $module]) }}" enctype="multipart/form-data" class="space-y-6 rounded-xl bg-white dark:bg-[#111a22] border border-slate-200 dark:border-[#344d65] p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Title *</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $module->title) }}" required class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">{{ old('description', $module->description) }}</textarea>
                </div>

                @php
                    $defaultQuestions = $module->lifeApplicationQuestions->pluck('question')->all();
                    $lifeApplicationQuestions = old('life_application_questions', $defaultQuestions);
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

                @php
                    $defaultActivities = $module->activities
                        ->sortBy('sort_order')
                        ->map(fn ($activity) => [
                            'title' => $activity->title,
                            'description' => $activity->description,
                            'occurs_at' => $activity->occurs_at?->format('Y-m-d\TH:i'),
                        ])
                        ->values()
                        ->all();
                    $activities = old('activities', $defaultActivities);
                    if (!is_array($activities)) {
                        $activities = [];
                    }
                @endphp
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Activities</label>
                    <p class="text-xs text-slate-500 dark:text-[#93adc8] mb-2">Add one or more activities for this module week, each with its own date and time.</p>
                    <div id="activities_container" class="space-y-3">
                        @foreach($activities as $index => $activity)
                            <div class="activity-item rounded-lg border border-slate-200 dark:border-[#344d65] p-3 space-y-3">
                                <div>
                                    <label class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Activity title *</label>
                                    <input
                                        type="text"
                                        data-field="title"
                                        name="activities[{{ $index }}][title]"
                                        value="{{ is_array($activity) ? ($activity['title'] ?? '') : '' }}"
                                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Description (optional)</label>
                                    <textarea
                                        rows="2"
                                        data-field="description"
                                        name="activities[{{ $index }}][description]"
                                        class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"
                                    >{{ is_array($activity) ? ($activity['description'] ?? '') : '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Date &amp; time *</label>
                                    <input
                                        type="datetime-local"
                                        data-field="occurs_at"
                                        name="activities[{{ $index }}][occurs_at]"
                                        value="{{ is_array($activity) ? ($activity['occurs_at'] ?? '') : '' }}"
                                        class="activity-occurs-at-input w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"
                                    >
                                </div>
                                <div>
                                    <button type="button" class="remove-activity rounded-lg border border-slate-300 dark:border-[#344d65] px-3 py-1.5 text-xs font-medium text-slate-600 dark:text-[#93adc8] hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                                        Remove activity
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add_activity" class="mt-3 rounded-lg border border-slate-300 dark:border-[#344d65] px-3 py-2 text-sm font-medium text-slate-700 dark:text-[#93adc8] hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                        Add activity
                    </button>
                </div>

                <div>
                    <label for="audio" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Audio (MP3)</label>
                    @if($module->audio_path)
                        <p class="text-xs text-slate-500 dark:text-[#93adc8] mb-1">Current file uploaded. Upload a new file to replace.</p>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-[#93adc8]">
                            <input type="checkbox" name="remove_audio" value="1"> Remove current audio
                        </label>
                    @endif
                    <input id="audio" name="audio" type="file" accept=".mp3,.mpeg" class="mt-2 w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/20 file:text-primary">
                </div>

                <div>
                    <label for="video_url" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Video URL</label>
                    <input id="video_url" name="video_url" type="url" value="{{ old('video_url', $module->video_url) }}" placeholder="https://..." class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label for="pdf" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">PDF</label>
                    @if($module->pdf_path)
                        <p class="text-xs text-slate-500 dark:text-[#93adc8] mb-1">Current file uploaded. Upload a new file to replace.</p>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-[#93adc8]">
                            <input type="checkbox" name="remove_pdf" value="1"> Remove current PDF
                        </label>
                    @endif
                    <input id="pdf" name="pdf" type="file" accept=".pdf" class="mt-2 w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary/20 file:text-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Module session schedule (optional)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="scheduled_start_at" class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Start</label>
                            <input id="scheduled_start_at" name="scheduled_start_at" type="datetime-local" value="{{ old('scheduled_start_at', $module->scheduled_start_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="scheduled_end_at" class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">End</label>
                            <input id="scheduled_end_at" name="scheduled_end_at" type="datetime-local" value="{{ old('scheduled_end_at', $module->scheduled_end_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-[#93adc8]">Example: Monday Feb 7, 2:30 PM - 3:30 PM.</p>
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-slate-700 dark:text-[#93adc8] mb-1">Published at</label>
                    <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $module->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                    @if($moduleWeekWindow)
                        <p class="mt-1 text-xs text-slate-500 dark:text-[#93adc8]">
                            Allowed dates for Week {{ $module->week_number }}: {{ $moduleWeekWindow['start_display'] }} to {{ $moduleWeekWindow['end_display'] }}
                        </p>
                    @endif
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Update Module
                    </button>
                    <a href="{{ route('admin.semesters.modules.index', $semester) }}" class="rounded-lg border border-slate-300 dark:border-[#344d65] px-4 py-2 text-slate-600 dark:text-[#93adc8] text-sm font-medium hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questionsContainer = document.getElementById('life_application_questions_container');
            const addQuestionButton = document.getElementById('add_life_application_question');
            const publishedAtInput = document.getElementById('published_at');
            const scheduledStartInput = document.getElementById('scheduled_start_at');
            const scheduledEndInput = document.getElementById('scheduled_end_at');
            const activitiesContainer = document.getElementById('activities_container');
            const addActivityButton = document.getElementById('add_activity');
            const moduleWeekWindow = @json($moduleWeekWindow);

            function clampDateTimeInput(input, min, max) {
                if (!input || !input.value) {
                    return;
                }

                if (input.value < min) {
                    input.value = min;
                } else if (input.value > max) {
                    input.value = max;
                }
            }

            function clearDateTimeInputConstraints(input) {
                if (!input) {
                    return;
                }

                input.removeAttribute('min');
                input.removeAttribute('max');
            }

            function applyActivityDateTimeConstraints(minDateTime, maxDateTime) {
                if (!activitiesContainer) {
                    return;
                }

                const activityDateInputs = activitiesContainer.querySelectorAll('.activity-occurs-at-input');
                activityDateInputs.forEach(function (input) {
                    if (!minDateTime || !maxDateTime) {
                        clearDateTimeInputConstraints(input);
                        return;
                    }

                    input.min = minDateTime;
                    input.max = maxDateTime;
                    clampDateTimeInput(input, minDateTime, maxDateTime);
                });
            }

            function applyWeekConstraints() {
                if (!moduleWeekWindow) {
                    [publishedAtInput, scheduledStartInput, scheduledEndInput].forEach(clearDateTimeInputConstraints);
                    applyActivityDateTimeConstraints(null, null);
                    return;
                }

                const minDateTime = moduleWeekWindow.start_datetime;
                const maxDateTime = moduleWeekWindow.end_datetime;
                [publishedAtInput, scheduledStartInput, scheduledEndInput].forEach(function (input) {
                    if (!input) {
                        return;
                    }

                    input.min = minDateTime;
                    input.max = maxDateTime;
                    clampDateTimeInput(input, minDateTime, maxDateTime);
                });
                applyActivityDateTimeConstraints(minDateTime, maxDateTime);
            }

            if (!questionsContainer || !addQuestionButton) {
                applyWeekConstraints();
            }

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

            if (activitiesContainer && addActivityButton) {
                function createActivityItem(activity = {}) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'activity-item rounded-lg border border-slate-200 dark:border-[#344d65] p-3 space-y-3';
                    wrapper.innerHTML = `
                        <div>
                            <label class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Activity title *</label>
                            <input type="text" data-field="title" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Description (optional)</label>
                            <textarea rows="2" data-field="description" class="w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 dark:text-[#93adc8] mb-1">Date &amp; time *</label>
                            <input type="datetime-local" data-field="occurs_at" class="activity-occurs-at-input w-full rounded-lg border-slate-300 dark:border-[#344d65] dark:bg-[#243647] dark:text-white shadow-sm focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <button type="button" class="remove-activity rounded-lg border border-slate-300 dark:border-[#344d65] px-3 py-1.5 text-xs font-medium text-slate-600 dark:text-[#93adc8] hover:bg-slate-50 dark:hover:bg-[#243647] transition-all">
                                Remove activity
                            </button>
                        </div>
                    `;

                    const titleInput = wrapper.querySelector('[data-field="title"]');
                    const descriptionInput = wrapper.querySelector('[data-field="description"]');
                    const occursAtInput = wrapper.querySelector('[data-field="occurs_at"]');

                    titleInput.value = activity.title || '';
                    descriptionInput.value = activity.description || '';
                    occursAtInput.value = activity.occurs_at || '';

                    return wrapper;
                }

                function renumberActivityInputs() {
                    const items = activitiesContainer.querySelectorAll('.activity-item');
                    items.forEach(function (item, index) {
                        const titleInput = item.querySelector('[data-field="title"]');
                        const descriptionInput = item.querySelector('[data-field="description"]');
                        const occursAtInput = item.querySelector('[data-field="occurs_at"]');

                        titleInput.name = `activities[${index}][title]`;
                        descriptionInput.name = `activities[${index}][description]`;
                        occursAtInput.name = `activities[${index}][occurs_at]`;
                    });
                }

                addActivityButton.addEventListener('click', function () {
                    activitiesContainer.appendChild(createActivityItem());
                    renumberActivityInputs();
                    applyWeekConstraints();
                });

                activitiesContainer.addEventListener('click', function (event) {
                    const button = event.target.closest('.remove-activity');
                    if (!button) {
                        return;
                    }

                    const item = button.closest('.activity-item');
                    if (item) {
                        item.remove();
                    }
                    renumberActivityInputs();
                });

                renumberActivityInputs();
            }

            applyWeekConstraints();
        });
    </script>
</x-admin-layout>
