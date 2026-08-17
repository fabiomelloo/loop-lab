<?php

namespace App\Services;

use App\Models\Exercise;

class ExerciseValidator
{
    public function __construct(private readonly RestrictedPhpRunner $runner) {}

    public function validate(Exercise $exercise, string $code): array
    {
        $candidates = $this->submissionCandidates($exercise, $code);
        $lastResult = null;

        foreach ($candidates as $candidate) {
            $result = $this->validateCandidate($exercise, $candidate);

            if ($result['passed']) {
                return $result;
            }

            $lastResult = $result;
        }

        return $lastResult ?? ['passed' => false, 'output' => '', 'expected' => '', 'error' => 'Não foi possível validar a resposta.', 'diagnostic' => '', 'milliseconds' => 0];
    }

    private function submissionCandidates(Exercise $exercise, string $code): array
    {
        $candidates = [trim($code)];
        $starter = trim((string) $exercise->starter_code);

        if ($starter === '' || str_contains($code, '<?php')) {
            return $candidates;
        }

        $merged = $starter."\n".$code;

        if (trim($merged) !== trim($code)) {
            $candidates[] = $merged;
        }

        return array_values(array_unique($candidates, SORT_STRING));
    }

    private function validateCandidate(Exercise $exercise, string $code): array
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
        $tokens = token_get_all($code);

        if ($structure === 'bitwise_and') {
            return collect($tokens)->contains(
                fn ($item) => $item === '&' || (is_array($item) && $item[1] === '&')
            );
        }

        if ($structure === 'ternary') {
            return in_array('?', $tokens, true) && in_array(':', $tokens, true);
        }

        if ($structure === 'comparison') {
            $comparisonTokens = [T_IS_EQUAL, T_IS_IDENTICAL, T_IS_NOT_EQUAL, T_IS_NOT_IDENTICAL, T_IS_SMALLER_OR_EQUAL, T_IS_GREATER_OR_EQUAL];

            return collect($tokens)->contains(fn ($item) => in_array($item, ['<', '>'], true)
                || (is_array($item) && in_array($item[0], $comparisonTokens, true)));
        }

        if ($structure === 'cast') {
            $castTokens = [T_INT_CAST, T_DOUBLE_CAST, T_STRING_CAST, T_ARRAY_CAST, T_OBJECT_CAST, T_BOOL_CAST, T_UNSET_CAST];

            return collect($tokens)->contains(fn ($item) => is_array($item) && in_array($item[0], $castTokens, true));
        }

        $token = match ($structure) {
            'for' => T_FOR, 'while' => T_WHILE, 'foreach' => T_FOREACH,
            'if' => T_IF, 'function' => T_FUNCTION, 'class' => T_CLASS,
            'switch' => T_SWITCH, 'match' => T_MATCH, 'break' => T_BREAK,
            'continue' => T_CONTINUE, 'const' => T_CONST, 'empty' => T_EMPTY,
            'null_coalescing' => T_COALESCE, 'logical_or' => T_BOOLEAN_OR,
            default => null,
        };

        if ($token !== null) {
            return collect($tokens)->contains(fn ($item) => is_array($item) && $item[0] === $token);
        }

        return collect($tokens)->contains(fn ($item) => is_array($item)
            && $item[0] === T_STRING
            && strcasecmp($item[1], $structure) === 0);
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
