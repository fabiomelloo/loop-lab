<?php

namespace App\Services;

use App\Models\Exercise;

class ExerciseValidator
{
    public function __construct(private readonly RestrictedPhpRunner $runner) {}

    public function validate(Exercise $exercise, string $code): array
    {
        if ($exercise->type === 'prediction') {
            $passed = trim($code) === trim((string) $exercise->correct_answer);

            return ['passed' => $passed, 'output' => trim($code), 'expected' => $exercise->correct_answer, 'error' => $passed ? '' : 'Observe o valor inicial, a condição e a atualização antes de responder.', 'diagnostic' => $passed ? '' : 'Simule cada linha em uma tabela de variáveis.', 'milliseconds' => 0];
        }

        if ($exercise->required_structure && ! $this->usesStructure($code, $exercise->required_structure)) {
            return ['passed' => false, 'output' => '', 'expected' => $exercise->tests->first()->expected_output, 'error' => "Use a estrutura {$exercise->required_structure}, como pedido no enunciado.", 'diagnostic' => 'A saída pode até estar correta, mas o objetivo é praticar a estrutura solicitada.', 'milliseconds' => 0];
        }

        $visible = $exercise->tests->where('is_hidden', false)->first() ?? $exercise->tests->first();
        $visibleOutput = '';
        $totalMilliseconds = 0;

        foreach ($exercise->tests as $test) {
            $testCode = $code.($test->input ? "\n".$test->input : '');
            $result = $this->runner->run($testCode);
            $totalMilliseconds += $result->milliseconds;
            if (! $result->successful) {
                return ['passed' => false, 'output' => $result->output, 'expected' => $visible->expected_output, 'error' => $result->error, 'diagnostic' => $this->diagnoseError($result->error), 'milliseconds' => $totalMilliseconds];
            }
            if (! $test->is_hidden) {
                $visibleOutput = $result->output;
            }
            if ($this->normalize($result->output) !== $this->normalize($test->expected_output)) {
                $diagnostic = $test->is_hidden
                    ? 'O exemplo visível pode funcionar, mas um valor diferente falhou. Evite resultados fixos e use os parâmetros ou variáveis recebidos.'
                    : $this->diagnoseOutput($result->output, $test->expected_output);

                return ['passed' => false, 'output' => $visibleOutput ?: $result->output, 'expected' => $visible->expected_output, 'error' => '', 'diagnostic' => $diagnostic, 'milliseconds' => $totalMilliseconds];
            }
        }

        return ['passed' => true, 'output' => $visibleOutput, 'expected' => $visible->expected_output, 'error' => '', 'diagnostic' => '', 'milliseconds' => $totalMilliseconds];
    }

    private function usesStructure(string $code, string $structure): bool
    {
        if ($structure === 'bitwise_and') {
            return collect(token_get_all($code))->contains(
                fn ($item) => $item === '&' || (is_array($item) && $item[1] === '&')
            );
        }

        if ($structure === 'ternary') {
            $tokens = token_get_all($code);

            return in_array('?', $tokens, true) && in_array(':', $tokens, true);
        }

        $token = match ($structure) {
            'for' => T_FOR, 'while' => T_WHILE, 'foreach' => T_FOREACH,
            'if' => T_IF, 'function' => T_FUNCTION, 'class' => T_CLASS,
            'logical_or' => T_BOOLEAN_OR, default => null,
        };

        return $token !== null && collect(token_get_all($code))->contains(fn ($item) => is_array($item) && $item[0] === $token);
    }

    private function normalize(string $output): string
    {
        $lines = preg_split('/\R/', trim($output)) ?: [];

        return implode("\n", array_map(fn ($line) => trim($line), $lines));
    }

    private function diagnoseOutput(string $actual, string $expected): string
    {
        $actualLines = preg_split('/\R/', trim($actual)) ?: [];
        $expectedLines = preg_split('/\R/', trim($expected)) ?: [];
        if (count($actualLines) + 1 === count($expectedLines)) {
            return 'Faltou um resultado. Verifique o limite final da condição; talvez devesse usar <= em vez de <.';
        }
        if (array_reverse($actualLines) === $expectedLines) {
            return 'Os valores estão corretos, mas a ordem está invertida. Confira o valor inicial e a atualização.';
        }
        if ($this->normalize($actual) === '') {
            return 'Seu código não produziu saída. Verifique se chamou echo ou se a condição chegou a ser verdadeira.';
        }

        return 'A saída é diferente da esperada. Compare a primeira linha divergente e acompanhe os valores das variáveis passo a passo.';
    }

    private function diagnoseError(string $error): string
    {
        if (str_contains($error, 'syntax error')) {
            return 'Há um erro de sintaxe. Confira ponto e vírgula, parênteses e chaves perto da linha indicada.';
        }
        if (str_contains($error, 'Tempo excedido')) {
            return 'A condição nunca ficou falsa. Confira se a variável de controle está sendo atualizada na direção correta.';
        }

        return 'Leia a linha indicada e confira o valor e o tipo de cada variável usada nela.';
    }
}
