<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SemestersController extends Controller
{
    public function index(): View
    {
        $semesters = Semester::query()
            ->notArchived()
            ->orderByRaw('is_active DESC, starts_at DESC')
            ->paginate(15);

        return view('admin.semesters.index', compact('semesters'));
    }

    public function create(): View
    {
        return view('admin.semesters.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            $this->semesterValidationRules($request),
            $this->semesterValidationMessages()
        );

        Semester::create([
            'name' => $request->name,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
        ]);

        return redirect()->route('admin.semesters.index')
            ->with('status', 'Semester created successfully.');
    }

    public function show(Semester $semester): View
    {
        $semester->load(['modules', 'semesterProjects']);

        return view('admin.semesters.show', compact('semester'));
    }

    public function edit(Semester $semester): View
    {
        return view('admin.semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester): RedirectResponse
    {
        $request->validate(
            $this->semesterValidationRules($request),
            $this->semesterValidationMessages()
        );

        $semester->update([
            'name' => $request->name,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
        ]);

        return redirect()->route('admin.semesters.show', $semester)
            ->with('status', 'Semester updated successfully.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        $semester->delete();

        return redirect()->route('admin.semesters.index')
            ->with('status', 'Semester deleted.');
    }

    public function setActive(Semester $semester): RedirectResponse
    {
        $semester->update(['is_active' => true]);

        return redirect()->back()
            ->with('status', "{$semester->name} is now the active semester.");
    }

    public function archive(Semester $semester): RedirectResponse
    {
        $semester->update(['is_active' => false, 'archived_at' => now()]);

        return redirect()->back()
            ->with('status', "{$semester->name} has been archived.");
    }

    private function semesterValidationRules(Request $request): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => [
                'required',
                'date',
                'after_or_equal:starts_at',
                function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
                    if (!$request->filled('starts_at') || empty($value)) {
                        return;
                    }

                    try {
                        $startDate = Carbon::parse($request->input('starts_at'))->startOfDay();
                        $endDate = Carbon::parse((string) $value)->startOfDay();
                    } catch (\Throwable) {
                        return;
                    }

                    $maxEndDate = $startDate->copy()->addMonthsNoOverflow(3);

                    if ($endDate->gt($maxEndDate)) {
                        $fail('The end date cannot be more than 3 months after the start date.');
                    }
                },
            ],
        ];
    }

    private function semesterValidationMessages(): array
    {
        return [
            'ends_at.after_or_equal' => 'The end date must be on or after the start date.',
        ];
    }
}
