<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\ExerciseAttempt;
use App\Models\Learner;
use App\Models\UserProgress;
use Illuminate\Support\Facades\DB;

class ProgressService
{
    public function learnerKey(): string
    {
        return session()->get('learner_key', function () {
            $key = (string) str()->uuid();
            session()->put('learner_key', $key);

            return $key;
        });
    }

    public function learner(): Learner
    {
        return Learner::firstOrCreate(
            ['learner_key' => $this->learnerKey()],
            ['display_name' => 'Estudante '.strtoupper(substr($this->learnerKey(), 0, 4)), 'last_active_at' => now()],
        );
    }

    public function updateDisplayName(string $name): Learner
    {
        $learner = $this->learner();
        $learner->update(['display_name' => $name, 'last_active_at' => now()]);

        return $learner;
    }

    public function recordAttempt(Exercise $exercise, string $code, array $result): void
    {
        $this->learner()->update(['last_active_at' => now()]);
        ExerciseAttempt::create([
            'learner_key' => $this->learnerKey(), 'exercise_id' => $exercise->id,
            'code' => $code, 'output' => $result['output'],
            'status' => $result['passed'] ? 'passed' : 'failed', 'execution_time' => $result['milliseconds'],
            'diagnostic' => $result['diagnostic'] ?? null,
        ]);

        if ($result['passed']) {
            UserProgress::firstOrCreate(
                ['learner_key' => $this->learnerKey(), 'exercise_id' => $exercise->id],
                ['completed_at' => now(), 'xp' => $exercise->xp],
            );
        }
    }

    public function stats(): array
    {
        $this->learner();
        $key = $this->learnerKey();

        try {
            $completed = UserProgress::where('learner_key', $key)->count();
            $total = Exercise::count();

            return [
                'completed' => $completed,
                'total' => $total,
                'percent' => $total ? (int) round($completed / $total * 100) : 0,
                'xp' => UserProgress::where('learner_key', $key)->sum('xp'),
                'attempts' => ExerciseAttempt::where('learner_key', $key)->count(),
            ];
        } catch (\Throwable $error) {
            report($error);

            return ['completed' => 0, 'total' => 0, 'percent' => 0, 'xp' => 0, 'attempts' => 0];
        }
    }

    public function completedExerciseIds(): array
    {
        return UserProgress::where('learner_key', $this->learnerKey())
            ->pluck('exercise_id')
            ->all();
    }

    public function completedLessonIds(): array
    {
        $completedExerciseIds = $this->completedExerciseIds();

        if (empty($completedExerciseIds)) {
            return [];
        }

        $completedSet = array_flip($completedExerciseIds);

        return Exercise::select('id', 'lesson_id')
            ->get()
            ->groupBy('lesson_id')
            ->filter(function ($exercises) use ($completedSet) {
                return $exercises->every(fn ($ex) => isset($completedSet[$ex->id]));
            })
            ->keys()
            ->all();
    }
}
