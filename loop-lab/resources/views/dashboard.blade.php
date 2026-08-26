@extends('layouts.app')
@section('title', 'Início — Loop Lab')
@section('content')
<div class="dashboard-heading">
    <div><span class="eyebrow">Continue aprendendo</span><h1>Olá, {{ $learner->display_name }}!</h1><p class="lead">Um passo por vez. Sua próxima missão já está pronta.</p></div>
    <div class="streak-pill" title="Dias consecutivos com atividade"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22c4.4 0 8-3 8-7.4 0-3.2-1.7-5.5-4.8-8.7.2 2.2-.8 3.7-2.1 4.6.1-3.6-1.8-6.2-5.2-8.5.2 4-3.9 6.7-3.9 12.6C4 19 7.6 22 12 22Z"/></svg><span><strong>{{ $streak }}</strong> {{ $streak === 1 ? 'dia' : 'dias' }} de sequência</span></div>
</div>

<section class="dashboard-grid" aria-label="Resumo da sua jornada">
    <article class="mission-hero">
        <div class="mission-copy">
            <span class="mission-label">Sua missão atual</span><p class="mission-path">{{ $lesson->module->title }} · {{ $lesson->title }}</p><h2>{{ $nextExercise->title }}</h2><p>{{ $lesson->summary }}</p>
            <div class="mission-progress-row"><span>Progresso geral</span><strong>{{ $stats['percent'] }}%</strong></div><div class="dashboard-progress" role="progressbar" aria-label="Progresso geral" aria-valuenow="{{ $stats['percent'] }}" aria-valuemin="0" aria-valuemax="100"><span style="width:{{ $stats['percent'] }}%"></span></div>
            <a class="btn mission-button" href="{{ route('lessons.show', [$lesson, $nextExercise]) }}">Continuar missão <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></a>
        </div>
        <div class="mission-art" aria-hidden="true"><span>&lt;?php</span><div class="mission-orbit orbit-one"></div><div class="mission-orbit orbit-two"></div></div>
    </article>
    <aside class="level-card"><div class="level-card-top"><span>Nível atual</span><strong>LVL {{ $level }}</strong></div><div class="level-ring" style="--level-progress:{{ $levelPercent * 3.6 }}deg"><div><strong>{{ $levelXp }}</strong><span>/ 500 XP</span></div></div><p>Faltam <strong>{{ 500 - $levelXp }} XP</strong> para o nível {{ $level + 1 }}.</p><a href="{{ route('rewards.index') }}">Ver recompensas <span aria-hidden="true">→</span></a></aside>
</section>

<section class="dashboard-section">
    <div class="dashboard-section-heading"><div><span class="eyebrow">Ritmo de estudo</span><h2>Missões de hoje</h2></div><span class="section-counter">{{ $todayAttempts }} tentativas hoje</span></div>
    <div class="daily-missions">
        <a class="daily-mission" href="{{ route('lessons.show', [$lesson, $nextExercise]) }}"><span class="mission-icon mission-icon-green"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m8 12 3 3 5-6"/><circle cx="12" cy="12" r="9"/></svg></span><span class="daily-copy"><strong>Concluir o próximo exercício</strong><small>{{ $nextExercise->title }}</small></span><span class="xp-chip">+{{ $nextExercise->xp }} XP</span></a>
        <a class="daily-mission" href="{{ route('lessons.show', [$lesson, $nextExercise]) }}"><span class="mission-icon mission-icon-blue"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M14 5l-4 14"/></svg></span><span class="daily-copy"><strong>Praticar três vezes</strong><small>{{ min($todayAttempts, 3) }} de 3 tentativas feitas hoje</small></span><span class="mission-fraction">{{ min($todayAttempts, 3) }}/3</span></a>
        <a class="daily-mission" href="{{ route('review') }}"><span class="mission-icon mission-icon-amber"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5M12 7v5l3 2"/></svg></span><span class="daily-copy"><strong>Revisar um ponto difícil</strong><small>{{ $failedToReview ? $failedToReview.' '.($failedToReview === 1 ? 'exercício pendente' : 'exercícios pendentes') : 'Nenhum erro pendente' }}</small></span><span class="mission-fraction">Revisar</span></a>
    </div>
</section>

<section class="dashboard-lower-grid">
    <article class="dashboard-panel ranking-preview">
        <div class="panel-heading"><div><span class="eyebrow eyebrow-gold">Competição saudável</span><h2>Ranking geral</h2></div><a href="{{ route('ranking') }}">Ver todos</a></div>
        <div class="podium-list">
            @forelse($rankingPreview as $entry)
                <div class="podium-entry {{ $entry->learner_key === $learner->learner_key ? 'current' : '' }}"><span class="podium-position">{{ $entry->position }}</span><span class="podium-avatar">{{ mb_strtoupper(mb_substr($entry->display_name, 0, 1)) }}</span><span class="podium-name"><strong>{{ $entry->display_name }}</strong><small>LVL {{ intdiv($entry->xp, 500) + 1 }}</small></span><strong class="podium-xp">{{ number_format($entry->xp, 0, ',', '.') }} XP</strong></div>
            @empty
                <p class="empty-dashboard">Conclua uma missão para entrar no ranking.</p>
            @endforelse
        </div>
        @if($currentPosition)<p class="your-position">Sua posição atual: <strong>#{{ $currentPosition }}</strong></p>@endif
    </article>
    <article class="dashboard-panel journey-card">
        <div class="panel-heading"><div><span class="eyebrow">Visão geral</span><h2>Sua jornada</h2></div></div>
        <div class="journey-stats"><div><span class="journey-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 3h14v18l-7-4-7 4V3Z"/></svg></span><strong>{{ $stats['completed'] }}</strong><small>exercícios concluídos</small></div><div><span class="journey-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 21h8M12 17v4M7 4h10v4a5 5 0 0 1-10 0V4Z"/><path d="M7 6H4v2a4 4 0 0 0 4 4M17 6h3v2a4 4 0 0 1-4 4"/></svg></span><strong>{{ number_format($stats['xp'], 0, ',', '.') }}</strong><small>XP conquistados</small></div><div><span class="journey-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16M6 16l4-4 3 3 5-7"/></svg></span><strong>{{ $stats['attempts'] }}</strong><small>tentativas realizadas</small></div></div>
        <a class="journey-link" href="{{ route('lessons.show', [$lesson, $nextExercise]) }}">Abrir trilha completa <span aria-hidden="true">→</span></a>
    </article>
</section>
@endsection
