<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RewardRedemption extends Model
{
    protected $fillable = ['learner_key', 'reward_item_id', 'points_spent', 'redemption_code', 'redeemed_at'];

    protected function casts(): array
    {
        return ['points_spent' => 'integer', 'redeemed_at' => 'datetime'];
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(RewardItem::class, 'reward_item_id');
    }
}
