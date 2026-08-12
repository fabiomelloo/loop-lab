<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = ['learner_key', 'exercise_id', 'completed_at', 'xp'];

    protected function casts(): array
    {
        return ['completed_at' => 'datetime'];
    }
}
