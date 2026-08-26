@extends('layouts.app')
@section('title', 'Recompensas — PHP na Prática')

@section('content')
<section class="reward-hero">
    <div>
        <span class="eyebrow">Central de conquistas</span>
        <h1>Troque seu XP por recompensas</h1>
        <p class="lead">Conclua exercícios, acumule experiência e desbloqueie itens que registram sua evolução na trilha.</p>
    </div>
    <div class="reward-balance" aria-label="Saldo disponível">
        <span>Saldo para resgatar</span>
        <strong><span data-reward-available>{{ $rewardSummary['available'] }}</span> XP</strong>
        <small>Seu XP total não some do ranking.</small>
    </div>
</section>

<div id="reward-feedback" aria-live="polite">
    @if(session('reward_success'))<p class="feedback ok">{{ session('reward_success') }}</p>@endif
</div>

<section class="reward-stats" aria-label="Resumo das recompensas">
    <article class="reward-stat"><span>XP conquistado</span><strong data-reward-earned>{{ $rewardSummary['earned'] }}</strong><small>Todo XP ganho nos exercícios</small></article>
    <article class="reward-stat"><span>XP utilizado</span><strong data-reward-spent>{{ $rewardSummary['spent'] }}</strong><small>Investido em recompensas</small></article>
    <article class="reward-stat"><span>Itens resgatados</span><strong data-reward-count>{{ $rewardSummary['redeemed'] }}</strong><small>Conquistas na sua coleção</small></article>
</section>

<section class="reward-section">
    <div class="reward-section-heading"><div><span class="eyebrow">Catálogo</span><h2>Escolha sua próxima conquista</h2></div><p>As recompensas são pessoais e cada item pode ser resgatado uma vez.</p></div>
    <div class="reward-grid">
        @foreach($rewards as $reward)
            @php($redeemed = in_array($reward->id, $redeemedIds))
            @php($canRedeem = ! $redeemed && $rewardSummary['available'] >= $reward->cost)
            @php($progress = min(100, $reward->cost ? (int) round($rewardSummary['available'] / $reward->cost * 100) : 100))
            <article class="reward-card reward-{{ $reward->accent }} {{ $redeemed ? 'redeemed' : '' }}" data-reward-card="{{ $reward->id }}" data-reward-cost="{{ $reward->cost }}" data-redeemed="{{ $redeemed ? 'true' : 'false' }}">
                <div class="reward-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M12 3 15 9l6 .9-4.5 4.4 1.1 6.2L12 17.6l-5.6 2.9 1.1-6.2L3 9.9 9 9z"/></svg>
                </div>
                <div class="reward-card-copy"><span class="reward-category">{{ $reward->category }}</span><h3>{{ $reward->title }}</h3><p>{{ $reward->description }}</p></div>
                <div class="reward-cost-row"><strong>{{ $reward->cost }} XP</strong><span>{{ $redeemed ? 'Na sua coleção' : ($canRedeem ? 'Disponível agora' : 'Continue praticando') }}</span></div>
                <div class="reward-progress" aria-label="{{ $progress }}% do XP necessário"><span style="width:{{ $redeemed ? 100 : $progress }}%"></span></div>
                <form method="POST" action="{{ route('rewards.redeem', $reward, absolute: false) }}" data-reward-form>
                    @csrf
                    <button class="btn {{ $canRedeem ? 'btn-primary' : 'btn-secondary' }} reward-button" type="submit" @disabled(! $canRedeem)>
                        {{ $redeemed ? 'Resgatada' : ($canRedeem ? 'Resgatar recompensa' : 'Saldo insuficiente') }}
                    </button>
                </form>
            </article>
        @endforeach
    </div>
</section>

<section class="reward-history">
    <div><span class="eyebrow">Sua coleção</span><h2>Resgates recentes</h2></div>
    <div class="reward-history-list" data-reward-history>
        @forelse($recentRedemptions as $redemption)
            <article><div><strong>{{ $redemption->reward->title }}</strong><span>{{ $redemption->redeemed_at->format('d/m/Y \à\s H:i') }}</span></div><code>{{ $redemption->redemption_code }}</code></article>
        @empty
            <p class="empty-ranking">Você ainda não resgatou itens. Conclua exercícios e escolha sua primeira recompensa.</p>
        @endforelse
    </div>
</section>
@endsection
