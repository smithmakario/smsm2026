<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Semester extends Model
{
    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
        'is_active',
        'archived_at',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_active' => 'boolean',
        'archived_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Semester $semester) {
            if ($semester->is_active) {
                static::where('id', '!=', $semester->id)->where('is_active', true)->update(['is_active' => false]);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeNotArchived(Builder $query): Builder
    {
        return $query->whereNull('archived_at');
    }

    /**
     * Current week number (1-12) based on semester start and today. Returns null if before start or after end.
     */
    public function currentWeekNumber(): ?int
    {
        $start = $this->starts_at->startOfDay();
        $end = $this->ends_at->endOfDay();
        $today = now();

        if ($today->lt($start) || $today->gt($end)) {
            return null;
        }

        $week = (int) $start->diffInWeeks($today) + 1;

        return min(max(1, $week), 12);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('week_number');
    }

    public function reviewMeetings(): HasMany
    {
        return $this->hasMany(ReviewMeeting::class);
    }

    public function semesterProjects(): HasMany
    {
        return $this->hasMany(SemesterProject::class)->orderBy('sort_order');
    }

    public function userSemesterPoints(): HasMany
    {
        return $this->hasMany(UserSemesterPoints::class);
    }
}
