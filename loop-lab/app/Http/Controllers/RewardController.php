<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\RewardItem;
use App\Models\RewardRedemption;
use App\Services\ProgressService;
use App\Services\RewardService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RewardController extends Controller
{
    public function __construct(
        private readonly ProgressService $progress,
        private readonly RewardService $rewards,
    ) {}

    public function index(): View
    {
        $learnerKey = $this->progress->learnerKey();
        $redeemedIds = RewardRedemption::where('learner_key', $learnerKey)->pluck('reward_item_id')->all();

        return view('rewards', [
            'modules' => Module::with('lessons')->orderBy('position')->get(),
            'completedLessonIds' => $this->progress->completedLessonIds(),
            'stats' => $this->progress->stats(),
            'rewardSummary' => $this->rewards->summary($learnerKey),
            'rewards' => RewardItem::where('is_active', true)->orderBy('cost')->get(),
            'redeemedIds' => $redeemedIds,
            'recentRedemptions' => RewardRedemption::with('reward')->where('learner_key', $learnerKey)->latest('redeemed_at')->take(5)->get(),
        ]);
    }

    public function redeem(RewardItem $reward): RedirectResponse|JsonResponse
    {
        $learnerKey = $this->progress->learnerKey();
        try {
            $redemption = $this->rewards->redeem($reward, $learnerKey);
        } catch (DomainException $error) {
            if (request()->expectsJson()) {
                return response()->json(['message' => $error->getMessage(), 'errors' => ['reward' => [$error->getMessage()]]], 422);
            }

            return back()->withErrors(['reward' => $error->getMessage()]);
        }
        $summary = $this->rewards->summary($learnerKey);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => "{$reward->title} foi resgatada com sucesso.",
                'rewardId' => $reward->id,
                'rewardTitle' => $reward->title,
                'code' => $redemption->redemption_code,
                'redeemedAt' => $redemption->redeemed_at->format('d/m/Y \à\s H:i'),
                'summary' => $summary,
            ]);
        }

        return back()->with('reward_success', "{$reward->title} foi resgatada com sucesso.");
    }
}
