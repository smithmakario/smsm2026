<?php

namespace App\Mail;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AtRiskCheckInReminder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Cohort $cohort
    ) {
        $this->cohort->load(['coordinator', 'members']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Check-in: ' . $this->cohort->name,
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.at-risk-check-in-reminder',
            with: ['emailType' => 'Check-in', 'subject' => 'Check-in: ' . $this->cohort->name],
        );
    }
}
