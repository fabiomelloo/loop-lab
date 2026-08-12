<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\ExerciseAttempt;
use App\Models\Learner;
use App\Models\UserProgress;
use App\Services\ExerciseValidator;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->get('/')->assertOk()->assertSee('Continue aprendendo');
        $this->get('/aulas/loop-for')->assertOk()->assertSee('Praticar com exercícios')->assertSee('Contagem de 1 a 10');
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
}
