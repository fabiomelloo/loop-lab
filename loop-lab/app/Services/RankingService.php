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
            $keys = Learner::query()->pluck('learner_key')
                ->merge(UserProgress::query()->pluck('learner_key'))
                ->merge(ExerciseAttempt::query()->pluck('learner_key'))
                ->unique()
                ->values();

            if ($keys->isEmpty()) {
                return collect();
            }

            $learners = Learner::whereIn('learner_key', $keys)->get()->keyBy('learner_key');

            $progressData = UserProgress::query()
                ->whereIn('learner_key', $keys)
                ->selectRaw('learner_key, SUM(xp) as xp, COUNT(*) as completed')
                ->groupBy('learner_key')
                ->get()
                ->keyBy('learner_key');

            $attemptsData = ExerciseAttempt::query()
                ->whereIn('learner_key', $keys)
                ->selectRaw('learner_key, COUNT(*) as attempts')
                ->groupBy('learner_key')
                ->get()
                ->keyBy('learner_key');

            $now = now();

            $result = $keys->map(function ($key) use ($learners, $progressData, $attemptsData, $now) {
                $learner = $learners->get($key);
                $progress = $progressData->get($key);
                $attempt = $attemptsData->get($key);

                $displayName = $learner?->display_name;
                if (! $displayName) {
                    $displayName = 'Estudante ' . strtoupper(substr($key, 0, 4));
                }

                $lastActiveAt = $learner?->last_active_at ?? $now;
                $xp = (int) ($progress?->xp ?? 0);
                $completed = (int) ($progress?->completed ?? 0);
                $attempts = (int) ($attempt?->attempts ?? 0);

                return (object) [
                    'learner_key' => $key,
                    'display_name' => $displayName,
                    'last_active_at' => $lastActiveAt,
                    'xp' => $xp,
                    'completed' => $completed,
                    'attempts' => $attempts,
                ];
            });

            $sorted = $result->sort(function ($a, $b) {
                if ($a->xp !== $b->xp) {
                    return $b->xp <=> $a->xp;
                }
                if ($a->completed !== $b->completed) {
                    return $b->completed <=> $a->completed;
                }
                if ($a->attempts !== $b->attempts) {
                    return $b->attempts <=> $a->attempts;
                }

                return $a->last_active_at <=> $b->last_active_at;
            })->take($limit)->values();

            return $sorted->map(function ($item, $index) {
                $item->position = $index + 1;

                return $item;
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
