<?php $__env->startSection('title','Dashboard — PHP na Prática'); ?>
<?php $__env->startSection('content'); ?>
<span class="eyebrow">Continue aprendendo</span><h1>Construa sua lógica em PHP</h1><p class="lead">Leia a ideia, preveja o resultado e escreva sua própria solução. Aqui, errar faz parte do treino.</p>
<div class="grid stats">
    <div class="card stat"><span>Exercícios concluídos</span><strong><?php echo e($stats['completed']); ?></strong></div>
    <div class="card stat"><span>Experiência</span><strong><?php echo e($stats['xp']); ?> XP</strong></div>
    <div class="card stat"><span>Tentativas</span><strong><?php echo e($stats['attempts']); ?></strong></div>
</div>
<section class="card course-card"><div><span class="badge">Módulo 03 · Loops</span><h2><?php echo e($lesson->title); ?></h2><p><?php echo e($lesson->summary); ?></p><div class="bar"><span style="width:<?php echo e($stats['percent']); ?>%"></span></div></div><a class="btn btn-primary" href="<?php echo e(route('lessons.show',$lesson)); ?>">Continuar aula</a></section>
<section style="margin-top:32px"><h2>Como estudar por aqui</h2><div class="grid"><article class="card"><strong>1. Entenda</strong><p>Leia a explicação e acompanhe o código linha por linha.</p></article><article class="card"><strong>2. Tente</strong><p>Escreva sem copiar. Use as dicas apenas quando travar.</p></article><article class="card"><strong>3. Valide</strong><p>Execute os testes, leia o feedback e ajuste sua solução.</p></article></div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\estudo\loop-lab\resources\views\dashboard.blade.php ENDPATH**/ ?>