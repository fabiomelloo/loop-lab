<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    protected $fillable = ['user_id', 'learner_key', 'display_name', 'last_active_at'];

    protected function casts(): array
    {
        return ['last_active_at' => 'datetime'];
    }
}
