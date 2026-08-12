@isset($execution)
<section class="result-card" aria-live="polite">
    <div class="result-heading"><span class="result-icon">›_</span><div><span class="eyebrow">Teste rápido</span><h2>Saída do seu código</h2></div></div>
    @if($execution['successful'])
        <pre class="output">{{ $execution['output'] ?: '(nenhuma saída)' }}</pre>
        <p class="security-note">Executado em {{ $execution['milliseconds'] }} ms. Confira a saída e valide quando estiver pronto.</p>
    @else
        <div class="feedback bad"><strong>Não foi possível executar.</strong><p>{{ $execution['error'] }}</p></div>
    @endif
</section>
@endisset

@isset($validation)
<section class="result-card" aria-live="polite">
    <div class="feedback {{ $validation['passed'] ? 'ok' : 'bad' }}">
        <h2>{{ $validation['passed'] ? 'Resposta correta!' : 'Ainda não passou nos testes' }}</h2>
        <p>{{ $validation['passed'] ? 'Muito bem. Seu progresso e XP foram atualizados.' : 'Compare as saídas, ajuste apenas uma coisa de cada vez e tente novamente.' }}</p>
        @if($validation['error'])
            <p><strong>O que corrigir:</strong> {{ $validation['error'] }}</p>
        @else
            <div class="compare"><div><b>Sua saída</b><pre>{{ $validation['output'] ?: '(vazia)' }}</pre></div><div><b>Saída esperada</b><pre>{{ $validation['expected'] }}</pre></div></div>
        @endif
        @if(!empty($validation['diagnostic']))<p><strong>Diagnóstico:</strong> {{ $validation['diagnostic'] }}</p>@endif
        @if($validation['passed'] && isset($nextExercise) && $nextExercise)
            <a class="btn btn-primary" data-spa href="{{ route('lessons.show', [$lesson, $nextExercise]) }}#praticar">Ir para o próximo exercício</a>
        @endif
    </div>
</section>
@endisset
