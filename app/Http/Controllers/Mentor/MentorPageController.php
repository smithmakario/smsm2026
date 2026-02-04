<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Mail\MeetingTimeUpdated;
use App\Models\Cohort;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MentorPageController extends Controller
{
    public function cohorts(): View
    {
        $cohorts = auth()->user()->mentoredCohorts()->with('members')->orderBy('name')->get();

        return view('mentor.cohorts', ['activeSidebar' => 'cohorts', 'cohorts' => $cohorts]);
    }

    public function showCohort(Cohort $cohort): View|RedirectResponse
    {
        if ($cohort->mentor_id !== auth()->id()) {
            abort(403, 'You are not assigned to this cohort.');
        }
        $cohort->load(['mentor', 'members']);

        return view('mentor.cohort-show', ['activeSidebar' => 'cohorts', 'cohort' => $cohort]);
    }

    public function updateCohort(Request $request, Cohort $cohort): RedirectResponse
    {
        if ($cohort->mentor_id !== auth()->id()) {
            abort(403, 'You are not assigned to this cohort.');
        }
        $request->validate([
            'meeting_time' => ['nullable', 'date'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
        ]);
        $cohort->update([
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
        ]);

        $cohort->load(['mentor', 'members']);
        if ($cohort->mentor_id) {
            Mail::to($cohort->mentor->email)->send(new MeetingTimeUpdated($cohort->mentor, $cohort, true));
        }
        foreach ($cohort->members as $member) {
            Mail::to($member->email)->send(new MeetingTimeUpdated($member, $cohort, false));
        }

        return back()->with('status', 'Meeting details updated.');
    }

    public function assignments(): View
    {
        return view('mentor.assignments', ['activeSidebar' => 'assignments']);
    }

    public function resources(): View
    {
        return view('mentor.resources', ['activeSidebar' => 'resources']);
    }

    public function analytics(): View
    {
        return view('mentor.analytics', ['activeSidebar' => 'analytics']);
    }

    public function settings(): View
    {
        return view('mentor.settings', ['activeSidebar' => 'settings']);
    }

    public function messages(): View
    {
        return view('mentor.messages', ['activeSidebar' => null]);
    }
}
