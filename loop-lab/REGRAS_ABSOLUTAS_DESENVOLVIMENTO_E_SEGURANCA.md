# REGRAS ABSOLUTAS DE DESENVOLVIMENTO E SEGURANÇA

## Sistema Institucional de Frequência — Laravel MVC

Estas regras são obrigatórias para qualquer análise, consulta, diagnóstico, criação, correção, refatoração, remoção ou alteração realizada neste sistema.

O sistema processa dados pessoais e funcionais de servidores, documentos privados, ocorrências de frequência, vantagens financeiras, aprovações, exportações para folha de pagamento e registros de auditoria. Nenhuma alteração pode ser tratada como um CRUD comum.

O sistema deve preservar, em qualquer situação:

- confidencialidade;
- integridade;
- rastreabilidade;
- segregação entre setores;
- controle de acesso;
- consistência financeira;
- imutabilidade depois da finalização;
- segurança contra requisições simultâneas;
- previsibilidade das regras de negócio.

---

# 1. REGRA PRINCIPAL

Não alterar, criar ou remover código sem identificar previamente:

1. qual regra de negócio está sendo atendida;
2. qual perfil pode executar a ação;
3. qual setor pode ser afetado;
4. qual estado atual o registro deve possuir;
5. para qual estado o registro será alterado;
6. quais dados relacionados serão modificados;
7. quais efeitos financeiros podem ser gerados;
8. quais registros de auditoria devem ser criados;
9. quais notificações devem ser enviadas;
10. quais riscos de concorrência existem;
11. quais testes devem comprovar o comportamento;
12. quais consequências a alteração terá em exportações, relatórios e documentos.

Nenhum código deve ser escrito antes dessa análise.

---

# 2. PROIBIÇÃO DE SUPOSIÇÕES

Não inventar regras de negócio. Quando uma regra não estiver claramente definida no código, documentação ou testes existentes:

- identificar a regra como indefinida;
- não escolher silenciosamente um comportamento;
- não criar solução ambígua;
- registrar claramente o ponto que necessita de decisão;
- usar o comportamento existente somente quando estiver comprovado.

Comentários antigos, nomes de métodos e nomes de variáveis não comprovam uma regra. A regra deve ser confirmada por pelo menos uma destas fontes:

- testes;
- validações;
- policies;
- services;
- estados permitidos;
- documentação funcional;
- migrations e constraints;
- fluxo já utilizado pelo sistema.

---

# 3. RESPONSABILIDADE DE CADA CAMADA

## Route

A rota deve apenas indicar endpoint, método HTTP, middlewares e controller. Não pode conter regra de negócio, consulta complexa ou alteração direta no banco.

## Middleware

Trata regras gerais da requisição: autenticação, conta ativa, sessão válida, troca obrigatória de senha, acesso geral por perfil e contexto institucional. Não substitui Policy, Service ou validação de setor.

## Form Request

Toda entrada externa com dados deve passar por Form Request. Ele deve validar tipos, formatos e tamanhos; normalizar quando necessário; rejeitar caracteres proibidos; aplicar autorização inicial; e fornecer mensagens previsíveis. Validação do navegador nunca é suficiente.

## Controller

Deve ser fino: receber dados validados, autorizar, chamar Service e devolver resposta, redirect, view ou arquivo. Não deve conter regra financeira, transição de estado, consultas complexas, transações extensas, manipulação direta de documentos, cálculos institucionais ou lógica de concorrência.

## Policy

Toda ação sobre recurso deve ser autorizada. Verificar perfil, usuário, setor, lotação, delegação ativa, abrangência, situação e propriedade institucional. Nunca autorizar somente por autenticação e nunca confiar em `setor_id`, `servidor_id`, `folha_id` ou identificador enviado pelo usuário.

## Service

Concentra regras de negócio, validações de domínio, transações, locks, transições, invariantes, auditoria, notificações, duplicidades e consistência entre registros relacionados.

## Model

Representa dados e relacionamentos. Pode conter relacionamentos, casts, scopes simples, accessors, mutators seguros, enums e pequenas regras do próprio registro. Não deve concentrar fluxos completos ou decisões institucionais complexas.

## Banco de dados

Regras críticas não podem depender apenas do PHP. Usar, quando aplicável, foreign keys, índices, constraints únicas, colunas obrigatórias, defaults seguros, tipos corretos e proteção contra duplicidades. Quando uma constraint não representar toda a regra, proteger com transação e lock.

## View

Apenas apresenta informações. Não decide autorização, não executa regra de negócio, não acessa outro setor, não calcula valores financeiros oficiais, não determina estados, não consulta diretamente e não usa campos escondidos como segurança. Esconder botão não impede ação; a proteção deve estar no servidor.

---

# 4. AUTORIZAÇÃO E SEPARAÇÃO POR SETOR

Toda consulta deve considerar o escopo institucional. Impedir acesso a outro setor por alteração de URL ou requisição. Verificar usuário autenticado, perfil, setor atual, setores permitidos, delegações válidas, vigência, situação ativa e recurso solicitado.

Nunca usar isoladamente `Model::findOrFail($id)` quando houver separação por setor. Buscar dentro do escopo ou autorizar imediatamente por Policy.

## SETORIAL

Atua somente no próprio setor ou setor validamente delegado. Não pode conferir como Central, aprovar, exportar folha, alterar cadastros globais ou acessar outro setor sem delegação válida.

## GESTOR

Atua somente dentro de permissões explicitamente concedidas. O nome do perfil não concede acesso global.

## CENTRAL

Pode conferir, devolver, aprovar, manter cadastros globais autorizados e realizar exportações autorizadas. Suas ações devem ser auditadas.

## ADMIN

Administra usuários, configurações e acessos. Não altera automaticamente dados funcionais, financeiros ou folhas sem permissão explicitamente definida.

## AUDITOR

Possui acesso de consulta. Não pode alterar folhas, ocorrências, documentos, eventos, usuários, aprovações, exportações ou cadastros funcionais.

---

# 5. MÁQUINA DE ESTADOS DA FOLHA

Transições devem ser explícitas e usar os enums e nomes reais do sistema. Fluxos conceituais:

```text
RASCUNHO → FINALIZADA → EM_CONFERENCIA → APROVADA
FINALIZADA ou EM_CONFERENCIA → DEVOLVIDA → RASCUNHO
```

Não permitir transições livres. Cada transição exige origem, destino, perfil, justificativa quando aplicável, usuário, data/hora, auditoria, transação, lock da folha e revalidação dentro da transação.

É proibido alterar status diretamente fora do fluxo oficial do domínio. Aprovação deve ocorrer por método específico do Service.

---

# 6. IMUTABILIDADE APÓS FINALIZAÇÃO

Após finalização, nenhum dado que componha o resultado pode mudar fora de devolução ou reabertura formal. Bloquear frequência, faltas, afastamentos, ocorrências, eventos, itens mensais, vantagens, valores, documentos, lançamentos e dados de exportação.

Em criação, edição e exclusão:

1. abrir transação;
2. buscar novamente a folha;
3. aplicar `lockForUpdate()`;
4. revalidar estado;
5. validar prazo e competência;
6. executar alteração;
7. registrar auditoria;
8. confirmar transação.

---

# 7. TRANSAÇÕES E CONCORRÊNCIA

Toda operação que lê condição e depois grava resultado deve ser analisada contra corrida. O padrão `if (! exists()) { create(); }` é inseguro para invariantes.

Usar combinação apropriada de `DB::transaction()`, `lockForUpdate()`, constraints únicas, índices, atualização atômica, bloqueio de raiz estável e tratamento de violação de constraint.

Proteger especialmente criação de lançamentos; limites de dias e valores; orçamento retroativo; delegações e seus limites; reciprocidade; fechamento de competência; finalização, aprovação, devolução e reabertura; contador de login; exportações; e numeração sequencial.

Validação e gravação devem ocorrer na mesma transação.

---

# 8. CONSTRAINTS E INVARIANTES

Toda regra que não pode ser quebrada é um invariante. Exemplos:

- não existir lançamento ativo duplicado para servidor, evento e competência;
- não existir mais de uma folha ativa do mesmo tipo e contexto;
- delegação não duplicada nem recíproca quando proibida;
- valores e dias não ultrapassarem limites;
- competência fechada não receber lançamentos;
- folha aprovada não voltar a rascunho por corrida;
- filho não ser alterado após finalização.

Verificar proteção em aplicação, banco e testes. Não confiar apenas em consulta prévia.

---

# 9. FECHAMENTO DE COMPETÊNCIA

Deve ocorrer em transação, bloquear a competência, recalcular pendências, impedir novos lançamentos e folhas, impedir alterações incompatíveis, registrar autor/data/hora, auditar e falhar previsivelmente.

Todo fluxo que cria ou altera dados da competência deve sincronizar com a mesma linha bloqueada pelo fechamento. Uma requisição não pode começar aberta e gravar depois do fechamento.

---

# 10. DELEGAÇÕES

Delegação deve registrar delegante, delegado, setor, início, fim, situação, escopo, criador e motivo quando aplicável.

Antes do uso, verificar atividade, início, fim, usuário ativo, setor, escopo e revogação. Na criação, impedir duplicidade, autorrelação indevida, reciprocidade proibida, excesso de limite, setor indevido e criador sem autoridade.

A reciprocidade deve usar chave canônica independente da direção, por exemplo `menor_usuario_id + maior_usuario_id + setor_id`, protegida por lock ou constraint.

---

# 11. SENHAS E CREDENCIAIS

Troca pelo usuário exige senha atual, nova senha, confirmação, complexidade, limite de tentativas e reautenticação quando necessária. Alteração de e-mail ou dado crítico exige confirmação recente.

Após troca/reset: revogar outras sessões, rotacionar `remember_token`, auditar, notificar e preservar somente a sessão atual quando essa política estiver definida.

Reset administrativo exige autorização específica, auditoria, revogação de sessões, ausência de exposição e troca obrigatória no próximo login quando aplicável.

Nunca registrar, enviar em texto aberto, armazenar sem hash, auditar, reexibir ou semear em produção uma senha.

---

# 12. SESSÕES E LOGIN

Invalidar sessões após troca de senha, desativação, remoção de permissão crítica, reset administrativo ou suspeita de comprometimento. Regenerar o ID após login.

O contador de falhas deve ser atômico; não usar leitura, soma e `save()` concorrentes. Usar atualização atômica, transação com lock ou rate limiting apropriado. Considerar conta, IP, período, tentativas, bloqueio temporário e auditoria. Mensagens não podem revelar existência do usuário.

---

# 13. EXPORTAÇÃO TXT PARA FOLHA

Todos os campos exportados devem usar allowlist. Rejeitar `\r`, `\n`, `\r\n`, tabs não permitidos, controles, separadores proibidos, quebras Unicode e valores fora do layout. Matrículas, códigos e identificadores exigem regex explícita conforme o layout oficial.

O Service deve revalidar antes da geração, mesmo que o cadastro já tenha validado.

A exportação deve incluir somente folhas aprovadas, impedir duplicidade, possuir identificação única, registrar usuário, data/hora, competência, hash, quantidade de linhas, total financeiro quando aplicável, preservar o arquivo e rastrear lançamentos de origem.

Nunca construir o arquivo com valores livres do banco sem sanitização e validação de formato.

---

# 14. DOCUMENTOS PRIVADOS

Armazenar em disco privado. Proibido colocar em `public`, gerar URL pública permanente, confiar em pasta, aceitar caminho do usuário ou usar nome original como caminho físico.

Download exige autenticação, Policy, setor, vínculo com recurso e auditoria quando necessária. Upload exige tamanho, MIME real, extensão, conteúdo compatível, nome seguro, quantidade máxima e vínculo autorizado. Nome físico é gerado pelo sistema; original somente como metadado seguro.

Exclusão/substituição deve tratar rollback, órfãos, registro sem arquivo, falha de storage e limpeza segura posterior.

---

# 15. MASS ASSIGNMENT

Revisar `$fillable` e `$guarded`. Não liberar sem necessidade `user_id`, `setor_id`, `status`, aprovadores/finalizadores, valores aprovados, perfil, `is_admin`, `ativo`, datas de exportação, `competencia_id` e auditoria.

Campos institucionais são definidos no servidor. Proibido usar `Model::create($request->all())`; montar explicitamente dados validados e atributos institucionais.

---

# 16. CONSULTAS E EXPOSIÇÃO DE DADOS

Selecionar somente o necessário. Evitar Models completos, documentos, dados funcionais sensíveis, tokens, sessões, auditoria indevida, relações sem escopo e endpoints globais para setoriais.

JSON/API deve usar Resources ou estruturas explícitas. Listagens devem paginar. Filtros devem respeitar o mesmo escopo de autorização.

---

# 17. AUDITORIA

Auditoria é independente de log técnico. Auditar criação, alteração, exclusão, finalização, devolução, aprovação, reabertura, fechamento, exportação, download sensível, troca/reset de senha, desativação, perfil, delegação, configuração e ações administrativas relevantes.

Registrar usuário, ação, recurso/id, data/hora, valores anteriores/posteriores relevantes, setor, competência, IP quando apropriado e contexto.

Nunca registrar senha, token, cookie, conteúdo sensível desnecessário, documento completo ou segredo. Usuários comuns não podem alterar auditoria.

---

# 18. EXCLUSÃO DE REGISTROS

Não aplicar exclusão física automaticamente. Avaliar auditoria, folha aprovada, efeitos financeiros, exportação, documento, retenção e relatórios.

Dados usados em aprovação ou exportação não podem desaparecer. Preferir cancelamento, inativação, soft delete, estorno, nova versão ou histórico. Alteração histórica não pode mudar silenciosamente exportação anterior.

---

# 19. EVENTOS FINANCEIROS

Devem possuir código, tipo, natureza, limite, cálculo, competência, período, servidor, origem, justificativa, responsável, situação e auditoria.

Não usar `float` para dinheiro. Preferir centavos inteiros ou decimal com precisão definida. Cálculos devem ser repetíveis e testáveis.

Impedir duplicidade, negativos indevidos, excesso de limite, incompatibilidade, lançamento fora/fechado, alteração após aprovação e exportação não aprovada.

---

# 20. VALIDAÇÃO DE PRAZOS E DATAS

Backend deve validar abertura/encerramento de competência, prazo setorial/conferência, afastamentos, delegações, competência correspondente e timezone institucional. Revalidar prazo dentro da transação crítica. Não depender implicitamente do timezone do servidor.

---

# 21. NOTIFICAÇÕES

São consequência de operação confirmada. Não enviar antes do commit; usar eventos pós-commit quando adequado. Respeitar destinatário, setor, perfil, mínimo de dados e ausência de links públicos para documentos. Falha de notificação não pode corromper a operação principal.

---

# 22. JOBS, FILAS E SCHEDULER

Jobs devem ser idempotentes. Repetição não pode duplicar exportações, notificações, lançamentos, arquivos, registros financeiros ou auditorias indevidas.

Revalidar estado, autorização sistêmica, existência, competência e execução anterior. Não depender de sessão. Jobs críticos exigem chave única, controle de repetição, tratamento de falha, registro e retry seguro.

---

# 23. ERROS E EXCEÇÕES

Diferenciar validação, autorização, estado inválido, conflito de concorrência, duplicidade, inexistência, falha externa e falha inesperada.

Não expor stack trace, SQL, paths, ambiente, segredos, infraestrutura. Logs técnicos devem ser suficientes e não conter dados sensíveis.

---

# 24. CÓDIGO MORTO E AMBIGUIDADE

Remover código somente após verificar rotas, controllers, services, jobs, commands, listeners, events, policies, views, JavaScript, scheduler, testes, chamadas dinâmicas e integrações. Laravel pode usar container, reflection, eventos, commands, Blade, convenções e filas.

Centralizar duplicação somente quando as regras forem realmente iguais. Evitar nomes genéricos, booleanos ambíguos, números mágicos, strings de status, métodos multitarefa, comentários contraditórios e efeitos ocultos. Preferir nomes institucionais explícitos.

---

# 25. ENUMS E CONSTANTES

Usar Enums para perfis, status, tipos, ocorrências, eventos, natureza financeira, delegações e exportações quando adequado. Não espalhar strings livres. Alterar valor persistido de Enum exige migration e análise de compatibilidade.

---

# 26. MIGRATIONS

Devem ser revisáveis, reversíveis quando possível, seguras para dados, compatíveis com produção e acompanhadas de índices/constraints.

Não apagar dados sem plano, alterar tipo sem conversão, criar coluna obrigatória sem tratar existentes, remover constraint para contornar erro ou corrigir regra silenciosamente sem auditoria. Mudanças destrutivas devem ser graduais.

---

# 27. TESTES OBRIGATÓRIOS

Regra crítica só está pronta com testes de sucesso, entrada inválida, não autenticado, perfil/setor incorretos, delegação expirada, recurso externo, estado/prazo inválidos, duplicidade, concorrência, rollback, auditoria, notificações, documentos, exportação, caracteres maliciosos e pós-finalização.

Testes específicos obrigatórios:

1. troca de senha sem senha atual;
2. senha atual incorreta;
3. troca de senha revogando outras sessões;
4. reset administrativo revogando sessões;
5. matrículas/códigos com `\r`;
6. matrículas/códigos com `\n`;
7. matrículas/códigos com `\r\n`;
8. controles Unicode;
9. duas criações simultâneas do mesmo lançamento;
10. concorrência ultrapassando limites;
11. duas delegações simultâneas;
12. delegações recíprocas simultâneas;
13. fechamento concorrente com criação;
14. finalização concorrente com item;
15. finalização concorrente com ocorrência;
16. finalização concorrente com frequência;
17. aprovação concorrente com reabertura;
18. tentativas de login concorrentes.

Testes concorrentes devem usar banco compatível com produção. SQLite não comprova locks do MySQL.

---

# 28. CHECKLIST OBRIGATÓRIO ANTES DE ALTERAR CÓDIGO

Responder internamente:

- Qual regra muda? Quem executa? Em qual setor?
- Existe Policy e Form Request?
- Um ID pode apontar para outro setor?
- Há efeito financeiro ou documento privado?
- Existe mudança de estado e ela é permitida?
- A folha está finalizada? A competência fechada? O prazo aberto?
- Existe corrida? Precisa de transação? Qual registro recebe `lockForUpdate()`?
- Existe constraint no banco?
- Precisa de auditoria e notificação?
- Afeta exportação, relatório ou histórico?
- Quais testes atuais e novos comprovam o comportamento?
- Há duplicação, código morto comprovado ou ambiguidade?
- Há risco de exposição, mass assignment, IDOR, XSS, injeção em arquivo, path traversal ou estado parcial?

Se alguma resposta não estiver definida, a alteração não está concluída.

---

# 29. CHECKLIST OBRIGATÓRIO DE CADA ENTREGA OU PULL REQUEST

## Regra alterada

Descrição, motivo, comportamento anterior e novo.

## Segurança

Perfis, autorização, setor, acesso indevido, concorrência, dados pessoais, documentos e sessões.

## Banco

Migrations, constraints, índices, FKs, rollback e dados existentes.

## Fluxo institucional

Estados, transições, competência, exportação, relatórios, auditoria e notificações.

## Testes

Criados/alterados, negativos, autorização, concorrência e suíte completa.

## Limpeza

Código morto, imports, duplicação, comentários, nomes ambíguos e rotas revisadas.

---

# 30. CRITÉRIOS DE CONCLUSÃO

Somente concluir quando regra explícita, autorização backend, setor protegido, Form Request, Service correto, transação/locks/constraints adequados, auditoria, privacidade documental, sessões, exportações sanitizadas e testes positivos/negativos/autorização/concorrência passarem.

Também exigir ausência de regra silenciosa, ambiguidade ou código morto comprovado; suíte existente preservada; formatação e análise estática aprovadas; nenhum segredo incluído.

---

# 31. PRIORIDADE IMEDIATA DE CORREÇÃO

Ordem obrigatória:

1. exigir senha atual para senha e dados críticos;
2. revogar sessões após troca/reset;
3. bloquear controles no TXT;
4. criar estratégia comum de transações/locks;
5. proteger folha e filhos após finalização;
6. proteger fechamento contra novos lançamentos;
7. proteger aprovação, devolução e reabertura;
8. reforçar duplicidades com constraints;
9. proteger limites acumulados na transação;
10. proteger delegações e reciprocidade;
11. tornar contador de login atômico;
12. adicionar testes reais de concorrência;
13. revisar arquivos privados órfãos;
14. revisar consistência de backup;
15. revisar cobertura da auditoria.

---

# 32. COMANDO ABSOLUTO PARA A IA

Sequência obrigatória em toda alteração:

```text
1. Ler o fluxo existente.
2. Identificar a regra de negócio.
3. Identificar os perfis autorizados.
4. Identificar o escopo de setor.
5. Identificar os estados envolvidos.
6. Identificar riscos financeiros.
7. Identificar riscos de concorrência.
8. Identificar necessidade de transação e lock.
9. Identificar constraints necessárias.
10. Identificar auditoria e notificações.
11. Identificar impacto em documentos e exportações.
12. Identificar testes existentes.
13. Implementar a menor alteração segura possível.
14. Criar testes positivos, negativos, de autorização e concorrência.
15. Executar testes e análise estática.
16. Revisar código morto, duplicado ou ambíguo.
17. Informar claramente qualquer ponto não comprovado.
```

É proibido:

- desativar validação para passar teste;
- remover Policy ou constraint para facilitar fluxo;
- capturar e ignorar exceção ou usar `try/catch` vazio;
- usar `forceFill()` sem justificativa ou `unguard()` como solução;
- confiar em campo escondido ou ID sem autorização;
- alterar status diretamente;
- gravar criticamente fora de transação;
- afirmar segurança total ou correção sem evidência/testes;
- inventar validação;
- esconder limitações.

---

# 33. PRINCÍPIO FINAL

Não existe código garantidamente sem falhas. Nunca afirmar invulnerabilidade.

Trabalhar para reduzir superfície, eliminar falhas conhecidas, preservar regras, impedir estados inválidos, garantir rastreabilidade, aplicar defesa em profundidade, criar testes antirregressão e declarar limitações.

Toda segurança crítica deve ter múltiplas camadas:

```text
Validação
+ Autorização
+ Regra de domínio
+ Transação
+ Lock
+ Constraint
+ Auditoria
+ Teste
```

Uma única camada nunca é proteção suficiente.

