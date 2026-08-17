<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $titles = ['Fundamentos', 'Condições', 'Loops', 'Arrays', 'Funções', 'Strings', 'Datas', 'Formulários', 'Orientação a Objetos'];
        foreach ($titles as $index => $title) {
            Module::updateOrCreate(
                ['slug' => str($title)->ascii()->slug()],
                ['title' => $title, 'position' => $index + 1, 'is_available' => $title === 'Loops'],
            );
        }

        $module = Module::where('slug', 'loops')->firstOrFail();
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'loop-for'],
            [
                'module_id' => $module->id,
                'title' => 'Loop for',
                'summary' => 'Aprenda a repetir um bloco quando você sabe quantas repetições serão necessárias.',
                'position' => 1,
                'content' => [
                    'learn' => 'Você vai entender as três partes do for, acompanhar cada repetição e escolher quando ele é a melhor opção.',
                    'explanation' => 'Um loop repete instruções. O for é indicado quando existe um começo, uma condição de parada e uma mudança previsível a cada repetição.',
                    'syntax' => "for (início; condição; atualização) {\n    // código repetido\n}",
                    'example' => "for (\$i = 1; \$i <= 3; \$i++) {\n    echo \$i . PHP_EOL;\n}",
                    'lines' => [
                        '$i = 1 cria o contador e define o valor inicial.',
                        '$i <= 3 pergunta se o loop deve continuar.',
                        'echo mostra o valor atual.',
                        '$i++ soma 1 depois de cada repetição.',
                    ],
                    'real_example' => "\$produtos = ['Teclado', 'Mouse', 'Monitor'];\nfor (\$i = 0; \$i < count(\$produtos); \$i++) {\n    echo \$produtos[\$i] . PHP_EOL;\n}",
                    'common_errors' => ['Esquecer o $i++ e criar um loop infinito.', 'Usar <= quando o limite correto é <.', 'Começar em 1 ao percorrer índices de um array, que começam em 0.'],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Contagem de 1 a 10', 'slug' => 'for-1-a-10', 'difficulty' => 'Fácil', 'position' => 1, 'xp' => 50,
            'description' => 'Use for para mostrar os números de 1 até 10, um por linha.',
            'rules' => ['Utilize um loop for.', 'Não escreva os números manualmente.'],
            'starter_code' => "<?php\n\n// Escreva sua solução aqui\n",
            'solution' => "<?php\n\nfor (\$i = 1; \$i <= 10; \$i++) {\n    echo \$i . PHP_EOL;\n}",
            'explanation' => 'O contador começa em 1, continua enquanto for menor ou igual a 10 e aumenta uma unidade por repetição.',
            'required_structure' => 'for',
            'hints' => ['Você precisa repetir a mesma ação dez vezes.', 'Use um contador que comece em 1.', 'A condição pode ser $i <= 10.'],
            'expected' => implode("\n", range(1, 10)),
        ]);

        $this->exercise($lesson, [
            'title' => 'Números pares', 'slug' => 'for-numeros-pares', 'difficulty' => 'Médio', 'position' => 2, 'xp' => 80,
            'description' => 'Mostre somente os números pares entre 1 e 20, um por linha.',
            'rules' => ['Utilize um loop for.', 'Use uma condição para identificar números pares.'],
            'starter_code' => "<?php\n\nfor (\$i = 1; \$i <= 20; \$i++) {\n    // Verifique se o número é par\n}\n",
            'solution' => "<?php\n\nfor (\$i = 1; \$i <= 20; \$i++) {\n    if (\$i % 2 === 0) {\n        echo \$i . PHP_EOL;\n    }\n}",
            'explanation' => 'O operador % obtém o resto. Quando o resto da divisão por 2 é zero, o número é par.',
            'required_structure' => 'for',
            'hints' => ['Percorra todos os números de 1 a 20.', 'O operador % informa o resto de uma divisão.', 'Teste se $i % 2 === 0.'],
            'expected' => implode("\n", range(2, 20, 2)),
        ]);

        $this->exercise($lesson, [
            'title' => 'Tabuada do 5', 'slug' => 'for-tabuada-cinco', 'difficulty' => 'Difícil', 'position' => 3, 'xp' => 120,
            'description' => 'Gere a tabuada do 5, do multiplicador 1 até o 10.',
            'rules' => ['Utilize um loop for.', 'Monte cada linha por cálculo e concatenação.'],
            'starter_code' => "<?php\n\n\$numero = 5;\n// Escreva sua solução aqui\n",
            'solution' => "<?php\n\n\$numero = 5;\nfor (\$i = 1; \$i <= 10; \$i++) {\n    echo \"\$numero x \$i = \" . (\$numero * \$i) . PHP_EOL;\n}",
            'explanation' => 'Em cada repetição, o multiplicador muda e o resultado é calculado em vez de ser escrito manualmente.',
            'required_structure' => 'for',
            'hints' => ['O multiplicador varia de 1 até 10.', 'Multiplique $numero por $i.', 'Concatene os valores para formar cada linha.'],
            'expected' => implode("\n", array_map(fn ($i) => "5 x $i = ".(5 * $i), range(1, 10))),
        ]);

        $this->seedAdditionalModules();
        $this->call([
            FundamentalsExpandedSeeder::class,
            ConditionsExpandedSeeder::class,
            LoopsExpansionSeeder::class,
            ArraysAndFunctionsExpandedSeeder::class,
            StringsExpandedSeeder::class,
        ]);
        $this->seedCurriculumExpansion();
        $this->normalizeCurriculum();
    }

    private function seedAdditionalModules(): void
    {
        $lessons = [
            'fundamentos' => [
                'title' => 'Variáveis e saída', 'slug' => 'fundamentos-variaveis',
                'summary' => 'Comece com tags PHP, echo, tipos, variáveis e operadores.',
                'learn' => 'Criar variáveis, guardar valores e mostrar informações na tela.',
                'explanation' => 'Uma variável é um espaço com nome usado para guardar um valor. Em PHP ela começa com $. Você pode guardar textos, inteiros, decimais e valores verdadeiro ou falso.',
                'syntax' => "\$nome = 'Ana';\necho \$nome;",
                'example' => "\$nome = 'Ana';\n\$idade = 20;\necho \"\$nome tem \$idade anos.\";",
                'lines' => ['A primeira linha guarda o texto Ana.', 'A segunda guarda o número 20.', 'echo interpola as variáveis dentro do texto.'],
                'real' => "\$preco = 50.0;\n\$quantidade = 3;\necho \$preco * \$quantidade;",
                'errors' => ['Esquecer o $ antes do nome.', 'Usar uma variável antes de criá-la.', 'Confundir ponto de concatenação com soma.'],
                'exercises' => [
                    ['Saudação personalizada', 'fundamentos-saudacao', 'Fácil', 'Crie $nome com o valor Ana e mostre: Olá, Ana!', "<?php\n\n\$nome = 'Ana';\n", "<?php\n\n\$nome = 'Ana';\necho 'Olá, ' . \$nome . '!';", 'Olá, Ana!', null],
                    ['Total da compra', 'fundamentos-total', 'Médio', 'Calcule 3 produtos de R$ 25 e mostre apenas o total.', "<?php\n\n\$preco = 25;\n\$quantidade = 3;\n", "<?php\n\n\$preco = 25;\n\$quantidade = 3;\necho \$preco * \$quantidade;", '75', null],
                ],
            ],
            'condicoes' => [
                'title' => 'Decisões com if', 'slug' => 'condicoes-if',
                'summary' => 'Faça o programa escolher um caminho com if, elseif e else.',
                'learn' => 'Construir decisões usando condições que resultam em verdadeiro ou falso.',
                'explanation' => 'Uma condição é uma pergunta feita pelo programa. O bloco if executa quando a resposta é verdadeira; else cuida do outro caso.',
                'syntax' => "if (condição) {\n    // verdadeiro\n} else {\n    // falso\n}",
                'example' => "\$idade = 18;\nif (\$idade >= 18) {\n    echo 'Maior de idade';\n} else {\n    echo 'Menor de idade';\n}",
                'lines' => ['A idade é guardada.', '>= compara a idade com 18.', 'Somente um dos blocos será executado.'],
                'real' => "\$estoque = 4;\nif (\$estoque > 0) {\n    echo 'Disponível';\n}",
                'errors' => ['Usar = no lugar de == ou ===.', 'Esquecer as chaves.', 'Criar condições que nunca podem ser verdadeiras.'],
                'exercises' => [
                    ['Maioridade', 'condicoes-maioridade', 'Fácil', 'Com $idade igual a 17, mostre Menor de idade.', "<?php\n\n\$idade = 17;\n", "<?php\n\n\$idade = 17;\nif (\$idade >= 18) { echo 'Maior de idade'; } else { echo 'Menor de idade'; }", 'Menor de idade', 'if'],
                    ['Situação da nota', 'condicoes-nota', 'Médio', 'Com nota 8, mostre Aprovado quando ela for maior ou igual a 7.', "<?php\n\n\$nota = 8;\n", "<?php\n\n\$nota = 8;\nif (\$nota >= 7) { echo 'Aprovado'; } else { echo 'Reprovado'; }", 'Aprovado', 'if'],
                ],
            ],
            'arrays' => [
                'title' => 'Listas com arrays', 'slug' => 'arrays-listas',
                'summary' => 'Guarde vários valores juntos e percorra a coleção.',
                'learn' => 'Criar arrays, acessar índices e percorrer valores com foreach.',
                'explanation' => 'Um array reúne vários valores em uma única variável. Índices numéricos começam em zero; arrays associativos usam chaves com nomes.',
                'syntax' => "\$nomes = ['Ana', 'Bia'];\necho \$nomes[0];",
                'example' => "\$nomes = ['Ana', 'Carlos', 'Pedro'];\nforeach (\$nomes as \$nome) {\n    echo \$nome . PHP_EOL;\n}",
                'lines' => ['O array recebe três textos.', 'foreach pega um item de cada vez.', 'O nome atual é mostrado.'],
                'real' => "\$precos = [20, 30, 50];\necho array_sum(\$precos);",
                'errors' => ['Acessar um índice inexistente.', 'Esquecer que o primeiro índice é 0.', 'Alterar o array errado dentro do loop.'],
                'exercises' => [
                    ['Lista de nomes', 'arrays-nomes', 'Fácil', 'Percorra Ana, Carlos e Pedro com foreach, um por linha.', "<?php\n\n\$nomes = ['Ana', 'Carlos', 'Pedro'];\n", "<?php\n\n\$nomes = ['Ana', 'Carlos', 'Pedro'];\nforeach (\$nomes as \$nome) { echo \$nome . PHP_EOL; }", "Ana\nCarlos\nPedro", 'foreach'],
                    ['Total da folha', 'arrays-salarios', 'Médio', 'Some os salários 3500, 2800 e 4200 e mostre o total.', "<?php\n\n\$salarios = [3500, 2800, 4200];\n", "<?php\n\n\$salarios = [3500, 2800, 4200];\necho array_sum(\$salarios);", '10500', null],
                ],
            ],
            'funcoes' => [
                'title' => 'Funções reutilizáveis', 'slug' => 'funcoes-basico',
                'summary' => 'Agrupe uma tarefa, receba parâmetros e devolva resultados.',
                'learn' => 'Declarar funções com parâmetros e retorno.',
                'explanation' => 'Uma função dá um nome a um bloco reutilizável. Parâmetros são entradas; return devolve o resultado para quem chamou.',
                'syntax' => "function nome(\$parametro) {\n    return \$resultado;\n}",
                'example' => "function somar(\$a, \$b) {\n    return \$a + \$b;\n}\necho somar(10, 20);",
                'lines' => ['function declara a função.', '$a e $b recebem os valores.', 'return entrega a soma.', 'echo mostra o valor devolvido.'],
                'real' => "function calcularTotal(\$preco, \$quantidade) {\n    return \$preco * \$quantidade;\n}",
                'errors' => ['Confundir echo com return.', 'Chamar a função com parâmetros faltando.', 'Tentar usar fora uma variável de escopo local.'],
                'exercises' => [
                    ['Função somar', 'funcoes-somar', 'Fácil', 'Crie somar($a, $b) e mostre o resultado de somar 10 e 20.', "<?php\n\n", "<?php\n\nfunction somar(\$a, \$b) { return \$a + \$b; }\necho somar(10, 20);", '30', 'function'],
                    ['Dobrar número', 'funcoes-dobrar', 'Médio', 'Crie dobrar($numero) e mostre o dobro de 7.', "<?php\n\n", "<?php\n\nfunction dobrar(\$numero) { return \$numero * 2; }\necho dobrar(7);", '14', 'function'],
                ],
            ],
            'strings' => [
                'title' => 'Manipulação de textos', 'slug' => 'strings-manipulacao',
                'summary' => 'Limpe, transforme, recorte e combine textos.',
                'learn' => 'Usar funções comuns como trim, strlen, strtoupper e str_replace.',
                'explanation' => 'Strings são sequências de caracteres. O PHP possui funções prontas para contar, limpar, dividir e substituir partes de um texto.',
                'syntax' => "\$texto = trim(\$texto);\necho strtoupper(\$texto);",
                'example' => "\$nome = '  ana  ';\necho strtoupper(trim(\$nome));",
                'lines' => ['trim remove espaços das pontas.', 'strtoupper converte letras para maiúsculas.', 'echo mostra o resultado.'],
                'real' => "\$tags = 'php,laravel,web';\n\$lista = explode(',', \$tags);",
                'errors' => ['Esperar que a função altere a variável original.', 'Confundir caracteres com bytes em textos acentuados.', 'Inverter os argumentos de str_replace.'],
                'exercises' => [
                    ['Texto em maiúsculas', 'strings-maiusculas', 'Fácil', 'Converta php para PHP com strtoupper.', "<?php\n\n\$texto = 'php';\n", "<?php\n\n\$texto = 'php';\necho strtoupper(\$texto);", 'PHP', null],
                    ['Trocar palavra', 'strings-trocar', 'Médio', 'Troque mundo por PHP em Olá, mundo!', "<?php\n\n\$texto = 'Olá, mundo!';\n", "<?php\n\n\$texto = 'Olá, mundo!';\necho str_replace('mundo', 'PHP', \$texto);", 'Olá, PHP!', null],
                ],
            ],
            'datas' => [
                'title' => 'Datas e horários', 'slug' => 'datas-basico',
                'summary' => 'Crie datas, formate valores e calcule diferenças.',
                'learn' => 'Formatar datas com date e trabalhar com objetos DateTime.',
                'explanation' => 'Datas possuem formatos diferentes para armazenamento e exibição. DateTime facilita operações como adicionar dias e calcular intervalos.',
                'syntax' => "\$data = new DateTime('2026-08-10');\necho \$data->format('d/m/Y');",
                'example' => "\$data = new DateTime('2026-08-10');\necho \$data->format('d/m/Y');",
                'lines' => ['DateTime cria uma data.', 'format define a ordem de dia, mês e ano.', 'd/m/Y produz 10/08/2026.'],
                'real' => "\$inicio = new DateTime('2026-08-01');\n\$fim = new DateTime('2026-08-10');\necho \$inicio->diff(\$fim)->days;",
                'errors' => ['Misturar m (mês) com i (minuto).', 'Depender do fuso sem configurá-lo.', 'Comparar datas formatadas como texto.'],
                'exercises' => [
                    ['Formatar data', 'datas-formatar', 'Fácil', 'Formate 2026-08-10 como 10/08/2026 usando DateTime.', "<?php\n\n\$data = new DateTime('2026-08-10');\n", "<?php\n\n\$data = new DateTime('2026-08-10');\necho \$data->format('d/m/Y');", '10/08/2026', null],
                    ['Diferença em dias', 'datas-diferenca', 'Médio', 'Mostre a diferença em dias entre 01/08/2026 e 10/08/2026.', "<?php\n\n\$inicio = new DateTime('2026-08-01');\n\$fim = new DateTime('2026-08-10');\n", "<?php\n\n\$inicio = new DateTime('2026-08-01');\n\$fim = new DateTime('2026-08-10');\necho \$inicio->diff(\$fim)->days;", '9', null],
                ],
            ],
            'formularios' => [
                'title' => 'Formulários e validação', 'slug' => 'formularios-post',
                'summary' => 'Receba dados, confira valores e produza respostas seguras.',
                'learn' => 'Entender GET, POST, isset, empty, validação e sanitização.',
                'explanation' => 'Formulários enviam dados para o servidor. GET coloca dados na URL; POST envia no corpo da requisição. Todo dado recebido deve ser validado antes do uso.',
                'syntax' => "\$nome = \$_POST['nome'] ?? '';\nif (empty(\$nome)) { echo 'Nome obrigatório'; }",
                'example' => "\$nome = 'Ana';\nif (empty(\$nome)) {\n    echo 'Nome obrigatório';\n} else {\n    echo 'Olá, ' . htmlspecialchars(\$nome);\n}",
                'lines' => ['O valor recebido é guardado.', 'empty verifica ausência de conteúdo.', 'htmlspecialchars protege a exibição no HTML.'],
                'real' => "\$email = 'aluno@example.com';\nif (filter_var(\$email, FILTER_VALIDATE_EMAIL)) {\n    echo 'E-mail válido';\n}",
                'errors' => ['Confiar diretamente em $_POST.', 'Validar só no navegador.', 'Mostrar texto recebido sem escapar HTML.'],
                'exercises' => [
                    ['Campo obrigatório', 'formularios-obrigatorio', 'Fácil', 'Com $nome vazio, use empty e mostre Nome obrigatório.', "<?php\n\n\$nome = '';\n", "<?php\n\n\$nome = '';\nif (empty(\$nome)) { echo 'Nome obrigatório'; }", 'Nome obrigatório', 'if'],
                    ['Validar e-mail', 'formularios-email', 'Médio', 'Valide aluno@example.com e mostre E-mail válido.', "<?php\n\n\$email = 'aluno@example.com';\n", "<?php\n\n\$email = 'aluno@example.com';\nif (filter_var(\$email, FILTER_VALIDATE_EMAIL)) { echo 'E-mail válido'; }", 'E-mail válido', 'if'],
                ],
            ],
            'orientacao-a-objetos' => [
                'title' => 'Classes e objetos', 'slug' => 'poo-classes-objetos',
                'summary' => 'Modele dados e comportamentos usando classes e objetos.',
                'learn' => 'Criar uma classe, instanciar um objeto e chamar métodos.',
                'explanation' => 'Uma classe é um molde. Um objeto é uma ocorrência criada a partir desse molde. Propriedades guardam estado e métodos descrevem comportamentos.',
                'syntax' => "class Pessoa {\n    public string \$nome;\n}\n\$pessoa = new Pessoa();",
                'example' => "class Pessoa {\n    public function saudar() { return 'Olá'; }\n}\n\$pessoa = new Pessoa();\necho \$pessoa->saudar();",
                'lines' => ['class cria o molde.', 'O método saudar devolve um texto.', 'new cria o objeto.', 'A seta chama o método do objeto.'],
                'real' => "class Produto {\n    public function __construct(public string \$nome) {}\n}\n\$produto = new Produto('Teclado');",
                'errors' => ['Confundir classe com objeto.', 'Tentar acessar membro private diretamente.', 'Esquecer new ao criar o objeto.'],
                'exercises' => [
                    ['Primeiro objeto', 'poo-primeiro-objeto', 'Fácil', 'Crie Pessoa com o método saudar retornando Olá e mostre o retorno.', "<?php\n\n", "<?php\n\nclass Pessoa { public function saudar() { return 'Olá'; } }\n\$pessoa = new Pessoa();\necho \$pessoa->saudar();", 'Olá', 'class'],
                    ['Produto com construtor', 'poo-construtor', 'Médio', 'Crie Produto que recebe o nome Teclado no construtor e mostre esse nome.', "<?php\n\n", "<?php\n\nclass Produto { public function __construct(public string \$nome) {} }\n\$produto = new Produto('Teclado');\necho \$produto->nome;", 'Teclado', 'class'],
                ],
            ],
        ];

        foreach ($lessons as $moduleSlug => $data) {
            $module = Module::where('slug', $moduleSlug)->firstOrFail();
            $module->update(['is_available' => true]);
            $lesson = Lesson::updateOrCreate(['slug' => $data['slug']], [
                'module_id' => $module->id, 'title' => $data['title'], 'summary' => $data['summary'], 'position' => 1,
                'content' => ['learn' => $data['learn'], 'explanation' => $data['explanation'], 'syntax' => $data['syntax'], 'example' => $data['example'], 'lines' => $data['lines'], 'real_example' => $data['real'], 'common_errors' => $data['errors']],
            ]);

            foreach ($data['exercises'] as $position => $exercise) {
                [$title, $slug, $difficulty, $description, $starter, $solution, $expected, $required] = $exercise;
                $this->exercise($lesson, [
                    'title' => $title, 'slug' => $slug, 'difficulty' => $difficulty, 'position' => $position + 1, 'xp' => $position ? 80 : 50,
                    'description' => $description, 'rules' => ['Produza exatamente a saída pedida.', 'Calcule a resposta em PHP; não mostre apenas texto fixo.'],
                    'starter_code' => $starter, 'solution' => $solution, 'explanation' => 'A solução usa o conceito apresentado na aula para calcular e mostrar o resultado.',
                    'required_structure' => $required, 'hints' => ['Releia o exemplo simples da aula.', 'Identifique quais valores entram e qual resultado deve sair.', 'Use a sintaxe mostrada e execute antes de validar.'], 'expected' => $expected,
                ]);
            }
        }

        $this->seedOperatorLesson();
    }

    private function seedOperatorLesson(): void
    {
        $module = Module::where('slug', 'fundamentos')->firstOrFail();
        $lesson = Lesson::updateOrCreate(['slug' => 'operadores-especiais'], [
            'module_id' => $module->id,
            'title' => 'Operadores ||, & e ?:',
            'summary' => 'Pratique decisões curtas, alternativas e operações bit a bit sem confundir operadores parecidos.',
            'position' => 2,
            'content' => [
                'learn' => 'Usar || para alternativas lógicas, & para comparar bits e ?: para escolher um valor de forma curta.',
                'explanation' => 'O operador || significa OU: basta uma condição ser verdadeira. O operador & trabalha com os bits de números inteiros e não substitui &&. O operador ternário ?: escolhe entre dois valores conforme uma condição.',
                'syntax' => "\$podeEntrar = \$temIngresso || \$ehConvidado;\n\$permissao = 6 & 3;\n\$status = \$idade >= 18 ? 'Adulto' : 'Menor';",
                'example' => "\$temIngresso = false;\n\$ehConvidado = true;\necho \$temIngresso || \$ehConvidado ? 'Pode entrar' : 'Não pode entrar';",
                'lines' => [
                    '$temIngresso é falso.',
                    '$ehConvidado é verdadeiro.',
                    'Com ||, apenas uma das condições precisa ser verdadeira.',
                    'O ternário mostra Pode entrar quando a condição é verdadeira.',
                ],
                'real_example' => "\$usuarioAtivo = true;\n\$administrador = false;\n\$mensagem = \$usuarioAtivo || \$administrador ? 'Acesso liberado' : 'Acesso negado';\necho \$mensagem;",
                'common_errors' => [
                    'Confundir || (OU lógico) com && (E lógico).',
                    'Usar & quando queria testar duas condições com &&.',
                    'Criar ternários longos e difíceis de ler; nesses casos, prefira if e else.',
                ],
            ],
        ]);

        $exercises = [
            [
                'title' => 'Entrada com alternativa', 'slug' => 'operador-ou-logico', 'difficulty' => 'Fácil', 'position' => 1, 'xp' => 50,
                'description' => 'Uma pessoa pode entrar se tiver ingresso OU se for convidada. Com ingresso falso e convidada verdadeira, mostre Pode entrar.',
                'rules' => ['Utilize o operador ||.', 'Utilize o operador ternário ?: para escolher a mensagem.'],
                'starter_code' => "<?php\n\n\$temIngresso = false;\n\$ehConvidado = true;\n\n// Complete aqui\n",
                'solution' => "<?php\n\n\$temIngresso = false;\n\$ehConvidado = true;\n\necho \$temIngresso || \$ehConvidado ? 'Pode entrar' : 'Não pode entrar';",
                'explanation' => 'Como $ehConvidado é verdadeiro, a expressão com || é verdadeira. O ternário escolhe Pode entrar.',
                'required_structure' => 'logical_or',
                'hints' => ['Basta uma das duas condições ser verdadeira.', 'Una as condições usando ||.', "Use condição ? 'Pode entrar' : 'Não pode entrar'."],
                'expected' => 'Pode entrar',
            ],
            [
                'title' => 'Permissões com bits', 'slug' => 'operador-bit-a-bit', 'difficulty' => 'Médio', 'position' => 2, 'xp' => 80,
                'description' => 'Calcule 6 & 3 e mostre o resultado numérico.',
                'rules' => ['Utilize o operador &.', 'Não substitua o cálculo pelo resultado pronto.'],
                'starter_code' => "<?php\n\n\$permissoesA = 6; // binário 110\n\$permissoesB = 3; // binário 011\n\n// Complete aqui\n",
                'solution' => "<?php\n\n\$permissoesA = 6;\n\$permissoesB = 3;\n\necho \$permissoesA & \$permissoesB;",
                'explanation' => '6 é 110 e 3 é 011 em binário. O & mantém 1 apenas onde os dois bits são 1: 010, que vale 2.',
                'required_structure' => 'bitwise_and',
                'hints' => ['& compara cada posição binária.', '110 & 011 resulta em 010.', 'Mostre $permissoesA & $permissoesB.'],
                'expected' => '2',
            ],
            [
                'title' => 'Frete com ternário', 'slug' => 'operador-ternario', 'difficulty' => 'Fácil', 'position' => 3, 'xp' => 50,
                'description' => 'Se o total for maior ou igual a 100, o frete será Grátis; caso contrário, será Pago. Com total 120, mostre Grátis.',
                'rules' => ['Utilize o operador ternário ?:.', 'A decisão deve depender de $total.'],
                'starter_code' => "<?php\n\n\$total = 120;\n\n// Complete aqui\n",
                'solution' => "<?php\n\n\$total = 120;\n\necho \$total >= 100 ? 'Grátis' : 'Pago';",
                'explanation' => 'A condição $total >= 100 é verdadeira, então o valor antes dos dois-pontos é escolhido.',
                'required_structure' => 'ternary',
                'hints' => ['Primeiro escreva a comparação $total >= 100.', 'Depois da ? fica o valor usado quando for verdadeiro.', 'Depois de : fica o valor usado quando for falso.'],
                'expected' => 'Grátis',
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

    private function seedCurriculumExpansion(): void
    {
        $topics = [
            ['fundamentos', 'comparacoes-logica', 'Comparações e lógica', 'Combine comparações com &&, || e !.', "\$idade = 20;\n\$temDocumento = true;\necho \$idade >= 18 && \$temDocumento ? 'Liberado' : 'Bloqueado';", 'Pode dirigir?', 'Crie podeDirigir($idade, $habilitado) e devolva Sim somente quando ambos permitirem.', "<?php\nfunction podeDirigir(\$idade, \$habilitado) {\n    // retorne Sim ou Não\n}\necho podeDirigir(18, true);", "<?php\nfunction podeDirigir(\$idade, \$habilitado) { return \$idade >= 18 && \$habilitado ? 'Sim' : 'Não'; }\necho podeDirigir(18, true);", 'Sim', 'function', [['echo PHP_EOL . podeDirigir(16, true);', "Sim\nNão"], ['echo PHP_EOL . podeDirigir(30, false);', "Sim\nNão"]]],
            ['condicoes', 'switch-e-match', 'Switch e match', 'Escolha resultados a partir de um único valor.', "\$dia = 2;\necho match (\$dia) { 1 => 'Segunda', 2 => 'Terça', default => 'Outro' };", 'Classificar perfil', 'Crie perfil($tipo) com match: admin retorna Administrador e os demais retornam Usuário.', "<?php\nfunction perfil(\$tipo) {\n    // use match\n}\necho perfil('admin');", "<?php\nfunction perfil(\$tipo) { return match (\$tipo) { 'admin' => 'Administrador', default => 'Usuário' }; }\necho perfil('admin');", 'Administrador', 'function', [["echo PHP_EOL . perfil('visitante');", "Administrador\nUsuário"]]],
            ['loops', 'while-do-while', 'While e do...while', 'Repita enquanto uma condição for verdadeira e entenda a primeira execução garantida.', "\$i = 1;\nwhile (\$i <= 3) { echo \$i++; }", 'Contagem com while', 'Crie contar($limite) que mostre de 1 ao limite usando while.', "<?php\nfunction contar(\$limite) {\n    // use while\n}\ncontar(3);", "<?php\nfunction contar(\$limite) { \$i=1; while (\$i<=\$limite) { echo \$i++.PHP_EOL; } }\ncontar(3);", "1\n2\n3", 'while', [['ob_start(); contar(5); $r=ob_get_clean(); echo trim($r);', "1\n2\n3\n1\n2\n3\n4\n5"]]],
            ['loops', 'foreach-break-continue', 'Foreach, break e continue', 'Percorra coleções, pule itens e encerre buscas.', 'foreach ([1,2,3] as $n) { if ($n === 2) continue; echo $n; }', 'Ignorar inativos', 'Percorra os usuários e mostre somente os ativos usando foreach e continue.', "<?php\n\$usuarios = [['nome'=>'Ana','ativo'=>true],['nome'=>'Bia','ativo'=>false],['nome'=>'Caio','ativo'=>true]];\n", "<?php\n\$usuarios = [['nome'=>'Ana','ativo'=>true],['nome'=>'Bia','ativo'=>false],['nome'=>'Caio','ativo'=>true]];\nforeach (\$usuarios as \$usuario) { if (!\$usuario['ativo']) continue; echo \$usuario['nome'].PHP_EOL; }", "Ana\nCaio", 'foreach', []],
            ['arrays', 'arrays-associativos', 'Arrays associativos', 'Use chaves, busque, altere e ordene informações.', "\$produto = ['nome'=>'Mouse','preco'=>80];\necho \$produto['nome'];", 'Carrinho total', 'Crie totalCarrinho($precos) e devolva a soma dos valores.', "<?php\nfunction totalCarrinho(\$precos) {\n    // calcule sem valor fixo\n}\necho totalCarrinho([10,20,30]);", "<?php\nfunction totalCarrinho(\$precos) { return array_sum(\$precos); }\necho totalCarrinho([10,20,30]);", '60', 'function', [['echo PHP_EOL.totalCarrinho([5,7]);', "60\n12"], ['echo PHP_EOL.totalCarrinho([]);', "60\n0"]]],
            ['funcoes', 'funcoes-tipos-escopo', 'Tipos, opcionais e escopo', 'Declare entradas, retornos e valores padrão.', "function saudar(string \$nome, string \$prefixo='Olá'): string { return \"\$prefixo, \$nome\"; }", 'Desconto tipado', 'Crie calcularDesconto(float $valor, float $percentual = 10): float.', "<?php\nfunction calcularDesconto(float \$valor, float \$percentual = 10): float {\n    // retorne o valor final\n}\necho calcularDesconto(100);", "<?php\nfunction calcularDesconto(float \$valor, float \$percentual = 10): float { return \$valor - (\$valor * \$percentual / 100); }\necho calcularDesconto(100);", '90', 'function', [['echo PHP_EOL.calcularDesconto(200,25);', "90\n150"]]],
            ['strings', 'strings-dividir-juntar', 'Dividir e juntar textos', 'Pratique substr, explode, implode e substituições.', "\$partes = explode(',', 'php,laravel');\necho implode(' | ', \$partes);", 'Formatar tags', 'Crie formatarTags($texto) que troque vírgulas por " | ".', "<?php\nfunction formatarTags(\$texto) {\n}\necho formatarTags('php,laravel,sql');", "<?php\nfunction formatarTags(\$texto) { return implode(' | ', explode(',', \$texto)); }\necho formatarTags('php,laravel,sql');", 'php | laravel | sql', 'function', [["echo PHP_EOL.formatarTags('html,css');", "php | laravel | sql\nhtml | css"]]],
            ['datas', 'datas-operacoes', 'Operações com datas', 'Adicione períodos e compare prazos.', "\$data = new DateTime('2026-01-01');\n\$data->modify('+10 days');\necho \$data->format('d/m/Y');", 'Adicionar prazo', 'Crie vencimento($data, $dias) e devolva a data final em d/m/Y.', "<?php\nfunction vencimento(\$data, \$dias) {\n}\necho vencimento('2026-08-10', 5);", "<?php\nfunction vencimento(\$data, \$dias) { \$d=new DateTime(\$data); \$d->modify(\"+\$dias days\"); return \$d->format('d/m/Y'); }\necho vencimento('2026-08-10', 5);", '15/08/2026', 'function', [["echo PHP_EOL.vencimento('2026-12-30',3);", "15/08/2026\n02/01/2027"]]],
            ['formularios', 'formularios-validacao', 'Validação e sanitização', 'Valide campos, e-mail e dados opcionais antes de usar.', "\$email = filter_var('a@b.com', FILTER_VALIDATE_EMAIL);\necho \$email ? 'Válido' : 'Inválido';", 'Validar idade recebida', 'Crie validarIdade($valor) que devolva Válida para inteiros entre 1 e 120.', "<?php\nfunction validarIdade(\$valor) {\n}\necho validarIdade(25);", "<?php\nfunction validarIdade(\$valor) { return filter_var(\$valor, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1,'max_range'=>120]]) !== false ? 'Válida' : 'Inválida'; }\necho validarIdade(25);", 'Válida', 'function', [['echo PHP_EOL.validarIdade(150);', "Válida\nInválida"], ["echo PHP_EOL.validarIdade('abc');", "Válida\nInválida"]]],
            ['orientacao-a-objetos', 'poo-encapsulamento', 'Encapsulamento e herança', 'Proteja propriedades e reutilize comportamentos.', 'class Conta { private float $saldo=0; public function depositar(float $v): void { $this->saldo += $v; } }', 'Conta protegida', 'Crie Conta com saldo privado, depositar e obterSaldo. Deposite 50 e mostre 50.', "<?php\nclass Conta {\n    // implemente\n}\n\$conta=new Conta();\n\$conta->depositar(50);\necho \$conta->obterSaldo();", "<?php\nclass Conta { private float \$saldo=0; public function depositar(float \$v): void { \$this->saldo+=\$v; } public function obterSaldo(): float { return \$this->saldo; } }\n\$conta=new Conta(); \$conta->depositar(50); echo \$conta->obterSaldo();", '50', 'class', []],
        ];

        foreach ($topics as $index => $topic) {
            [$moduleSlug,$slug,$title,$summary,$example,$exerciseTitle,$description,$starter,$solution,$expected,$required,$hidden] = $topic;
            $module = Module::where('slug', $moduleSlug)->firstOrFail();
            $lesson = Lesson::updateOrCreate(['slug' => $slug], ['module_id' => $module->id, 'title' => $title, 'summary' => $summary, 'position' => 10 + $index, 'content' => [
                'learn' => $summary, 'explanation' => $summary.' Observe a entrada, o processamento e a saída antes de escrever.', 'syntax' => $example, 'example' => $example,
                'lines' => ['Identifique os valores de entrada.', 'Aplique o operador ou estrutura apropriada.', 'Produza a saída somente depois do cálculo.'],
                'real_example' => $example, 'common_errors' => ['Fixar a resposta em vez de calcular.', 'Ignorar tipos ou casos-limite.', 'Não testar com outros valores.'],
            ]]);
            $this->exercise($lesson, ['title' => $exerciseTitle, 'slug' => $slug.'-pratica', 'difficulty' => 'Médio', 'type' => 'code', 'position' => 1, 'xp' => 90, 'description' => $description,
                'rules' => ['Resolva com o conceito desta aula.', 'A solução deve funcionar com valores diferentes nos testes ocultos.'], 'starter_code' => $starter, 'solution' => $solution,
                'explanation' => 'A solução recebe valores e calcula o resultado, por isso funciona também nos testes ocultos.', 'required_structure' => $required,
                'hints' => ['Transforme o enunciado em entradas e saída.', 'Use o exemplo da aula como estrutura.', 'Não fixe o resultado: use os parâmetros.'], 'expected' => $expected, 'hidden_tests' => $hidden]);
        }

        $lesson = Lesson::where('slug', 'loop-for')->firstOrFail();
        $this->exercise($lesson, ['title' => 'Encontre o loop infinito', 'slug' => 'debug-loop-infinito', 'difficulty' => 'Médio', 'type' => 'debug', 'position' => 4, 'xp' => 90, 'description' => 'Corrija o código que diminui $i e nunca alcança o fim.', 'rules' => ['Mantenha o loop for.', 'Altere apenas o necessário.'], 'starter_code' => "<?php\nfor (\$i=1; \$i<=5; \$i--) { echo \$i.PHP_EOL; }", 'solution' => "<?php\nfor (\$i=1; \$i<=5; \$i++) { echo \$i.PHP_EOL; }", 'explanation' => '$i++ aproxima o contador do limite final.', 'required_structure' => 'for', 'hints' => ['Observe a direção do contador.', 'Ele começa em 1 e precisa chegar a 5.', 'Troque -- por ++.'], 'expected' => "1\n2\n3\n4\n5"]);
        $this->exercise($lesson, ['title' => 'Preveja a saída', 'slug' => 'previsao-loop-zero', 'difficulty' => 'Fácil', 'type' => 'prediction', 'options' => ['A' => '1 2 3', 'B' => '0 1 2', 'C' => '0 1 2 3', 'D' => 'Loop infinito'], 'correct_answer' => 'B', 'position' => 5, 'xp' => 40, 'description' => 'Qual é a saída de: for ($i=0; $i<3; $i++) echo $i;', 'rules' => ['Simule cada repetição antes de responder.'], 'starter_code' => 'B', 'solution' => 'B', 'explanation' => 'Começa em 0 e para antes de 3.', 'required_structure' => null, 'hints' => ['O primeiro valor é 0.', '$i < 3 não inclui 3.', 'Os valores são 0, 1 e 2.'], 'expected' => 'B']);
    }

    private function normalizeCurriculum(): void
    {
        Lesson::whereIn('slug', ['switch-e-match', 'foreach-break-continue', 'strings-dividir-juntar'])
            ->update(['is_published' => false]);

        $paths = [
            'fundamentos' => ['fundamentos-variaveis', 'tipos-dados-completo', 'operadores-aritmeticos', 'concatenacao-interpolacao', 'constantes', 'operadores-especiais', 'comparacoes-logica'],
            'condicoes' => ['condicoes-if', 'comparacoes-logica-completa', 'if-elseif-else-avancado', 'ternario-null-coalescing', 'switch-match'],
            'loops' => ['loop-for', 'loop-while', 'while-do-while', 'loop-foreach', 'break-continue', 'loops-aninhados'],
            'arrays' => ['arrays-listas', 'arrays-associativos', 'array-metodos-count-in-array', 'array-manipulacao-push-pop-merge'],
            'funcoes' => ['funcoes-basico', 'funcoes-parametros-padrao', 'funcoes-tipos-retorno', 'funcoes-tipos-escopo', 'funcoes-com-arrays-parameters'],
            'strings' => ['strings-manipulacao', 'strings-comprimento-caracteres', 'strings-substring-extrair', 'strings-busca-strpos', 'strings-transformacao-case-trim', 'strings-explode-implode', 'strings-substituicao-replace', 'strings-escape-sequences', 'strings-formatacao-repeticao'],
            'datas' => ['datas-basico', 'datas-operacoes'],
            'formularios' => ['formularios-post', 'formularios-validacao'],
            'orientacao-a-objetos' => ['poo-classes-objetos', 'poo-encapsulamento'],
        ];

        $previous = null;
        foreach ($paths as $moduleSlug => $slugs) {
            $module = Module::where('slug', $moduleSlug)->firstOrFail();
            $position = 1;
            foreach ($slugs as $slug) {
                $lesson = Lesson::where('slug', $slug)->where('module_id', $module->id)->first();
                if (! $lesson) {
                    continue;
                }
                $lesson->update([
                    'position' => $position++,
                    'is_published' => true,
                    'prerequisite_lesson_id' => $previous?->id,
                ]);
                $previous = $lesson;
            }
        }
    }
}
