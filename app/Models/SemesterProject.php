<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SemesterProject extends Model
{
    protected $fillable = [
        'semester_id',
        'title',
        'description',
        'points',
        'sort_order',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function menteeSemesterProjects(): HasMany
    {
        return $this->hasMany(MenteeSemesterProject::class, 'semester_project_id');
    }
}
