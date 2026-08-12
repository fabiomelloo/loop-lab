<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = ['title', 'slug', 'position', 'is_available'];

    protected function casts(): array
    {
        return ['is_available' => 'boolean'];
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }
}
