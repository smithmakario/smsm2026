<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Mail\MeetingTimeUpdated;
use App\Models\Cohort;
use App\Models\CohortAttendance;
use App\Models\ModuleLifeApplicationQuestion;
use App\Models\Semester;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CoordinatorPageController extends Controller
{
    public function cohorts(): View
    {
        $cohorts = auth()->user()->coordinatedCohorts()->with('members')->orderBy('name')->get();

        return view('coordinator.cohorts', ['activeSidebar' => 'cohorts', 'cohorts' => $cohorts]);
    }

    public function showCohort(Cohort $cohort): View|RedirectResponse
    {
        if ($cohort->coordinator_id !== auth()->id()) {
            abort(403, 'You are not assigned to this cohort.');
        }
        $cohort->load(['coordinator', 'members']);
        $attendances = CohortAttendance::where('cohort_id', $cohort->id)->get();
        $attendanceByMember = $attendances->groupBy('user_id')->map(
            fn ($rows) => $rows->keyBy('week_number')->map(fn ($r) => $r->status)
        );
        $activeSemester = Semester::active()->first();
        $currentWeek = $activeSemester?->currentWeekNumber();
        $currentModule = null;
        if ($activeSemester && $currentWeek !== null) {
            $currentModule = $activeSemester->modules()
                ->where('week_number', $currentWeek)
                ->with('lifeApplicationQuestions')
                ->first();
        }

        return view('coordinator.cohort-show', [
            'activeSidebar' => 'cohorts',
            'cohort' => $cohort,
            'attendanceByMember' => $attendanceByMember,
            'currentWeek' => $currentWeek,
            'currentModule' => $currentModule,
        ]);
    }

    public function showLifeApplicationQuestionToMentee(Cohort $cohort, ModuleLifeApplicationQuestion $question): RedirectResponse
    {
        if ($cohort->coordinator_id !== auth()->id()) {
            abort(403, 'You are not assigned to this cohort.');
        }

        $this->ensureQuestionBelongsToCurrentWeekModule($question);
        $question->is_visible_to_mentee = true;
        $question->save();

        return back()->with('status', 'Question is now visible to mentees.');
    }

    public function hideLifeApplicationQuestionFromMentee(Cohort $cohort, ModuleLifeApplicationQuestion $question): RedirectResponse
    {
        if ($cohort->coordinator_id !== auth()->id()) {
            abort(403, 'You are not assigned to this cohort.');
        }

        $this->ensureQuestionBelongsToCurrentWeekModule($question);
        $question->is_visible_to_mentee = false;
        $question->save();

        return back()->with('status', 'Question is now hidden from mentees.');
    }

    public function storeAttendance(Request $request, Cohort $cohort): RedirectResponse
    {
        if ($cohort->coordinator_id !== auth()->id()) {
            abort(403, 'You are not assigned to this cohort.');
        }
        $memberIds = $cohort->members()->pluck('users.id')->all();
        $request->validate([
            'week_number' => ['required', 'integer', 'min:1', 'max:255'],
            'attendances' => ['nullable', 'array'],
            'attendances.*' => ['nullable', 'string', 'in:present,late,absent,none'],
        ]);
        $week = (int) $request->week_number;
        $attendances = $request->input('attendances', []);
        foreach ($attendances as $userId => $status) {
            $userId = (int) $userId;
            if (! in_array($userId, $memberIds, true)) {
                continue;
            }
            if ($status === 'none' || $status === '' || $status === null) {
                CohortAttendance::where('cohort_id', $cohort->id)
                    ->where('user_id', $userId)
                    ->where('week_number', $week)
                    ->delete();
            } else {
                CohortAttendance::updateOrCreate(
                    [
                        'cohort_id' => $cohort->id,
                        'user_id' => $userId,
                        'week_number' => $week,
                    ],
                    ['status' => $status]
                );
            }
        }

        return redirect()->route('coordinator.cohorts.show', $cohort)
            ->with('status', 'Attendance saved.')
            ->withInput(['week_number' => $week]);
    }

    public function updateCohort(Request $request, Cohort $cohort): RedirectResponse
    {
        if ($cohort->coordinator_id !== auth()->id()) {
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

        $cohort->load(['coordinator', 'members']);
        if ($cohort->coordinator_id) {
            Mail::to($cohort->coordinator->email)->send(new MeetingTimeUpdated($cohort->coordinator, $cohort, true));
        }
        foreach ($cohort->members as $member) {
            Mail::to($member->email)->send(new MeetingTimeUpdated($member, $cohort, false));
        }

        return back()->with('status', 'Meeting details updated.');
    }

    public function assignments(): View
    {
        return view('coordinator.assignments', ['activeSidebar' => 'assignments']);
    }

    public function resources(): View
    {
        return view('coordinator.resources', ['activeSidebar' => 'resources']);
    }

    public function analytics(): View
    {
        return view('coordinator.analytics', ['activeSidebar' => 'analytics']);
    }

    public function settings(): View
    {
        return view('coordinator.settings', ['activeSidebar' => 'settings']);
    }

    public function messages(): View
    {
        return view('coordinator.messages', ['activeSidebar' => null]);
    }

    private function ensureQuestionBelongsToCurrentWeekModule(ModuleLifeApplicationQuestion $question): void
    {
        $activeSemester = Semester::active()->first();
        $currentWeek = $activeSemester?->currentWeekNumber();
        if (! $activeSemester || $currentWeek === null) {
            abort(404, 'No active module is available right now.');
        }

        $isQuestionForCurrentModule = $activeSemester->modules()
            ->where('week_number', $currentWeek)
            ->where('id', $question->module_id)
            ->exists();

        if (! $isQuestionForCurrentModule) {
            abort(404, 'Question not found for the current module.');
        }
    }
}
