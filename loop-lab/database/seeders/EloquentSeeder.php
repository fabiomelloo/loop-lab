<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class EloquentSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::where('slug', 'laravel-eloquent')->firstOrFail();

        $this->lesson($module, 1, [
            'slug' => 'eloquent-models-convencoes',
            'title' => 'Models, objetos e tabelas',
            'summary' => 'Entenda como uma classe Model representa uma tabela e cada objeto representa uma linha.',
            'learn' => 'Conectar orientação a objetos com banco de dados: classe, objeto, tabela, linha e coluna.',
            'explanation' => 'Eloquent é o ORM do Laravel. A classe Produto representa a tabela produtos; um objeto $produto representa uma linha; e $produto->nome acessa a coluna nome.',
            'syntax' => "use Illuminate\\Database\\Eloquent\\Model;\n\nclass Produto extends Model\n{\n    protected \$fillable = ['nome', 'preco', 'estoque'];\n}\n\n\$produto = Produto::find(1);\necho \$produto->nome;",
            'example' => "// SQL\nSELECT * FROM produtos WHERE id = 1;\n\n// Eloquent\n\$produto = Produto::find(1);",
            'lines' => ['Produto é uma classe Model.', 'Por convenção, Produto usa a tabela produtos.', 'find(1) procura a chave primária id igual a 1.', '$produto é um objeto com os dados da linha.'],
            'real_example' => "class Produto extends Model\n{\n    protected \$casts = ['preco' => 'decimal:2', 'ativo' => 'boolean'];\n}\n\n\$produto = Produto::findOrFail(10);\necho \$produto->ativo ? \$produto->nome : 'Indisponível';",
            'common_errors' => ['Confundir Model com Controller.', 'Usar find() e acessar propriedades sem verificar null.', 'Esquecer $fillable ao usar create() ou update().'],
        ], [
            ['model-classe-tabela', 'O que a classe Produto representa?', ['A' => 'Uma única coluna', 'B' => 'A tabela produtos', 'C' => 'Uma rota', 'D' => 'Um controller'], 'B', 'A classe Model representa a tabela; cada instância representa uma linha.'],
            ['model-objeto-linha', 'Depois de $produto = Produto::find(7), o que $produto representa?', ['A' => 'A linha de id 7', 'B' => 'Todas as tabelas', 'C' => 'A migration', 'D' => 'A conexão inteira'], 'A', 'find(7) devolve um objeto correspondente à linha com chave primária 7.'],
            ['model-find-null', 'Qual diferença está correta?', ['A' => 'find() sempre cria', 'B' => 'findOrFail() retorna array', 'C' => 'find() pode retornar null; findOrFail() lança 404', 'D' => 'Não existe diferença'], 'C', 'findOrFail é útil quando a página deve responder 404 se o registro não existir.'],
        ]);

        $this->lesson($module, 2, [
            'slug' => 'eloquent-sql-select',
            'title' => 'Do SELECT SQL para Eloquent',
            'summary' => 'Converta SELECT, WHERE, ORDER BY e LIMIT em consultas Eloquent legíveis.',
            'learn' => 'Ler uma consulta SQL e montar a cadeia equivalente com where(), orderBy(), select(), first() e get().',
            'explanation' => 'O Query Builder do Eloquent forma uma consulta passo a passo. get() retorna uma coleção; first() retorna um Model ou null; value() retorna apenas o valor de uma coluna.',
            'syntax' => "// SQL\nSELECT id, nome, preco FROM produtos\nWHERE ativo = true AND preco < 100\nORDER BY preco DESC LIMIT 5;\n\n// Eloquent\nProduto::query()\n    ->select('id', 'nome', 'preco')\n    ->where('ativo', true)\n    ->where('preco', '<', 100)\n    ->orderByDesc('preco')\n    ->limit(5)\n    ->get();",
            'example' => "// SQL: SELECT * FROM pedidos WHERE status = 'pago';\n\$pedidos = Pedido::where('status', 'pago')->get();\n\n// Uma linha\n\$pedido = Pedido::where('codigo', 'ABC123')->first();",
            'lines' => ['query() inicia uma consulta explícita.', 'Cada where adiciona uma condição AND.', 'orderByDesc equivale a ORDER BY ... DESC.', 'get() executa e retorna uma Collection.'],
            'real_example' => "\$maisVendidos = Produto::query()\n    ->where('ativo', true)\n    ->whereBetween('preco', [20, 200])\n    ->orderByDesc('vendas')\n    ->take(10)\n    ->get();",
            'common_errors' => ['Esquecer get() e ficar só com o construtor da consulta.', 'Usar first() esperando uma coleção.', 'Carregar todas as colunas quando apenas duas são necessárias.'],
        ], [
            ['sql-where-eloquent', 'Converta: SELECT * FROM produtos WHERE estoque > 0', ['A' => "Produto::where('estoque', '>', 0)->get()", 'B' => "Produto::find('estoque')", 'C' => 'Produto::all()->whereSql(0)', 'D' => "Produto::create(['estoque' => 0])"], 'A', 'where recebe coluna, operador e valor; get executa a consulta.'],
            ['sql-order-limit', 'Qual cadeia equivale a ORDER BY preco ASC LIMIT 3?', ['A' => "->sort('preco')->all(3)", 'B' => "->orderBy('preco')->limit(3)->get()", 'C' => "->where('preco', 3)", 'D' => '->first(3)'], 'B', 'orderBy usa ASC por padrão e limit restringe a quantidade.'],
            ['get-vs-first', 'Qual retorno está correto?', ['A' => 'get(): Model; first(): Collection', 'B' => 'Ambos sempre retornam array', 'C' => 'get(): Collection; first(): Model ou null', 'D' => 'first(): SQL em texto'], 'C', 'Use get para várias linhas e first para no máximo uma.'],
        ]);

        $this->lesson($module, 3, [
            'slug' => 'eloquent-crud',
            'title' => 'CRUD real com Eloquent',
            'summary' => 'Crie, consulte, atualize e remova registros com segurança.',
            'learn' => 'Implementar Create, Read, Update e Delete e entender fillable, save(), update() e delete().',
            'explanation' => 'CRUD reúne as quatro operações básicas do banco. Eloquent permite trabalhar com elas como métodos de objetos, mas dados recebidos do usuário devem ser validados e protegidos por $fillable.',
            'syntax' => "// CREATE\n\$produto = Produto::create(['nome' => 'Mouse', 'preco' => 89.90]);\n// READ\n\$produto = Produto::findOrFail(1);\n// UPDATE\n\$produto->update(['preco' => 79.90]);\n// DELETE\n\$produto->delete();",
            'example' => "// SQL\nUPDATE produtos SET estoque = estoque - 1 WHERE id = 10;\n\n// Eloquent atômico\nProduto::whereKey(10)->decrement('estoque');",
            'lines' => ['create insere e devolve o Model criado.', 'findOrFail busca ou interrompe com 404.', 'update altera atributos permitidos e salva.', 'delete remove a linha representada pelo objeto.'],
            'real_example' => "\$dados = \$request->validate([\n    'nome' => ['required', 'max:120'],\n    'preco' => ['required', 'numeric', 'min:0'],\n]);\n\n\$produto = Produto::create(\$dados);",
            'common_errors' => ['Usar $request->all() sem validação.', 'Não configurar $fillable.', 'Fazer controle de estoque sem transação ou decrement atômico.'],
        ], [
            ['crud-create', 'Qual método insere e retorna o novo Model?', ['A' => 'create()', 'B' => 'get()', 'C' => 'delete()', 'D' => 'orderBy()'], 'A', 'create faz inserção em massa dos campos permitidos por fillable.'],
            ['crud-update-object', 'Você já possui $produto. Como atualizar somente o preço?', ['A' => "\$produto->update(['preco' => 50])", 'B' => "\$produto->get('preco')", 'C' => "\$produto->delete('preco')", 'D' => 'Produto::all(50)'], 'A', 'update altera os atributos e persiste a mudança.'],
            ['crud-mass-assignment', 'Qual prática protege atribuição em massa?', ['A' => 'Deixar qualquer campo passar', 'B' => 'Usar $fillable e dados validados', 'C' => 'Esconder o botão', 'D' => 'Usar apenas GET'], 'B', '$fillable define quais atributos podem ser preenchidos em massa.'],
        ]);

        $this->lesson($module, 4, [
            'slug' => 'eloquent-relacionamentos',
            'title' => 'Relacionamentos entre Models',
            'summary' => 'Modele cliente, pedidos e itens usando belongsTo, hasMany e belongsToMany.',
            'learn' => 'Transformar chaves estrangeiras e JOINs em métodos orientados a objetos.',
            'explanation' => 'Relacionamentos descrevem como Models se conectam. Um Pedido pertence a um Cliente; um Cliente possui muitos Pedidos. O Eloquent usa esses métodos para consultar dados relacionados.',
            'syntax' => "class Pedido extends Model\n{\n    public function cliente(): BelongsTo\n    {\n        return \$this->belongsTo(Cliente::class);\n    }\n}\n\nclass Cliente extends Model\n{\n    public function pedidos(): HasMany\n    {\n        return \$this->hasMany(Pedido::class);\n    }\n}",
            'example' => "// SQL\nSELECT pedidos.* FROM pedidos\nJOIN clientes ON clientes.id = pedidos.cliente_id\nWHERE clientes.email = 'ana@email.com';\n\n// Eloquent\nPedido::whereHas('cliente', fn (\$q) =>\n    \$q->where('email', 'ana@email.com')\n)->get();",
            'lines' => ['belongsTo fica no Model que possui a chave estrangeira.', 'hasMany fica no lado pai.', '$pedido->cliente acessa o objeto relacionado.', '$cliente->pedidos é uma coleção quando carregada.'],
            'real_example' => "\$pedido = Pedido::with(['cliente', 'itens.produto'])->findOrFail(50);\n\necho \$pedido->cliente->nome;\nforeach (\$pedido->itens as \$item) {\n    echo \$item->produto->nome;\n}",
            'common_errors' => ['Colocar belongsTo no lado errado.', 'Confundir o método pedidos() com a propriedade carregada pedidos.', 'Consultar relações dentro de loops e criar N+1.'],
        ], [
            ['relacao-belongs-to', 'A tabela pedidos possui cliente_id. Qual relação pertence ao Model Pedido?', ['A' => 'belongsTo(Cliente::class)', 'B' => 'hasMany(Cliente::class)', 'C' => 'hasOne(Pedido::class)', 'D' => 'Nenhuma'], 'A', 'O Model que contém a chave estrangeira pertence ao pai.'],
            ['relacao-has-many', 'Um cliente pode ter vários pedidos. Qual método usar em Cliente?', ['A' => 'belongsTo', 'B' => 'hasMany', 'C' => 'findOrFail', 'D' => 'decrement'], 'B', 'Cliente é o lado um; pedidos são o lado muitos.'],
            ['relacao-where-has', 'Para buscar pedidos cujo cliente está ativo, qual recurso usar?', ['A' => "whereHas('cliente', fn (\$q) => \$q->where('ativo', true))", 'B' => 'limitCliente()', 'C' => 'createCliente()', 'D' => 'deleteJoin()'], 'A', 'whereHas filtra o Model principal por condições da relação.'],
        ]);

        $this->lesson($module, 5, [
            'slug' => 'eloquent-scopes-performance',
            'title' => 'Scopes, eager loading e N+1',
            'summary' => 'Organize consultas reutilizáveis e evite dezenas de queries desnecessárias.',
            'learn' => 'Reconhecer N+1, usar with(), selecionar colunas e criar scopes de domínio.',
            'explanation' => 'N+1 acontece quando uma consulta busca a lista e outra consulta é executada para cada item. Eager loading com with() carrega relações em poucas consultas. Scopes guardam filtros frequentes com nomes do negócio.',
            'syntax' => "// N+1\n\$pedidos = Pedido::all();\nforeach (\$pedidos as \$pedido) echo \$pedido->cliente->nome;\n\n// Correto\n\$pedidos = Pedido::with('cliente')->get();",
            'example' => "class Produto extends Model\n{\n    public function scopeDisponiveis(Builder \$query): void\n    {\n        \$query->where('ativo', true)->where('estoque', '>', 0);\n    }\n}\n\n\$produtos = Produto::disponiveis()->orderBy('nome')->get();",
            'lines' => ['all() consulta pedidos uma vez.', 'A relação acessada no loop pode consultar clientes repetidamente.', 'with(cliente) carrega os clientes antecipadamente.', 'O scope dá nome e reutilização a uma regra de negócio.'],
            'real_example' => "\$pedidos = Pedido::query()\n    ->with(['cliente:id,nome', 'itens.produto:id,nome'])\n    ->whereBetween('created_at', [\$inicio, \$fim])\n    ->latest()\n    ->paginate(20);",
            'common_errors' => ['Usar with() para relações que não serão exibidas.', 'Esquecer a chave id ao limitar colunas da relação.', 'Usar get() com milhares de linhas em vez de paginate() ou chunk().'],
        ], [
            ['nmaisum-identificar', 'Qual código tende a gerar N+1?', ['A' => "Pedido::with('cliente')->get()", 'B' => 'Acessar $pedido->cliente dentro de loop sem with()', 'C' => 'Pedido::count()', 'D' => 'Pedido::find(1)'], 'B', 'O carregamento preguiçoso dentro do loop pode executar uma consulta por pedido.'],
            ['eager-loading-with', 'Como carregar clientes junto com pedidos?', ['A' => "Pedido::with('cliente')->get()", 'B' => "Pedido::create('cliente')", 'C' => 'Pedido::delete()', 'D' => 'Pedido::limitCliente()'], 'A', 'with faz eager loading da relação.'],
            ['scope-beneficio', 'Qual é o principal benefício de um scope?', ['A' => 'Substituir migrations', 'B' => 'Reutilizar filtros com nome do domínio', 'C' => 'Criar HTML', 'D' => 'Desativar o banco'], 'B', 'Scopes evitam duplicação e deixam a intenção da consulta clara.'],
        ]);
    }

    private function lesson(Module $module, int $position, array $data, array $questions): void
    {
        $lesson = Lesson::updateOrCreate(['slug' => $data['slug']], [
            'module_id' => $module->id,
            'title' => $data['title'],
            'summary' => $data['summary'],
            'position' => $position,
            'content' => [
                'learn' => $data['learn'],
                'explanation' => $data['explanation'],
                'syntax' => $data['syntax'],
                'example' => $data['example'],
                'lines' => $data['lines'],
                'real_example' => $data['real_example'],
                'common_errors' => $data['common_errors'],
            ],
        ]);

        foreach ($questions as $index => [$slug, $description, $options, $answer, $explanation]) {
            $this->prediction($lesson, $index + 1, $slug, $description, $options, $answer, $explanation);
        }
    }

    private function prediction(Lesson $lesson, int $position, string $slug, string $description, array $options, string $answer, string $explanation): void
    {
        $exercise = Exercise::updateOrCreate(['slug' => $slug], [
            'lesson_id' => $lesson->id,
            'title' => 'SQL para Eloquent: desafio '.$position,
            'difficulty' => $position === 1 ? 'Fácil' : ($position === 2 ? 'Médio' : 'Difícil'),
            'type' => 'prediction',
            'description' => $description,
            'rules' => ['Escolha a alternativa mais correta.', 'Compare SQL, Model, método e tipo de retorno antes de validar.'],
            'starter_code' => $answer,
            'solution' => $answer,
            'explanation' => $explanation,
            'required_structure' => null,
            'hints' => ['Compare tabela com Model.', 'Observe filtros e tipo de retorno.', 'Elimine métodos que alteram dados quando a pergunta apenas consulta.'],
            'options' => $options,
            'correct_answer' => $answer,
            'position' => $position,
            'xp' => 60 + ($position * 20),
        ]);

        $exercise->tests()->updateOrCreate(['is_hidden' => false], ['expected_output' => $answer, 'input' => null]);
        $exercise->tests()->where('is_hidden', true)->delete();
        $exercise->tests()->create(['is_hidden' => true, 'expected_output' => $answer, 'input' => null]);
    }
}
