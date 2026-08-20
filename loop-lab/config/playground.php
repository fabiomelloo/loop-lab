<?php

return [
    'studies' => [
        [
            'id' => 'saida', 'title' => '1. Saída e texto', 'concept' => 'echo e concatenação',
            'goal' => 'Troque o nome e faça a frase aparecer no console.',
            'tip' => 'O ponto (.) junta textos em PHP.',
            'code' => "<?php\n\n\$nome = 'João';\necho 'Olá, ' . \$nome . '!';",
        ],
        [
            'id' => 'variaveis', 'title' => '2. Variáveis', 'concept' => 'valores e operadores',
            'goal' => 'Altere os preços e mostre o novo total.',
            'tip' => 'Variáveis começam com $ e podem guardar números.',
            'code' => "<?php\n\n\$produto = 25;\n\$frete = 8;\n\$total = \$produto + \$frete;\n\necho \"Total: R$ \$total\";",
        ],
        [
            'id' => 'condicoes', 'title' => '3. Condições', 'concept' => 'if, && e ||',
            'goal' => 'Mude os valores e observe quando o acesso é permitido.',
            'tip' => '&& exige as duas condições; || aceita pelo menos uma.',
            'code' => "<?php\n\n\$idade = 19;\n\$temIngresso = true;\n\$ehConvidado = false;\n\nif (\$idade >= 18 && (\$temIngresso || \$ehConvidado)) {\n    echo 'Entrada permitida';\n} else {\n    echo 'Entrada negada';\n}",
        ],
        [
            'id' => 'atalhos', 'title' => '4. Atalhos úteis', 'concept' => '?? e operador ternário',
            'goal' => 'Teste um nome vazio e altere a idade.',
            'tip' => '?? escolhe uma alternativa; condição ? A : B escolhe entre dois resultados.',
            'code' => "<?php\n\n\$nomeInformado = null;\n\$nome = \$nomeInformado ?? 'Visitante';\n\$idade = 17;\n\$grupo = \$idade >= 18 ? 'adulto' : 'menor';\n\necho \"\$nome é \$grupo\";",
        ],
        [
            'id' => 'for', 'title' => '5. Repetição com for', 'concept' => 'quantidade conhecida',
            'goal' => 'Faça a contagem chegar até 10.',
            'tip' => 'Use for quando já sabe quantas repetições serão feitas.',
            'code' => "<?php\n\nfor (\$numero = 1; \$numero <= 5; \$numero++) {\n    echo \$numero . PHP_EOL;\n}",
        ],
        [
            'id' => 'while', 'title' => '6. Repetição com while', 'concept' => 'repetir enquanto',
            'goal' => 'Simule retiradas de 20 até o saldo chegar a zero.',
            'tip' => 'Atualize a condição dentro do loop para evitar repetição infinita.',
            'code' => "<?php\n\n\$saldo = 60;\n\nwhile (\$saldo > 0) {\n    echo \"Saldo: \$saldo\" . PHP_EOL;\n    \$saldo -= 20;\n}",
        ],
        [
            'id' => 'foreach', 'title' => '7. Listas com foreach', 'concept' => 'percorrer arrays',
            'goal' => 'Adicione uma linguagem e numere os itens.',
            'tip' => 'Use foreach quando quer visitar cada item de uma lista.',
            'code' => "<?php\n\n\$linguagens = ['PHP', 'JavaScript', 'Go'];\n\nforeach (\$linguagens as \$indice => \$linguagem) {\n    echo (\$indice + 1) . '. ' . \$linguagem . PHP_EOL;\n}",
        ],
        [
            'id' => 'funcoes', 'title' => '8. Funções', 'concept' => 'reutilizar lógica',
            'goal' => 'Chame a função para outro aluno e outra nota.',
            'tip' => 'Parâmetros são entradas; return devolve o resultado.',
            'code' => "<?php\n\nfunction situacao(string \$aluno, float \$nota): string\n{\n    \$resultado = \$nota >= 7 ? 'aprovado' : 'em recuperação';\n    return \"\$aluno está \$resultado\";\n}\n\necho situacao('Ana', 8.5);",
        ],
    ],
];
