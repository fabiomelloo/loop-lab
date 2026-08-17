<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class FundamentalsExpandedSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::where('slug', 'fundamentos')->firstOrFail();

        // Lição: Tipos de Dados
        $this->createDataTypesLesson($module);

        // Lição: Operadores Aritméticos
        $this->createArithmeticLesson($module);

        // Lição: Concatenação e Interpolação
        $this->createConcatenationLesson($module);

        // Lição: Constantes
        $this->createConstantsLesson($module);
    }

    private function createDataTypesLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'tipos-dados-completo'],
            [
                'module_id' => $module->id,
                'title' => 'Tipos de Dados em PHP',
                'summary' => 'Compreenda inteiros, decimais, textos, booleanos, arrays e NULL — cada um tem seu uso e comportamento.',
                'position' => 3,
                'content' => [
                    'learn' => 'Identificar quando usar cada tipo de dado, entender as diferenças entre eles e saber como PHP converte tipos automaticamente.',
                    'explanation' => 'PHP suporta vários tipos: integer (inteiros), float/double (decimais), string (textos), boolean (verdadeiro/falso), array (listas), object (objetos) e NULL. A tipagem é dinâmica: uma variável pode mudar de tipo, mas cada operação espera um tipo específico.',
                    'syntax' => "\$inteiro = 42;          // Inteiro\n\$decimal = 3.14;       // Float\n\$texto = 'Hello';      // String\n\$booleano = true;      // Boolean\n\$nulo = null;          // NULL\n\$lista = [1, 2, 3];    // Array",
                    'example' => "\$idade = 25;\n\$altura = 1.75;\n\$nome = 'João';\n\$ativo = true;\n\necho \$idade . ' anos, ' . \$altura . 'm, ' . \$nome . ', ativo: ' . (\$ativo ? 'sim' : 'não');",
                    'lines' => [
                        '$idade é um inteiro (integer).',
                        '$altura é um decimal (float).',
                        '$nome é um texto (string).',
                        '$ativo é booleano (true ou false).',
                        'O echo concatena tudo e exibe na ordem.',
                    ],
                    'real_example' => "\$preco = 29.99;        // Float para preço com centavos\n\$estoque = 150;        // Integer para quantidade\n\$sku = 'PROD-001';     // String para identificador\n\$disponivel = true;    // Boolean para status",
                    'common_errors' => [
                        'Confundir string com número: "25" é texto, não número.',
                        'Esquecer que 0, "", "0", array() e null são todos falsos (false-ish).',
                        'Usar aspas erradas: $texto = \'texto\' ou "texto" — ambos funcionam, mas use um padrão.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Identificar tipos',
                'slug' => 'tipos-identificar',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Crie variáveis com diferentes tipos e use gettype() para mostrar o tipo de cada uma.',
                'rules' => ['Use gettype() para cada variável.', 'Crie: um inteiro, um float, uma string e um booleano.'],
                'starter_code' => "<?php\n\n\$numero = 42;\n\$decimal = 3.14;\n\$texto = 'PHP';\n\$verdadeiro = true;\n\n// Use gettype() para mostrar cada tipo\n",
                'solution' => "<?php\n\n\$numero = 42;\n\$decimal = 3.14;\n\$texto = 'PHP';\n\$verdadeiro = true;\n\necho gettype(\$numero) . PHP_EOL;\necho gettype(\$decimal) . PHP_EOL;\necho gettype(\$texto) . PHP_EOL;\necho gettype(\$verdadeiro) . PHP_EOL;",
                'explanation' => 'gettype() retorna uma string com o nome do tipo. integer, double (para float), string e boolean são os tipos básicos.',
                'required_structure' => 'gettype',
                'hints' => ['gettype() retorna o tipo como string.', 'Use echo com PHP_EOL para quebrar linhas.', 'Cada echo mostra: integer, double, string, boolean.'],
                'expected' => "integer\ndouble\nstring\nboolean",
            ],
            [
                'title' => 'Verificar valores false-ish',
                'slug' => 'tipos-falsy-valores',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Use empty() para verificar quais destes são considerados vazios: 0, "", array(), null.',
                'rules' => ['Use empty() para cada valor.', 'Mostre Vazio ou Não vazio.'],
                'starter_code' => "<?php\n\n\$valores = [0, \"\", [], null];\nforeach (\$valores as \$valor) {\n    echo empty(\$valor) ? 'Vazio' : 'Não vazio';\n    echo PHP_EOL;\n}\n",
                'solution' => "<?php\n\n\$valores = [0, \"\", [], null];\nforeach (\$valores as \$valor) {\n    echo empty(\$valor) ? 'Vazio' : 'Não vazio';\n    echo PHP_EOL;\n}",
                'explanation' => 'Em PHP, 0, "", array() vazio, null, false e "0" são todos considerados falsos. empty() retorna true para qualquer um deles.',
                'required_structure' => 'empty',
                'hints' => ['empty() verifica se o valor é falso-ish.', 'Use ternário para escolher a mensagem.', 'Todos os 4 valores no array são vazios.'],
                'expected' => "Vazio\nVazio\nVazio\nVazio",
            ],
            [
                'title' => 'Casting de tipos',
                'slug' => 'tipos-casting',
                'difficulty' => 'Difícil',
                'position' => 3,
                'xp' => 120,
                'description' => 'Converta "123" (string) para inteiro, e 45.67 para inteiro, mostrando os resultados.',
                'rules' => ['Use (int) ou (integer) para converter.', 'Não use funções como intval().'],
                'starter_code' => "<?php\n\n\$texto = '123';\n\$decimal = 45.67;\n\n// Converta para inteiro e mostre\necho (int)\$texto . PHP_EOL;\necho (int)\$decimal . PHP_EOL;\n",
                'solution' => "<?php\n\n\$texto = '123';\n\$decimal = 45.67;\n\necho (int)\$texto . PHP_EOL;\necho (int)\$decimal . PHP_EOL;",
                'explanation' => '(int) força a conversão para inteiro. String "123" vira 123. Float 45.67 perde a parte decimal e vira 45.',
                'required_structure' => 'cast',
                'hints' => ['Use (int) antes da variável.', 'A string "123" se torna o número 123.', 'O float 45.67 vira 45 (sem arredondamento).'],
                'expected' => "123\n45",
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createArithmeticLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'operadores-aritmeticos'],
            [
                'module_id' => $module->id,
                'title' => 'Operadores Aritméticos',
                'summary' => 'Realize cálculos com +, -, *, /, % e **, entendendo precedência e ordem de operações.',
                'position' => 4,
                'content' => [
                    'learn' => 'Usar corretamente +, -, *, /, % (resto) e ** (exponenciação), e compreender que multiplicação e divisão têm precedência sobre adição e subtração.',
                    'explanation' => 'Os operadores aritméticos funcionam como na matemática. Multiplicação (*), divisão (/) e módulo (%) têm precedência — são calculados antes de adição (+) e subtração (-). Parênteses mudam a ordem.',
                    'syntax' => "\$soma = 10 + 5;           // 15\n\$diferenca = 10 - 3;       // 7\n\$produto = 4 * 6;         // 24\n\$quociente = 20 / 4;      // 5\n\$resto = 17 % 5;          // 2\n\$potencia = 2 ** 3;       // 8",
                    'example' => "\$total = 100 + 50 * 2;  // 200, não 300 (multiplica primeiro)\n\$resultado = (100 + 50) * 2; // 300 (parênteses mudam a ordem)",
                    'lines' => [
                        'Na primeira: 50 * 2 = 100, depois 100 + 100 = 200.',
                        'Na segunda: 100 + 50 = 150, depois 150 * 2 = 300.',
                        'Parênteses sempre têm precedência máxima.',
                    ],
                    'real_example' => "\$precoBruto = 100;\n\$impostos = \$precoBruto * 0.15;  // 15% de impostos\n\$precoFinal = \$precoBruto + \$impostos; // 115",
                    'common_errors' => [
                        'Esquecer a precedência: 5 + 2 * 3 é 11, não 21.',
                        'Usar / para inteiros: 7 / 2 é 3.5, não 3 (use % para resto).',
                        'Confundir ** com ^: em PHP, ** é exponenciação, ^ é XOR bit a bit.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Calcular com precedência',
                'slug' => 'aritmetica-precedencia',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Calcule 10 + 5 * 2 e mostre o resultado (deve ser 20, não 30).',
                'rules' => ['Sem parênteses.', 'Mostre o resultado do cálculo.'],
                'starter_code' => "<?php\n\n// Calcule 10 + 5 * 2\necho 10 + 5 * 2;\n",
                'solution' => "<?php\n\necho 10 + 5 * 2;",
                'explanation' => 'Multiplicação é feita antes de adição. 5 * 2 = 10, então 10 + 10 = 20.',
                'required_structure' => null,
                'hints' => ['Lembre-se: multiplicação vem antes de adição.', 'Primeiro 5 * 2 = 10.', 'Depois 10 + 10 = 20.'],
                'expected' => '20',
            ],
            [
                'title' => 'Resto de divisão',
                'slug' => 'aritmetica-modulo',
                'difficulty' => 'Médio',
                'position' => 2,
                'xp' => 80,
                'description' => 'Use % para descobrir o resto de 25 dividido por 7.',
                'rules' => ['Use o operador %.', 'Mostre apenas o resto.'],
                'starter_code' => "<?php\n\n// Resto de 25 / 7\necho 25 % 7;\n",
                'solution' => "<?php\n\necho 25 % 7;",
                'explanation' => '25 dividido por 7 é 3 com resto 4. Porque 7 * 3 = 21, e 25 - 21 = 4.',
                'required_structure' => null,
                'hints' => ['% retorna apenas o resto, não o quociente.', '25 / 7 = 3 com resto 4.', 'Mostre 4.'],
                'expected' => '4',
            ],
            [
                'title' => 'Potência',
                'slug' => 'aritmetica-exponenciacao',
                'difficulty' => 'Médio',
                'position' => 3,
                'xp' => 80,
                'description' => 'Use ** para calcular 2 elevado à 10ª potência.',
                'rules' => ['Use o operador **.', 'Mostre o resultado.'],
                'starter_code' => "<?php\n\n// 2 elevado a 10\necho 2 ** 10;\n",
                'solution' => "<?php\n\necho 2 ** 10;",
                'explanation' => '** calcula potência. 2^10 = 2 * 2 * 2... (10 vezes) = 1024.',
                'required_structure' => null,
                'hints' => ['Use ** para exponenciação.', '2 ** 10 = 1024.'],
                'expected' => '1024',
            ],
            [
                'title' => 'Calcular preço com impostos',
                'slug' => 'aritmetica-imposto',
                'difficulty' => 'Difícil',
                'position' => 4,
                'xp' => 120,
                'description' => 'O produto custa R$ 100. Calcule o preço com 15% de impostos.',
                'rules' => ['Use multiplicação para calcular o percentual.', 'Mostre o preço final.'],
                'starter_code' => "<?php\n\n\$preco = 100;\n\$imposto = \$preco * 0.15;\n\$precoFinal = \$preco + \$imposto;\n\necho \$precoFinal;\n",
                'solution' => "<?php\n\n\$preco = 100;\n\$imposto = \$preco * 0.15;\n\$precoFinal = \$preco + \$imposto;\n\necho \$precoFinal;",
                'explanation' => 'Calcule 15% de 100 (que é 100 * 0.15 = 15). Depois some ao preço original: 100 + 15 = 115.',
                'required_structure' => null,
                'hints' => ['15% de 100 é 100 * 0.15 = 15.', 'Preço final é preço + imposto.', '100 + 15 = 115.'],
                'expected' => '115',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createConcatenationLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'concatenacao-interpolacao'],
            [
                'module_id' => $module->id,
                'title' => 'Concatenação vs Interpolação',
                'summary' => 'Combine strings com . (concatenação) ou use "" com variáveis (interpolação).',
                'position' => 5,
                'content' => [
                    'learn' => 'Entender as duas formas de combinar variáveis com texto: concatenação com . e interpolação dentro de aspas duplas.',
                    'explanation' => 'Concatenação usa o ponto (.) para unir strings. Interpolação coloca variáveis dentro de aspas duplas (" ") e PHP as substitui pelos valores. Ambas funcionam, mas cada uma tem vantagens.',
                    'syntax' => "// Concatenação com .\n\$nome = 'Ana';\necho 'Olá, ' . \$nome . '!';\n\n// Interpolação em aspas duplas\necho \"Olá, \$nome!\";",
                    'example' => "\$preco = 50;\n\$quantidade = 3;\n\n// Concatenação\necho 'Total: R\$ ' . (\$preco * \$quantidade);\n\n// Interpolação\necho \"Total: R\$ \" . (\$preco * \$quantidade);",
                    'lines' => [
                        'Concatenação une cada pedaço com ponto.',
                        'Interpolação coloca a variável direto na string com aspas duplas.',
                        'Expressões (como multiplicação) precisam de parênteses em ambas.',
                    ],
                    'real_example' => "\$usuario = 'João';\n\$login_hora = '14:30';\n\n// Concatenação\necho 'Usuário ' . \$usuario . ' entrou em ' . \$login_hora;\n\n// Interpolação\necho \"Usuário \$usuario entrou em \$login_hora\";",
                    'common_errors' => [
                        'Tentar colocar variáveis em aspas simples: \'Olá \$nome\' mostra o texto literal.',
                        'Esquecer parênteses em cálculos: \"Total \$a * \$b\" não funciona; use parênteses.',
                        'Misturar pontos: \"texto\" . \$var . \"mais\" em vez de \"texto \$var mais\".',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Concatenar dois textos',
                'slug' => 'concat-dois-textos',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Use concatenação para combinar "Olá, " e "Mundo".',
                'rules' => ['Use o operador de concatenação (.).', 'Use echo.'],
                'starter_code' => "<?php\n\necho 'Olá, ' . 'Mundo';\n",
                'solution' => "<?php\n\necho 'Olá, ' . 'Mundo';",
                'explanation' => 'O ponto (.) une duas strings. "Olá, " . "Mundo" resulta em "Olá, Mundo".',
                'required_structure' => null,
                'hints' => ['Use . para unir strings.', 'Echo mostra o resultado.'],
                'expected' => 'Olá, Mundo',
            ],
            [
                'title' => 'Interpolar variável',
                'slug' => 'interpolacao-variavel',
                'difficulty' => 'Fácil',
                'position' => 2,
                'xp' => 50,
                'description' => 'Com $nome = "Ana", mostre "Bem-vinda, Ana!" usando interpolação.',
                'rules' => ['Use aspas duplas.', 'Coloque $nome direto dentro da string.'],
                'starter_code' => "<?php\n\n\$nome = 'Ana';\necho \"Bem-vinda, \$nome!\";\n",
                'solution' => "<?php\n\n\$nome = 'Ana';\necho \"Bem-vinda, \$nome!\";",
                'explanation' => 'Em aspas duplas, PHP substitui $nome pelo valor "Ana".',
                'required_structure' => null,
                'hints' => ['Use aspas duplas (\"), não simples (\').', 'PHP interpola o valor de $nome.'],
                'expected' => 'Bem-vinda, Ana!',
            ],
            [
                'title' => 'Concatenar com cálculo',
                'slug' => 'concat-calculo',
                'difficulty' => 'Médio',
                'position' => 3,
                'xp' => 80,
                'description' => 'Com preço 50 e quantidade 3, mostre "Total: R$ 150" usando concatenação.',
                'rules' => ['Use concatenação (.).', 'Calcule o total dentro da expressão.'],
                'starter_code' => "<?php\n\n\$preco = 50;\n\$quantidade = 3;\n\necho 'Total: R\$ ' . (\$preco * \$quantidade);\n",
                'solution' => "<?php\n\n\$preco = 50;\n\$quantidade = 3;\n\necho 'Total: R\$ ' . (\$preco * \$quantidade);",
                'explanation' => 'Parênteses garantem que a multiplicação ocorre antes da concatenação. \\$ escapa o símbolo de dólar.',
                'required_structure' => null,
                'hints' => ['Use parênteses para a multiplicação.', 'Use \\\\$ para mostrar o símbolo $.', '50 * 3 = 150.'],
                'expected' => 'Total: R$ 150',
            ],
            [
                'title' => 'Interpolação vs Concatenação',
                'slug' => 'interpolacao-vs-concat',
                'difficulty' => 'Difícil',
                'position' => 4,
                'xp' => 120,
                'description' => 'Use interpolação para mostrar "Ana tem 25 anos e 1.70m de altura."',
                'rules' => ['Use apenas interpolação (aspas duplas).', 'Use múltiplas variáveis.'],
                'starter_code' => "<?php\n\n\$nome = 'Ana';\n\$idade = 25;\n\$altura = 1.70;\n\necho \"\$nome tem \$idade anos e {\$altura}m de altura.\";\n",
                'solution' => "<?php\n\n\$nome = 'Ana';\n\$idade = 25;\n\$altura = 1.70;\n\necho \"\$nome tem \$idade anos e {\$altura}m de altura.\";",
                'explanation' => 'PHP interpola as variáveis dentro das aspas duplas. Concatenamos a letra "m" ao final.',
                'required_structure' => null,
                'hints' => ['Use aspas duplas para interpolar.', 'Todas as variáveis são substituídas.', 'Use . para adicionar "m" ao final.'],
                'expected' => 'Ana tem 25 anos e 1.7m de altura.',
            ],
        ];

        foreach ($exercises as $exercise) {
            $this->exercise($lesson, $exercise);
        }
    }

    private function createConstantsLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'constantes'],
            [
                'module_id' => $module->id,
                'title' => 'Constantes',
                'summary' => 'Crie valores que não podem ser alterados e use define() ou const.',
                'position' => 6,
                'content' => [
                    'learn' => 'Entender quando usar constantes (valores imutáveis) em vez de variáveis, e as diferenças entre define() e const.',
                    'explanation' => 'Uma constante é criada uma vez e não pode ser alterada. Use para valores que nunca mudam: números fixos, configurações, chaves de acesso. define() e const fazem isso, mas const é mais moderna e rápida.',
                    'syntax' => "define('PI', 3.14159);\necho PI; // Exibe 3.14159\n\nconst TAXA = 0.10;\necho TAXA; // Exibe 0.10",
                    'example' => "define('TAXA_IMPOSTO', 0.15);\n\$preco = 100;\n\$total = \$preco * (1 + TAXA_IMPOSTO);\necho \$total; // Exibe 115",
                    'lines' => [
                        'define() cria uma constante global.',
                        'Não use $ antes do nome da constante.',
                        'Uma constante não pode ser mudada ou deletada.',
                        'Use MAIÚSCULAS por convenção.',
                    ],
                    'real_example' => "define('VERSAO_APP', '1.0.0');\ndefine('TAXA_BOLETO', 0.02);\n\necho 'Versão: ' . VERSAO_APP;\necho 'Taxa de boleto: ' . (TAXA_BOLETO * 100) . '%';",
                    'common_errors' => [
                        'Tentar usar $ com constantes: \$PI não funciona, é PI.',
                        'Tentar reatribuir uma constante: TAXA = 0.20; gera erro.',
                        'Esquecer que const não funciona fora de classes antes do PHP 5.6.',
                    ],
                ],
            ],
        );

        $exercises = [
            [
                'title' => 'Definir e usar constante',
                'slug' => 'const-definir-usar',
                'difficulty' => 'Fácil',
                'position' => 1,
                'xp' => 50,
                'description' => 'Use define() para criar uma constante PI com valor 3.14159 e exiba-a.',
                'rules' => ['Use define().', 'Mostre o valor da constante.'],
                'starter_code' => "<?php\n\ndefine('PI', 3.14159);\necho PI;\n",
                'solution' => "<?php\n\ndefine('PI', 3.14159);\necho PI;",
                'explanation' => 'define() cria uma constante. Sem $, ela é acessada apenas pelo nome.',
                'required_structure' => 'define',
                'hints' => ['Use define() com o nome em MAIÚSCULAS.', 'Não use $ antes do nome ao acessar.', 'Echo mostra o valor.'],
                'expected' => '3.14159',
            ],
            [
                'title' => 'Constante com const',
                'slug' => 'const-moderna',
                'difficulty' => 'Fácil',
                'position' => 2,
                'xp' => 50,
                'description' => 'Use const para definir TAXA = 0.10 e use na expressão 100 * TAXA.',
                'rules' => ['Use const (não define).', 'Use a constante em um cálculo.'],
                'starter_code' => "<?php\n\nconst TAXA = 0.10;\necho 100 * TAXA;\n",
                'solution' => "<?php\n\nconst TAXA = 0.10;\necho 100 * TAXA;",
                'explanation' => 'const é a forma moderna de definir constantes. Aqui, 100 * 0.10 = 10.',
                'required_structure' => 'const',
                'hints' => ['Use const para definir.', 'Use sem $ ao acessar.', '100 * 0.10 = 10.'],
                'expected' => '10',
            ],
            [
                'title' => 'Calcular circunferência',
                'slug' => 'const-pi-circunferencia',
                'difficulty' => 'Médio',
                'position' => 3,
                'xp' => 80,
                'description' => 'Defina PI = 3.14159 e calcule a circunferência de um círculo com raio 5: 2 * PI * raio.',
                'rules' => ['Use uma constante para PI.', 'Calcule 2 * PI * 5.'],
                'starter_code' => "<?php\n\ndefine('PI', 3.14159);\n\$raio = 5;\necho 2 * PI * \$raio;\n",
                'solution' => "<?php\n\ndefine('PI', 3.14159);\n\$raio = 5;\necho 2 * PI * \$raio;",
                'explanation' => 'Circunferência = 2 * π * r. Com π = 3.14159 e r = 5, o resultado é aproximadamente 31.4159.',
                'required_structure' => 'define',
                'hints' => ['PI é uma constante, não usa $.', 'Fórmula: 2 * PI * raio.', '2 * 3.14159 * 5 ≈ 31.4159.'],
                'expected' => '31.4159',
            ],
            [
                'title' => 'Múltiplas constantes',
                'slug' => 'const-multiplas',
                'difficulty' => 'Difícil',
                'position' => 4,
                'xp' => 120,
                'description' => 'Defina TAXA_IMPOSTO = 0.15 e TAXA_DESCONTO = 0.10. Calcule o preço final de 100 com imposto e desconto.',
                'rules' => ['Use duas constantes.', 'Aplique imposto depois desconto.'],
                'starter_code' => "<?php\n\ndefine('TAXA_IMPOSTO', 0.15);\ndefine('TAXA_DESCONTO', 0.10);\n\n\$preco = 100;\n\$comImposto = \$preco * (1 + TAXA_IMPOSTO);\n\$comDesconto = \$comImposto * (1 - TAXA_DESCONTO);\n\necho \$comDesconto;\n",
                'solution' => "<?php\n\ndefine('TAXA_IMPOSTO', 0.15);\ndefine('TAXA_DESCONTO', 0.10);\n\n\$preco = 100;\n\$comImposto = \$preco * (1 + TAXA_IMPOSTO);\n\$comDesconto = \$comImposto * (1 - TAXA_DESCONTO);\n\necho \$comDesconto;",
                'explanation' => 'Primeiro, 100 * 1.15 = 115. Depois, 115 * 0.90 = 103.5. O resultado é 103.5.',
                'required_structure' => 'define',
                'hints' => ['Imposto aumenta: multiplique por (1 + taxa).', 'Desconto reduz: multiplique por (1 - taxa).', '100 * 1.15 * 0.90 = 103.5.'],
                'expected' => '103.5',
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
