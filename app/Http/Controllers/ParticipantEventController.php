<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParticipantEventController extends Controller
{
    private function area(): string
    {
        $name = request()->route()?->getName() ?? '';
        return str_contains($name, 'coordinator') ? 'coordinator' : 'mentee';
    }

    public function index(): View
    {
        $area = $this->area();
        $events = Event::withCount(['registrations' => function ($q) {
            $q->where('status', '!=', EventRegistration::STATUS_CANCELLED);
        }])
            ->orderBy('start_at', 'asc')
            ->paginate(12);

        return view($area . '.events.index', compact('events', 'area'));
    }

    public function show(Event $event): View
    {
        $area = $this->area();
        $event->loadCount(['registrations' => function ($q) {
            $q->where('status', '!=', EventRegistration::STATUS_CANCELLED);
        }]);

        $registration = $event->registrations()
            ->where('user_id', auth()->id())
            ->where('status', '!=', EventRegistration::STATUS_CANCELLED)
            ->first();

        $guestRegisterUrl = url('/events/' . $event->id . '/register?ref=' . auth()->id());

        return view($area . '.events.show', compact('event', 'registration', 'guestRegisterUrl', 'area'));
    }

    public function register(Request $request, Event $event): RedirectResponse
    {
        $user = $request->user();
        $existing = $event->registrations()
            ->where('user_id', $user->id)
            ->where('status', '!=', EventRegistration::STATUS_CANCELLED)
            ->exists();

        if ($existing) {
            return back()->with('status', 'You are already registered for this event.');
        }

        if ($event->isAtCapacity()) {
            return back()->withErrors(['event' => 'This event is at capacity.']);
        }

        $event->registrations()->create([
            'user_id' => $user->id,
            'status' => EventRegistration::STATUS_REGISTERED,
            'payment_status' => $event->isPaid() ? EventRegistration::PAYMENT_PENDING : null,
        ]);

        return back()->with('status', 'You are now registered for this event.');
    }

    public function unregister(Request $request, Event $event): RedirectResponse
    {
        $event->registrations()
            ->where('user_id', $request->user()->id)
            ->where('status', '!=', EventRegistration::STATUS_CANCELLED)
            ->update(['status' => EventRegistration::STATUS_CANCELLED]);

        return back()->with('status', 'You have been unregistered from this event.');
    }
}
