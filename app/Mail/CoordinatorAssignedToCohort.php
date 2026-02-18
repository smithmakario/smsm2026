<?php

namespace App\Mail;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoordinatorAssignedToCohort extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $coordinator,
        public Cohort $cohort
    ) {
        $this->cohort->load(['coordinator', 'members']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You\'ve been assigned to cohort: ' . $this->cohort->name,
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.coordinator-assigned-to-cohort',
            with: ['emailType' => 'Cohort Assignment', 'subject' => 'You\'ve been assigned to cohort: ' . $this->cohort->name],
        );
    }
}
