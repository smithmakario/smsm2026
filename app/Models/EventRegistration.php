<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    public const STATUS_REGISTERED = 'registered';
    public const STATUS_CHECKED_IN = 'checked_in';
    public const STATUS_CANCELLED = 'cancelled';
    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_WAIVED = 'waived';

    protected $fillable = [
        'event_id',
        'user_id',
        'guest_name',
        'guest_email',
        'status',
        'invited_by',
        'payment_status',
        'reminder_sent_at',
        'post_event_sent_at',
    ];

    protected $casts = [
        'reminder_sent_at' => 'datetime',
        'post_event_sent_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isGuest(): bool
    {
        return $this->user_id === null;
    }

    public function getAttendeeNameAttribute(): string
    {
        return $this->user_id
            ? $this->user->full_name
            : (string) $this->guest_name;
    }

    public function getAttendeeEmailAttribute(): string
    {
        return $this->user_id
            ? $this->user->email
            : (string) $this->guest_email;
    }
}
