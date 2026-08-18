<?php if(isset($execution)): ?>
<section class="result-card" aria-live="polite">
    <div class="result-heading"><span class="result-icon">›_</span><div><span class="eyebrow">Teste rápido</span><h2>Saída do seu código</h2></div></div>
    <?php if($execution['successful']): ?>
        <pre class="output"><?php echo e($execution['output'] ?: '(nenhuma saída)'); ?></pre>
        <p class="security-note">Executado em <?php echo e($execution['milliseconds']); ?> ms. Confira a saída e valide quando estiver pronto.</p>
    <?php else: ?>
        <div class="feedback bad"><strong>Não foi possível executar.</strong><p><?php echo e($execution['error']); ?></p></div>
    <?php endif; ?>
</section>
<?php endif; ?>

<?php if(isset($validation)): ?>
<section class="result-card" aria-live="polite">
    <div class="feedback <?php echo e($validation['passed'] ? 'ok' : 'bad'); ?>">
        <h2><?php echo e($validation['passed'] ? 'Resposta correta!' : 'Ainda não passou nos testes'); ?></h2>
        <p><?php echo e($validation['passed'] ? 'Muito bem. Seu progresso e XP foram atualizados.' : 'Compare as saídas, ajuste apenas uma coisa de cada vez e tente novamente.'); ?></p>
        <?php if($validation['error']): ?>
            <p><strong>O que corrigir:</strong> <?php echo e($validation['error']); ?></p>
        <?php else: ?>
            <div class="compare"><div><b>Sua saída</b><pre><?php echo e($validation['output'] ?: '(vazia)'); ?></pre></div><div><b>Saída esperada</b><pre><?php echo e($validation['expected']); ?></pre></div></div>
        <?php endif; ?>
        <?php if(!empty($validation['diagnostic'])): ?><p><strong>Diagnóstico:</strong> <?php echo e($validation['diagnostic']); ?></p><?php endif; ?>
        <?php if($validation['passed'] && isset($nextStep) && $nextStep['exercise']): ?>
            <div class="next-step"><span class="eyebrow">Próximo passo recomendado</span><h3><?php echo e($nextStep['kind'] === 'exercise' ? $nextStep['exercise']->title : $nextStep['lesson']->title); ?></h3><p><?php echo e($nextStep['kind'] === 'exercise' ? 'Continue praticando este assunto.' : 'Você concluiu esta aula. Agora avance para o próximo conceito.'); ?></p>
            <a class="btn btn-primary" data-spa href="<?php echo e(route('lessons.show', [$nextStep['lesson'], $nextStep['exercise']])); ?>#<?php echo e($nextStep['kind'] === 'exercise' ? 'praticar' : 'aprender'); ?>"><?php echo e($nextStep['kind'] === 'exercise' ? 'Próximo exercício' : 'Começar próxima aula'); ?></a></div>
        <?php elseif($validation['passed'] && isset($nextStep) && $nextStep['kind'] === 'complete'): ?>
            <p><strong>Você concluiu todo o percurso publicado. Continue pela área Revisar.</strong></p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
<?php /**PATH D:\projetos\estudo\loop-lab\resources\views\partials\exercise-result.blade.php ENDPATH**/ ?>