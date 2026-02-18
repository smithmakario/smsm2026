<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AtRiskCheckInReminder;
use App\Mail\MeetingTimeUpdated;
use App\Mail\CoordinatorAssignedToCohort;
use App\Mail\UserAddedToCohort;
use App\Models\Cohort;
use App\Models\CohortAttendance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CohortsController extends Controller
{
    public function index(): View
    {
        $cohorts = Cohort::with(['coordinator', 'members'])->orderBy('name')->paginate(15);

        return view('admin.cohorts.index', compact('cohorts'));
    }

    public function create(): View
    {
        $coordinators = User::where('user_type', User::TYPE_COORDINATOR)->orderBy('first_name')->get();
        $mentees = User::where('user_type', User::TYPE_MENTEE)->orderBy('first_name')->get();

        return view('admin.cohorts.create', compact('coordinators', 'mentees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'coordinator_id' => ['nullable', 'exists:users,id'],
            'meeting_time' => ['nullable', 'date'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
            'members' => ['nullable', 'array'],
            'members.*' => ['exists:users,id'],
        ]);

        $cohort = Cohort::create([
            'name' => $request->name,
            'coordinator_id' => $request->coordinator_id ?: null,
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
        ]);

        if ($request->members) {
            $mentees = User::whereIn('id', $request->members)->where('user_type', User::TYPE_MENTEE)->pluck('id');
            $cohort->members()->sync($mentees);
        }

        $cohort->load(['coordinator', 'members']);
        if ($cohort->coordinator_id) {
            Mail::to($cohort->coordinator->email)->send(new CoordinatorAssignedToCohort($cohort->coordinator, $cohort));
        }
        foreach ($cohort->members as $member) {
            Mail::to($member->email)->send(new UserAddedToCohort($member, $cohort));
        }

        return redirect()->route('admin.cohorts.show', $cohort)
            ->with('status', 'Cohort created successfully.');
    }

    public function show(Cohort $cohort): View
    {
        $cohort->load(['coordinator', 'members']);
        $coordinators = User::where('user_type', User::TYPE_COORDINATOR)->orderBy('first_name')->get();
        $availableMentees = User::where('user_type', User::TYPE_MENTEE)
            ->where(function ($q) use ($cohort) {
                $q->whereDoesntHave('cohorts')
                    ->orWhereHas('cohorts', fn ($q2) => $q2->where('cohorts.id', $cohort->id));
            })
            ->orderBy('first_name')
            ->get();

        $attendances = CohortAttendance::where('cohort_id', $cohort->id)->get();
        $attendanceByMember = $attendances->groupBy('user_id')->map(
            fn ($rows) => $rows->keyBy('week_number')->map(fn ($r) => $r->status)
        );

        $totalRecords = $attendances->count();
        $presentOrLate = $attendances->whereIn('status', ['present', 'late'])->count();
        $averageAttendance = $totalRecords > 0 ? round(($presentOrLate / $totalRecords) * 100) : null;

        $maxWeek = $attendances->isEmpty() ? 0 : (int) $attendances->max('week_number');
        $activeMenteeCount = 0;
        if ($maxWeek >= 1) {
            $lastTwoWeeks = $maxWeek >= 2 ? [$maxWeek, $maxWeek - 1] : [$maxWeek];
            $activeMenteeCount = $attendances
                ->whereIn('week_number', $lastTwoWeeks)
                ->whereIn('status', ['present', 'late'])
                ->pluck('user_id')
                ->unique()
                ->count();
        }

        $atRiskMembers = $this->computeAtRiskMembers($cohort, $attendances, $maxWeek);
        $atRiskCount = $atRiskMembers->count();

        return view('admin.cohorts.show', compact(
            'cohort',
            'coordinators',
            'availableMentees',
            'attendanceByMember',
            'averageAttendance',
            'activeMenteeCount',
            'atRiskMembers',
            'atRiskCount'
        ));
    }

    /**
     * @return Collection<int, array{user: User, reason: string}>
     */
    private function computeAtRiskMembers(Cohort $cohort, Collection $attendances, int $maxWeek): Collection
    {
        $memberIds = $cohort->members->pluck('id')->all();
        $byUser = $attendances->groupBy('user_id');
        $atRisk = collect();
        foreach ($memberIds as $userId) {
            $userRecords = $byUser->get($userId, collect());
            if ($userRecords->isEmpty()) {
                continue;
            }
            $user = $cohort->members->firstWhere('id', $userId);
            if (! $user) {
                continue;
            }
            $total = $userRecords->count();
            $presentOrLate = $userRecords->whereIn('status', ['present', 'late'])->count();
            $rate = $total > 0 ? $presentOrLate / $total : 0;
            $lowAttendance = $rate < 0.6;
            $missedLastTwo = false;
            if ($maxWeek >= 2) {
                $lastWeek = $userRecords->firstWhere('week_number', $maxWeek);
                $prevWeek = $userRecords->firstWhere('week_number', $maxWeek - 1);
                $lastStatus = $lastWeek ? $lastWeek->status : null;
                $prevStatus = $prevWeek ? $prevWeek->status : null;
                $missedLastTwo = in_array($lastStatus, ['absent', null], true) && in_array($prevStatus, ['absent', null], true);
            }
            if ($missedLastTwo) {
                $atRisk->push(['user' => $user, 'reason' => 'Missed last 2 sessions']);
            } elseif ($lowAttendance) {
                $atRisk->push(['user' => $user, 'reason' => round($rate * 100) . '% Attendance']);
            }
        }

        return $atRisk;
    }

    public function edit(Cohort $cohort): View
    {
        $cohort->load(['coordinator', 'members']);
        $coordinators = User::where('user_type', User::TYPE_COORDINATOR)->orderBy('first_name')->get();
        $mentees = User::where('user_type', User::TYPE_MENTEE)->orderBy('first_name')->get();

        return view('admin.cohorts.edit', compact('cohort', 'coordinators', 'mentees'));
    }

    public function update(Request $request, Cohort $cohort): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'coordinator_id' => ['nullable', 'exists:users,id'],
            'meeting_time' => ['nullable', 'date'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
            'members' => ['nullable', 'array'],
            'members.*' => ['exists:users,id'],
        ]);

        $previousCoordinatorId = $cohort->coordinator_id;
        $previousMemberIds = $cohort->members()->pluck('users.id')->all();
        $meetingTimeChanged = $cohort->meeting_time?->format('Y-m-d H:i') !== ($request->meeting_time ? date('Y-m-d H:i', strtotime($request->meeting_time)) : null)
            || (string) $cohort->meeting_link !== (string) $request->meeting_link;

        $cohort->update([
            'name' => $request->name,
            'coordinator_id' => $request->coordinator_id ?: null,
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
        ]);

        if ($request->coordinator_id && (int) $request->coordinator_id !== (int) $previousCoordinatorId && $cohort->coordinator) {
            Mail::to($cohort->coordinator->email)->send(new CoordinatorAssignedToCohort($cohort->coordinator, $cohort->fresh(['members'])));
        }

        if ($request->has('members')) {
            $mentees = User::whereIn('id', $request->members)->where('user_type', User::TYPE_MENTEE)->pluck('id');
            $cohort->members()->sync($mentees);
            $cohort->load('members');
            $newMemberIds = $cohort->members->pluck('id')->all();
            $addedIds = array_diff($newMemberIds, $previousMemberIds);
            foreach ($cohort->members->whereIn('id', $addedIds) as $member) {
                Mail::to($member->email)->send(new UserAddedToCohort($member, $cohort));
            }
        }

        if ($meetingTimeChanged) {
            $cohort->load(['coordinator', 'members']);
            if ($cohort->coordinator_id) {
                Mail::to($cohort->coordinator->email)->send(new MeetingTimeUpdated($cohort->coordinator, $cohort, true));
            }
            foreach ($cohort->members as $member) {
                Mail::to($member->email)->send(new MeetingTimeUpdated($member, $cohort, false));
            }
        }

        return redirect()->route('admin.cohorts.show', $cohort)
            ->with('status', 'Cohort updated successfully.');
    }

    public function destroy(Cohort $cohort): RedirectResponse
    {
        $cohort->members()->detach();
        $cohort->delete();

        return redirect()->route('admin.cohorts.index')
            ->with('status', 'Cohort deleted successfully.');
    }

    public function addMember(Request $request, Cohort $cohort): RedirectResponse
    {
        $request->validate(['user_id' => ['required', 'exists:users,id']]);

        $user = User::findOrFail($request->user_id);
        if ($user->user_type !== User::TYPE_MENTEE) {
            return back()->withErrors(['user_id' => 'Only mentees can be added to cohorts.']);
        }

        if (!$cohort->members()->where('user_id', $user->id)->exists()) {
            $cohort->members()->attach($user->id);
            $cohort->load(['coordinator', 'members']);
            Mail::to($user->email)->send(new UserAddedToCohort($user, $cohort));
        }

        return back()->with('status', 'Member added successfully.');
    }

    public function removeMember(Cohort $cohort, User $user): RedirectResponse
    {
        $cohort->members()->detach($user->id);

        return back()->with('status', 'Member removed successfully.');
    }

    public function sendAtRiskEmail(Cohort $cohort, User $user): RedirectResponse
    {
        if (! $cohort->members()->where('user_id', $user->id)->exists()) {
            abort(403, 'User is not a member of this cohort.');
        }

        Mail::to($user->email)->send(new AtRiskCheckInReminder($user, $cohort));

        return redirect()->route('admin.cohorts.show', $cohort)
            ->with('status', 'Reminder sent to ' . $user->full_name . '.');
    }
}
