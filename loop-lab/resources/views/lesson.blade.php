@extends('layouts.app')
@section('title', $lesson->title.' — Loop Lab')
@section('content')
@php
    $currentIndex = $lesson->exercises->search(fn ($item) => $item->is($exercise));
@endphp

<span class="eyebrow">{{ $lesson->module->title }} · Aula</span>
<h1>{{ $lesson->title }}</h1>
<p class="lead">{{ $lesson->summary }}</p>

<nav class="page-jump" aria-label="Navegação dentro da aula">
    <a href="#aprender">1. Aprender</a>
    <a href="#praticar">2. Praticar</a>
</nav>

<section id="aprender" class="lesson-section">
    <div class="section-heading">
        <span class="section-number">1</span>
        <div><span class="eyebrow">Primeiro, entenda</span><h2>Aprender o conceito</h2></div>
    </div>

    <div class="learning-grid">
        <article class="card learning-intro"><h3>O que você vai aprender</h3><p>{{ $lesson->content['learn'] }}</p></article>
        <article class="card learning-intro"><h3>Em palavras simples</h3><p>{{ $lesson->content['explanation'] }}</p></article>
    </div>

    <div class="learning-grid learning-code">
        <article class="card"><h3>Sintaxe básica</h3><pre class="code"><code>{{ $lesson->content['syntax'] }}</code></pre></article>
        <article class="card"><h3>Exemplo simples</h3><pre class="code"><code>{{ $lesson->content['example'] }}</code></pre></article>
    </div>

    <details class="card lesson-detail">
        <summary>Entender o exemplo linha por linha</summary>
        <ol class="line-list">@foreach($lesson->content['lines'] as $line)<li>{{ $line }}</li>@endforeach</ol>
    </details>

    @if($lesson->slug === 'loop-for')
    <details class="card lesson-detail">
        <summary>Ver a execução passo a passo</summary>
        <div class="step"><strong>Passo 1</strong><span><code>$i = 1</code>; 1 ≤ 3 é verdadeiro; mostra 1.</span></div>
        <div class="step"><strong>Passo 2</strong><span><code>$i = 2</code>; 2 ≤ 3 é verdadeiro; mostra 2.</span></div>
        <div class="step"><strong>Passo 3</strong><span><code>$i = 3</code>; 3 ≤ 3 é verdadeiro; mostra 3.</span></div>
        <div class="step"><strong>Fim</strong><span><code>$i = 4</code>; 4 ≤ 3 é falso; o loop termina.</span></div>
        <div class="warning"><strong>O que aconteceu?</strong> Depois de cada saída, <code>$i++</code> aumentou o contador. A condição foi conferida novamente.</div>
    </details>
    @endif

    <details class="card lesson-detail">
        <summary>Exemplo prático e erros comuns</summary>
        <h3>Exemplo prático</h3><pre class="code"><code>{{ $lesson->content['real_example'] }}</code></pre>
        <h3>Erros comuns</h3><ul>@foreach($lesson->content['common_errors'] as $error)<li>{{ $error }}</li>@endforeach</ul>
    </details>
</section>

<section id="praticar" class="lesson-section practice-section">
    <div class="section-heading">
        <span class="section-number">2</span>
        <div><span class="eyebrow">Agora é sua vez</span><h2>Praticar com exercícios</h2><p>Resolva na ordem: o próximo exercício reutiliza o raciocínio do anterior.</p></div>
    </div>

    <nav class="exercise-list" aria-label="Exercícios desta aula">
        @foreach($lesson->exercises as $item)
        <a class="exercise-item {{ $item->is($exercise) ? 'active' : '' }}" data-spa data-exercise-id="{{ $item->id }}" href="{{ route('lessons.show', [$lesson, $item]) }}#praticar" @if($item->is($exercise)) aria-current="step" @endif>
            <span class="exercise-status">{{ in_array($item->id, $completedExerciseIds) ? '✓' : $item->position }}</span>
            <span><strong>{{ $item->title }}</strong><small>{{ $item->difficulty }} · {{ $item->xp }} XP @if($item->is($exercise))<b>· AGORA</b>@endif</small></span>
        </a>
        @endforeach
    </nav>

    <div class="exercise-workspace">
        <article class="exercise-brief">
            <div class="exercise-kicker"><span>Exercício {{ $currentIndex + 1 }} de {{ $lesson->exercises->count() }}</span><span class="badge">{{ $exercise->difficulty }}</span></div>
            <h2>{{ $exercise->title }}</h2>
            <div class="task-box"><span class="task-label">O que fazer</span><p>{{ $exercise->description }}</p></div>
            <div class="rules-box"><h3>Regras</h3><ul>@foreach($exercise->rules as $rule)<li>{{ $rule }}</li>@endforeach</ul></div>
            <p class="workflow-tip"><strong>Como resolver:</strong> escreva o código, clique em Executar para conferir a saída e, quando estiver pronto, clique em Validar resposta.</p>
        </article>

        <form class="editor-card" method="POST" data-async-form data-starter-code="{{ base64_encode($exercise->starter_code) }}">
            @csrf
            <div class="editor-heading"><div><span class="editor-dot"></span><span class="editor-dot"></span><span class="editor-dot"></span></div><strong>{{ $exercise->type === 'prediction' ? 'Escolha sua resposta' : 'solucao.php' }}</strong></div>
            @if($exercise->type === 'prediction')
                <div style="padding:22px;background:#fff">@foreach($exercise->options as $value=>$label)<label class="exercise-item" style="margin-bottom:10px"><input type="radio" name="code" value="{{ $value }}" required> <strong>{{ $value }}) {{ $label }}</strong></label>@endforeach</div>
            @else
                <label class="sr-only" for="code-editor">Seu código PHP</label>
                <textarea id="code-editor" class="editor" name="code" spellcheck="false" aria-describedby="editor-help">{{ old('code', $exercise->starter_code) }}</textarea>
                <p id="editor-help" class="editor-help">Dica: use Tab para indentar. Seu rascunho é salvo automaticamente neste navegador.</p>
            @endif
            @error('code')<p class="feedback bad" role="alert">{{ $message }}</p>@enderror
            <div class="editor-actions">
                <div class="actions-secondary">
                    @if($exercise->type !== 'prediction')<button type="submit" class="btn btn-secondary" formaction="{{ route('exercises.run', $exercise, absolute: false) }}">Executar código</button>@endif
                    <a class="btn btn-quiet" data-reset-editor href="{{ route('lessons.show', [$lesson, $exercise]) }}#praticar">Resetar</a>
                </div>
                <button type="submit" class="btn btn-primary" formaction="{{ route('exercises.validate', $exercise, absolute: false) }}">Validar resposta</button>
            </div>
        </form>
    </div>

    <div id="exercise-result">
        @if(session('execution'))
            @include('partials.exercise-result', ['execution' => session('execution')])
        @elseif(session('validation'))
            @include('partials.exercise-result', ['validation' => session('validation'), 'nextStep' => $nextStep, 'lesson' => $lesson])
        @endif
    </div>

    <section class="help-card">
        <div><span class="eyebrow">Travou?</span><h2>Ajuda gradual</h2><p>Abra uma dica de cada vez. A solução fica por último.</p></div>
        <div class="hints">
            @foreach($exercise->hints as $index => $hint)<details><summary>Dica {{ $index + 1 }}</summary><p>{{ $hint }}</p></details>@endforeach
            <details class="solution"><summary>Ver uma solução possível</summary><div class="warning">Tente resolver sozinho antes. Mais de uma solução pode estar correta.</div><pre class="code"><code>{{ $exercise->solution }}</code></pre><p>{{ $exercise->explanation }}</p></details>
        </div>
    </section>
    <p class="security-note">Ambiente local restrito: timeout de 2 s, memória limitada e funções perigosas bloqueadas.</p>
</section>
@endsection
