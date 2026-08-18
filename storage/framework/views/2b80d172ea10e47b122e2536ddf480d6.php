<?php $__env->startSection('title','PHP Playground'); ?>
<?php $__env->startSection('content'); ?>
<span class="eyebrow">Laboratório</span><h1>PHP Playground</h1><p class="lead">Teste pequenos trechos dos fundamentos. Recursos de arquivos, rede, processos, classes e includes ficam bloqueados neste ambiente local.</p>
<form class="card" method="POST" action="<?php echo e(route('playground.run', absolute: false)); ?>" data-async-form><?php echo csrf_field(); ?><textarea class="editor" name="code" aria-label="Editor do playground" spellcheck="false"><?php echo e(old('code',"<?php\n\n\$nome = 'João';\necho 'Olá, ' . \$nome;")); ?></textarea><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="feedback bad"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><button class="btn btn-primary" type="submit">Executar código</button></form>
<div id="exercise-result"><?php if(session('execution')): ?><?php echo $__env->make('partials.exercise-result', ['execution' => session('execution')], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php endif; ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projetos\estudo\loop-lab\resources\views\playground.blade.php ENDPATH**/ ?>