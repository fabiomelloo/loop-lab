<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = ['module_id', 'prerequisite_lesson_id', 'title', 'slug', 'summary', 'content', 'position'];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class)->orderBy('position');
    }
}
