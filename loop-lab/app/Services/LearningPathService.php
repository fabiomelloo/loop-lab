<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\Lesson;

class LearningPathService
{
    public function next(Exercise $exercise): array
    {
        $nextExercise = $exercise->lesson->exercises()
            ->where('position', '>', $exercise->position)
            ->first();

        if ($nextExercise) {
            return ['exercise' => $nextExercise, 'lesson' => $exercise->lesson, 'kind' => 'exercise'];
        }

        $nextLesson = Lesson::query()
            ->where('lessons.is_published', true)
            ->where(function ($query) use ($exercise) {
                $query->where('modules.position', '>', $exercise->lesson->module->position)
                    ->orWhere(fn ($sameModule) => $sameModule
                        ->where('lessons.module_id', $exercise->lesson->module_id)
                        ->where('lessons.position', '>', $exercise->lesson->position));
            })
            ->join('modules', 'modules.id', '=', 'lessons.module_id')
            ->orderBy('modules.position')
            ->orderBy('lessons.position')
            ->select('lessons.*')
            ->first();

        return ['exercise' => $nextLesson?->exercises()->first(), 'lesson' => $nextLesson, 'kind' => $nextLesson ? 'lesson' : 'complete'];
    }
}
