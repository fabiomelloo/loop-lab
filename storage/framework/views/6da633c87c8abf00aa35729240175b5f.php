<?php $__env->startSection('title', $lesson->title.' — PHP na Prática'); ?>
<?php $__env->startSection('content'); ?>
<?php
    $currentIndex = $lesson->exercises->search(fn ($item) => $item->is($exercise));
?>

<span class="eyebrow"><?php echo e($lesson->module->title); ?> · Aula</span>
<h1><?php echo e($lesson->title); ?></h1>
<p class="lead"><?php echo e($lesson->summary); ?></p>

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
        <article class="card learning-intro"><h3>O que você vai aprender</h3><p><?php echo e($lesson->content['learn']); ?></p></article>
        <article class="card learning-intro"><h3>Em palavras simples</h3><p><?php echo e($lesson->content['explanation']); ?></p></article>
    </div>

    <div class="learning-grid learning-code">
        <article class="card"><h3>Sintaxe básica</h3><pre class="code"><code><?php echo e($lesson->content['syntax']); ?></code></pre></article>
        <article class="card"><h3>Exemplo simples</h3><pre class="code"><code><?php echo e($lesson->content['example']); ?></code></pre></article>
    </div>

    <details class="card lesson-detail">
        <summary>Entender o exemplo linha por linha</summary>
        <ol class="line-list"><?php $__currentLoopData = $lesson->content['lines']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($line); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ol>
    </details>

    <?php if($lesson->slug === 'loop-for'): ?>
    <details class="card lesson-detail">
        <summary>Ver a execução passo a passo</summary>
        <div class="step"><strong>Passo 1</strong><span><code>$i = 1</code>; 1 ≤ 3 é verdadeiro; mostra 1.</span></div>
        <div class="step"><strong>Passo 2</strong><span><code>$i = 2</code>; 2 ≤ 3 é verdadeiro; mostra 2.</span></div>
        <div class="step"><strong>Passo 3</strong><span><code>$i = 3</code>; 3 ≤ 3 é verdadeiro; mostra 3.</span></div>
        <div class="step"><strong>Fim</strong><span><code>$i = 4</code>; 4 ≤ 3 é falso; o loop termina.</span></div>
        <div class="warning"><strong>O que aconteceu?</strong> Depois de cada saída, <code>$i++</code> aumentou o contador. A condição foi conferida novamente.</div>
    </details>
    <?php endif; ?>

    <details class="card lesson-detail">
        <summary>Exemplo prático e erros comuns</summary>
        <h3>Exemplo prático</h3><pre class="code"><code><?php echo e($lesson->content['real_example']); ?></code></pre>
        <h3>Erros comuns</h3><ul><?php $__currentLoopData = $lesson->content['common_errors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
    </details>
</section>

<section id="praticar" class="lesson-section practice-section">
    <div class="section-heading">
        <span class="section-number">2</span>
        <div><span class="eyebrow">Agora é sua vez</span><h2>Praticar com exercícios</h2><p>Resolva na ordem: o próximo exercício reutiliza o raciocínio do anterior.</p></div>
    </div>

    <nav class="exercise-list" aria-label="Exercícios desta aula">
        <?php $__currentLoopData = $lesson->exercises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="exercise-item <?php echo e($item->is($exercise) ? 'active' : ''); ?>" data-spa data-exercise-id="<?php echo e($item->id); ?>" href="<?php echo e(route('lessons.show', [$lesson, $item])); ?>#praticar" <?php if($item->is($exercise)): ?> aria-current="step" <?php endif; ?>>
            <span class="exercise-status"><?php echo e(in_array($item->id, $completedExerciseIds) ? '✓' : $item->position); ?></span>
            <span><strong><?php echo e($item->title); ?></strong><small><?php echo e($item->difficulty); ?> · <?php echo e($item->xp); ?> XP <?php if($item->is($exercise)): ?><b>· AGORA</b><?php endif; ?></small></span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <div class="exercise-workspace">
        <article class="exercise-brief">
            <div class="exercise-kicker"><span>Exercício <?php echo e($currentIndex + 1); ?> de <?php echo e($lesson->exercises->count()); ?></span><span class="badge"><?php echo e($exercise->difficulty); ?></span></div>
            <h2><?php echo e($exercise->title); ?></h2>
            <div class="task-box"><span class="task-label">O que fazer</span><p><?php echo e($exercise->description); ?></p></div>
            <div class="rules-box"><h3>Regras</h3><ul><?php $__currentLoopData = $exercise->rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($rule); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
            <p class="workflow-tip"><strong>Como resolver:</strong> escreva o código, clique em Executar para conferir a saída e, quando estiver pronto, clique em Validar resposta.</p>
        </article>

        <form class="editor-card" method="POST" data-async-form data-starter-code="<?php echo e(base64_encode($exercise->starter_code)); ?>">
            <?php echo csrf_field(); ?>
            <div class="editor-heading"><div><span class="editor-dot"></span><span class="editor-dot"></span><span class="editor-dot"></span></div><strong><?php echo e($exercise->type === 'prediction' ? 'Escolha sua resposta' : 'solucao.php'); ?></strong></div>
            <?php if($exercise->type === 'prediction'): ?>
                <div style="padding:22px;background:#fff"><?php $__currentLoopData = $exercise->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><label class="exercise-item" style="margin-bottom:10px"><input type="radio" name="code" value="<?php echo e($value); ?>" required> <strong><?php echo e($value); ?>) <?php echo e($label); ?></strong></label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
            <?php else: ?>
                <label class="sr-only" for="code-editor">Seu código PHP</label>
                <textarea id="code-editor" class="editor" name="code" spellcheck="false" aria-describedby="editor-help"><?php echo e(old('code', $exercise->starter_code)); ?></textarea>
                <p id="editor-help" class="editor-help">Dica: use Tab para indentar. Seu rascunho é salvo automaticamente neste navegador.</p>
            <?php endif; ?>
            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="feedback bad" role="alert"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="editor-actions">
                <div class="actions-secondary">
                    <?php if($exercise->type !== 'prediction'): ?><button type="submit" class="btn btn-secondary" formaction="<?php echo e(route('exercises.run', $exercise, absolute: false)); ?>">Executar código</button><?php endif; ?>
                    <a class="btn btn-quiet" data-reset-editor href="<?php echo e(route('lessons.show', [$lesson, $exercise])); ?>#praticar">Resetar</a>
                </div>
                <button type="submit" class="btn btn-primary" formaction="<?php echo e(route('exercises.validate', $exercise, absolute: false)); ?>">Validar resposta</button>
            </div>
        </form>
    </div>

    <div id="exercise-result">
        <?php if(session('execution')): ?>
            <?php echo $__env->make('partials.exercise-result', ['execution' => session('execution')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif(session('validation')): ?>
            <?php echo $__env->make('partials.exercise-result', ['validation' => session('validation'), 'nextStep' => $nextStep, 'lesson' => $lesson], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    </div>

    <section class="help-card">
        <div><span class="eyebrow">Travou?</span><h2>Ajuda gradual</h2><p>Abra uma dica de cada vez. A solução fica por último.</p></div>
        <div class="hints">
            <?php $__currentLoopData = $exercise->hints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><details><summary>Dica <?php echo e($index + 1); ?></summary><p><?php echo e($hint); ?></p></details><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <details class="solution"><summary>Ver uma solução possível</summary><div class="warning">Tente resolver sozinho antes. Mais de uma solução pode estar correta.</div><pre class="code"><code><?php echo e($exercise->solution); ?></code></pre><p><?php echo e($exercise->explanation); ?></p></details>
        </div>
    </section>
    <p class="security-note">Ambiente local restrito: timeout de 2 s, memória limitada e funções perigosas bloqueadas.</p>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\estudo\loop-lab\resources\views/lesson.blade.php ENDPATH**/ ?>