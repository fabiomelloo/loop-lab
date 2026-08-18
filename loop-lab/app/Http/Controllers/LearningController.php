<?php

namespace App\Http\Controllers;

use App\Http\Requests\RunCodeRequest;
use App\Models\Exercise;
use App\Models\ExerciseAttempt;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\UserProgress;
use App\Services\ExerciseValidator;
use App\Services\LearningPathService;
use App\Services\ProgressService;
use App\Services\RankingService;
use App\Services\RestrictedPhpRunner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningController extends Controller
{
    public function __construct(private readonly ProgressService $progress) {}

    public function dashboard(): View
    {
        return view('dashboard', $this->navigation() + [
            'stats' => $this->progress->stats(),
            'lesson' => Lesson::with('exercises')->where('slug', 'loop-for')->firstOrFail(),
        ]);
    }

    public function lesson(Lesson $lesson, ?Exercise $exercise = null): View
    {
        abort_unless($lesson->is_published, 404);
        $lesson->load('exercises.tests');
        $exercise ??= $lesson->exercises->first();
        abort_unless($exercise && $exercise->lesson_id === $lesson->id, 404);

        return view('lesson', $this->navigation() + [
            'stats' => $this->progress->stats(), 'lesson' => $lesson, 'exercise' => $exercise,
            'completedExerciseIds' => $this->progress->completedExerciseIds(),
            'nextStep' => app(LearningPathService::class)->next($exercise),
        ]);
    }

    public function run(RunCodeRequest $request, Exercise $exercise, RestrictedPhpRunner $runner): RedirectResponse|JsonResponse
    {
        $result = $runner->run($request->validated('code'));

        $execution = [
            'successful' => $result->successful, 'output' => $result->output,
            'error' => $result->error, 'milliseconds' => $result->milliseconds,
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('partials.exercise-result', compact('execution'))->render(),
            ]);
        }

        return back()->withInput()->with('execution', $execution);
    }

    public function validateAnswer(RunCodeRequest $request, Exercise $exercise, ExerciseValidator $validator, LearningPathService $path): RedirectResponse|JsonResponse
    {
        $result = $validator->validate($exercise->load('tests'), $request->validated('code'));
        $progressSaved = true;
        try {
            $this->progress->recordAttempt($exercise, $request->validated('code'), $result);
        } catch (\Throwable $error) {
            report($error);
            $progressSaved = false;
        }

        if ($request->expectsJson()) {
            $nextStep = $path->next($exercise);

            return response()->json([
                'html' => view('partials.exercise-result', [
                    'validation' => $result,
                    'nextStep' => $nextStep,
                    'lesson' => $exercise->lesson,
                ])->render(),
                'stats' => $progressSaved ? $this->progress->stats() : null,
                'progressWarning' => $progressSaved ? null : 'Seu código foi validado, mas o progresso não pôde ser salvo agora.',
                'exerciseId' => $exercise->id,
                'gamification' => ['type' => $result['passed'] ? 'success' : 'error'],
            ]);
        }

        return back()->withInput()->with('validation', $result);
    }

    public function playground(): View
    {
        try {
            $stats = $this->progress->stats();
        } catch (\Throwable $error) {
            report($error);
            $stats = ['completed' => 0, 'total' => 0, 'percent' => 0, 'xp' => 0, 'attempts' => 0];
        }

        return view('playground', $this->navigation() + ['stats' => $stats]);
    }

    public function ranking(RankingService $ranking): View
    {
        try {
            $learner = $this->progress->learner();
            $stats = $this->progress->stats();
            $entries = $ranking->top();
            $currentPosition = $ranking->currentPosition($learner->learner_key);
        } catch (\Throwable $error) {
            report($error);

            $learner = $this->progress->learner();
            $stats = ['completed' => 0, 'total' => 0, 'percent' => 0, 'xp' => 0, 'attempts' => 0];
            $entries = collect();
            $currentPosition = null;
        }

        return view('ranking', $this->navigation() + [
            'stats' => $stats,
            'learner' => $learner,
            'ranking' => $entries,
            'currentPosition' => $currentPosition,
        ]);
    }

    public function review(): View
    {
        $learnerKey = $this->progress->learnerKey();
        $exerciseIds = ExerciseAttempt::query()
            ->where('learner_key', $learnerKey)->where('status', 'failed')
            ->whereNotIn('exercise_id', UserProgress::where('learner_key', $learnerKey)->select('exercise_id'))
            ->latest()->pluck('exercise_id')->unique()->take(12);
        $exercises = Exercise::with('lesson.module')->whereIn('id', $exerciseIds)->get()
            ->sortBy(fn ($exercise) => $exerciseIds->search($exercise->id));

        return view('review', $this->navigation() + [
            'stats' => $this->progress->stats(), 'exercises' => $exercises,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'min:2', 'max:30', 'regex:/^[\pL\pN ._-]+$/u'],
        ], [
            'display_name.required' => 'Informe um nome para aparecer no ranking.',
            'display_name.min' => 'O nome precisa ter pelo menos 2 caracteres.',
            'display_name.max' => 'O nome pode ter no máximo 30 caracteres.',
            'display_name.regex' => 'Use apenas letras, números, espaços, ponto, hífen ou sublinhado.',
        ]);

        $learner = $this->progress->updateDisplayName($data['display_name']);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Nome atualizado.', 'displayName' => $learner->display_name]);
        }

        return back()->with('profile_updated', true);
    }

    public function runPlayground(RunCodeRequest $request, RestrictedPhpRunner $runner): RedirectResponse|JsonResponse
    {
        $result = $runner->run($request->validated('code'));
        $execution = [
            'successful' => $result->successful,
            'output' => $result->output,
            'error' => $result->error,
            'milliseconds' => $result->milliseconds,
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('partials.exercise-result', compact('execution'))->render(),
            ]);
        }

        return back()->withInput()->with('execution', $execution);
    }

    private function navigation(): array
    {
        return [
            'modules' => Module::with('lessons')->orderBy('position')->get(),
            'completedLessonIds' => $this->progress->completedLessonIds(),
        ];
    }
}
