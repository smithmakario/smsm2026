<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewMeeting extends Model
{
    protected $fillable = [
        'cohort_id',
        'semester_id',
        'week_number',
        'user_id',
        'occurred_at',
        'notes',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
