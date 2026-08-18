<?php

namespace App\Services;

use App\Models\ExerciseAttempt;
use App\Models\Learner;
use App\Models\UserProgress;
use Illuminate\Support\Collection;

class RankingService
{
    public function top(int $limit = 20): Collection
    {
        $progress = UserProgress::query()
            ->selectRaw('learner_key, SUM(xp) as xp, COUNT(*) as completed, MAX(completed_at) as reached_at')
            ->groupBy('learner_key');

        $attempts = ExerciseAttempt::query()
            ->selectRaw('learner_key, COUNT(*) as attempts')
            ->groupBy('learner_key');

        return Learner::query()
            ->leftJoinSub($progress, 'progress', 'progress.learner_key', '=', 'learners.learner_key')
            ->leftJoinSub($attempts, 'attempts', 'attempts.learner_key', '=', 'learners.learner_key')
            ->whereRaw('COALESCE(progress.completed, 0) > 0 OR COALESCE(attempts.attempts, 0) > 0')
            ->select('learners.learner_key', 'learners.display_name', 'learners.last_active_at')
            ->selectRaw('COALESCE(progress.xp, 0) as xp')
            ->selectRaw('COALESCE(progress.completed, 0) as completed')
            ->selectRaw('COALESCE(attempts.attempts, 0) as attempts')
            ->orderByDesc('xp')
            ->orderByDesc('completed')
            ->orderByDesc('attempts')
            ->orderBy('progress.reached_at')
            ->limit($limit)
            ->get()
            ->values()
            ->map(function ($learner, $index) {
                $learner->position = $index + 1;

                return $learner;
            });
    }

    public function currentPosition(string $learnerKey): ?int
    {
        $position = $this->top(1000)->firstWhere('learner_key', $learnerKey)?->position;

        return $position ? (int) $position : null;
    }
}
