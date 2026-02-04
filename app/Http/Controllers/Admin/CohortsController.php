<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MeetingTimeUpdated;
use App\Mail\MentorAssignedToCohort;
use App\Mail\UserAddedToCohort;
use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CohortsController extends Controller
{
    public function index(): View
    {
        $cohorts = Cohort::with(['mentor', 'members'])->orderBy('name')->paginate(15);

        return view('admin.cohorts.index', compact('cohorts'));
    }

    public function create(): View
    {
        $mentors = User::where('user_type', User::TYPE_MENTOR)->orderBy('first_name')->get();
        $mentees = User::where('user_type', User::TYPE_MENTEE)->orderBy('first_name')->get();

        return view('admin.cohorts.create', compact('mentors', 'mentees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mentor_id' => ['nullable', 'exists:users,id'],
            'meeting_time' => ['nullable', 'date'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
            'members' => ['nullable', 'array'],
            'members.*' => ['exists:users,id'],
        ]);

        $cohort = Cohort::create([
            'name' => $request->name,
            'mentor_id' => $request->mentor_id ?: null,
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
        ]);

        if ($request->members) {
            $mentees = User::whereIn('id', $request->members)->where('user_type', User::TYPE_MENTEE)->pluck('id');
            $cohort->members()->sync($mentees);
        }

        $cohort->load(['mentor', 'members']);
        if ($cohort->mentor_id) {
            Mail::to($cohort->mentor->email)->send(new MentorAssignedToCohort($cohort->mentor, $cohort));
        }
        foreach ($cohort->members as $member) {
            Mail::to($member->email)->send(new UserAddedToCohort($member, $cohort));
        }

        return redirect()->route('admin.cohorts.show', $cohort)
            ->with('status', 'Cohort created successfully.');
    }

    public function show(Cohort $cohort): View
    {
        $cohort->load(['mentor', 'members']);
        $mentors = User::where('user_type', User::TYPE_MENTOR)->orderBy('first_name')->get();
        $availableMentees = User::where('user_type', User::TYPE_MENTEE)
            ->where(function ($q) use ($cohort) {
                $q->whereDoesntHave('cohorts')
                    ->orWhereHas('cohorts', fn ($q2) => $q2->where('cohorts.id', $cohort->id));
            })
            ->orderBy('first_name')
            ->get();

        return view('admin.cohorts.show', compact('cohort', 'mentors', 'availableMentees'));
    }

    public function edit(Cohort $cohort): View
    {
        $cohort->load(['mentor', 'members']);
        $mentors = User::where('user_type', User::TYPE_MENTOR)->orderBy('first_name')->get();
        $mentees = User::where('user_type', User::TYPE_MENTEE)->orderBy('first_name')->get();

        return view('admin.cohorts.edit', compact('cohort', 'mentors', 'mentees'));
    }

    public function update(Request $request, Cohort $cohort): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mentor_id' => ['nullable', 'exists:users,id'],
            'meeting_time' => ['nullable', 'date'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
            'members' => ['nullable', 'array'],
            'members.*' => ['exists:users,id'],
        ]);

        $previousMentorId = $cohort->mentor_id;
        $previousMemberIds = $cohort->members()->pluck('users.id')->all();
        $meetingTimeChanged = $cohort->meeting_time?->format('Y-m-d H:i') !== ($request->meeting_time ? date('Y-m-d H:i', strtotime($request->meeting_time)) : null)
            || (string) $cohort->meeting_link !== (string) $request->meeting_link;

        $cohort->update([
            'name' => $request->name,
            'mentor_id' => $request->mentor_id ?: null,
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
        ]);

        if ($request->mentor_id && (int) $request->mentor_id !== (int) $previousMentorId && $cohort->mentor) {
            Mail::to($cohort->mentor->email)->send(new MentorAssignedToCohort($cohort->mentor, $cohort->fresh(['members'])));
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
            $cohort->load(['mentor', 'members']);
            if ($cohort->mentor_id) {
                Mail::to($cohort->mentor->email)->send(new MeetingTimeUpdated($cohort->mentor, $cohort, true));
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
            $cohort->load(['mentor', 'members']);
            Mail::to($user->email)->send(new UserAddedToCohort($user, $cohort));
        }

        return back()->with('status', 'Member added successfully.');
    }

    public function removeMember(Cohort $cohort, User $user): RedirectResponse
    {
        $cohort->members()->detach($user->id);

        return back()->with('status', 'Member removed successfully.');
    }
}
