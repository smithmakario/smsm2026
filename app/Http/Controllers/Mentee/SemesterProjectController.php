<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use App\Models\MenteeSemesterProject;
use App\Models\Semester;
use App\Models\SemesterProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SemesterProjectController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $activeSemester = Semester::active()->first();

        if (! $activeSemester) {
            return redirect()->route('mentee.index')->with('error', 'No active semester.');
        }

        $currentWeek = $activeSemester->currentWeekNumber();
        $canSelect = $currentWeek !== null && $currentWeek <= 2;

        $existing = MenteeSemesterProject::where('user_id', $user->id)
            ->whereHas('semesterProject', fn ($q) => $q->where('semester_id', $activeSemester->id))
            ->with('semesterProject')
            ->first();

        $projects = $activeSemester->semesterProjects()->orderBy('sort_order')->orderBy('title')->get();

        return view('mentee.project.index', [
            'activeSemester' => $activeSemester,
            'currentWeek' => $currentWeek,
            'canSelect' => $canSelect,
            'existing' => $existing,
            'projects' => $projects,
            'activeNav' => 'dashboard',
            'activeSidebar' => 'home',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $activeSemester = Semester::active()->first();

        if (! $activeSemester) {
            return redirect()->route('mentee.index')->with('error', 'No active semester.');
        }

        $currentWeek = $activeSemester->currentWeekNumber();
        if ($currentWeek === null || $currentWeek > 2) {
            return redirect()->route('mentee.project.index')->with('error', 'Project selection is only open during the first 2 weeks of the semester.');
        }

        $request->validate([
            'semester_project_id' => ['required', 'exists:semester_projects,id'],
        ]);

        $project = SemesterProject::findOrFail($request->semester_project_id);
        if ($project->semester_id !== $activeSemester->id) {
            return redirect()->route('mentee.project.index')->with('error', 'Invalid project.');
        }

        $already = MenteeSemesterProject::where('user_id', $user->id)
            ->whereHas('semesterProject', fn ($q) => $q->where('semester_id', $activeSemester->id))
            ->exists();
        if ($already) {
            return redirect()->route('mentee.project.index')->with('error', 'You have already selected a project for this semester.');
        }

        MenteeSemesterProject::create([
            'user_id' => $user->id,
            'semester_project_id' => $project->id,
            'status' => MenteeSemesterProject::STATUS_NOT_STARTED,
            'selected_at' => now(),
        ]);

        return redirect()->route('mentee.project.index')->with('status', 'Project selected successfully.');
    }
}
