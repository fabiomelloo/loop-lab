<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = ['lesson_id', 'title', 'slug', 'difficulty', 'type', 'description', 'rules', 'starter_code', 'solution', 'explanation', 'required_structure', 'hints', 'options', 'correct_answer', 'position', 'xp'];

    protected function casts(): array
    {
        return ['rules' => 'array', 'hints' => 'array', 'options' => 'array'];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(ExerciseTest::class);
    }
}
