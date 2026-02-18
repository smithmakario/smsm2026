<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenteeSemesterProject extends Model
{
    public const STATUS_NOT_STARTED = 'not_started';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_VERIFIED = 'verified';

    public const STATUSES = [
        self::STATUS_NOT_STARTED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
        self::STATUS_VERIFIED,
    ];

    protected $fillable = [
        'user_id',
        'semester_project_id',
        'status',
        'selected_at',
    ];

    protected $casts = [
        'selected_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updated(function (MenteeSemesterProject $msp) {
            if ($msp->wasChanged('status') && $msp->status === self::STATUS_VERIFIED) {
                $semester = $msp->semesterProject->semester;
                $points = $msp->semesterProject->points;
                $usp = UserSemesterPoints::firstOrCreate(
                    ['user_id' => $msp->user_id, 'semester_id' => $semester->id],
                    ['points' => 0],
                );
                $usp->increment('points', $points);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function semesterProject(): BelongsTo
    {
        return $this->belongsTo(SemesterProject::class, 'semester_project_id');
    }

    public function getSemesterAttribute(): ?Semester
    {
        return $this->semesterProject?->semester;
    }
}
