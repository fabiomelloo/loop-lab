<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($mode === 'cadastro' ? 'Criar conta' : 'Entrar'); ?> — PHP na Prática</title>
    <style>
        body {
            margin: 0;
            display: grid;
            place-items: center;
            min-height: 100vh;
            background: #f4f7fb;
            color: #172033;
            font: 16px/1.6 Arial;
        }

        .box {
            width: min(440px, calc(100% - 32px));
            padding: 30px;
            border: 1px solid #dbe3ef;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 16px 45px rgba(20, 38, 70, 0.08);
        }

        h1 {
            margin: 0 0 6px;
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: 700;
        }

        input, button {
            width: 100%;
            min-height: 48px;
            padding: 10px 12px;
            border-radius: 10px;
            font: inherit;
            box-sizing: border-box;
        }

        input {
            border: 1px solid #cbd5e1;
        }

        button {
            margin-top: 22px;
            border: 0;
            background: #2563eb;
            color: #fff;
            font-weight: 800;
            cursor: pointer;
        }

        .error {
            color: #b42318;
        }

        a {
            color: #1d4ed8;
        }
    </style>
</head>
<body>
    <main class="box">
        <h1><?php echo e($mode === 'cadastro' ? 'Criar sua conta' : 'Bem-vindo de volta'); ?></h1>
        <p>Salve seu progresso e continue em qualquer dispositivo.</p>

        <form method="POST" action="<?php echo e($mode === 'cadastro' ? route('register', absolute: false) : route('login.submit', absolute: false)); ?>">
            <?php echo csrf_field(); ?>

            <?php if($mode === 'cadastro'): ?>
                <label for="name">Nome</label>
                <input id="name" name="name" value="<?php echo e(old('name')); ?>" required>
            <?php endif; ?>

            <label for="email">E-mail</label>
            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required>

            <label for="password">Senha</label>
            <input id="password" name="password" type="password" required>

            <?php if($mode === 'cadastro'): ?>
                <label for="password_confirmation">Confirmar senha</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            <?php endif; ?>

            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="error"><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <button><?php echo e($mode === 'cadastro' ? 'Criar conta' : 'Entrar'); ?></button>
        </form>

        <p>
            <?php if($mode === 'cadastro'): ?>
                Já possui conta? <a href="<?php echo e(route('login')); ?>">Entrar</a>
            <?php else: ?>
                Ainda não possui conta? <a href="<?php echo e(route('login', ['mode' => 'cadastro'])); ?>">Criar conta</a>
            <?php endif; ?>
        </p>

        <a href="<?php echo e(route('dashboard')); ?>">Continuar sem conta</a>
    </main>
</body>
</html>
<?php /**PATH D:\projetos\estudo\loop-lab\resources\views\auth.blade.php ENDPATH**/ ?>