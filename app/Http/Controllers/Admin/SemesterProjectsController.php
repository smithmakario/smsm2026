<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenteeSemesterProject;
use App\Models\Semester;
use App\Models\SemesterProject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SemesterProjectsController extends Controller
{
    public function index(Semester $semester): View
    {
        $projects = $semester->semesterProjects()->orderBy('sort_order')->orderBy('title')->get();

        return view('admin.semesters.projects.index', compact('semester', 'projects'));
    }

    public function create(Semester $semester): View
    {
        return view('admin.semesters.projects.create', compact('semester'));
    }

    public function store(Request $request, Semester $semester): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'points' => ['required', 'integer', 'min:0', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $semester->semesterProjects()->create([
            'title' => $request->title,
            'description' => $request->description,
            'points' => (int) $request->points,
            'sort_order' => (int) ($request->sort_order ?? 0),
        ]);

        return redirect()->route('admin.semesters.projects.index', $semester)
            ->with('status', 'Project added successfully.');
    }

    public function edit(Semester $semester, SemesterProject $semester_project): View
    {
        abort_if($semester_project->semester_id !== $semester->id, 404);

        return view('admin.semesters.projects.edit', compact('semester', 'semester_project'));
    }

    public function update(Request $request, Semester $semester, SemesterProject $semester_project): RedirectResponse
    {
        abort_if($semester_project->semester_id !== $semester->id, 404);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'points' => ['required', 'integer', 'min:0', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $semester_project->update([
            'title' => $request->title,
            'description' => $request->description,
            'points' => (int) $request->points,
            'sort_order' => (int) ($request->sort_order ?? 0),
        ]);

        return redirect()->route('admin.semesters.projects.index', $semester)
            ->with('status', 'Project updated successfully.');
    }

    public function destroy(Semester $semester, SemesterProject $semester_project): RedirectResponse
    {
        abort_if($semester_project->semester_id !== $semester->id, 404);

        $semester_project->delete();

        return redirect()->route('admin.semesters.projects.index', $semester)
            ->with('status', 'Project removed.');
    }

    public function menteeProjects(Semester $semester): View
    {
        $mentees = User::where('user_type', User::TYPE_MENTEE)->orderBy('first_name')->get();
        $assignments = MenteeSemesterProject::whereHas('semesterProject', fn ($q) => $q->where('semester_id', $semester->id))
            ->with(['user', 'semesterProject'])
            ->get()
            ->keyBy('user_id');

        return view('admin.semesters.mentee-projects.index', compact('semester', 'mentees', 'assignments'));
    }

    public function updateMenteeProject(Request $request, Semester $semester, MenteeSemesterProject $mentee_semester_project): RedirectResponse
    {
        abort_if($mentee_semester_project->semesterProject->semester_id !== $semester->id, 404);

        $request->validate([
            'status' => ['required', 'in:' . implode(',', MenteeSemesterProject::STATUSES)],
        ]);

        $mentee_semester_project->update(['status' => $request->status]);

        return redirect()->route('admin.semesters.mentee-projects', $semester)
            ->with('status', 'Status updated.');
    }
}
