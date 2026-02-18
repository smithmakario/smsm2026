<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestEventRegistrationController extends Controller
{
    public function create(Event $event): View|RedirectResponse
    {
        $event->loadCount(['registrations' => function ($q) {
            $q->where('status', '!=', EventRegistration::STATUS_CANCELLED);
        }]);

        if ($event->isAtCapacity()) {
            return redirect()->route('events.guest.register', $event)
                ->with('error', 'This event is at capacity.');
        }

        $inviter = null;
        if (request()->filled('ref')) {
            $inviter = User::find(request('ref'));
        }

        return view('events.register', compact('event', 'inviter'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        $event->loadCount(['registrations' => function ($q) {
            $q->where('status', '!=', EventRegistration::STATUS_CANCELLED);
        }]);

        if ($event->isAtCapacity()) {
            return back()->withInput()->withErrors(['event' => 'This event is at capacity.']);
        }

        $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email'],
        ]);

        $existing = $event->registrations()
            ->whereNull('user_id')
            ->where('guest_email', $request->guest_email)
            ->where('status', '!=', EventRegistration::STATUS_CANCELLED)
            ->exists();

        if ($existing) {
            return back()->withInput()->withErrors(['guest_email' => 'This email is already registered for this event.']);
        }

        $invitedBy = null;
        if ($request->filled('ref')) {
            $user = User::find($request->ref);
            if ($user) {
                $invitedBy = $user->id;
            }
        }

        $event->registrations()->create([
            'user_id' => null,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'status' => EventRegistration::STATUS_REGISTERED,
            'invited_by' => $invitedBy,
            'payment_status' => $event->isPaid() ? EventRegistration::PAYMENT_PENDING : null,
        ]);

        return redirect()->route('events.guest.register', $event)
            ->with('status', 'You are registered for this event. We look forward to seeing you!');
    }
}
