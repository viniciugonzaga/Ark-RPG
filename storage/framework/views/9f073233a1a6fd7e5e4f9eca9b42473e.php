<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'ARK RPG')); ?> - <?php echo $__env->yieldContent('title', 'Acesso'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-black text-gray-200" style="background-image: radial-gradient(circle at 20% 30%, #0a1a1a 0%, #030808 100%);">
    <div class="min-h-screen flex flex-col">
        
        <header class="py-6 px-4 border-b border-cyan-500/20 bg-black/40 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 relative">
                        <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-full h-full filter brightness-0 invert']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full h-full filter brightness-0 invert']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                    </div>
                    <span class="text-xl font-display font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-300">ARK</span>
                </a>
                <div class="text-xs text-gray-500 uppercase tracking-widest">
                    <span class="text-cyan-400/70">SISTEMA DE ACESSO</span>
                </div>
            </div>
        </header>

        
        <main class="flex-grow flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <?php echo e($slot); ?>

            </div>
        </main>

        
        <footer class="py-4 text-center border-t border-cyan-500/10 bg-black/30">
            <p class="text-[10px] text-gray-500 tracking-widest">
                &copy; <?php echo e(date('Y')); ?> ARK RPG - Terminal de Acesso
            </p>
        </footer>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/layouts/guest.blade.php ENDPATH**/ ?>