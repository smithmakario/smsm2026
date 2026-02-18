<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleLifeApplicationQuestion extends Model
{
    protected $fillable = [
        'module_id',
        'question',
        'sort_order',
        'is_visible_to_mentee',
    ];

    protected $casts = [
        'is_visible_to_mentee' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
