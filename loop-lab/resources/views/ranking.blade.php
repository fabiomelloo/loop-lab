@extends('layouts.app')
@section('title', 'Ranking — PHP na Prática')
@section('content')
<span class="eyebrow">Comunidade</span><h1>Ranking de estudantes</h1><p class="lead">A classificação considera XP e exercícios concluídos. Tentativas não dão pontos.</p>

<section class="card" style="margin:28px 0">
    <div class="course-card" style="margin:0">
        <div><h2>Seu perfil</h2><p>Escolha o nome que aparecerá para os outros estudantes.</p></div>
        <form class="profile-form" method="POST" action="{{ route('profile.update') }}" data-profile-form>
            @csrf<div><label for="display_name">Nome no ranking</label><input id="display_name" name="display_name" value="{{ old('display_name', $learner->display_name) }}" maxlength="30" required></div>
            <button class="btn btn-primary" type="submit">Salvar nome</button>
        </form>
    </div>
    <div id="profile-feedback" aria-live="polite">@error('display_name')<p class="feedback bad">{{ $message }}</p>@enderror</div>
</section>

<div class="grid stats">
    <div class="card stat"><span>Sua posição</span><strong>{{ $currentPosition ? '#'.$currentPosition : '—' }}</strong></div>
    <div class="card stat"><span>Seu XP</span><strong>{{ $stats['xp'] }}</strong></div>
    <div class="card stat"><span>Concluídos</span><strong>{{ $stats['completed'] }}</strong></div>
</div>

<section class="card" style="padding:0;overflow:hidden"><table class="ranking-table"><thead><tr><th>Posição</th><th>Estudante</th><th>XP</th><th>Concluídos</th><th>Tentativas</th></tr></thead><tbody>
@forelse($ranking as $entry)<tr class="{{ $entry->learner_key === $learner->learner_key ? 'current' : '' }}"><td class="rank-position">#{{ $entry->position }}</td><td class="rank-name">{{ $entry->display_name }}@if($entry->learner_key === $learner->learner_key)<span class="rank-you">VOCÊ</span>@endif</td><td>{{ $entry->xp }} XP</td><td>{{ $entry->completed }}</td><td>{{ $entry->attempts }}</td></tr>
@empty<tr><td class="empty-ranking" colspan="5">Conclua seu primeiro exercício para entrar no ranking.</td></tr>@endforelse
</tbody></table></section>
@endsection
