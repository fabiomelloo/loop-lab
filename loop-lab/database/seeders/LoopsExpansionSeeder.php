<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class LoopsExpansionSeeder extends Seeder
{
    /**
     * Expande o módulo de Loops com mais lições e exercícios práticos
     */
    public function run(): void
    {
        $module = Module::where('slug', 'loops')->firstOrFail();

        // Lição: While
        $this->createWhileLesson($module);

        // Lição: Foreach
        $this->createForeachLesson($module);

        // Lição: Loops aninhados
        $this->createNestedLoopsLesson($module);

        // Lição: Break e Continue
        $this->createBreakContinueLesson($module);
    }

    private function createWhileLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'loop-while'],
            [
                'module_id' => $module->id,
                'title' => 'Loop while',
                'summary' => 'Repita um bloco enquanto uma condição for verdadeira, sem precisar saber quantas repetições.',
                'position' => 2,
                'content' => [
                    'learn' => 'Entender como while funciona diferente de for: você define apenas a condição, e o loop continua enquanto ela for verdadeira.',
                    'explanation' => 'While repete enquanto uma condição é verdadeira. É útil quando não sabemos o número exato de repetições, como processar uma entrada até que seja 0.',
                    'syntax' => "while (condição) {\n    // código repetido\n    // você deve alterar o que afeta a condição\n}",
                    'example' => "\$numero = 1;\nwhile (\$numero <= 5) {\n    echo \$numero . PHP_EOL;\n    \$numero++;\n}",
                    'lines' => [
                        'O valor inicial é 1.',
                        'A condição $numero <= 5 é verificada antes de cada repetição.',
                        'O código no bloco é executado.',
                        '$numero++ muda o valor para que a condição eventualmente seja falsa.',
                    ],
                    'real_example' => "\$tentativas = 0;\nwhile (\$tentativas < 3) {\n    echo 'Tentativa ' . (\$tentativas + 1) . PHP_EOL;\n    \$tentativas++;\n}",
                    'common_errors' => [
                        'Esquecer de atualizar a variável da condição, criando um loop infinito.',
                        'Colocar a atualização da variável no lugar errado.',
                        'Confundir a ordem: condição é verificada ANTES de cada execução.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Contagem com while',
            'slug' => 'while-contagem-1-5',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use while para mostrar números de 1 até 5, um por linha.',
            'rules' => ['Utilize um loop while.', 'Não use for.'],
            'starter_code' => "<?php\n\n\$numero = 1;\n// Escreva seu while aqui\n",
            'solution' => "<?php\n\n\$numero = 1;\nwhile (\$numero <= 5) {\n    echo \$numero . PHP_EOL;\n    \$numero++;\n}",
            'explanation' => 'O contador começa em 1 e aumenta a cada repetição. Quando fica maior que 5, a condição é falsa e o loop para.',
            'required_structure' => 'while',
            'hints' => ['Crie uma variável para controlar a repetição.', 'Verifique a condição: $numero <= 5.', 'Não esqueça de aumentar $numero no final do bloco.'],
            'expected' => implode("\n", range(1, 5)),
        ]);

        $this->exercise($lesson, [
            'title' => 'Decremento com while',
            'slug' => 'while-decremento-10-1',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Use while para contar de 10 até 1, diminuindo a cada repetição.',
            'rules' => ['Utilize um loop while.', 'Diminua a variável, não aumente.'],
            'starter_code' => "<?php\n\n\$numero = 10;\n// Use while para contar para trás\n",
            'solution' => "<?php\n\n\$numero = 10;\nwhile (\$numero >= 1) {\n    echo \$numero . PHP_EOL;\n    \$numero--;\n}",
            'explanation' => 'Começamos em 10 e decrementamos até chegar a 1. A condição >= garante que 1 ainda é mostrado.',
            'required_structure' => 'while',
            'hints' => ['Comece em 10.', 'Decremente com $numero--.', 'A condição é $numero >= 1.'],
            'expected' => implode("\n", range(10, 1, -1)),
        ]);

        $this->exercise($lesson, [
            'title' => 'Soma acumulada',
            'slug' => 'while-soma-acumulada',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Use while para somar de 1 até 10 e mostre o resultado final.',
            'rules' => ['Utilize um loop while.', 'Acumule os valores em uma variável.'],
            'starter_code' => "<?php\n\n\$numero = 1;\n\$soma = 0;\n// Use while para acumular\necho \$soma;\n",
            'solution' => "<?php\n\n\$numero = 1;\n\$soma = 0;\nwhile (\$numero <= 10) {\n    \$soma += \$numero;\n    \$numero++;\n}\necho \$soma;",
            'explanation' => 'A cada repetição, $soma recebe ela mesma mais o valor atual. Ao final, a soma total é 1+2+...+10=55.',
            'required_structure' => 'while',
            'hints' => ['Crie $soma começando em 0.', 'Use += para adicionar ao total.', 'Incremente $numero dentro do loop.'],
            'expected' => '55',
        ]);
    }

    private function createForeachLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'loop-foreach'],
            [
                'module_id' => $module->id,
                'title' => 'Loop foreach',
                'summary' => 'Percorra arrays automaticamente, acessando cada item sem contar repetições.',
                'position' => 3,
                'content' => [
                    'learn' => 'Entender como foreach pega cada item de um array e o disponibiliza em uma variável temporária.',
                    'explanation' => 'Foreach é feito para percorrer coleções. Você não precisa contar itens: o loop simplesmente pega um de cada vez até terminar.',
                    'syntax' => "foreach (\$array as \$variavel) {\n    // use \$variavel a cada repetição\n}\n// ou com chave:\nforeach (\$array as \$chave => \$valor) {\n    // use \$chave e \$valor\n}",
                    'example' => "\$nomes = ['Ana', 'Bia', 'Caio'];\nforeach (\$nomes as \$nome) {\n    echo 'Olá, ' . \$nome . PHP_EOL;\n}",
                    'lines' => [
                        'O array tem três itens.',
                        'foreach pega um item de cada vez e o coloca em $nome.',
                        'O código dentro do bloco é executado três vezes.',
                        'Não é necessário verificar índices ou contar manualmente.',
                    ],
                    'real_example' => "\$precos = ['Mouse' => 50, 'Teclado' => 120, 'Monitor' => 800];\nforeach (\$precos as \$produto => \$valor) {\n    echo \$produto . ': R\$ ' . \$valor . PHP_EOL;\n}",
                    'common_errors' => [
                        'Tentar alterar o array dentro do foreach sem usar &.',
                        'Confundir $item com a variável real dentro do array.',
                        'Esquecer que arrays associativos usam chaves, não índices numéricos.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Listar nomes',
            'slug' => 'foreach-listar-nomes',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Percorra o array e mostre cada nome prefixado por Aluno: ',
            'rules' => ['Utilize foreach.', 'Não use for.'],
            'starter_code' => "<?php\n\n\$nomes = ['Ana', 'Bruno', 'Carla'];\nforeach (\$nomes as \$nome) {\n    // Mostre: Aluno: Nome\n}\n",
            'solution' => "<?php\n\n\$nomes = ['Ana', 'Bruno', 'Carla'];\nforeach (\$nomes as \$nome) {\n    echo 'Aluno: ' . \$nome . PHP_EOL;\n}",
            'explanation' => 'Foreach pega cada nome do array, e echo o mostra com o prefixo.',
            'required_structure' => 'foreach',
            'hints' => ['Use foreach para percorrer $nomes.', 'A variável temporária é $nome.', 'Concatene com \"Aluno: \".'],
            'expected' => "Aluno: Ana\nAluno: Bruno\nAluno: Carla",
        ]);

        $this->exercise($lesson, [
            'title' => 'Soma com foreach',
            'slug' => 'foreach-soma-precos',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Percorra os preços [100, 250, 50] e mostre o total.',
            'rules' => ['Utilize foreach.', 'Acumule em uma variável.'],
            'starter_code' => "<?php\n\n\$precos = [100, 250, 50];\n\$total = 0;\nforeach (\$precos as \$preco) {\n    // Acumule\n}\necho \$total;\n",
            'solution' => "<?php\n\n\$precos = [100, 250, 50];\n\$total = 0;\nforeach (\$precos as \$preco) {\n    \$total += \$preco;\n}\necho \$total;",
            'explanation' => 'A cada iteração, adicione o preço ao total. Ao final, o resultado é 100+250+50=400.',
            'required_structure' => 'foreach',
            'hints' => ['Crie $total começando em 0.', 'Use += para acumular.', 'Mostre $total depois do loop.'],
            'expected' => '400',
        ]);

        $this->exercise($lesson, [
            'title' => 'Array associativo',
            'slug' => 'foreach-associativo-cidades',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Use foreach com chave e valor para mostrar: São Paulo: 11 milhões',
            'rules' => ['Utilize foreach com $chave => $valor.', 'Use o array fornecido.'],
            'starter_code' => "<?php\n\n\$cidades = ['São Paulo' => '11 milhões', 'Rio de Janeiro' => '6 milhões'];\nforeach (\$cidades as \$cidade => \$populacao) {\n    // Mostre: Cidade: População\n}\n",
            'solution' => "<?php\n\n\$cidades = ['São Paulo' => '11 milhões', 'Rio de Janeiro' => '6 milhões'];\nforeach (\$cidades as \$cidade => \$populacao) {\n    echo \$cidade . ': ' . \$populacao . PHP_EOL;\n}",
            'explanation' => 'Quando foreach encontra um array associativo, $chave recebe a chave e $valor recebe o valor.',
            'required_structure' => 'foreach',
            'hints' => ['Use $cidade => $populacao no foreach.', 'Concatene com dois-pontos.', 'Mostre as duas variáveis.'],
            'expected' => "São Paulo: 11 milhões\nRio de Janeiro: 6 milhões",
        ]);
    }

    private function createNestedLoopsLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'loops-aninhados'],
            [
                'module_id' => $module->id,
                'title' => 'Loops aninhados',
                'summary' => 'Coloque um loop dentro de outro para resolver problemas que precisam de repetição dupla.',
                'position' => 4,
                'content' => [
                    'learn' => 'Compreender como um loop dentro de outro executa: a cada volta do loop externo, o interno se completa inteiro.',
                    'explanation' => 'Loops aninhados são necessários para padrões 2D, matrizes e problemas onde você precisa repetir uma ação múltiplas vezes em diferentes contextos.',
                    'syntax' => "for (\$i = 1; \$i <= 3; \$i++) {\n    for (\$j = 1; \$j <= 2; \$j++) {\n        echo \$i . ',' . \$j . PHP_EOL;\n    }\n}",
                    'example' => "for (\$linha = 1; \$linha <= 3; \$linha++) {\n    for (\$coluna = 1; \$coluna <= 3; \$coluna++) {\n        echo '* ';\n    }\n    echo PHP_EOL;\n}",
                    'lines' => [
                        'O loop externo controla as linhas.',
                        'Para cada linha, o loop interno repete as colunas.',
                        'Cada * representa uma célula da matriz.',
                        'PHP_EOL quebra a linha depois que as colunas terminam.',
                    ],
                    'real_example' => "\$alunos = ['Ana', 'Bia'];\n\$disciplinas = ['PHP', 'SQL'];\nforeach (\$alunos as \$aluno) {\n    foreach (\$disciplinas as \$disciplina) {\n        echo \$aluno . ' estuda ' . \$disciplina . PHP_EOL;\n    }\n}",
                    'common_errors' => [
                        'Usar o mesmo nome de variável no loop externo e interno.',
                        'Confundir o número total de repetições (multiplicação, não adição).',
                        'Colocar o echo ou return no lugar errado.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Matriz 3x3',
            'slug' => 'nested-matriz-3x3',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use loops aninhados para mostrar 3 linhas com 3 asteriscos cada.',
            'rules' => ['Utilize dois for aninhados.', 'Use echo para os asteriscos.'],
            'starter_code' => "<?php\n\nfor (\$linha = 1; \$linha <= 3; \$linha++) {\n    // Loop interno para colunas\n}\n",
            'solution' => "<?php\n\nfor (\$linha = 1; \$linha <= 3; \$linha++) {\n    for (\$coluna = 1; \$coluna <= 3; \$coluna++) {\n        echo '* ';\n    }\n    echo PHP_EOL;\n}",
            'explanation' => 'O loop externo executa 3 vezes. Cada vez, o interno executa 3 vezes, mostrando 3 asteriscos. Depois quebra a linha.',
            'required_structure' => 'for',
            'hints' => ['O loop externo conta as linhas.', 'O loop interno conta as colunas.', 'Echo com espaço: \"* \", depois quebra a linha.'],
            'expected' => "* * * \n* * * \n* * * ",
        ]);

        $this->exercise($lesson, [
            'title' => 'Tabuada 5x5',
            'slug' => 'nested-tabuada-5x5',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Gere uma tabuada mostrando 1x1, 1x2... até 5x5.',
            'rules' => ['Utilize dois for aninhados.', 'Mostre o formato: 1x1=1, 1x2=2, etc.'],
            'starter_code' => "<?php\n\nfor (\$i = 1; \$i <= 5; \$i++) {\n    for (\$j = 1; \$j <= 5; \$j++) {\n        // Mostre i x j = resultado\n    }\n    // Quebra linha\n}\n",
            'solution' => "<?php\n\nfor (\$i = 1; \$i <= 5; \$i++) {\n    for (\$j = 1; \$j <= 5; \$j++) {\n        echo \$i . 'x' . \$j . '=' . (\$i * \$j) . ' ';\n    }\n    echo PHP_EOL;\n}",
            'explanation' => 'Cada multiplicação é calculada e exibida. A quebra de linha ocorre depois de cada linha de 5 resultados.',
            'required_structure' => 'for',
            'hints' => ['Multiplique $i por $j.', 'Mostre no formato i x j = resultado.', 'Separe com espaços e quebre linha após cada linha.'],
            'expected' => "1x1=1 1x2=2 1x3=3 1x4=4 1x5=5 \n2x1=2 2x2=4 2x3=6 2x4=8 2x5=10 \n3x1=3 3x2=6 3x3=9 3x4=12 3x5=15 \n4x1=4 4x2=8 4x3=12 4x4=16 4x5=20 \n5x1=5 5x2=10 5x3=15 5x4=20 5x5=25 ",
        ]);

        $this->exercise($lesson, [
            'title' => 'Combine dados',
            'slug' => 'nested-foreach-combinado',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Use dois foreach para mostrar cada aluno com cada disciplina: Ana estuda PHP.',
            'rules' => ['Utilize dois foreach aninhados.', 'Combine dados dos arrays.'],
            'starter_code' => "<?php\n\n\$alunos = ['Ana', 'Bruno'];\n\$disciplinas = ['PHP', 'SQL'];\n\nforeach (\$alunos as \$aluno) {\n    foreach (\$disciplinas as \$disciplina) {\n        // Mostre: Aluno estuda Disciplina\n    }\n}\n",
            'solution' => "<?php\n\n\$alunos = ['Ana', 'Bruno'];\n\$disciplinas = ['PHP', 'SQL'];\n\nforeach (\$alunos as \$aluno) {\n    foreach (\$disciplinas as \$disciplina) {\n        echo \$aluno . ' estuda ' . \$disciplina . PHP_EOL;\n    }\n}",
            'explanation' => 'Para cada aluno, o segundo foreach mostra todas as disciplinas. Total de linhas: alunos × disciplinas = 2 × 2 = 4.',
            'required_structure' => 'foreach',
            'hints' => ['O primeiro foreach percorre alunos.', 'Para cada aluno, o segundo percorre disciplinas.', 'Use echo e concatenação.'],
            'expected' => "Ana estuda PHP\nAna estuda SQL\nBruno estuda PHP\nBruno estuda SQL",
        ]);
    }

    private function createBreakContinueLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'break-continue'],
            [
                'module_id' => $module->id,
                'title' => 'Break e continue',
                'summary' => 'Interrompa loops, pule iterações e controle o fluxo de repetição com precisão.',
                'position' => 5,
                'content' => [
                    'learn' => 'Saber quando usar break para encerrar e continue para pular a iteração atual.',
                    'explanation' => 'Break encerra o loop imediatamente. Continue pula para a próxima iteração, ignorando o resto do código atual.',
                    'syntax' => "foreach (\$dados as \$item) {\n    if (\$item === 'parar') break;\n    if (\$item === 'pular') continue;\n    echo \$item;\n}",
                    'example' => "for (\$i = 1; \$i <= 10; \$i++) {\n    if (\$i === 5) break;\n    echo \$i . ' ';\n}\n// Mostra: 1 2 3 4",
                    'lines' => [
                        'O loop começaria a mostrar 1, 2, 3, 4...',
                        'Quando $i é 5, break encerra o loop.',
                        'O resultado é: 1 2 3 4 (sem 5 e seguintes).',
                    ],
                    'real_example' => "foreach ([1,2,3,2,5] as \$num) {\n    if (\$num === 3) break;\n    echo \$num . ' ';\n}",
                    'common_errors' => [
                        'Confundir break (encerra) com continue (pula).',
                        'Usar break em if fora de um loop.',
                        'Colocar continue sem condicional, causando pulos desnecessários.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Parar em 5',
            'slug' => 'break-parar-em-5',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Mostre números de 1 até 10, mas pare quando chegar a 6 usando break.',
            'rules' => ['Utilize break.', 'Mostre 1 2 3 4 5.'],
            'starter_code' => "<?php\n\nfor (\$i = 1; \$i <= 10; \$i++) {\n    if (\$i === 6) break;\n    echo \$i . ' ';\n}\n",
            'solution' => "<?php\n\nfor (\$i = 1; \$i <= 10; \$i++) {\n    if (\$i === 6) break;\n    echo \$i . ' ';\n}",
            'explanation' => 'Quando $i atinge 6, break encerra o loop. O resultado mostra apenas 1 a 5.',
            'required_structure' => 'break',
            'hints' => ['Verifique se $i === 6.', 'Use break para parar.', 'Echo mostra antes da verificação.'],
            'expected' => '1 2 3 4 5 ',
        ]);

        $this->exercise($lesson, [
            'title' => 'Pular pares',
            'slug' => 'continue-pular-pares',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Mostre números de 1 a 10, mas pule os pares usando continue.',
            'rules' => ['Utilize continue.', 'Mostre apenas 1 3 5 7 9.'],
            'starter_code' => "<?php\n\nfor (\$i = 1; \$i <= 10; \$i++) {\n    if (\$i % 2 === 0) continue;\n    echo \$i . ' ';\n}\n",
            'solution' => "<?php\n\nfor (\$i = 1; \$i <= 10; \$i++) {\n    if (\$i % 2 === 0) continue;\n    echo \$i . ' ';\n}",
            'explanation' => 'Quando o número é par (resto de divisão por 2 é 0), continue pula para a próxima iteração.',
            'required_structure' => 'continue',
            'hints' => ['Teste se $i % 2 === 0.', 'Use continue para pular.', 'Não esqueça de echo fora do if.'],
            'expected' => '1 3 5 7 9 ',
        ]);

        $this->exercise($lesson, [
            'title' => 'Buscar e parar',
            'slug' => 'break-buscar-elemento',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Procure por PHP em um array e mostre Encontrado assim que achar, usando break.',
            'rules' => ['Utilize foreach e break.', 'Mostre: PHP encontrado (sem buscar o resto).'],
            'starter_code' => "<?php\n\n\$tecnologias = ['HTML', 'CSS', 'PHP', 'SQL'];\nforeach (\$tecnologias as \$tech) {\n    if (\$tech === 'PHP') {\n        echo 'PHP encontrado';\n        break;\n    }\n}\n",
            'solution' => "<?php\n\n\$tecnologias = ['HTML', 'CSS', 'PHP', 'SQL'];\nforeach (\$tecnologias as \$tech) {\n    if (\$tech === 'PHP') {\n        echo 'PHP encontrado';\n        break;\n    }\n}",
            'explanation' => 'O foreach percorre até encontrar PHP. Assim que acha, mostra a mensagem e break encerra o loop.',
            'required_structure' => 'foreach',
            'hints' => ['Use foreach para percorrer.', 'Compare com ===.', 'Echo e depois break.'],
            'expected' => 'PHP encontrado',
        ]);
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
