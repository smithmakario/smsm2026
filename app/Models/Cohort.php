<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cohort extends Model
{
    protected $fillable = [
        'name',
        'coordinator_id',
        'meeting_time',
        'meeting_link',
    ];

    protected $casts = [
        'meeting_time' => 'datetime',
    ];

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cohort_user')
            ->withTimestamps();
    }

    public function mentees(): BelongsToMany
    {
        return $this->members()->where('user_type', User::TYPE_MENTEE);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(CohortAttendance::class);
    }

    public function reviewMeetings(): HasMany
    {
        return $this->hasMany(ReviewMeeting::class);
    }
}
