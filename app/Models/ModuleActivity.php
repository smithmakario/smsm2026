<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleActivity extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'occurs_at',
        'sort_order',
    ];

    protected $casts = [
        'occurs_at' => 'datetime',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
