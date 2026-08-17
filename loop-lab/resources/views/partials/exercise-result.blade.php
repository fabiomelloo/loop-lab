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
        @if($validation['passed'] && isset($nextStep) && $nextStep['exercise'])
            <div class="next-step"><span class="eyebrow">Próximo passo recomendado</span><h3>{{ $nextStep['kind'] === 'exercise' ? $nextStep['exercise']->title : $nextStep['lesson']->title }}</h3><p>{{ $nextStep['kind'] === 'exercise' ? 'Continue praticando este assunto.' : 'Você concluiu esta aula. Agora avance para o próximo conceito.' }}</p>
            <a class="btn btn-primary" data-spa href="{{ route('lessons.show', [$nextStep['lesson'], $nextStep['exercise']]) }}#{{ $nextStep['kind'] === 'exercise' ? 'praticar' : 'aprender' }}">{{ $nextStep['kind'] === 'exercise' ? 'Próximo exercício' : 'Começar próxima aula' }}</a></div>
        @elseif($validation['passed'] && isset($nextStep) && $nextStep['kind'] === 'complete')
            <p><strong>Você concluiu todo o percurso publicado. Continue pela área Revisar.</strong></p>
        @endif
    </div>
</section>
@endisset
