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
        try {
            $progress = UserProgress::query()
                ->selectRaw('learner_key, SUM(xp) as xp, COUNT(*) as completed, MAX(completed_at) as reached_at')
                ->groupBy('learner_key');

            $attempts = ExerciseAttempt::query()
                ->selectRaw('learner_key, COUNT(*) as attempts')
                ->groupBy('learner_key');

            $possibleKeys = UserProgress::query()
                ->select('learner_key')
                ->unionAll(ExerciseAttempt::query()->select('learner_key'));

            $query = Learner::query()
                ->rightJoinSub($possibleKeys, 'activity', 'activity.learner_key', '=', 'learners.learner_key')
                ->leftJoinSub($progress, 'progress', 'progress.learner_key', '=', 'activity.learner_key')
                ->leftJoinSub($attempts, 'attempts', 'attempts.learner_key', '=', 'activity.learner_key')
                ->selectRaw('COALESCE(learners.learner_key, activity.learner_key) as learner_key')
                ->selectRaw('COALESCE(learners.display_name, CONCAT("Estudante ", UPPER(SUBSTRING(COALESCE(learners.learner_key, activity.learner_key), 1, 4)))) as display_name')
                ->selectRaw('COALESCE(learners.last_active_at, NOW()) as last_active_at')
                ->selectRaw('COALESCE(progress.xp, 0) as xp')
                ->selectRaw('COALESCE(progress.completed, 0) as completed')
                ->selectRaw('COALESCE(attempts.attempts, 0) as attempts')
                ->orderByDesc('xp')
                ->orderByDesc('completed')
                ->orderByDesc('attempts')
                ->orderBy('last_active_at')
                ->limit($limit);

            return $query->get()->values()->map(function ($learner, $index) {
                $learner->position = $index + 1;

                return $learner;
            });
        } catch (\Throwable $error) {
            report($error);

            return collect();
        }
    }

    public function currentPosition(string $learnerKey): ?int
    {
        try {
            $position = $this->top(1000)->firstWhere('learner_key', $learnerKey)?->position;

            return $position ? (int) $position : null;
        } catch (\Throwable $error) {
            report($error);

            return null;
        }
    }
}
