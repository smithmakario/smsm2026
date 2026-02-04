<?php

namespace App\Mail;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingTimeUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $recipient,
        public Cohort $cohort,
        public bool $isMentor = false
    ) {
        $this->cohort->load(['mentor', 'members']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Meeting time updated: ' . $this->cohort->name,
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting-time-updated',
            with: ['emailType' => 'Meeting Update', 'subject' => 'Meeting time updated: ' . $this->cohort->name],
        );
    }
}
