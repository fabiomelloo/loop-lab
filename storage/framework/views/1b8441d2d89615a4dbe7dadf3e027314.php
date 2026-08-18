<?php $__env->startSection('title', 'Ranking — PHP na Prática'); ?>
<?php $__env->startSection('content'); ?>
<span class="eyebrow">Comunidade</span><h1>Ranking de estudantes</h1><p class="lead">A classificação considera XP, exercícios concluídos e atividade recente. Tentativas aparecem para acompanhar quem está praticando.</p>

<section class="card" style="margin:28px 0">
    <div class="course-card" style="margin:0">
        <div><h2>Seu perfil</h2><p>Escolha o nome que aparecerá para os outros estudantes.</p></div>
        <form class="profile-form" method="POST" action="<?php echo e(route('profile.update', absolute: false)); ?>" data-profile-form>
            <?php echo csrf_field(); ?><div><label for="display_name">Nome no ranking</label><input id="display_name" name="display_name" value="<?php echo e(old('display_name', $learner->display_name)); ?>" maxlength="30" required></div>
            <button class="btn btn-primary" type="submit">Salvar nome</button>
        </form>
    </div>
    <div id="profile-feedback" aria-live="polite"><?php $__errorArgs = ['display_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="feedback bad"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
</section>

<div class="grid stats">
    <div class="card stat"><span>Sua posição</span><strong><?php echo e($currentPosition ? '#'.$currentPosition : '—'); ?></strong></div>
    <div class="card stat"><span>Seu XP</span><strong><?php echo e($stats['xp']); ?></strong></div>
    <div class="card stat"><span>Concluídos</span><strong><?php echo e($stats['completed']); ?></strong></div>
</div>

<section class="card" style="padding:0;overflow:hidden"><table class="ranking-table"><thead><tr><th>Posição</th><th>Estudante</th><th>XP</th><th>Concluídos</th><th>Tentativas</th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr class="<?php echo e($entry->learner_key === $learner->learner_key ? 'current' : ''); ?>"><td class="rank-position">#<?php echo e($entry->position); ?></td><td class="rank-name"><?php echo e($entry->display_name); ?><?php if($entry->learner_key === $learner->learner_key): ?><span class="rank-you">VOCÊ</span><?php endif; ?></td><td><?php echo e($entry->xp); ?> XP</td><td><?php echo e($entry->completed); ?></td><td><?php echo e($entry->attempts); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td class="empty-ranking" colspan="5">Valide seu primeiro exercício para entrar no ranking.</td></tr><?php endif; ?>
</tbody></table></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\estudo\loop-lab\resources\views\ranking.blade.php ENDPATH**/ ?>