<?php

namespace App\Mail;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserAddedToCohort extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Cohort $cohort
    ) {
        $this->cohort->load(['mentor', 'members']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You\'re in! Welcome to ' . $this->cohort->name,
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-added-to-cohort',
            with: ['emailType' => 'Cohort Notification', 'subject' => 'You\'re in! Welcome to ' . $this->cohort->name],
        );
    }
}
