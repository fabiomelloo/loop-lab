<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\ExerciseAttempt;
use App\Models\Learner;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\RewardItem;
use App\Models\RewardRedemption;
use App\Models\User;
use App\Models\UserProgress;
use App\Services\ExerciseValidator;
use App\Services\LearningPathService;
use App\Services\ProgressService;
use App\Services\RankingService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Tests\TestCase;

class LearningFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_dashboard_and_lesson_are_available_in_portuguese(): void
    {
        $this->get('/')->assertOk()->assertSee('Continue aprendendo')->assertSee('Missões de hoje')->assertSee('Ranking geral');
        $this->get('/aulas/loop-for')->assertOk()->assertSee('Praticar com exercícios')->assertSee('Contagem de 1 a 10');
    }

    public function test_dashboard_streak_uses_real_activity_days(): void
    {
        $learnerKey = '77777777-7777-4777-8777-777777777777';
        $exercise = Exercise::firstOrFail();

        foreach ([now()->subDay(), now()] as $activityDate) {
            $attempt = ExerciseAttempt::create([
                'learner_key' => $learnerKey,
                'exercise_id' => $exercise->id,
                'code' => '<?php echo 1;',
                'output' => '1',
                'status' => 'failed',
                'execution_time' => 10,
            ]);
            DB::table('exercise_attempts')->where('id', $attempt->id)->update([
                'created_at' => $activityDate,
                'updated_at' => $activityDate,
            ]);
        }

        $this->withSession(['learner_key' => $learnerKey])
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('streak', 2)
            ->assertSee('dias de sequência');
    }

    public function test_student_can_execute_php_code(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();

        $this->post(route('exercises.run', $exercise), ['code' => '<?php for ($i=1; $i<=3; $i++) echo $i;'])
            ->assertSessionHas('execution', fn ($result) => $result['successful'] && $result['output'] === '123');
    }

    public function test_student_can_execute_without_a_page_redirect(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();

        $this->postJson(route('exercises.run', $exercise), [
            'code' => '<?php echo "Teste";',
        ])->assertOk()->assertJsonPath('html', fn ($html) => str_contains($html, 'Teste'));
    }

    public function test_render_proxy_uses_same_origin_form_actions(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();

        $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.10'])
            ->withHeaders(['Host' => 'loop-lab-2.onrender.com', 'X-Forwarded-Proto' => 'https'])
            ->get('/aulas/loop-for')
            ->assertOk()
            ->assertSee('formaction="/exercicios/'.$exercise->id.'/validar"', false)
            ->assertDontSee('formaction="http://', false);
    }

    public function test_dangerous_functions_are_blocked(): void
    {
        $exercise = Exercise::firstOrFail();

        $this->post(route('exercises.run', $exercise), ['code' => '<?php echo file_get_contents(".env");'])
            ->assertSessionHas('execution', fn ($result) => ! $result['successful'] && str_contains($result['error'], 'não é permitida'));
    }

    public function test_correct_answer_records_progress_and_xp(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        $code = '<?php for ($i=1; $i<=10; $i++) { echo $i . PHP_EOL; }';

        $this->post(route('exercises.validate', $exercise), ['code' => $code])
            ->assertSessionHas('validation', fn ($result) => $result['passed']);

        $this->assertDatabaseCount(UserProgress::class, 1);
        $this->assertDatabaseHas(ExerciseAttempt::class, ['exercise_id' => $exercise->id, 'status' => 'passed']);
    }

    public function test_validation_updates_result_and_stats_without_redirect(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        $code = '<?php for ($i=1; $i<=10; $i++) { echo $i . PHP_EOL; }';

        $this->postJson(route('exercises.validate', $exercise), ['code' => $code])
            ->assertOk()
            ->assertJsonPath('stats.completed', 1)
            ->assertJsonPath('stats.xp', 50)
            ->assertJsonPath('gamification.type', 'success')
            ->assertJsonPath('html', fn ($html) => str_contains($html, 'Resposta correta!'));
    }

    public function test_validation_result_survives_a_progress_storage_failure(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        $progress = \Mockery::mock(ProgressService::class);
        $progress->shouldReceive('recordAttempt')->once()->andThrow(new RuntimeException('Banco indisponível'));
        $this->app->instance(ProgressService::class, $progress);

        $this->postJson(route('exercises.validate', $exercise), [
            'code' => '<?php for ($i=1; $i<=10; $i++) { echo $i . PHP_EOL; }',
        ])->assertOk()
            ->assertJsonPath('gamification.type', 'success')
            ->assertJsonPath('stats', null)
            ->assertJsonPath('progressWarning', 'Seu código foi validado, mas o progresso não pôde ser salvo agora.')
            ->assertJsonPath('html', fn ($html) => str_contains($html, 'Resposta correta!'));
    }

    public function test_answer_without_required_for_is_rejected(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();

        $this->post(route('exercises.validate', $exercise), ['code' => '<?php echo implode(PHP_EOL, range(1, 10));'])
            ->assertSessionHas('validation', fn ($result) => ! $result['passed'] && str_contains($result['error'], 'estrutura for'));
    }

    public function test_every_published_exercise_has_a_working_solution(): void
    {
        $validator = app(ExerciseValidator::class);

        Exercise::with('tests')->each(function (Exercise $exercise) use ($validator) {
            $result = $validator->validate($exercise, $exercise->solution);
            $this->assertTrue($result['passed'], "A solução de {$exercise->slug} falhou: {$result['error']}");
        });
    }

    public function test_student_can_choose_a_ranking_name_without_redirect(): void
    {
        $this->postJson(route('profile.update'), ['display_name' => 'Maria PHP'])
            ->assertOk()
            ->assertJsonPath('displayName', 'Maria PHP');

        $this->assertDatabaseHas(Learner::class, ['display_name' => 'Maria PHP']);
    }

    public function test_ranking_orders_students_by_xp(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        Learner::create(['learner_key' => '11111111-1111-4111-8111-111111111111', 'display_name' => 'Ana']);
        Learner::create(['learner_key' => '22222222-2222-4222-8222-222222222222', 'display_name' => 'Bruno']);
        UserProgress::create(['learner_key' => '11111111-1111-4111-8111-111111111111', 'exercise_id' => $exercise->id, 'xp' => 50, 'completed_at' => now()]);
        UserProgress::create(['learner_key' => '22222222-2222-4222-8222-222222222222', 'exercise_id' => $exercise->id, 'xp' => 120, 'completed_at' => now()]);

        $this->get(route('ranking'))->assertOk()->assertSeeInOrder(['Bruno', 'Ana']);
    }

    public function test_ranking_includes_students_that_are_attempting_exercises(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        Learner::create(['learner_key' => '33333333-3333-4333-8333-333333333333', 'display_name' => 'Caio']);
        ExerciseAttempt::create([
            'learner_key' => '33333333-3333-4333-8333-333333333333',
            'exercise_id' => $exercise->id,
            'code' => '<?php echo 1;',
            'output' => '1',
            'status' => 'failed',
            'execution_time' => 10,
        ]);

        $this->get(route('ranking'))
            ->assertOk()
            ->assertSee('Caio')
            ->assertSee('0 XP');
    }

    public function test_rewards_dashboard_shows_balance_and_catalog(): void
    {
        $this->get(route('rewards.index'))
            ->assertOk()
            ->assertSee('Troque seu XP por recompensas')
            ->assertSee('Insígnia Primeiro Passo');
    }

    public function test_student_can_redeem_a_reward_without_page_reload(): void
    {
        $learnerKey = '44444444-4444-4444-8444-444444444444';
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        $reward = RewardItem::where('slug', 'insignia-primeiro-passo')->firstOrFail();
        UserProgress::create(['learner_key' => $learnerKey, 'exercise_id' => $exercise->id, 'xp' => 50, 'completed_at' => now()]);

        $this->withSession(['learner_key' => $learnerKey])
            ->postJson(route('rewards.redeem', $reward))
            ->assertOk()
            ->assertJsonPath('rewardId', $reward->id)
            ->assertJsonPath('summary.available', 0)
            ->assertJsonPath('summary.redeemed', 1);

        $this->assertDatabaseHas(RewardRedemption::class, [
            'learner_key' => $learnerKey,
            'reward_item_id' => $reward->id,
            'points_spent' => 50,
        ]);
    }

    public function test_reward_cannot_be_redeemed_without_enough_xp(): void
    {
        $reward = RewardItem::where('slug', 'certificado-trilha-php')->firstOrFail();

        $this->withSession(['learner_key' => '55555555-5555-4555-8555-555555555555'])
            ->postJson(route('rewards.redeem', $reward))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('reward');
    }

    public function test_same_reward_cannot_be_redeemed_twice(): void
    {
        $learnerKey = '66666666-6666-4666-8666-666666666666';
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        $reward = RewardItem::where('slug', 'insignia-primeiro-passo')->firstOrFail();
        UserProgress::create(['learner_key' => $learnerKey, 'exercise_id' => $exercise->id, 'xp' => 50, 'completed_at' => now()]);

        $this->withSession(['learner_key' => $learnerKey])->postJson(route('rewards.redeem', $reward))->assertOk();
        $this->withSession(['learner_key' => $learnerKey])->postJson(route('rewards.redeem', $reward))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('reward');
    }

    public function test_ranking_does_not_crash_when_rank_service_fails(): void
    {
        $progress = \Mockery::mock(ProgressService::class);
        $progress->shouldReceive('learner')->andReturn(Learner::make(['learner_key' => 'fallback-key', 'display_name' => 'Aluno de teste']));
        $progress->shouldReceive('stats')->andReturn(['completed' => 0, 'total' => 0, 'percent' => 0, 'xp' => 0, 'attempts' => 0]);
        $progress->shouldReceive('completedLessonIds')->andReturn([]);
        $this->app->instance(ProgressService::class, $progress);

        $ranking = \Mockery::mock(RankingService::class);
        $ranking->shouldReceive('top')->andThrow(new RuntimeException('Ranking indisponível'));
        $ranking->shouldReceive('currentPosition')->andThrow(new RuntimeException('Ranking indisponível'));
        $this->app->instance(RankingService::class, $ranking);

        $this->get(route('ranking'))
            ->assertOk()
            ->assertSee('Ranking de estudantes');
    }

    public function test_operator_lesson_contains_the_three_requested_exercises(): void
    {
        $this->get('/aulas/operadores-especiais')
            ->assertOk()
            ->assertSee('Entrada com alternativa')
            ->assertSee('Permissões com bits')
            ->assertSee('Frete com ternário');
    }

    public function test_hidden_inputs_reject_a_hardcoded_answer(): void
    {
        $exercise = Exercise::where('slug', 'arrays-associativos-pratica')->firstOrFail();

        $this->postJson(route('exercises.validate', $exercise), ['code' => '<?php function totalCarrinho($p) { return 60; } echo totalCarrinho([10,20,30]);'])
            ->assertOk()
            ->assertJsonPath('gamification.type', 'error')
            ->assertJsonPath('html', fn ($html) => str_contains($html, 'valor diferente falhou'));
    }

    public function test_failed_exercise_appears_in_review(): void
    {
        $exercise = Exercise::where('slug', 'for-1-a-10')->firstOrFail();
        $this->post(route('exercises.validate', $exercise), ['code' => '<?php for($i=1;$i<3;$i++) echo $i;']);

        $this->get(route('review'))->assertOk()->assertSee('Contagem de 1 a 10');
    }

    public function test_prediction_exercise_can_be_answered(): void
    {
        $exercise = Exercise::where('slug', 'previsao-loop-zero')->firstOrFail();

        $this->postJson(route('exercises.validate', $exercise), ['code' => 'B'])
            ->assertOk()->assertJsonPath('html', fn ($html) => str_contains($html, 'Resposta correta!'));
    }

    public function test_student_can_submit_only_the_missing_code_when_the_exercise_has_starter_code(): void
    {
        $exercise = Exercise::where('slug', 'operador-ou-logico')->firstOrFail();

        $this->postJson(route('exercises.validate', $exercise), ['code' => "echo \$temIngresso || \$ehConvidado ? 'Pode entrar' : 'Não pode entrar';"])
            ->assertOk()
            ->assertJsonPath('html', fn ($html) => str_contains($html, 'Resposta correta!'));
    }

    public function test_student_can_register_and_keep_an_identified_learner(): void
    {
        $this->get('/')->assertOk();
        $this->post(route('register'), [
            'name' => 'Aluno Teste', 'email' => 'aluno@teste.com',
            'password' => 'senha-segura', 'password_confirmation' => 'senha-segura',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas(Learner::class, ['display_name' => 'Aluno Teste']);
    }

    public function test_student_can_log_out_and_log_back_in(): void
    {
        $user = User::factory()->create(['password' => 'senha-segura']);

        $this->post(route('login.submit'), [
            'email' => $user->email,
            'password' => 'senha-segura',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->post(route('logout'))->assertRedirect(route('dashboard'));
        $this->assertGuest();
    }

    public function test_published_curriculum_has_continuous_positions_without_duplicate_short_lessons(): void
    {
        Module::with('lessons')->get()->each(function (Module $module) {
            $this->assertSame(range(1, $module->lessons->count()), $module->lessons->pluck('position')->all(), "Ordem inválida em {$module->title}");
        });

        $this->assertFalse(Lesson::where('slug', 'switch-e-match')->firstOrFail()->is_published);
        $this->assertFalse(Lesson::where('slug', 'foreach-break-continue')->firstOrFail()->is_published);
    }

    public function test_editor_supports_tab_shift_tab_and_single_delegated_handler(): void
    {
        $response = $this->get('/aulas/loop-for');

        $response->assertOk()
            ->assertSee("event.key === 'Tab'", false)
            ->assertSee('event.shiftKey', false)
            ->assertSee("document.addEventListener('keydown'", false)
            ->assertDontSee("editor.addEventListener('keydown'", false);
    }

    public function test_last_exercise_recommends_the_next_lesson(): void
    {
        $lesson = Lesson::where('slug', 'fundamentos-variaveis')->firstOrFail();
        $exercise = $lesson->exercises()->reorder('position', 'desc')->firstOrFail();
        $result = app(LearningPathService::class)->next($exercise);

        $this->assertSame('lesson', $result['kind']);
        $this->assertSame('tipos-dados-completo', $result['lesson']->slug);
    }

    public function test_eloquent_module_is_available_after_object_orientation(): void
    {
        $module = Module::with('lessons.exercises')->where('slug', 'laravel-eloquent')->firstOrFail();

        $this->assertSame('Laravel Eloquent', $module->title);
        $this->assertSame([
            'eloquent-models-convencoes',
            'eloquent-sql-select',
            'eloquent-crud',
            'eloquent-relacionamentos',
            'eloquent-scopes-performance',
        ], $module->lessons->pluck('slug')->all());
        $this->assertTrue($module->lessons->every(fn (Lesson $lesson) => $lesson->exercises->count() === 3));

        $lastObjectLesson = Lesson::where('slug', 'poo-encapsulamento')->firstOrFail();
        $lastObjectExercise = $lastObjectLesson->exercises()->reorder('position', 'desc')->firstOrFail();
        $result = app(LearningPathService::class)->next($lastObjectExercise);

        $this->assertSame('eloquent-models-convencoes', $result['lesson']->slug);
    }
}
