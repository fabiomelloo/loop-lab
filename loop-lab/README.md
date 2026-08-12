# PHP na Prática

MVP de uma plataforma educacional em Laravel para aprender PHP escrevendo código.

## O que já funciona

- dashboard com XP, tentativas e progresso;
- sidebar com os nove módulos disponíveis;
- aulas de fundamentos, condições, loops, arrays, funções, strings, datas, formulários e orientação a objetos;
- 19 exercícios executáveis e progressivos;
- execução de PHP com saída e erros;
- validação por resultado e pela estrutura obrigatória;
- testes visíveis e ocultos;
- três níveis de dica e solução sob demanda;
- registro persistente de tentativas e exercícios concluídos;
- PHP Playground restrito.

## Executar localmente

Requisitos: PHP 8.3 ou superior e extensões exigidas pelo Laravel.

```powershell
cd D:\projetos\estudo\loop-lab
php artisan migrate --seed
php artisan serve
```

Abra `http://127.0.0.1:8000`.

## Testes

```powershell
php artisan test
```

## Segurança do executor

O executor local usa processo separado, limite de dois segundos, 32 MB de memória, diretório temporário, `open_basedir`, `disable_functions` e análise de tokens. Ele bloqueia arquivos, rede, processos, includes, classes e outras construções que não são necessárias nos exercícios iniciais.

Essa defesa é adequada somente para desenvolvimento local. Antes de publicar a plataforma, substitua `RestrictedPhpRunner` por um serviço com contêiner descartável, sem rede, filesystem somente leitura, usuário sem privilégios e limites no nível do sistema operacional.

## Próximos passos

O banco e a navegação aceitam novos módulos, aulas, exercícios e testes. A evolução natural é aprofundar cada assunto com novas aulas, desafios de debug e previsão; depois adicionar autenticação individual e um executor em contêiner.
