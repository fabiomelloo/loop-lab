<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = ['module_id', 'prerequisite_lesson_id', 'title', 'slug', 'summary', 'content', 'position', 'is_published'];

    protected function casts(): array
    {
        return ['content' => 'array', 'is_published' => 'boolean'];
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
