<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseAttempt extends Model
{
    protected $fillable = ['learner_key', 'exercise_id', 'code', 'output', 'status', 'diagnostic', 'execution_time'];
}
