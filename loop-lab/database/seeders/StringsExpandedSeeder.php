<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class StringsExpandedSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::where('slug', 'strings')->firstOrFail();

        // Lição: Comprimento e Caracteres
        $this->createLengthLesson($module);

        // Lição: Extração de Substrings
        $this->createSubstringLesson($module);

        // Lição: Busca dentro de Strings
        $this->createSearchLesson($module);

        // Lição: Transformação (Maiúscula, Minúscula, Trim)
        $this->createTransformLesson($module);

        // Lição: Divisão e Junção
        $this->createSplitJoinLesson($module);

        // Lição: Substituição
        $this->createReplaceLesson($module);

        // Lição: Escape Sequences
        $this->createEscapeLesson($module);

        // Lição: Formatação e Repetição
        $this->createFormattingLesson($module);
    }

    private function createLengthLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-comprimento-caracteres'],
            [
                'module_id' => $module->id,
                'title' => 'Comprimento e Acesso a Caracteres',
                'summary' => 'Use strlen() para contar caracteres e acesse-os por índice com $str[0].',
                'position' => 1,
                'content' => [
                    'learn' => 'Entender como medir strings com strlen() e acessar caracteres individuais por posição.',
                    'explanation' => 'strlen() retorna o número de caracteres. Strings em PHP são tratadas como arrays: $str[0] acessa o primeiro, $str[1] o segundo, etc. Índices negativos contam do final: $str[-1] é o último.',
                    'syntax' => "\$texto = 'PHP';\necho strlen(\$texto);        // 3\necho \$texto[0];              // P\necho \$texto[-1];             // P (último)",
                    'example' => "\$nome = 'João';\n\necho 'Seu nome tem ' . strlen(\$nome) . ' letras' . PHP_EOL;\necho 'Primeira letra: ' . \$nome[0] . PHP_EOL;\necho 'Última letra: ' . \$nome[-1];",
                    'lines' => [
                        'strlen() conta 4 caracteres em "João".',
                        'Acesso $nome[0] retorna "J".',
                        'Acesso $nome[-1] retorna "o".',
                    ],
                    'real_example' => "\$senha = 'abc123xyz';\n\nif (strlen(\$senha) < 8) {\n    echo 'Senha muito curta';\n}\n\necho 'Primeira letra: ' . \$senha[0];",
                    'common_errors' => [
                        'Esquecer que índices começam em 0, não 1.',
                        'Tentar modificar direto: $str[0] = \"x\" funciona, mas é incomum.',
                        'Confundir strlen() com count(): count() é para arrays, strlen() é para strings.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Contar caracteres',
            'slug' => 'strlen-contar',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use strlen() para contar caracteres em "Laravel" e mostre o resultado.',
            'rules' => ['Use strlen().', 'Sem espaços adicionais.'],
            'starter_code' => "<?php\n\n\$texto = 'Laravel';\necho strlen(\$texto);\n",
            'solution' => "<?php\n\n\$texto = 'Laravel';\necho strlen(\$texto);",
            'explanation' => 'strlen() retorna 7, pois "Laravel" tem 7 caracteres.',
            'required_structure' => 'strlen',
            'hints' => ['strlen() conta caracteres.', '"Laravel" tem 7 letras.'],
            'expected' => '7',
        ]);

        $this->exercise($lesson, [
            'title' => 'Acessar primeira letra',
            'slug' => 'string-index-primeiro',
            'difficulty' => 'Fácil',
            'position' => 2,
            'xp' => 50,
            'description' => 'Acesse o primeiro caractere de "PHP" usando $str[0].',
            'rules' => ['Use indexação com [0].', 'Não use funções, apenas acesso direto.'],
            'starter_code' => "<?php\n\n\$texto = 'PHP';\necho \$texto[0];\n",
            'solution' => "<?php\n\n\$texto = 'PHP';\necho \$texto[0];",
            'explanation' => '$texto[0] acessa a primeira posição, que é "P".',
            'required_structure' => null,
            'hints' => ['Índice 0 é o primeiro caractere.', 'Resultado: P.'],
            'expected' => 'P',
        ]);

        $this->exercise($lesson, [
            'title' => 'Último caractere',
            'slug' => 'string-index-ultimo',
            'difficulty' => 'Médio',
            'position' => 3,
            'xp' => 80,
            'description' => 'Use $str[-1] para pegar o último caractere de "Javascript".',
            'rules' => ['Use índice negativo [-1].', 'Mostre apenas o caractere.'],
            'starter_code' => "<?php\n\n\$texto = 'Javascript';\necho \$texto[-1];\n",
            'solution' => "<?php\n\n\$texto = 'Javascript';\necho \$texto[-1];",
            'explanation' => 'Índice -1 acessa o último caractere: "t".',
            'required_structure' => null,
            'hints' => ['Índice -1 é o último caractere.', '"Javascript" termina com "t".'],
            'expected' => 't',
        ]);
    }

    private function createSubstringLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-substring-extrair'],
            [
                'module_id' => $module->id,
                'title' => 'Extrair Substrings com substr()',
                'summary' => 'Use substr() para pegar uma parte da string começando numa posição.',
                'position' => 2,
                'content' => [
                    'learn' => 'Usar substr() para extrair partes de strings, incluindo posição inicial e comprimento.',
                    'explanation' => 'substr($str, $start, $length) extrai $length caracteres começando em $start. Se $start é negativo, começa do final. Se $length é omitido, vai até o final.',
                    'syntax' => "\$texto = 'Hello World';\necho substr(\$texto, 0, 5);      // Hello\necho substr(\$texto, 6);         // World\necho substr(\$texto, -5);        // World",
                    'example' => "\$data = '2026-08-12';\n\$ano = substr(\$data, 0, 4);   // 2026\n\$mes = substr(\$data, 5, 2);   // 08\n\$dia = substr(\$data, 8, 2);   // 12",
                    'lines' => [
                        'substr($data, 0, 4) extrai 4 caracteres começando em 0: "2026".',
                        'substr($data, 5, 2) extrai 2 caracteres começando em 5: "08".',
                        'substr($data, 8, 2) extrai 2 caracteres começando em 8: "12".',
                    ],
                    'real_example' => "\$email = 'usuario@example.com';\n\n\$antes = substr(\$email, 0, strpos(\$email, '@'));\n\necho \$antes; // usuario",
                    'common_errors' => [
                        'Confundir posição (índice) com contagem de caracteres.',
                        'Esquecer que posição 0 é o primeiro caractere.',
                        'Usar ($str, 0, 3) e ($str, 3) para diferentes efeitos.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Extrair primeiras letras',
            'slug' => 'substr-primeiras',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use substr() para extrair "Prog" de "Programming".',
            'rules' => ['Use substr($str, 0, 4).', 'Sem concatenação.'],
            'starter_code' => "<?php\n\n\$texto = 'Programming';\necho substr(\$texto, 0, 4);\n",
            'solution' => "<?php\n\n\$texto = 'Programming';\necho substr(\$texto, 0, 4);",
            'explanation' => 'substr() começa em 0 e extrai 4 caracteres: "Prog".',
            'required_structure' => 'substr',
            'hints' => ['Posição 0 é o começo.', 'Comprimento 4 pega 4 caracteres.', 'Resultado: Prog.'],
            'expected' => 'Prog',
        ]);

        $this->exercise($lesson, [
            'title' => 'Extrair últimas letras',
            'slug' => 'substr-ultimas',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Use substr() com posição negativa para extrair "ing" de "Programming".',
            'rules' => ['Use posição negativa.', 'Mostre apenas "ing".'],
            'starter_code' => "<?php\n\n\$texto = 'Programming';\necho substr(\$texto, -3);\n",
            'solution' => "<?php\n\n\$texto = 'Programming';\necho substr(\$texto, -3);",
            'explanation' => 'Posição -3 começa 3 caracteres antes do final: "ing".',
            'required_structure' => 'substr',
            'hints' => ['Posição -3 é 3 caracteres antes do final.', '"Programming" termina com "ing".'],
            'expected' => 'ing',
        ]);

        $this->exercise($lesson, [
            'title' => 'Extrair meio da string',
            'slug' => 'substr-meio',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'De "2026-08-12", extraia "08" (o mês) usando substr().',
            'rules' => ['Use substr($str, 5, 2).', 'Posição 5, comprimento 2.'],
            'starter_code' => "<?php\n\n\$data = '2026-08-12';\necho substr(\$data, 5, 2);\n",
            'solution' => "<?php\n\n\$data = '2026-08-12';\necho substr(\$data, 5, 2);",
            'explanation' => 'Começando na posição 5 (depois de "2026-") e pegando 2 caracteres: "08".',
            'required_structure' => 'substr',
            'hints' => ['Posição 5 está logo após "2026-".', 'Comprimento 2 pega "08".'],
            'expected' => '08',
        ]);
    }

    private function createSearchLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-busca-strpos'],
            [
                'module_id' => $module->id,
                'title' => 'Buscar dentro de Strings com strpos()',
                'summary' => 'Use strpos() para encontrar a posição de um texto dentro de uma string.',
                'position' => 3,
                'content' => [
                    'learn' => 'Usar strpos() para localizar uma substring e entender que retorna posição (0 ou maior), não booleano.',
                    'explanation' => 'strpos($haystack, $needle) retorna a posição (índice) onde $needle foi encontrado. Retorna false se não encontrar. Atenção: posição 0 é válida, então use !== false, não == true.',
                    'syntax' => "\$texto = 'Hello World';\n\$pos = strpos(\$texto, 'World');\necho \$pos;  // 6\n\nif (strpos(\$texto, 'xyz') !== false) {\n    echo 'Encontrado';\n} else {\n    echo 'Não encontrado';\n}",
                    'example' => "\$email = 'usuario@example.com';\n\nif (strpos(\$email, '@') !== false) {\n    echo 'É um email válido (tem @)';\n}",
                    'lines' => [
                        'strpos() procura "@" no email.',
                        'Encontra na posição 7.',
                        'Verifica !== false para ter certeza que foi encontrado.',
                    ],
                    'real_example' => "\$url = 'https://example.com/page';\n\nif (strpos(\$url, 'https://') === 0) {\n    echo 'URL começa com HTTPS';\n}\n\nif (strpos(\$url, '.com') !== false) {\n    echo 'URL contém .com';\n}",
                    'common_errors' => [
                        'Esquecer que posição 0 é válida: if (strpos(...)) falha se encontrar em posição 0.',
                        'Usar == false em vez de !== false.',
                        'Confundir strpos() com in_array().',
                        'strpos() é case-sensitive: "Hello" ≠ "hello".',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Encontrar posição',
            'slug' => 'strpos-posicao',
            'difficulty' => 'Médio',
            'position' => 1,
            'xp' => 80,
            'description' => 'Use strpos() para encontrar a posição de "World" em "Hello World".',
            'rules' => ['Use strpos($str, $needle).', 'Mostre apenas o número.'],
            'starter_code' => "<?php\n\n\$texto = 'Hello World';\necho strpos(\$texto, 'World');\n",
            'solution' => "<?php\n\n\$texto = 'Hello World';\necho strpos(\$texto, 'World');",
            'explanation' => 'strpos() encontra "World" começando na posição 6.',
            'required_structure' => 'strpos',
            'hints' => ['"Hello " tem 6 caracteres.', '"World" começa após isso.', 'Resultado: 6.'],
            'expected' => '6',
        ]);

        $this->exercise($lesson, [
            'title' => 'Verificar se contém',
            'slug' => 'strpos-contem',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Verifique se "Laravel" contém "vel" usando strpos().',
            'rules' => ['Use strpos() com !== false.', 'Mostre "Contém" ou "Não contém".'],
            'starter_code' => "<?php\n\n\$texto = 'Laravel';\necho strpos(\$texto, 'vel') !== false ? 'Contém' : 'Não contém';\n",
            'solution' => "<?php\n\n\$texto = 'Laravel';\necho strpos(\$texto, 'vel') !== false ? 'Contém' : 'Não contém';",
            'explanation' => 'strpos() encontra "vel", então !== false é verdadeiro.',
            'required_structure' => 'strpos',
            'hints' => ['strpos() retorna posição se encontrar.', 'Comparar com !== false.', '"Laravel" contém "vel".'],
            'expected' => 'Contém',
        ]);

        $this->exercise($lesson, [
            'title' => 'Validar email simples',
            'slug' => 'strpos-email-valido',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Verifique se "usuario@example.com" contém "@" (validação bem simples).',
            'rules' => ['Use strpos() para buscar "@".', 'Mostre "Válido" ou "Inválido".'],
            'starter_code' => "<?php\n\n\$email = 'usuario@example.com';\necho strpos(\$email, '@') !== false ? 'Válido' : 'Inválido';\n",
            'solution' => "<?php\n\n\$email = 'usuario@example.com';\necho strpos(\$email, '@') !== false ? 'Válido' : 'Inválido';",
            'explanation' => 'Um email deve conter @. strpos() encontra, então é válido.',
            'required_structure' => 'strpos',
            'hints' => ['Email tem "@".', 'strpos() encontra em posição 7.', 'Resultado: Válido.'],
            'expected' => 'Válido',
        ]);
    }

    private function createTransformLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-transformacao-case-trim'],
            [
                'module_id' => $module->id,
                'title' => 'Transformação: Maiúsculas, Minúsculas, Trim',
                'summary' => 'Use strtoupper(), strtolower(), trim() para transformar e limpar strings.',
                'position' => 4,
                'content' => [
                    'learn' => 'Usar strtoupper(), strtolower(), ucfirst(), ucwords() para transformação de caso, e trim(), ltrim(), rtrim() para remover espaços.',
                    'explanation' => 'strtoupper() converte para MAIÚSCULA. strtolower() para minúscula. ucfirst() maiúscula apenas primeira letra. ucwords() maiúscula primeira de cada palavra. trim() remove espaços do início e fim. ltrim() remove do esquerda, rtrim() da direita.',
                    'syntax' => "\$texto = '  hello world  ';\necho strtoupper(\$texto);        // '  HELLO WORLD  '\necho strtolower('HELLO');       // 'hello'\necho trim(\$texto);             // 'hello world'\necho ucfirst('hello');          // 'Hello'\necho ucwords('hello world');    // 'Hello World'",
                    'example' => "\$nome = '  joão silva  ';\n\n\$nome = trim(\$nome);            // Remove espaços\n\$nome = ucwords(strtolower(\$nome)); // Padroniza: \"João Silva\"",
                    'lines' => [
                        'trim() remove espaços extras.',
                        'strtolower() converte para minúscula.',
                        'ucwords() maiúscula primeira letra de cada palavra.',
                    ],
                    'real_example' => "\$entrada = '  ADMIN  ';\n\n\$entrada = trim(\$entrada);         // \"ADMIN\"\n\$entrada = strtolower(\$entrada);   // \"admin\"\n\nif (\$entrada === 'admin') {\n    echo 'Login aceito';\n}",
                    'common_errors' => [
                        'Esquecer que strtoupper/lower retornam novo valor, não modificam original.',
                        'Usar trim() errado: trim() só remove espaços, não caracteres específicos.',
                        'Confundir ucfirst (uma letra) com ucwords (todas as palavras).',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Converter para maiúsculas',
            'slug' => 'strtoupper-maiuscula',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use strtoupper() para converter "hello" para maiúsculas.',
            'rules' => ['Use strtoupper().', 'Mostre o resultado.'],
            'starter_code' => "<?php\n\n\$texto = 'hello';\necho strtoupper(\$texto);\n",
            'solution' => "<?php\n\n\$texto = 'hello';\necho strtoupper(\$texto);",
            'explanation' => 'strtoupper() converte cada letra para maiúscula.',
            'required_structure' => 'strtoupper',
            'hints' => ['strtoupper() vai converter para MAIÚSCULA.', '"hello" vira "HELLO".'],
            'expected' => 'HELLO',
        ]);

        $this->exercise($lesson, [
            'title' => 'Remover espaços com trim()',
            'slug' => 'trim-espacos',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Use trim() para remover espaços de "  PHP  ".',
            'rules' => ['Use trim().', 'Sem espaços no resultado.'],
            'starter_code' => "<?php\n\n\$texto = '  PHP  ';\necho trim(\$texto);\n",
            'solution' => "<?php\n\n\$texto = '  PHP  ';\necho trim(\$texto);",
            'explanation' => 'trim() remove espaços do início e fim.',
            'required_structure' => 'trim',
            'hints' => ['trim() remove espaços nas pontas.', 'Espaços do meio continuam.', 'Resultado: "PHP" (sem espaços).'],
            'expected' => 'PHP',
        ]);

        $this->exercise($lesson, [
            'title' => 'Padronizar nome',
            'slug' => 'ucwords-padronizar',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Use ucwords() e trim() para padronizar "  joão silva  " em "João Silva".',
            'rules' => ['Use trim() e ucwords().', 'Primeira letra maiúscula em cada palavra.'],
            'starter_code' => "<?php\n\n\$nome = '  joão silva  ';\necho ucwords(trim(\$nome));\n",
            'solution' => "<?php\n\n\$nome = '  joão silva  ';\necho ucwords(trim(\$nome));",
            'explanation' => 'trim() remove espaços, ucwords() maiúscula cada palavra.',
            'required_structure' => 'ucwords',
            'hints' => ['trim() remove espaços extras.', 'ucwords() maiúscula cada palavra.', 'Resultado: "João Silva".'],
            'expected' => 'João Silva',
        ]);
    }

    private function createSplitJoinLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-explode-implode'],
            [
                'module_id' => $module->id,
                'title' => 'Divisão e Junção: explode() e implode()',
                'summary' => 'Use explode() para dividir strings em arrays e implode() para juntar.',
                'position' => 5,
                'content' => [
                    'learn' => 'Usar explode() para quebrar uma string em múltiplas partes, e implode() (ou join()) para unir array em string.',
                    'explanation' => 'explode($delimitador, $string) divide a string usando $delimitador como separador. implode($delimitador, $array) une array em string com $delimitador entre itens. Operação oposta.',
                    'syntax' => "\$csv = 'João,Maria,Pedro';\n\$nomes = explode(',', \$csv);\n// Array: ['João', 'Maria', 'Pedro']\n\n\$resultado = implode(' - ', \$nomes);\n// String: 'João - Maria - Pedro'",
                    'example' => "\$tags = 'php,laravel,web,sql';\n\n\$lista = explode(',', \$tags);\n\nforeach (\$lista as \$tag) {\n    echo \$tag . PHP_EOL;\n}",
                    'lines' => [
                        'explode(\"," separador) quebra por vírgula.',
                        'Resultado é um array com 4 elementos.',
                        'foreach percorre cada tag.',
                    ],
                    'real_example' => "\$entrada = 'maçã banana laranja';\n\n\$frutas = explode(' ', \$entrada);\n\necho 'Total: ' . count(\$frutas);\n\n\$unido = implode(' | ', \$frutas);\necho \$unido; // maçã | banana | laranja",
                    'common_errors' => [
                        'Esquecer que explode() retorna array, não string.',
                        'Confundir ordem: explode(delimiter, string) ou implode(glue, array).',
                        'Usar array_join em vez de implode (não existe).',
                        'Comportamento de limite (3º parâmetro) de explode().',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Dividir por vírgula',
            'slug' => 'explode-dividir',
            'difficulty' => 'Médio',
            'position' => 1,
            'xp' => 80,
            'description' => 'Use explode() para dividir "A,B,C" por vírgula e mostre quantos itens tem.',
            'rules' => ['Use explode(",", ...).', 'Use count() no resultado.'],
            'starter_code' => "<?php\n\n\$dados = 'A,B,C';\n\$array = explode(',', \$dados);\necho count(\$array);\n",
            'solution' => "<?php\n\n\$dados = 'A,B,C';\n\$array = explode(',', \$dados);\necho count(\$array);",
            'explanation' => 'explode() divide por vírgula em 3 partes: A, B, C.',
            'required_structure' => 'explode',
            'hints' => ['explode(",", ...) divide por vírgula.', 'Resultado tem 3 elementos.', 'count() retorna 3.'],
            'expected' => '3',
        ]);

        $this->exercise($lesson, [
            'title' => 'Juntar com hífen',
            'slug' => 'implode-juntar',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Use implode() para juntar ["A", "B", "C"] com hífen.',
            'rules' => ['Use implode("-", ...).', 'Resultado: A-B-C.'],
            'starter_code' => "<?php\n\n\$array = ['A', 'B', 'C'];\necho implode('-', \$array);\n",
            'solution' => "<?php\n\n\$array = ['A', 'B', 'C'];\necho implode('-', \$array);",
            'explanation' => 'implode() une com "-" entre cada item.',
            'required_structure' => 'implode',
            'hints' => ['implode() junta array em string.', 'Separador é "-".', 'Resultado: "A-B-C".'],
            'expected' => 'A-B-C',
        ]);

        $this->exercise($lesson, [
            'title' => 'Processar lista de emails',
            'slug' => 'explode-emails',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Divida "a@test.com b@test.com" por espaço e conte quantos emails.',
            'rules' => ['Use explode(" ", ...).', 'Use count() no resultado.'],
            'starter_code' => "<?php\n\n\$emails = 'a@test.com b@test.com';\n\$lista = explode(' ', \$emails);\necho count(\$lista);\n",
            'solution' => "<?php\n\n\$emails = 'a@test.com b@test.com';\n\$lista = explode(' ', \$emails);\necho count(\$lista);",
            'explanation' => 'Dividindo por espaço resulta em 2 emails.',
            'required_structure' => 'explode',
            'hints' => ['explode(" ", ...) divide por espaço.', 'Há 2 emails separados por espaço.'],
            'expected' => '2',
        ]);
    }

    private function createReplaceLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-substituicao-replace'],
            [
                'module_id' => $module->id,
                'title' => 'Substituição: str_replace()',
                'summary' => 'Use str_replace() para substituir partes de uma string por outras.',
                'position' => 6,
                'content' => [
                    'learn' => 'Usar str_replace() para encontrar e substituir texto, com suporte a múltiplas substituições simultâneas.',
                    'explanation' => 'str_replace($procura, $substitui, $texto) substitui todas as ocorrências. Pode processar arrays: str_replace($array_procura, $array_substitui, $texto).',
                    'syntax' => "\$texto = 'Olá Mundo';\necho str_replace('Mundo', 'PHP', \$texto); // Olá PHP\n\n// Múltiplas substituições\n\$procura = ['a', 'e'];\n\$substitui = ['*', '&'];\necho str_replace(\$procura, \$substitui, 'cafe'); // c*f&",
                    'example' => "\$mensagem = 'Seu saldo é R\$ 0.00';\n\n\$novoSaldo = str_replace('0.00', '150.50', \$mensagem);\n\necho \$novoSaldo; // Seu saldo é R\$ 150.50",
                    'lines' => [
                        'str_replace() procura "0.00".',
                        'Substitui por "150.50".',
                        'Retorna nova string sem modificar original.',
                    ],
                    'real_example' => "\$template = 'Olá {nome}, bem-vindo!';\n\n\$resultado = str_replace('{nome}', 'João', \$template);\necho \$resultado; // Olá João, bem-vindo!",
                    'common_errors' => [
                        'Esquecer que str_replace() retorna novo valor, não modifica original.',
                        'str_replace() é case-sensitive: "PHP" ≠ "php".',
                        'Confundir com preg_replace() (expressões regulares, mais poderoso).',
                        'Ordem de arrays: procura primeiro, substitui depois.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Substituir palavra simples',
            'slug' => 'str_replace-simples',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use str_replace() para substituir "Mundo" por "PHP" em "Olá Mundo".',
            'rules' => ['Use str_replace().', 'Resultado: "Olá PHP".'],
            'starter_code' => "<?php\n\n\$texto = 'Olá Mundo';\necho str_replace('Mundo', 'PHP', \$texto);\n",
            'solution' => "<?php\n\n\$texto = 'Olá Mundo';\necho str_replace('Mundo', 'PHP', \$texto);",
            'explanation' => 'str_replace() substitui "Mundo" por "PHP".',
            'required_structure' => 'str_replace',
            'hints' => ['Procura "Mundo".', 'Substitui por "PHP".', 'Resultado: "Olá PHP".'],
            'expected' => 'Olá PHP',
        ]);

        $this->exercise($lesson, [
            'title' => 'Substituir em template',
            'slug' => 'str_replace-template',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Substitua "{nome}" por "Ana" em "Bem-vindo, {nome}!".',
            'rules' => ['Use str_replace().', 'Resultado: "Bem-vindo, Ana!".'],
            'starter_code' => "<?php\n\n\$mensagem = 'Bem-vindo, {nome}!';\necho str_replace('{nome}', 'Ana', \$mensagem);\n",
            'solution' => "<?php\n\n\$mensagem = 'Bem-vindo, {nome}!';\necho str_replace('{nome}', 'Ana', \$mensagem);",
            'explanation' => 'str_replace() substitui o placeholder "{nome}" pelo valor real.',
            'required_structure' => 'str_replace',
            'hints' => ['Procura "{nome}".', 'Substitui por "Ana".', 'Resultado: "Bem-vindo, Ana!".'],
            'expected' => 'Bem-vindo, Ana!',
        ]);

        $this->exercise($lesson, [
            'title' => 'Múltiplas substituições',
            'slug' => 'str_replace-multiplo',
            'difficulty' => 'Difícil',
            'position' => 3,
            'xp' => 120,
            'description' => 'Substitua "a" por "*" e "e" por "&" em "cafe" usando arrays.',
            'rules' => ['Use str_replace() com arrays.', 'Resultado: "c*f&".'],
            'starter_code' => "<?php\n\n\$procura = ['a', 'e'];\n\$substitui = ['*', '&'];\necho str_replace(\$procura, \$substitui, 'cafe');\n",
            'solution' => "<?php\n\n\$procura = ['a', 'e'];\n\$substitui = ['*', '&'];\necho str_replace(\$procura, \$substitui, 'cafe');",
            'explanation' => 'str_replace() processa arrays: "a"→"*", "e"→"&".',
            'required_structure' => 'str_replace',
            'hints' => ['Procura: ["a", "e"].', 'Substitui: ["*", "&"].', 'c fica c, a fica *, f fica f, e fica &.'],
            'expected' => 'c*f&',
        ]);
    }

    private function createEscapeLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-escape-sequences'],
            [
                'module_id' => $module->id,
                'title' => 'Escape Sequences em Strings',
                'summary' => 'Use \\n, \\t, \\" para quebras de linha, tabulações e aspas em strings.',
                'position' => 7,
                'content' => [
                    'learn' => 'Entender como usar escape sequences (\\n, \\t, \\", \\, etc) em strings com aspas duplas.',
                    'explanation' => 'Em aspas duplas, \\n quebra linha, \\t insere tabulação, \\" insere aspas, \\\\ insere barra. Em aspas simples, praticamente nada é escapado (exceto \' e \\).',
                    'syntax' => "echo \"Linha 1\\nLinha 2\";     // Quebra linha\necho \"Tab:\\tValor\";         // Tabulação\necho \\\"Aspas: \\\\\\\"PHP\\\\\\\"\\\";  // Aspas literais\necho 'Aspas simples: \\'texto\\''; // Em simples, \\' escapa",
                    'example' => "\$lista = \"- PHP\\n- SQL\\n- HTML\";\necho \$lista;\n\n// Output:\n// - PHP\n// - SQL\n// - HTML",
                    'lines' => [
                        '\\n dentro de aspas duplas quebra a linha.',
                        'Cada item em uma nova linha.',
                        'Em aspas simples, \\n seria literal (não funcionaria).',
                    ],
                    'real_example' => "\$csv = \"Nome\\tIdade\\tEmail\\njohm\\t25\\njohn@test.com\\n\";\necho \$csv;\n\n// Pode ser parseado como CSV com tabs",
                    'common_errors' => [
                        'Usar \\n em aspas simples: a barra-n é literal, não quebra linha.',
                        'Esquecer que aspas simples não interpolam variáveis nem fazem escape.',
                        'Confundir \\\\ (barra) com / (slash).',
                        'Usar aspas erradas causando syntax error.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Quebra de linha',
            'slug' => 'escape-quebra-linha',
            'difficulty' => 'Fácil',
            'position' => 1,
            'xp' => 50,
            'description' => 'Use \\n para exibir duas linhas: "Linha 1" e "Linha 2".',
            'rules' => ['Use \\n entre as linhas.', 'Use aspas duplas.'],
            'starter_code' => "<?php\n\necho \"Linha 1\\nLinha 2\";\n",
            'solution' => "<?php\n\necho \"Linha 1\\nLinha 2\";",
            'explanation' => '\\n dentro de aspas duplas quebra para a linha seguinte.',
            'required_structure' => null,
            'hints' => ['\\n em aspas duplas = nova linha.', 'Aspas simples não funcionam com \\n.'],
            'expected' => "Linha 1\nLinha 2",
        ]);

        $this->exercise($lesson, [
            'title' => 'Tabulação',
            'slug' => 'escape-tabulacao',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Use \\t para exibir "Nome\\tJoão" (com tabulação entre).',
            'rules' => ['Use \\t.', 'Use aspas duplas.'],
            'starter_code' => "<?php\n\necho \"Nome\\tJoão\";\n",
            'solution' => "<?php\n\necho \"Nome\\tJoão\";",
            'explanation' => '\\t insere uma tabulação (espaço alinhado).',
            'required_structure' => null,
            'hints' => ['\\t em aspas duplas = tabulação.', 'Resultado: Nome com espaço alinhado.'],
            'expected' => "Nome\tJoão",
        ]);

        $this->exercise($lesson, [
            'title' => 'Aspas dentro de string',
            'slug' => 'escape-aspas',
            'difficulty' => 'Médio',
            'position' => 3,
            'xp' => 80,
            'description' => 'Exiba: Disse: "Olá"  usando \\" para as aspas.',
            'rules' => ['Use \\" para aspas literais.', 'Use aspas duplas na string.'],
            'starter_code' => "<?php\n\necho \"Disse: \\\"Olá\\\"\";\n",
            'solution' => "<?php\n\necho \"Disse: \\\"Olá\\\"\";",
            'explanation' => '\\" escapa as aspas, mostrando-as literalmente.',
            'required_structure' => null,
            'hints' => ['Dentro de aspas duplas, use \\" para mostrar aspas.', 'Resultado: Disse: "Olá".'],
            'expected' => 'Disse: "Olá"',
        ]);
    }

    private function createFormattingLesson(Module $module): void
    {
        $lesson = Lesson::updateOrCreate(
            ['slug' => 'strings-formatacao-repeticao'],
            [
                'module_id' => $module->id,
                'title' => 'Formatação e Repetição: sprintf(), str_repeat()',
                'summary' => 'Use sprintf() para formatação controlada e str_repeat() para repetir strings.',
                'position' => 8,
                'content' => [
                    'learn' => 'Usar sprintf() para formatar strings com placeholders, e str_repeat() para duplicar strings.',
                    'explanation' => 'sprintf($format, $arg1, $arg2) retorna string formatada (não exibe direto, ao contrário de printf). str_repeat($str, $count) repete a string $count vezes. Muito útil para padronização.',
                    'syntax' => "\$resultado = sprintf('Olá %s, você tem %d anos', 'João', 25);\necho \$resultado; // Olá João, você tem 25 anos\n\necho str_repeat('=', 10); // ==========",
                    'example' => "\$preco = 19.99;\n\$formatado = sprintf('R\$ %.2f', \$preco);\necho \$formatado; // R\$ 19.99",
                    'lines' => [
                        'sprintf() permite placeholders como %s (string), %d (inteiro), %.2f (float 2 casas).',
                        'str_repeat() repete a string.',
                    ],
                    'real_example' => "\$linhas = 3;\n\$separador = str_repeat('-', 20);\n\necho \$separador . PHP_EOL;\necho 'Relatório' . PHP_EOL;\necho \$separador;",
                    'common_errors' => [
                        'Usar printf() em vez de sprintf(): printf exibe, sprintf retorna.',
                        'Esquecer que %d é inteiro, %.2f é float com 2 casas.',
                        'str_repeat() pode usar muita memória se repetido demais.',
                    ],
                ],
            ],
        );

        $this->exercise($lesson, [
            'title' => 'Formatação simples',
            'slug' => 'sprintf-basico',
            'difficulty' => 'Médio',
            'position' => 1,
            'xp' => 80,
            'description' => 'Use sprintf() para formatar "Olá João, você tem 30 anos".',
            'rules' => ['Use sprintf($format, ...).', '%s para strings, %d para inteiros.'],
            'starter_code' => "<?php\n\n\$resultado = sprintf('Olá %s, você tem %d anos', 'João', 30);\necho \$resultado;\n",
            'solution' => "<?php\n\n\$resultado = sprintf('Olá %s, você tem %d anos', 'João', 30);\necho \$resultado;",
            'explanation' => 'sprintf() substitui %s por string e %d por inteiro.',
            'required_structure' => 'sprintf',
            'hints' => ['%s = placeholder para string.', '%d = placeholder para inteiro.', 'Resultado: "Olá João, você tem 30 anos".'],
            'expected' => 'Olá João, você tem 30 anos',
        ]);

        $this->exercise($lesson, [
            'title' => 'Formatar preço',
            'slug' => 'sprintf-preco',
            'difficulty' => 'Médio',
            'position' => 2,
            'xp' => 80,
            'description' => 'Use sprintf() para formatar 49.9 como "R\$ 49.90" (2 casas decimais).',
            'rules' => ['Use sprintf() com %.2f.', 'Resultado com 2 casas decimais.'],
            'starter_code' => "<?php\n\n\$preco = 49.9;\n\$formatado = sprintf('R\\$ %.2f', \$preco);\necho \$formatado;\n",
            'solution' => "<?php\n\n\$preco = 49.9;\n\$formatado = sprintf('R\\$ %.2f', \$preco);\necho \$formatado;",
            'explanation' => '%.2f formata float com 2 casas decimais: 49.9 vira 49.90.',
            'required_structure' => 'sprintf',
            'hints' => ['%.2f = float com 2 casas.', '49.9 vira 49.90.', 'Resultado: "R\$ 49.90".'],
            'expected' => 'R$ 49.90',
        ]);

        $this->exercise($lesson, [
            'title' => 'Repetir string',
            'slug' => 'str_repeat-repetir',
            'difficulty' => 'Fácil',
            'position' => 3,
            'xp' => 50,
            'description' => 'Use str_repeat() para repetir "=" 5 vezes.',
            'rules' => ['Use str_repeat("=", 5).', 'Resultado: "====="'],
            'starter_code' => "<?php\n\necho str_repeat('=', 5);\n",
            'solution' => "<?php\n\necho str_repeat('=', 5);",
            'explanation' => 'str_repeat() duplica a string n vezes.',
            'required_structure' => 'str_repeat',
            'hints' => ['str_repeat(string, count).', 'Repete 5 vezes.', 'Resultado: "=====".'],
            'expected' => '=====',
        ]);
    }

    // Helper para criar exercícios
    private function exercise(Lesson $lesson, array $data): void
    {
        if (!isset($data['expected'])) {
            $data['expected'] = '';
        }

        Exercise::updateOrCreate(
            ['lesson_id' => $lesson->id, 'slug' => $data['slug']],
            [
                'title' => $data['title'],
                'difficulty' => $data['difficulty'],
                'position' => $data['position'],
                'xp' => $data['xp'],
                'description' => $data['description'],
                'rules' => $data['rules'],
                'starter_code' => base64_encode($data['starter_code']),
                'solution' => $data['solution'],
                'explanation' => $data['explanation'],
                'required_structure' => $data['required_structure'] ?? null,
                'hints' => $data['hints'],
            ],
        );

        // Criar teste (expected output)
        $exerciseId = Exercise::where('slug', $data['slug'])->first()?->id;
        if ($exerciseId) {
            \App\Models\ExerciseTest::updateOrCreate(
                ['exercise_id' => $exerciseId],
                ['expected_output' => $data['expected']],
            );
        }
    }
}
