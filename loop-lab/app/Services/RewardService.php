<?php

namespace App\Services;

use App\Models\RewardItem;
use App\Models\RewardRedemption;
use App\Models\UserProgress;
use DomainException;
use Illuminate\Support\Facades\DB;

class RewardService
{
    public function summary(string $learnerKey): array
    {
        $earned = (int) UserProgress::where('learner_key', $learnerKey)->sum('xp');
        $spent = (int) RewardRedemption::where('learner_key', $learnerKey)->sum('points_spent');

        return [
            'earned' => $earned,
            'spent' => $spent,
            'available' => max(0, $earned - $spent),
            'redeemed' => RewardRedemption::where('learner_key', $learnerKey)->count(),
        ];
    }

    public function redeem(RewardItem $reward, string $learnerKey): RewardRedemption
    {
        return DB::transaction(function () use ($reward, $learnerKey) {
            $reward = RewardItem::query()->lockForUpdate()->findOrFail($reward->id);

            if (! $reward->is_active) {
                throw new DomainException('Esta recompensa não está disponível no momento.');
            }

            if (RewardRedemption::where('learner_key', $learnerKey)->where('reward_item_id', $reward->id)->exists()) {
                throw new DomainException('Você já resgatou esta recompensa.');
            }

            $summary = $this->summary($learnerKey);
            if ($summary['available'] < $reward->cost) {
                $missing = $reward->cost - $summary['available'];
                throw new DomainException("Faltam {$missing} XP para resgatar esta recompensa.");
            }

            return RewardRedemption::create([
                'learner_key' => $learnerKey,
                'reward_item_id' => $reward->id,
                'points_spent' => $reward->cost,
                'redemption_code' => strtoupper(str()->random(10)),
                'redeemed_at' => now(),
            ]);
        });
    }
}
