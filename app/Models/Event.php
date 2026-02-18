<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    public const TYPE_FREE = 'free';
    public const TYPE_PAID = 'paid';
    public const FORMAT_ONSITE = 'onsite';
    public const FORMAT_VIRTUAL = 'virtual';

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'type',
        'format',
        'location',
        'meeting_link',
        'price',
        'capacity',
        'created_by',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function attendees(): HasMany
    {
        return $this->registrations()->where('status', '!=', EventRegistration::STATUS_CANCELLED);
    }

    public function isPaid(): bool
    {
        return $this->type === self::TYPE_PAID;
    }

    public function isVirtual(): bool
    {
        return $this->format === self::FORMAT_VIRTUAL;
    }

    public function isAtCapacity(): bool
    {
        if ($this->capacity === null) {
            return false;
        }

        return $this->attendees()->count() >= $this->capacity;
    }
}
