<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ConditionsExpandedSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::where('slug', 'condicoes')->firstOrFail();

        // Lição: Operadores de Comparação
        $this->createComparisonLesson($module);

        // Lição: if/elseif/else Avançado
        $this->createIfElseifElseLesson($module);

        // Lição: Switch
        $this->createSwitchLesson($module);

        // Lição: Ternário e Null Coalescing
        $this->createTernaryNullCoalescingLesson($module);
    }

    private function createComparisonLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'comparacoes-logica-completa'],
            [
                'module_id' => $module->id,
                'title' => 'Operadores de Comparação e Lógica',
                'summary' => 'Domine ==, ===, !=, !==, <, >, <=, >= e combine com &&, ||, !.',
                'position' => 3,
                'content' => [
                    'learn' => 'Entender a diferença entre == (solta) e === (rigorosa), e como combinar múltiplas condições com lógica.',
                    'explanation' => 'Comparação retorna verdadeiro ou falso. == ignora tipo ("5" == 5 é true), mas === verifica tipo também ("5" === 5 é false). Use && (E) quando TODAS as condições devem ser verdadeiras, || (OU) quando uma basta, e ! (NÃO) para inverter.',
                    'syntax' => "// Comparação\n\$a == \$b;    // Igual (tipos soltos)\n\$a === \$b;   // Idêntico (tipos rigorosos)\n\$a != \$b;    // Diferente\n\$a !== \$b;   // Não idêntico\n\$a < \$b;     // Menor\n\$a <= \$b;    // Menor ou igual\n\n// Lógica\n\$a && \$b;    // E (ambas verdadeiras)\n\$a || \$b;    // OU (uma basta)\n!\$a;         // NÃO (inverte)",
                    'example' => "\$idade = 18;\n\$temDocumento = true;\n\nif (\$idade >= 18 && \$temDocumento) {\n    echo 'Pode dirigir';\n} else {\n    echo 'Não pode dirigir';\n}",
                    'lines' => [
                        'A idade é 18.',
                        'temDocumento é verdadeiro.',
                        '&& significa que ambas as condições devem ser verdadeiras.',
                        'Como são, exibe \"Pode dirigir\".',
                    ],
                    'real_example' => "\$estoque = 10;\n\$precoValido = true;\n\nif (\$estoque > 0 && \$precoValido) {\n    echo 'Produto disponível e preço ok';\n}\n\n// Ou com OU:\nif (\$estoque > 0 || \$precoValido) {\n    echo 'Pelo menos uma condição é verdadeira';\n}",
                    'common_errors' => [
                        'Usar = (atribuição) em vez de == (comparação) no if.',
                        'Confundir == com ===: "0" == 0 é true, mas "0" === 0 é false.',
                        'Usar | em vez de || (é XOR bitwise, não OU lógico).',
                        'Esquecer que ! inverte: !true é false.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Comparação solta vs rigorosa',
                'slug' => 'comp-solta-rigorosa',
                'difficulty' => 'Médio',
                'position' => 1,
                'xp' => 80,
                'description' => 'Use == e === para comparar "5" com 5. Mostre os resultados separados por quebra de linha.',
                'rules' => ['Use == e depois ===.', 'Mostre 1 para verdadeiro, 0 para falso.'],
                'starter_code' => "<?php\n\necho (\"5\" == 5) ? 1 : 0;\necho PHP_EOL;\necho (\"5\" === 5) ? 1 : 0;\n",
                'solution' => "<?php\n\necho (\"5\" == 5) ? 1 : 0;\necho PHP_EOL;\necho (\"5\" === 5) ? 1 : 0;",
                'explanation' => '== ignora tipo, então "5" == 5 é verdadeiro (1). === verifica tipo, então "5" === 5 é falso (0).',
                'required_structure' => 'comparison',
                'hints' => ['== é solta: tipos diferentes podem ser iguais.', '=== é rigorosa: tipo deve ser idêntico.', 'String "5" e número 5 não são idênticos.'],
                'expected' => "1\n0",
            ],
            [
                'title' => 'Operador E (&&)',
                'slug' => 'logica-e',
                'difficulty' => 'Fácil',
                'position' => 2,
                'xp' => 50,
                'description' => 'Com idade 20 e documento true, use && para verificar se pode entrar.',
                'rules' => ['Use && em um if.', 'Mostre "Pode" ou "Não pode".'],
                'starter_code' => "<?php\n\n\$idade = 20;\n\$temDocumento = true;\n\nif (\$idade >= 18 && \$temDocumento) {\n    echo 'Pode';\n} else {\n    echo 'Não pode';\n}\n",
                'solution' => "<?php\n\n\$idade = 20;\n\$temDocumento = true;\n\nif (\$idade >= 18 && \$temDocumento) {\n    echo 'Pode';\n} else {\n    echo 'Não pode';\n}",
                'explanation' => '&& requer que ambas as condições sejam verdadeiras. 20 >= 18 é true, temDocumento é true, então ambas são verdadeiras.',
                'required_structure' => 'if',
                'hints' => ['&& significa E: ambas devem ser verdadeiras.', 'Idade >= 18 é verdadeira.', 'Documento é verdadeiro.', 'Resultado: "Pode".'],
                'expected' => 'Pode',
            ],
            [
                'title' => 'Operador OU (||)',
                'slug' => 'logica-ou',
                'difficulty' => 'Médio',
                'position' => 3,
                'xp' => 80,
                'description' => 'Tem ingresso false, é VIP true. Use || para verificar se pode entrar.',
                'rules' => ['Use || em um if.', 'Mostre "Pode entrar" ou "Não pode entrar".'],
                'starter_code' => "<?php\n\n\$temIngresso = false;\n\$ehVIP = true;\n\nif (\$temIngresso || \$ehVIP) {\n    echo 'Pode entrar';\n} else {\n    echo 'Não pode entrar';\n}\n",
                'solution' => "<?php\n\n\$temIngresso = false;\n\$ehVIP = true;\n\nif (\$temIngresso || \$ehVIP) {\n    echo 'Pode entrar';\n} else {\n    echo 'Não pode entrar';\n}",
                'explanation' => '|| requer que uma das condições seja verdadeira. temIngresso é false, mas ehVIP é true, então uma é verdadeira.',
                'required_structure' => 'if',
                'hints' => ['|| significa OU: uma basta ser verdadeira.', 'Ingresso é falso.', 'VIP é verdadeiro.', 'Resultado: "Pode entrar".'],
                'expected' => 'Pode entrar',
            ],
            [
                'title' => 'Negar com !',
                'slug' => 'logica-nao',
                'difficulty' => 'Médio',
                'position' => 4,
                'xp' => 80,
                'description' => 'Com estoque 0, use ! para verificar se está fora de estoque.',
                'rules' => ['Use ! para negar.', 'Mostre "Fora de estoque" ou "Em estoque".'],
                'starter_code' => "<?php\n\n\$estoque = 0;\n\nif (!\$estoque) {\n    echo 'Fora de estoque';\n} else {\n    echo 'Em estoque';\n}\n",
                'solution' => "<?php\n\n\$estoque = 0;\n\nif (!\$estoque) {\n    echo 'Fora de estoque';\n} else {\n    echo 'Em estoque';\n}",
                'explanation' => '! inverte: estoque é 0 (falso), então !estoque é true. Logo, está fora de estoque.',
                'required_structure' => 'if',
                'hints' => ['! inverte o booleano.', 'Estoque 0 é falso.', '!false é true.', 'Resultado: "Fora de estoque".'],
                'expected' => 'Fora de estoque',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createIfElseifElseLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'if-elseif-else-avancado'],
            [
                'module_id' => $module->id,
                'title' => 'if, elseif e else Avançado',
                'summary' => 'Crie decisões com múltiplos caminhos usando elseif para verificar várias condições.',
                'position' => 4,
                'content' => [
                    'learn' => 'Entender como elseif permite testar múltiplas condições em sequência, parando na primeira verdadeira.',
                    'explanation' => 'if começa a verificação. elseif testa outra condição APENAS se o if foi falso. else é executado se nenhuma condição anterior foi verdadeira. A primeira condição verdadeira é executada, e o resto é ignorado.',
                    'syntax' => "if (condição1) {\n    // Executado se condição1 for verdadeira\n} elseif (condição2) {\n    // Executado se condição1 for falsa E condição2 for verdadeira\n} elseif (condição3) {\n    // Executado se ambas anteriores forem falsas E essa for verdadeira\n} else {\n    // Executado se todas forem falsas\n}",
                    'example' => "\$nota = 7;\n\nif (\$nota >= 9) {\n    echo 'A';\n} elseif (\$nota >= 7) {\n    echo 'B';\n} elseif (\$nota >= 5) {\n    echo 'C';\n} else {\n    echo 'F';\n}",
                    'lines' => [
                        'nota é 7.',
                        'Primeira: 7 >= 9? Não, então pula.',
                        'Segunda: 7 >= 7? Sim! Executa e para.',
                        'Resultado: B.',
                    ],
                    'real_example' => "\$hora = 14;\n\nif (\$hora < 12) {\n    echo 'Bom dia';\n} elseif (\$hora < 18) {\n    echo 'Boa tarde';\n} else {\n    echo 'Boa noite';\n}",
                    'common_errors' => [
                        'Esquecer que elseif não executa se o if foi verdadeiro.',
                        'Usar else if (dois palavras) em vez de elseif: ambos funcionam, mas elseif é o padrão.',
                        'Múltiplas condições que se sobrepõem, fazendo testes desnecessários.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Classificar nota',
                'slug' => 'elseif-nota-conceito',
                'difficulty' => 'Médio',
                'position' => 1,
                'xp' => 80,
                'description' => 'Com nota 8, use elseif para mostrar: A (9+), B (7-8), C (5-6), F (< 5).',
                'rules' => ['Use if, elseif e else.', 'Use >= para as comparações.'],
                'starter_code' => "<?php\n\n\$nota = 8;\n\nif (\$nota >= 9) {\n    echo 'A';\n} elseif (\$nota >= 7) {\n    echo 'B';\n} elseif (\$nota >= 5) {\n    echo 'C';\n} else {\n    echo 'F';\n}\n",
                'solution' => "<?php\n\n\$nota = 8;\n\nif (\$nota >= 9) {\n    echo 'A';\n} elseif (\$nota >= 7) {\n    echo 'B';\n} elseif (\$nota >= 5) {\n    echo 'C';\n} else {\n    echo 'F';\n}",
                'explanation' => 'Nota 8 não atende 9+, mas atende 7-8, então resultado é B.',
                'required_structure' => 'if',
                'hints' => ['Primeira verifica >= 9.', 'Se falso, segunda verifica >= 7.', 'Nota 8 entra no segundo bloco.'],
                'expected' => 'B',
            ],
            [
                'title' => 'Classificar hora',
                'slug' => 'elseif-periodo-dia',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Com hora 14, use elseif para mostrar: Madrugada (< 6), Manhã (6-11), Tarde (12-17), Noite (18+).',
                'rules' => ['Use múltiplos elseif.', 'Use as comparações fornecidas.'],
                'starter_code' => "<?php\n\n\$hora = 14;\n\nif (\$hora < 6) {\n    echo 'Madrugada';\n} elseif (\$hora < 12) {\n    echo 'Manhã';\n} elseif (\$hora < 18) {\n    echo 'Tarde';\n} else {\n    echo 'Noite';\n}\n",
                'solution' => "<?php\n\n\$hora = 14;\n\nif (\$hora < 6) {\n    echo 'Madrugada';\n} elseif (\$hora < 12) {\n    echo 'Manhã';\n} elseif (\$hora < 18) {\n    echo 'Tarde';\n} else {\n    echo 'Noite';\n}",
                'explanation' => 'Hora 14: não < 6, não < 12, mas < 18, então é Tarde.',
                'required_structure' => 'if',
                'hints' => ['14 não é menor que 6.', '14 não é menor que 12.', '14 é menor que 18: Tarde.'],
                'expected' => 'Tarde',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createSwitchLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'switch-match'],
            [
                'module_id' => $module->id,
                'title' => 'Switch e Match',
                'summary' => 'Use switch para comparar um valor com múltiplas opções, ou match (PHP 8+) para expressões.',
                'position' => 5,
                'content' => [
                    'learn' => 'Entender quando switch é melhor que elseif (múltiplas opções iguais) e como match oferece sintaxe mais limpa.',
                    'explanation' => 'switch compara um valor com vários casos. match é a versão moderna (PHP 8+): mais curta, retorna valor, sem need de break. Use switch quando há muitos casos iguais; use match para código mais legível.',
                    'syntax' => "// Switch com break\nswitch (\$operacao) {\n    case 'soma':\n        echo \$a + \$b;\n        break;\n    case 'multiplicacao':\n        echo \$a * \$b;\n        break;\n    default:\n        echo 'Inválido';\n}\n\n// Match (PHP 8+)\n\$resultado = match(\$operacao) {\n    'soma' => \$a + \$b,\n    'mult' => \$a * \$b,\n    default => 'Inválido'\n};",
                    'example' => "\$dia = 'quarta';\n\nswitch (\$dia) {\n    case 'segunda':\n        echo 'Trabalho';\n        break;\n    case 'sexta':\n        echo 'Quase fim de semana';\n        break;\n    case 'sábado':\n    case 'domingo':\n        echo 'Fim de semana';\n        break;\n    default:\n        echo 'Dia comum';\n}",
                    'lines' => [
                        'dia é \"quarta\".',
                        'Compara com case \'segunda\': falso.',
                        'Compara com case \'sexta\': falso.',
                        'Compara com case \'sábado\' e \'domingo\': ambos falsos.',
                        'Executa default: \"Dia comum\".',
                    ],
                    'real_example' => "\$tipo = 'premium';\n\n\$preco = match(\$tipo) {\n    'gratis' => 0,\n    'basico' => 9.99,\n    'premium' => 29.99,\n    'enterprise' => 99.99,\n    default => 0\n};",
                    'common_errors' => [
                        'Esquecer break: executa todos os casos posteriores (fall-through).',
                        'Usar == em vez de === em switch: ambos funcionam, mas === é mais rigoroso.',
                        'Esquecer default para casos não previstos.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Switch com break',
                'slug' => 'switch-cores',
                'difficulty' => 'Médio',
                'position' => 1,
                'xp' => 80,
                'description' => 'Use switch para com cor "azul", mostrar "Cor fria". Se "vermelho", mostrar "Cor quente". Default: "Cor desconhecida".',
                'rules' => ['Use switch.', 'Use break em cada case.'],
                'starter_code' => "<?php\n\n\$cor = 'azul';\n\nswitch (\$cor) {\n    case 'azul':\n        echo 'Cor fria';\n        break;\n    case 'vermelho':\n        echo 'Cor quente';\n        break;\n    default:\n        echo 'Cor desconhecida';\n}\n",
                'solution' => "<?php\n\n\$cor = 'azul';\n\nswitch (\$cor) {\n    case 'azul':\n        echo 'Cor fria';\n        break;\n    case 'vermelho':\n        echo 'Cor quente';\n        break;\n    default:\n        echo 'Cor desconhecida';\n}",
                'explanation' => 'cor é "azul", entra no case "azul", executa echo e break encerra.',
                'required_structure' => 'switch',
                'hints' => ['switch compara com cada case.', 'Azul é "Cor fria".', 'break evita executar os próximos.'],
                'expected' => 'Cor fria',
            ],
            [
                'title' => 'Match moderno',
                'slug' => 'match-operacao',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Use match para com operacao "div", calcular 20 / 4 = 5. Outras: "soma" (20 + 4 = 24), "mult" (20 * 4 = 80).',
                'rules' => ['Use match (não switch).', 'Retorne os cálculos.'],
                'starter_code' => "<?php\n\n\$operacao = 'div';\n\$resultado = match(\$operacao) {\n    'soma' => 20 + 4,\n    'mult' => 20 * 4,\n    'div' => 20 / 4,\n    default => 0\n};\n\necho \$resultado;\n",
                'solution' => "<?php\n\n\$operacao = 'div';\n\$resultado = match(\$operacao) {\n    'soma' => 20 + 4,\n    'mult' => 20 * 4,\n    'div' => 20 / 4,\n    default => 0\n};\n\necho \$resultado;",
                'explanation' => 'match encontra "div" e retorna 20 / 4 = 5.',
                'required_structure' => 'match',
                'hints' => ['match é uma expressão que retorna valor.', 'operacao é "div".', '20 / 4 = 5.'],
                'expected' => '5',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createTernaryNullCoalescingLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'ternario-null-coalescing'],
            [
                'module_id' => $module->id,
                'title' => 'Ternário e Null Coalescing',
                'summary' => 'Use ?: para escolher entre dois valores e ?? para valores padrão.',
                'position' => 6,
                'content' => [
                    'learn' => 'Aprender a sintaxe curta para if/else (ternário) e para verificar se existe (null coalescing).',
                    'explanation' => 'Ternário ?: é uma forma curta de if/else: condição ? valor_verdadeiro : valor_falso. Null coalescing ?? retorna o valor se não for null, senão usa padrão. Útil para parâmetros opcionais.',
                    'syntax' => "// Ternário\n\$status = \$ativo ? 'Online' : 'Offline';\n\n// Null Coalescing\n\$nome = \$_POST['nome'] ?? 'Visitante';\n\n// Combinado\n\$mensagem = \$usuario ? (\$usuario['ativo'] ? 'Ativo' : 'Inativo') : 'Não autenticado';",
                    'example' => "\$idade = 20;\n\$categoria = \$idade >= 18 ? 'Adulto' : 'Menor';\necho \$categoria; // Exibe: Adulto",
                    'lines' => [
                        'Primeira parte: idade >= 18 (verdadeiro).',
                        'Segunda parte (após ?): \"Adulto\" é escolhido.',
                        'Terceira parte (após :) seria alternativa, ignorada.',
                    ],
                    'real_example' => "\$usuarioLogado = \$_SESSION['usuario'] ?? null;\n\n\$nome = \$usuarioLogado ? \$usuarioLogado['nome'] : 'Visitante';\necho \"Bem-vindo, \$nome\";",
                    'common_errors' => [
                        'Confundir ? (ternário) com ? em URLs (query string).',
                        'Usar :: com ternário quando queria ?:.',
                        'Null coalescing retorna o valor se EXISTE e NÃO é null; 0, "", false não são ignorados.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Ternário simples',
                'slug' => 'ternario-maioridade',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Com idade 25, use ternário para mostrar "Maior" ou "Menor".',
                'rules' => ['Use o operador ternário ?:.', 'Use >= 18 para maioridade.'],
                'starter_code' => "<?php\n\n\$idade = 25;\necho \$idade >= 18 ? 'Maior' : 'Menor';\n",
                'solution' => "<?php\n\n\$idade = 25;\necho \$idade >= 18 ? 'Maior' : 'Menor';",
                'explanation' => '25 >= 18 é verdadeiro, então retorna "Maior".',
                'required_structure' => 'ternary',
                'hints' => ['Condição ? valor_true : valor_false.', '25 >= 18 é verdadeiro.', 'Resultado: "Maior".'],
                'expected' => 'Maior',
            ],
            [
                'title' => 'Null coalescing',
                'slug' => 'null-coalescing-padrao',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Use ?? para atribuir "Visitante" se $nome é null.',
                'rules' => ['Use o operador ??.', 'Declare $nome = null.'],
                'starter_code' => "<?php\n\n\$nome = null;\necho \$nome ?? 'Visitante';\n",
                'solution' => "<?php\n\n\$nome = null;\necho \$nome ?? 'Visitante';",
                'explanation' => '$nome é null, então ?? retorna "Visitante".',
                'required_structure' => 'null_coalescing',
                'hints' => ['?? retorna o primeiro se não for null.', '$nome é null.', 'Resultado: "Visitante".'],
                'expected' => 'Visitante',
            ],
            [
                'title' => 'Ternário aninhado',
                'slug' => 'ternario-nota-conceito-v2',
                'difficulty' => 'Difícil',
                'position' => 3,
                'xp' => 120,
                'description' => 'Com nota 8, use ternário aninhado para mostrar "A", "B", "C" ou "F".',
                'rules' => ['Use ternários aninhados.', 'Use os mesmos critérios: A (>=9), B (>=7), C (>=5), F (<5).'],
                'starter_code' => "<?php\n\n\$nota = 8;\necho \$nota >= 9 ? 'A' : (\$nota >= 7 ? 'B' : (\$nota >= 5 ? 'C' : 'F'));\n",
                'solution' => "<?php\n\n\$nota = 8;\necho \$nota >= 9 ? 'A' : (\$nota >= 7 ? 'B' : (\$nota >= 5 ? 'C' : 'F'));",
                'explanation' => 'Nota 8: não é >=9, mas é >=7, então retorna B.',
                'required_structure' => 'ternary',
                'hints' => ['Ternários podem ser aninhados com parênteses.', '8 não é >= 9.', '8 é >= 7: resultado B.'],
                'expected' => 'B',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function exercise(Lesson $lesson, array $data): void
    {
        $expected = $data['expected'];
        $hiddenTests = $data['hidden_tests'] ?? [];
        unset($data['expected'], $data['hidden_tests']);
        $exercise = Exercise::updateOrCreate(['slug' => $data['slug']], ['lesson_id' => $lesson->id] + $data);
        $exercise->tests()->updateOrCreate(['is_hidden' => false], ['expected_output' => $expected, 'input' => null]);
        $exercise->tests()->where('is_hidden', true)->delete();
        if ($hiddenTests) {
            foreach ($hiddenTests as [$input, $hiddenExpected]) {
                $exercise->tests()->create(['is_hidden' => true, 'input' => $input, 'expected_output' => $hiddenExpected]);
            }
        } else {
            $exercise->tests()->create(['is_hidden' => true, 'expected_output' => $expected, 'input' => null]);
        }
    }
}
