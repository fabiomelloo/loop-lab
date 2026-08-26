<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RewardItem extends Model
{
    protected $fillable = ['slug', 'title', 'description', 'category', 'cost', 'accent', 'is_active'];

    protected function casts(): array
    {
        return ['cost' => 'integer', 'is_active' => 'boolean'];
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(RewardRedemption::class);
    }
}
