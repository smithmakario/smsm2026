<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cohort extends Model
{
    protected $fillable = [
        'name',
        'mentor_id',
        'meeting_time',
        'meeting_link',
    ];

    protected $casts = [
        'meeting_time' => 'datetime',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
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
}
