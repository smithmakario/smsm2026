<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    protected $fillable = [
        'semester_id',
        'week_number',
        'title',
        'description',
        'audio_path',
        'video_url',
        'pdf_path',
        'published_at',
        'scheduled_start_at',
        'scheduled_end_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_start_at' => 'datetime',
        'scheduled_end_at' => 'datetime',
    ];

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ModuleReview::class);
    }

    public function lifeApplicationQuestions(): HasMany
    {
        return $this->hasMany(ModuleLifeApplicationQuestion::class)->orderBy('sort_order');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ModuleActivity::class)->orderBy('occurs_at');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    public function getAudioUrlAttribute(): ?string
    {
        if (! $this->audio_path) {
            return null;
        }

        return Storage::disk('public')->url($this->audio_path);
    }

    public function getPdfUrlAttribute(): ?string
    {
        if (! $this->pdf_path) {
            return null;
        }

        return Storage::disk('public')->url($this->pdf_path);
    }
}
