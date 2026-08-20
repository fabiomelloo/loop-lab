@php($execution = is_array($execution ?? null) ? $execution : null)
@isset($execution)
<section class="result-card" aria-live="polite">
    <div class="result-heading"><span class="result-icon">›_</span><div><span class="eyebrow">Teste rápido</span><h2>Saída do seu código</h2></div></div>
    @if(data_get($execution, 'successful'))
        <pre class="output">{{ data_get($execution, 'output') ?: '(nenhuma saída)' }}</pre>
        <p class="security-note">Executado em {{ data_get($execution, 'milliseconds', 0) }} ms. Confira a saída e valide quando estiver pronto.</p>
    @else
        <div class="feedback bad"><strong>Não foi possível executar.</strong><p>{{ data_get($execution, 'error', 'A execução não retornou um resultado válido.') }}</p></div>
    @endif
</section>
@endisset

@php($validation = is_array($validation ?? null) ? $validation : null)
@isset($validation)
<section class="result-card" aria-live="polite">
    <div class="feedback {{ data_get($validation, 'passed') ? 'ok' : 'bad' }}">
        <h2>{{ data_get($validation, 'passed') ? 'Resposta correta!' : 'Ainda não passou nos testes' }}</h2>
        <p>{{ data_get($validation, 'passed') ? 'Muito bem. Seu progresso e XP foram atualizados.' : 'Compare as saídas, ajuste apenas uma coisa de cada vez e tente novamente.' }}</p>
        @if(data_get($validation, 'error'))
            <p><strong>O que corrigir:</strong> {{ data_get($validation, 'error') }}</p>
        @else
            <div class="compare"><div><b>Sua saída</b><pre>{{ data_get($validation, 'output') ?: '(vazia)' }}</pre></div><div><b>Saída esperada</b><pre>{{ data_get($validation, 'expected', '(indisponível)') }}</pre></div></div>
        @endif
        @if(!empty(data_get($validation, 'diagnostic')))<p><strong>Diagnóstico:</strong> {{ data_get($validation, 'diagnostic') }}</p>@endif
        @if(data_get($validation, 'passed') && isset($nextStep) && data_get($nextStep, 'exercise'))
            <div class="next-step"><span class="eyebrow">Próximo passo recomendado</span><h3>{{ data_get($nextStep, 'kind') === 'exercise' ? data_get($nextStep, 'exercise')->title : data_get($nextStep, 'lesson')->title }}</h3><p>{{ data_get($nextStep, 'kind') === 'exercise' ? 'Continue praticando este assunto.' : 'Você concluiu esta aula. Agora avance para o próximo conceito.' }}</p>
            <a class="btn btn-primary" data-spa href="{{ route('lessons.show', [data_get($nextStep, 'lesson'), data_get($nextStep, 'exercise')]) }}#{{ data_get($nextStep, 'kind') === 'exercise' ? 'praticar' : 'aprender' }}">{{ data_get($nextStep, 'kind') === 'exercise' ? 'Próximo exercício' : 'Começar próxima aula' }}</a></div>
        @elseif(data_get($validation, 'passed') && isset($nextStep) && data_get($nextStep, 'kind') === 'complete')
            <p><strong>Você concluiu todo o percurso publicado. Continue pela área Revisar.</strong></p>
        @endif
    </div>
</section>
@endisset
