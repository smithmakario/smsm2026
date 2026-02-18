<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\ReviewMeeting;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewMeetingsController extends Controller
{
    public function index(Cohort $cohort): View
    {
        $meetings = $cohort->reviewMeetings()->with(['semester', 'user'])->orderBy('occurred_at', 'desc')->paginate(20);
        $semesters = Semester::notArchived()->orderBy('starts_at', 'desc')->get();

        return view('admin.cohorts.review-meetings.index', compact('cohort', 'meetings', 'semesters'));
    }

    public function create(Cohort $cohort): View
    {
        $semesters = Semester::notArchived()->orderBy('starts_at', 'desc')->get();
        $mentees = $cohort->mentees()->orderBy('first_name')->get();

        return view('admin.cohorts.review-meetings.create', compact('cohort', 'semesters', 'mentees'));
    }

    public function store(Request $request, Cohort $cohort): RedirectResponse
    {
        $request->validate([
            'semester_id' => ['required', 'exists:semesters,id'],
            'week_number' => ['required', 'integer', 'min:1', 'max:12'],
            'user_id' => ['nullable', 'exists:users,id'],
            'occurred_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $userId = $request->user_id ?: null;
        if ($userId && ! $cohort->mentees()->where('users.id', $userId)->exists()) {
            return redirect()->back()->withErrors(['user_id' => 'Selected user is not a mentee in this cohort.']);
        }

        ReviewMeeting::create([
            'cohort_id' => $cohort->id,
            'semester_id' => $request->semester_id,
            'week_number' => (int) $request->week_number,
            'user_id' => $userId,
            'occurred_at' => $request->occurred_at,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.cohorts.review-meetings.index', $cohort)
            ->with('status', 'Review meeting recorded.');
    }
}
