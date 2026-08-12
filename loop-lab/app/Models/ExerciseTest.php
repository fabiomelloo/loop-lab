<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseTest extends Model
{
    protected $fillable = ['exercise_id', 'input', 'expected_output', 'is_hidden'];

    protected function casts(): array
    {
        return ['is_hidden' => 'boolean'];
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
