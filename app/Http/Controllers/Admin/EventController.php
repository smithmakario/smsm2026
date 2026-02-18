<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EventPostEvent;
use App\Mail\EventReminder;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Event::with(['creator', 'registrations'])->orderBy('start_at', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }
        if ($request->filled('from')) {
            $query->where('start_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('start_at', '<=', $request->to);
        }

        $events = $query->paginate(15)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'type' => ['required', 'in:free,paid'],
            'format' => ['required', 'in:onsite,virtual'],
            'location' => ['nullable', 'string', 'max:500'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'type' => $request->type,
            'format' => $request->format,
            'location' => $request->location,
            'meeting_link' => $request->meeting_link,
            'capacity' => $request->capacity,
            'created_by' => $request->user()->id,
        ];

        if ($request->type === Event::TYPE_PAID && $request->filled('price')) {
            $data['price'] = $request->price;
        } else {
            $data['price'] = null;
        }

        $event = Event::create($data);

        return redirect()->route('admin.events.show', $event)
            ->with('status', 'Event created successfully.');
    }

    public function show(Event $event): View
    {
        $event->load(['creator', 'registrations.user', 'registrations.inviter']);

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'type' => ['required', 'in:free,paid'],
            'format' => ['required', 'in:onsite,virtual'],
            'location' => ['nullable', 'string', 'max:500'],
            'meeting_link' => ['nullable', 'string', 'max:500'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'type' => $request->type,
            'format' => $request->format,
            'location' => $request->location,
            'meeting_link' => $request->meeting_link,
            'capacity' => $request->capacity,
        ];

        if ($request->type === Event::TYPE_PAID && $request->filled('price')) {
            $data['price'] = $request->price;
        } else {
            $data['price'] = null;
        }

        $event->update($data);

        return redirect()->route('admin.events.show', $event)
            ->with('status', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->registrations()->delete();
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('status', 'Event deleted successfully.');
    }

    public function checkIn(EventRegistration $registration): RedirectResponse
    {
        if ($registration->status !== EventRegistration::STATUS_REGISTERED) {
            return back()->with('status', 'Attendee already checked in or cancelled.');
        }

        $registration->update(['status' => EventRegistration::STATUS_CHECKED_IN]);

        return back()->with('status', 'Attendee checked in successfully.');
    }

    public function markPaid(EventRegistration $registration): RedirectResponse
    {
        $registration->event->load('registrations');
        if (!$registration->event->isPaid()) {
            return back()->withErrors(['payment' => 'Event is not a paid event.']);
        }

        $registration->update(['payment_status' => EventRegistration::PAYMENT_PAID]);

        return back()->with('status', 'Marked as paid.');
    }

    public function markWaived(EventRegistration $registration): RedirectResponse
    {
        $registration->event->load('registrations');
        if (!$registration->event->isPaid()) {
            return back()->withErrors(['payment' => 'Event is not a paid event.']);
        }

        $registration->update(['payment_status' => EventRegistration::PAYMENT_WAIVED]);

        return back()->with('status', 'Payment waived.');
    }

    public function sendReminder(Event $event): RedirectResponse
    {
        $event->load(['registrations' => function ($q) {
            $q->where('status', '!=', EventRegistration::STATUS_CANCELLED)
                ->whereNull('reminder_sent_at')
                ->with('user');
        }]);

        $count = 0;
        foreach ($event->registrations as $registration) {
            $email = $registration->attendee_email;
            if ($email) {
                Mail::to($email)->queue(new EventReminder($event->fresh(), $registration->fresh()));
                $registration->update(['reminder_sent_at' => now()]);
                $count++;
            }
        }

        return back()->with('status', $count > 0 ? "Reminder sent to {$count} attendee(s)." : 'No attendees pending reminder.');
    }

    public function sendPostEvent(Event $event): RedirectResponse
    {
        $event->load(['registrations' => function ($q) {
            $q->where('status', '!=', EventRegistration::STATUS_CANCELLED)
                ->with('user');
        }]);

        $count = 0;
        foreach ($event->registrations as $registration) {
            $email = $registration->attendee_email;
            if ($email) {
                Mail::to($email)->queue(new EventPostEvent($event->fresh(), $registration->fresh()));
                $registration->update(['post_event_sent_at' => now()]);
                $count++;
            }
        }

        return back()->with('status', $count > 0 ? "Post-event notification sent to {$count} attendee(s)." : 'No attendees to notify.');
    }
}
