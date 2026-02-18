<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CohortAttendance extends Model
{
    public const STATUS_PRESENT = 'present';
    public const STATUS_LATE = 'late';
    public const STATUS_ABSENT = 'absent';

    protected $fillable = [
        'cohort_id',
        'user_id',
        'week_number',
        'status',
    ];

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function validStatuses(): array
    {
        return [self::STATUS_PRESENT, self::STATUS_LATE, self::STATUS_ABSENT];
    }
}
