<?php $__env->startSection('title', 'Revisar — PHP na Prática'); ?>
<?php $__env->startSection('content'); ?>
<span class="eyebrow">Aprendizado adaptativo</span><h1>Revisar seus erros</h1><p class="lead">Aqui aparecem exercícios que você tentou e ainda não concluiu. Resolva os mais recentes primeiro.</p>
<div class="stack" style="margin-top:28px">
<?php $__empty_1 = true; $__currentLoopData = $exercises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<article class="card course-card" style="margin:0"><div><span class="badge"><?php echo e($exercise->lesson->module->title); ?> · <?php echo e($exercise->difficulty); ?></span><h2><?php echo e($exercise->title); ?></h2><p><?php echo e($exercise->description); ?></p></div><a class="btn btn-primary" href="<?php echo e(route('lessons.show', [$exercise->lesson, $exercise])); ?>#praticar">Tentar novamente</a></article>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<section class="card empty-ranking"><h2>Nenhuma revisão pendente</h2><p>Os exercícios errados aparecerão aqui até serem concluídos.</p></section>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\estudo\loop-lab\resources\views\review.blade.php ENDPATH**/ ?>