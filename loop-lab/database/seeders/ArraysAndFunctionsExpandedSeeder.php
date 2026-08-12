<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ArraysAndFunctionsExpandedSeeder extends Seeder
{
    public function run(): void
    {
        $arrayModule = Module::where('slug', 'arrays')->firstOrFail();
        $functionsModule = Module::where('slug', 'funcoes')->firstOrFail();

        // Arrays
        $this->createArrayMethodsLesson($arrayModule);
        $this->createArrayManipulationLesson($arrayModule);

        // Funções
        $this->createFunctionParametersLesson($functionsModule);
        $this->createFunctionReturnTypesLesson($functionsModule);
        $this->createArrayFunctionsLesson($functionsModule);
    }

    private function createArrayMethodsLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'array-metodos-count-in-array'],
            [
                'module_id' => $module->id,
                'title' => 'Funções de Array: count() e in_array()',
                'summary' => 'Use count() para contar itens e in_array() para buscar elementos.',
                'position' => 3,
                'content' => [
                    'learn' => 'Dominar count() para tamanho, in_array() para busca, e array_keys() / array_values() para extrair partes.',
                    'explanation' => 'count($array) retorna quantos itens há. in_array($valor, $array) retorna true se o valor existe. array_keys() retorna os índices/chaves, array_values() retorna só os valores.',
                    'syntax' => "\$lista = ['A', 'B', 'C'];\necho count(\$lista);           // 3\necho in_array('B', \$lista);  // 1 (verdadeiro)\necho in_array('Z', \$lista);  // 0 (falso)",
                    'example' => "\$produtos = ['Mouse', 'Teclado', 'Monitor'];\n\necho count(\$produtos);                    // 3\n\nif (in_array('Mouse', \$produtos)) {\n    echo 'Tem Mouse';\n}",
                    'lines' => [
                        'count() conta 3 produtos.',
                        'in_array() busca e retorna booleano.',
                        'if usa o booleano para decisão.',
                    ],
                    'real_example' => "\$permitidos = ['html', 'css', 'php', 'sql'];\n\$entrada = 'php';\n\nif (in_array(\$entrada, \$permitidos)) {\n    echo 'Tecnologia válida';\n} else {\n    echo 'Tecnologia não permitida';\n}",
                    'common_errors' => [
                        'Confundir count() com sizeof() (ambos funcionam, mas count() é padrão).',
                        'in_array() é case-sensitive: \'PHP\' !== \'php\'.',
                        'Esquecer que in_array() retorna booleano, não índice.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Contar itens',
                'slug' => 'array-count-tamanho',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Use count() para mostrar quantos elementos há em [10, 20, 30, 40, 50].',
                'rules' => ['Use count().', 'Mostre o número.'],
                'starter_code' => "<?php\n\n\$numeros = [10, 20, 30, 40, 50];\necho count(\$numeros);\n",
                'solution' => "<?php\n\n\$numeros = [10, 20, 30, 40, 50];\necho count(\$numeros);",
                'explanation' => 'count() retorna 5, o número de elementos.',
                'required_structure' => 'count',
                'hints' => ['count() conta o número de elementos.', 'Array tem 5 valores.'],
                'expected' => '5',
            ],
            [
                'title' => 'Buscar em array',
                'slug' => 'array-in-array-busca',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Use in_array() para buscar "Gato" em [\'Cão\', \'Gato\', \'Pássaro\'].',
                'rules' => ['Use in_array().', 'Mostre "Existe" ou "Não existe".'],
                'starter_code' => "<?php\n\n\$animais = ['Cão', 'Gato', 'Pássaro'];\necho in_array('Gato', \$animais) ? 'Existe' : 'Não existe';\n",
                'solution' => "<?php\n\n\$animais = ['Cão', 'Gato', 'Pássaro'];\necho in_array('Gato', \$animais) ? 'Existe' : 'Não existe';",
                'explanation' => 'in_array() procura "Gato" e encontra, retornando true.',
                'required_structure' => 'in_array',
                'hints' => ['in_array() busca e retorna booleano.', '"Gato" está no array.', 'Resultado: "Existe".'],
                'expected' => 'Existe',
            ],
            [
                'title' => 'Validar entrada',
                'slug' => 'array-validacao-entrada',
                'difficulty' => 'Difícil',
                'position' => 3,
                'xp' => 120,
                'description' => 'Permita apenas php, javascript, python. Com entrada "php", mostre "Permitido".',
                'rules' => ['Use in_array() para validar.', 'Array de permitidos: [\'php\', \'javascript\', \'python\'].'],
                'starter_code' => "<?php\n\n\$linguagens_permitidas = ['php', 'javascript', 'python'];\n\$entrada = 'php';\n\necho in_array(\$entrada, \$linguagens_permitidas) ? 'Permitido' : 'Não permitido';\n",
                'solution' => "<?php\n\n\$linguagens_permitidas = ['php', 'javascript', 'python'];\n\$entrada = 'php';\n\necho in_array(\$entrada, \$linguagens_permitidas) ? 'Permitido' : 'Não permitido';",
                'explanation' => '"php" está no array, então in_array() retorna true.',
                'required_structure' => 'in_array',
                'hints' => ['Crie um array de permitidos.', 'Use in_array() para verificar.', '"php" é permitido.'],
                'expected' => 'Permitido',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createArrayManipulationLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'array-manipulacao-push-pop-merge'],
            [
                'module_id' => $module->id,
                'title' => 'Manipular Arrays: push, pop, array_merge',
                'summary' => 'Adicione, remova e combine elementos de arrays dinamicamente.',
                'position' => 4,
                'content' => [
                    'learn' => 'Usar array_push() para adicionar, array_pop() para remover do final, array_merge() para combinar.',
                    'explanation' => 'array_push() adiciona ao final e modifica o array original. array_pop() remove o último e devolve. array_merge() combina dois arrays em um novo.',
                    'syntax' => "\$lista = [1, 2, 3];\narray_push(\$lista, 4, 5);      // [1, 2, 3, 4, 5]\n\$removido = array_pop(\$lista); // Remove 5, devolve 5\n\$a = [1, 2];\n\$b = [3, 4];\n\$c = array_merge(\$a, \$b);     // [1, 2, 3, 4]",
                    'example' => "\$carrinho = ['Produto A', 'Produto B'];\n\narray_push(\$carrinho, 'Produto C');\n\necho count(\$carrinho); // 3\n\nforeach (\$carrinho as \$produto) {\n    echo \$produto . PHP_EOL;\n}",
                    'lines' => [
                        'Array começa com 2 produtos.',
                        'array_push() adiciona um terceiro.',
                        'Agora tem 3 itens.',
                        'foreach percorre todos.',
                    ],
                    'real_example' => "\$tags_usuario = ['php', 'web'];\n\nif (!in_array('laravel', \$tags_usuario)) {\n    array_push(\$tags_usuario, 'laravel');\n}\n\n\$resultado = array_merge(['html'], \$tags_usuario);",
                    'common_errors' => [
                        'Esquecer que array_push() modifica o original.',
                        'Confundir pop com shift (shift remove do começo).',
                        'array_merge() com arrays associativos: valores númericos são reindexa das.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Adicionar com push',
                'slug' => 'array-push-adicionar',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Use array_push() para adicionar 4 a [1, 2, 3] e mostre o resultado com count().',
                'rules' => ['Use array_push().', 'Mostre o novo tamanho.'],
                'starter_code' => "<?php\n\n\$numeros = [1, 2, 3];\narray_push(\$numeros, 4);\necho count(\$numeros);\n",
                'solution' => "<?php\n\n\$numeros = [1, 2, 3];\narray_push(\$numeros, 4);\necho count(\$numeros);",
                'explanation' => 'array_push() adiciona 4 ao final. Novo tamanho: 4.',
                'required_structure' => 'array_push',
                'hints' => ['array_push() adiciona ao final.', 'Tamanho original: 3.', 'Novo tamanho: 4.'],
                'expected' => '4',
            ],
            [
                'title' => 'Remover com pop',
                'slug' => 'array-pop-remover',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Use array_pop() para remover o último elemento de [\'A\', \'B\', \'C\'] e mostre qual foi removido.',
                'rules' => ['Use array_pop().', 'Echo o valor removido.'],
                'starter_code' => "<?php\n\n\$letras = ['A', 'B', 'C'];\n\$removida = array_pop(\$letras);\n\necho \$removida;\n",
                'solution' => "<?php\n\n\$letras = ['A', 'B', 'C'];\n\$removida = array_pop(\$letras);\n\necho \$removida;",
                'explanation' => 'array_pop() remove e retorna "C".',
                'required_structure' => 'array_pop',
                'hints' => ['array_pop() remove o último elemento.', 'Retorna o elemento removido.', 'Resultado: "C".'],
                'expected' => 'C',
            ],
            [
                'title' => 'Combinar arrays',
                'slug' => 'array-merge-combinar',
                'difficulty' => 'Médio',
                'position' => 3,
                'xp' => 80,
                'description' => 'Use array_merge() para combinar [1, 2] com [3, 4] e mostre o count() do resultado.',
                'rules' => ['Use array_merge().', 'Mostre o tamanho final.'],
                'starter_code' => "<?php\n\n\$a = [1, 2];\n\$b = [3, 4];\n\n\$resultado = array_merge(\$a, \$b);\n\necho count(\$resultado);\n",
                'solution' => "<?php\n\n\$a = [1, 2];\n\$b = [3, 4];\n\n\$resultado = array_merge(\$a, \$b);\n\necho count(\$resultado);",
                'explanation' => 'array_merge() combina dois arrays. Resultado: [1, 2, 3, 4] com tamanho 4.',
                'required_structure' => 'array_merge',
                'hints' => ['array_merge() une dois arrays.', 'Resultado tem 2 + 2 = 4 elementos.'],
                'expected' => '4',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createFunctionParametersLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'funcoes-parametros-padrao'],
            [
                'module_id' => $module->id,
                'title' => 'Funções: Parâmetros e Valores Padrão',
                'summary' => 'Crie funções com parâmetros opcionais usando valores padrão.',
                'position' => 3,
                'content' => [
                    'learn' => 'Entender parâmetros obrigatórios vs opcionais com valores padrão, e como usá-los.',
                    'explanation' => 'Parâmetros obrigatórios devem ser fornecidos. Opcionais têm valor padrão: se não passado, usa o padrão. Coloque sempre parâmetros opcionais no final.',
                    'syntax' => "function saudacao(\$nome, \$prefixo = 'Olá') {\n    return \$prefixo . ', ' . \$nome;\n}\n\necho saudacao('Ana');           // Olá, Ana\necho saudacao('Ana', 'Bem-vindo'); // Bem-vindo, Ana",
                    'example' => "function desconto(\$preco, \$percentual = 10) {\n    return \$preco * (1 - \$percentual / 100);\n}\n\necho desconto(100);        // 90 (10% por padrão)\necho desconto(100, 20);    // 80 (20% desconto)",
                    'lines' => [
                        'Primeira chamada: percentual não informado, usa 10.',
                        'Segunda chamada: percentual informado, usa 20.',
                        'Valores padrão facilitam reúso.',
                    ],
                    'real_example' => "function conectar_banco(\$host = 'localhost', \$porta = 3306, \$usuario = 'root') {\n    echo \"Conectando a \$host:\$porta com \$usuario\";\n}\n\nconectar_banco();                      // localhost:3306 root\nconectar_banco('192.168.1.1');         // 192.168.1.1:3306 root\nconectar_banco('192.168.1.1', 5432);  // 192.168.1.1:5432 root",
                    'common_errors' => [
                        'Colocar parâmetro com padrão ANTES de obrigatório: não funciona.',
                        'Esquecer que padrão só é usado se não passar o argumento.',
                        'Comparar padrão com None/Undefined; em PHP não existe, use null.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Parâmetro com padrão',
                'slug' => 'funcoes-padrao-simples',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Crie saudar($nome, $prefixo = "Oi") e chame saudar("João").',
                'rules' => ['Defina com valor padrão.', 'Não passe o segundo parâmetro na chamada.'],
                'starter_code' => "<?php\n\nfunction saudar(\$nome, \$prefixo = 'Oi') {\n    return \$prefixo . ', ' . \$nome;\n}\n\necho saudar('João');\n",
                'solution' => "<?php\n\nfunction saudar(\$nome, \$prefixo = 'Oi') {\n    return \$prefixo . ', ' . \$nome;\n}\n\necho saudar('João');",
                'explanation' => '$prefixo não foi passado, então usa "Oi".',
                'required_structure' => 'function',
                'hints' => ['Valor padrão é "Oi".', 'Não passamos $prefixo, então usa o padrão.', 'Resultado: "Oi, João".'],
                'expected' => 'Oi, João',
            ],
            [
                'title' => 'Sobrescrever padrão',
                'slug' => 'funcoes-padrao-override',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Crie desconto($preco, $taxa = 0.10) e chame com preco 100 e taxa 0.25.',
                'rules' => ['Use valor padrão.', 'Passe a taxa como 0.25.'],
                'starter_code' => "<?php\n\nfunction desconto(\$preco, \$taxa = 0.10) {\n    return \$preco - (\$preco * \$taxa);\n}\n\necho desconto(100, 0.25);\n",
                'solution' => "<?php\n\nfunction desconto(\$preco, \$taxa = 0.10) {\n    return \$preco - (\$preco * \$taxa);\n}\n\necho desconto(100, 0.25);",
                'explanation' => 'Passamos 0.25, então sobrescreve o padrão 0.10. Resultado: 100 - 25 = 75.',
                'required_structure' => 'function',
                'hints' => ['Taxa padrão é 0.10, mas passamos 0.25.', 'Desconto: 100 * 0.25 = 25.', 'Preço final: 100 - 25 = 75.'],
                'expected' => '75',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createFunctionReturnTypesLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'funcoes-tipos-retorno'],
            [
                'module_id' => $module->id,
                'title' => 'Tipos de Retorno em Funções',
                'summary' => 'Declare tipos para parâmetros e retorno: int, string, float, bool, array.',
                'position' => 4,
                'content' => [
                    'learn' => 'Usar type hints para garantir que funções recebem e devolvem tipos corretos.',
                    'explanation' => 'Type hints especificam: function soma(int $a, int $b): int. Evita erros de tipo. Se passar tipo errado, PHP tenta converter (type juggling) ou gera erro (strict mode).',
                    'syntax' => "function somar(int \$a, int \$b): int {\n    return \$a + \$b;\n}\n\nfunction temEstoque(string \$produto): bool {\n    return strlen(\$produto) > 0;\n}",
                    'example' => "function calcularMedia(float \$nota1, float \$nota2, float \$nota3): float {\n    return (\$nota1 + \$nota2 + \$nota3) / 3;\n}\n\necho calcularMedia(7.5, 8.0, 9.0); // 8.1666...",
                    'lines' => [
                        'Parâmetros: float indicam que espera decimais.',
                        'Retorno: float garante que devolve decimal.',
                        'PHP valida os tipos.',
                    ],
                    'real_example' => "function filtrarPalavras(array \$palavras, string \$prefixo): array {\n    return array_filter(\$palavras, fn(\$p) => str_starts_with(\$p, \$prefixo));\n}",
                    'common_errors' => [
                        'Type hint apenas no PHP 7+.',
                        'Confundir order: function nome(tipo \$param): tipo_retorno.',
                        'Usar | para múltiplos tipos (PHP 8+ apenas): int|string.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Type hint simples',
                'slug' => 'tipos-retorno-int',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Crie funcao(int $a, int $b): int que soma e retorna o resultado.',
                'rules' => ['Use type hints para int.', 'Retorne a soma.'],
                'starter_code' => "<?php\n\nfunction somar(int \$a, int \$b): int {\n    return \$a + \$b;\n}\n\necho somar(5, 3);\n",
                'solution' => "<?php\n\nfunction somar(int \$a, int \$b): int {\n    return \$a + \$b;\n}\n\necho somar(5, 3);",
                'explanation' => 'Type hints garantem que recebemos inteiros e devolvemos inteiro. Resultado: 8.',
                'required_structure' => 'function',
                'hints' => ['Type hint: int $a, int $b.', 'Retorno: int.', '5 + 3 = 8.'],
                'expected' => '8',
            ],
            [
                'title' => 'Tipo string e bool',
                'slug' => 'tipos-retorno-string-bool',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Crie estaVazio(string $texto): bool que retorna true se vazio.',
                'rules' => ['Use type hints.', 'Retorne booleano.'],
                'starter_code' => "<?php\n\nfunction estaVazio(string \$texto): bool {\n    return empty(\$texto);\n}\n\necho estaVazio('') ? 'Vazio' : 'Não vazio';\n",
                'solution' => "<?php\n\nfunction estaVazio(string \$texto): bool {\n    return empty(\$texto);\n}\n\necho estaVazio('') ? 'Vazio' : 'Não vazio';",
                'explanation' => 'empty() retorna booleano. String vazia retorna true.',
                'required_structure' => 'function',
                'hints' => ['Type hint: string $texto.', 'Retorno: bool.', 'String vazia é vazia.'],
                'expected' => 'Vazio',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createArrayFunctionsLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'funcoes-com-arrays-parameters'],
            [
                'module_id' => $module->id,
                'title' => 'Funções que Recebem e Devolvem Arrays',
                'summary' => 'Trabalhe com arrays como parâmetros e retornos de função.',
                'position' => 5,
                'content' => [
                    'learn' => 'Passar arrays como parâmetros, modificá-los ou devolver novos arrays processados.',
                    'explanation' => 'Arrays são passados por referência em PHP (após PHP 5). Modificá-los dentro da função afeta o original, a menos que crie um novo.',
                    'syntax' => "function somarTodos(array \$numeros): int {\n    \$total = 0;\n    foreach (\$numeros as \$numero) {\n        \$total += \$numero;\n    }\n    return \$total;\n}\n\necho somarTodos([1, 2, 3, 4]); // 10",
                    'example' => "function filtrarMaiores(array \$numeros, int \$limite): array {\n    \$resultado = [];\n    foreach (\$numeros as \$numero) {\n        if (\$numero > \$limite) {\n            array_push(\$resultado, \$numero);\n        }\n    }\n    return \$resultado;\n}\n\necho count(filtrarMaiores([1, 5, 3, 8, 2], 3)); // 2",
                    'lines' => [
                        'Recebe array de números.',
                        'Loop percorre cada um.',
                        'Filtra maiores que limite.',
                        'Devolve novo array com resultados.',
                    ],
                    'real_example' => "function removerDuplicatas(array \$valores): array {\n    return array_unique(\$valores);\n}\n\nfunction ordenar(array \$valores): array {\n    sort(\$valores);\n    return \$valores;\n}",
                    'common_errors' => [
                        'Esquecer que modificar array dentro sem return afeta o original.',
                        'Confundir modificação com devolução: às vezes precisa de ambos.',
                        'Usar & para passar por referência sem necessidade.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Somar array',
                'slug' => 'funcoes-array-somar',
                'difficulty' => 'Médio',
                'position' => 1,
                'xp' => 80,
                'description' => 'Crie somarTodos(array $numeros): int e retorne a soma de [10, 20, 30].',
                'rules' => ['Use foreach para somar.', 'Declare tipo int como retorno.'],
                'starter_code' => "<?php\n\nfunction somarTodos(array \$numeros): int {\n    \$total = 0;\n    foreach (\$numeros as \$numero) {\n        \$total += \$numero;\n    }\n    return \$total;\n}\n\necho somarTodos([10, 20, 30]);\n",
                'solution' => "<?php\n\nfunction somarTodos(array \$numeros): int {\n    \$total = 0;\n    foreach (\$numeros as \$numero) {\n        \$total += \$numero;\n    }\n    return \$total;\n}\n\necho somarTodos([10, 20, 30]);",
                'explanation' => 'Loop soma cada elemento: 0 + 10 + 20 + 30 = 60.',
                'required_structure' => 'function',
                'hints' => ['Inicie total em 0.', 'Loop: total += numero.', '10 + 20 + 30 = 60.'],
                'expected' => '60',
            ],
            [
                'title' => 'Filtrar maiores',
                'slug' => 'funcoes-array-filtrar',
                'difficulty' => 'Difícil',
                'position' => 2,
                'xp' => 120,
                'description' => 'Crie filtrarMaiores(array $nums, int $limite): array que devolve apenas maiores que limite.',
                'rules' => ['Use foreach.', 'Use array_push() para adicionar ao resultado.'],
                'starter_code' => "<?php\n\nfunction filtrarMaiores(array \$numeros, int \$limite): array {\n    \$resultado = [];\n    foreach (\$numeros as \$numero) {\n        if (\$numero > \$limite) {\n            array_push(\$resultado, \$numero);\n        }\n    }\n    return \$resultado;\n}\n\necho count(filtrarMaiores([1, 5, 3, 8, 2], 3));\n",
                'solution' => "<?php\n\nfunction filtrarMaiores(array \$numeros, int \$limite): array {\n    \$resultado = [];\n    foreach (\$numeros as \$numero) {\n        if (\$numero > \$limite) {\n            array_push(\$resultado, \$numero);\n        }\n    }\n    return \$resultado;\n}\n\necho count(filtrarMaiores([1, 5, 3, 8, 2], 3));",
                'explanation' => 'Filtra maiores que 3: [5, 8]. Count: 2.',
                'required_structure' => 'function',
                'hints' => ['Crie array vazio para resultado.', 'Se numero > limite, adicione.', 'Maiores que 3: 5 e 8 = 2 elementos.'],
                'expected' => '2',
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
