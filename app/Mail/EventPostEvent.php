<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventPostEvent extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Event $event,
        public EventRegistration $registration
    ) {
        $this->event->loadMissing('creator');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for attending: ' . $this->event->title,
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-post-event',
            with: [
                'emailType' => 'Event Follow-up',
                'subject' => 'Thank you for attending: ' . $this->event->title,
            ],
        );
    }
}
