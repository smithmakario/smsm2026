<?php

namespace App\Console\Commands;

use App\Mail\EventReminder;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';

    protected $description = 'Send reminder emails for events starting in the next 24 hours to attendees who have not received one.';

    public function handle(): int
    {
        $from = now();
        $to = now()->addHours(24);

        $events = Event::whereBetween('start_at', [$from, $to])
            ->with(['registrations' => function ($q) {
                $q->where('status', '!=', EventRegistration::STATUS_CANCELLED)
                    ->whereNull('reminder_sent_at')
                    ->with('user');
            }])
            ->get();

        $sent = 0;
        foreach ($events as $event) {
            foreach ($event->registrations as $registration) {
                $email = $registration->attendee_email;
                if ($email) {
                    Mail::to($email)->queue(new EventReminder($event->fresh(), $registration->fresh()));
                    $registration->update(['reminder_sent_at' => now()]);
                    $sent++;
                }
            }
        }

        if ($sent > 0) {
            $this->info("Queued {$sent} reminder(s) for events in the next 24 hours.");
        }

        return self::SUCCESS;
    }
}
