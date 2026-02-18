<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Semester;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SemesterModulesController extends Controller
{
    public function index(Semester $semester): View
    {
        $semester->load('modules');
        $modules = $semester->modules()->orderBy('week_number')->get();

        return view('admin.semesters.modules.index', compact('semester', 'modules'));
    }

    public function create(Semester $semester): View
    {
        $existingWeeks = $semester->modules()->pluck('week_number')->toArray();
        $weekWindows = $this->buildWeekWindows($semester);
        $weeks = collect(array_keys($weekWindows))
            ->filter(fn ($w) => ! in_array($w, $existingWeeks))
            ->values();

        return view('admin.semesters.modules.create', compact('semester', 'weeks', 'weekWindows'));
    }

    public function store(Request $request, Semester $semester): RedirectResponse
    {
        $weekWindows = $this->buildWeekWindows($semester);

        $request->validate([
            'week_number' => [
                'required',
                'integer',
                'min:1',
                'max:12',
                function (string $attribute, mixed $value, Closure $fail) use ($weekWindows): void {
                    if (! array_key_exists((int) $value, $weekWindows)) {
                        $fail('The selected week is outside the semester date range.');
                    }
                },
                fn ($attr, $value, $fail) => $semester->modules()->where('week_number', $value)->exists()
                    ? $fail('A module for week ' . $value . ' already exists.')
                    : null,
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'audio' => ['nullable', 'file', 'mimes:mp3,mpeg', 'max:51200'],
            'video_url' => ['nullable', 'string', 'max:500', 'url'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'published_at' => [
                'nullable',
                'date',
                $this->ensureDateWithinSelectedWeek($request, $weekWindows, 'Publish date/time'),
            ],
            'scheduled_start_at' => [
                'nullable',
                'date',
                'required_with:scheduled_end_at',
                $this->ensureDateWithinSelectedWeek($request, $weekWindows, 'Schedule start date/time'),
            ],
            'scheduled_end_at' => [
                'nullable',
                'date',
                'required_with:scheduled_start_at',
                'after:scheduled_start_at',
                $this->ensureDateWithinSelectedWeek($request, $weekWindows, 'Schedule end date/time'),
            ],
            'life_application_questions' => ['nullable', 'array', 'max:100'],
            'life_application_questions.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $module = new Module([
            'semester_id' => $semester->id,
            'week_number' => (int) $request->week_number,
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'published_at' => $request->published_at ? now()->parse($request->published_at) : null,
            'scheduled_start_at' => $request->scheduled_start_at ? now()->parse($request->scheduled_start_at) : null,
            'scheduled_end_at' => $request->scheduled_end_at ? now()->parse($request->scheduled_end_at) : null,
        ]);

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store(
                "modules/semester_{$semester->id}",
                'public',
            );
            $module->audio_path = $path;
        }

        if ($request->hasFile('pdf')) {
            $path = $request->file('pdf')->store(
                "modules/semester_{$semester->id}",
                'public',
            );
            $module->pdf_path = $path;
        }

        $module->save();
        $this->syncLifeApplicationQuestions($module, $this->extractLifeApplicationQuestions($request));

        return redirect()->route('admin.semesters.modules.index', $semester)
            ->with('status', 'Module created successfully.');
    }

    public function edit(Semester $semester, Module $module): View
    {
        abort_if($module->semester_id !== $semester->id, 404);
        $module->load('lifeApplicationQuestions');

        return view('admin.semesters.modules.edit', compact('semester', 'module'));
    }

    public function update(Request $request, Semester $semester, Module $module): RedirectResponse
    {
        abort_if($module->semester_id !== $semester->id, 404);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'audio' => ['nullable', 'file', 'mimes:mp3,mpeg', 'max:51200'],
            'video_url' => ['nullable', 'string', 'max:500', 'url'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'published_at' => ['nullable', 'date'],
            'scheduled_start_at' => ['nullable', 'date', 'required_with:scheduled_end_at'],
            'scheduled_end_at' => ['nullable', 'date', 'required_with:scheduled_start_at', 'after:scheduled_start_at'],
            'life_application_questions' => ['nullable', 'array', 'max:100'],
            'life_application_questions.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $module->title = $request->title;
        $module->description = $request->description;
        $module->video_url = $request->video_url;
        $module->published_at = $request->published_at ? now()->parse($request->published_at) : null;
        $module->scheduled_start_at = $request->scheduled_start_at ? now()->parse($request->scheduled_start_at) : null;
        $module->scheduled_end_at = $request->scheduled_end_at ? now()->parse($request->scheduled_end_at) : null;

        if ($request->hasFile('audio')) {
            if ($module->audio_path) {
                Storage::disk('public')->delete($module->audio_path);
            }
            $module->audio_path = $request->file('audio')->store(
                "modules/semester_{$semester->id}",
                'public',
            );
        }

        if ($request->hasFile('pdf')) {
            if ($module->pdf_path) {
                Storage::disk('public')->delete($module->pdf_path);
            }
            $module->pdf_path = $request->file('pdf')->store(
                "modules/semester_{$semester->id}",
                'public',
            );
        }

        if ($request->boolean('remove_audio')) {
            if ($module->audio_path) {
                Storage::disk('public')->delete($module->audio_path);
            }
            $module->audio_path = null;
        }
        if ($request->boolean('remove_pdf')) {
            if ($module->pdf_path) {
                Storage::disk('public')->delete($module->pdf_path);
            }
            $module->pdf_path = null;
        }

        $this->syncLifeApplicationQuestions($module, $this->extractLifeApplicationQuestions($request));
        $module->save();

        return redirect()->route('admin.semesters.modules.index', $semester)
            ->with('status', 'Module updated successfully.');
    }

    public function destroy(Semester $semester, Module $module): RedirectResponse
    {
        abort_if($module->semester_id !== $semester->id, 404);

        if ($module->audio_path) {
            Storage::disk('public')->delete($module->audio_path);
        }
        if ($module->pdf_path) {
            Storage::disk('public')->delete($module->pdf_path);
        }
        $module->delete();

        return redirect()->route('admin.semesters.modules.index', $semester)
            ->with('status', 'Module deleted.');
    }

    private function buildWeekWindows(Semester $semester): array
    {
        $semesterStart = $semester->starts_at->copy()->startOfDay();
        $semesterEnd = $semester->ends_at->copy()->endOfDay();
        $windows = [];

        for ($week = 1; $week <= 12; $week++) {
            $weekStart = $semesterStart->copy()->addWeeks($week - 1)->startOfDay();
            if ($weekStart->gt($semesterEnd)) {
                break;
            }

            $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();
            if ($weekEnd->gt($semesterEnd)) {
                $weekEnd = $semesterEnd->copy();
            }

            $windows[$week] = [
                'start' => $weekStart,
                'end' => $weekEnd,
                'start_datetime' => $weekStart->format('Y-m-d\TH:i'),
                'end_datetime' => $weekEnd->format('Y-m-d\TH:i'),
                'start_display' => $weekStart->toFormattedDateString(),
                'end_display' => $weekEnd->toFormattedDateString(),
            ];
        }

        return $windows;
    }

    private function ensureDateWithinSelectedWeek(Request $request, array $weekWindows, string $fieldLabel): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail) use ($request, $weekWindows, $fieldLabel): void {
            if (empty($value) || ! $request->filled('week_number')) {
                return;
            }

            $selectedWeek = (int) $request->input('week_number');
            if (! isset($weekWindows[$selectedWeek])) {
                return;
            }

            try {
                $valueDate = Carbon::parse((string) $value);
            } catch (\Throwable) {
                return;
            }

            $weekStart = $weekWindows[$selectedWeek]['start'];
            $weekEnd = $weekWindows[$selectedWeek]['end'];

            if ($valueDate->lt($weekStart) || $valueDate->gt($weekEnd)) {
                $fail($fieldLabel . ' must be between ' . $weekStart->format('Y-m-d H:i') . ' and ' . $weekEnd->format('Y-m-d H:i') . ' for the selected week.');
            }
        };
    }

    /**
     * @return list<string>
     */
    private function extractLifeApplicationQuestions(Request $request): array
    {
        $questions = $request->input('life_application_questions', []);
        if (! is_array($questions)) {
            return [];
        }

        $cleaned = [];
        foreach ($questions as $question) {
            if (! is_string($question)) {
                continue;
            }
            $trimmed = trim($question);
            if ($trimmed === '') {
                continue;
            }
            $cleaned[] = $trimmed;
        }

        return $cleaned;
    }

    /**
     * @param list<string> $questions
     */
    private function syncLifeApplicationQuestions(Module $module, array $questions): void
    {
        $module->lifeApplicationQuestions()->delete();
        foreach ($questions as $index => $question) {
            $module->lifeApplicationQuestions()->create([
                'question' => $question,
                'sort_order' => $index + 1,
                'is_visible_to_mentee' => false,
            ]);
        }
    }
}
