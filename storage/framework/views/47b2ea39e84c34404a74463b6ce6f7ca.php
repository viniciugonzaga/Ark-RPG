
<div id="global-loader" class="fixed inset-0 z-[10000] bg-black flex flex-col items-center justify-center transition-opacity duration-700" 
     style="background: radial-gradient(circle at center, #0a1a1a 0%, #000000 100%);">
    
    <div class="relative">
        
        <div class="w-32 h-32 relative">
            <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-full h-full text-cyan-400 filter drop-shadow-[0_0_15px_rgba(0,242,255,0.5)]','style' => 'filter: brightness(0) invert(1);']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full h-full text-cyan-400 filter drop-shadow-[0_0_15px_rgba(0,242,255,0.5)]','style' => 'filter: brightness(0) invert(1);']); ?>
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
            
            
            <div class="absolute inset-0 rounded-full bg-cyan-500/20 blur-xl animate-pulse"></div>
        </div>
        
        
        <div class="absolute -inset-6 rounded-full border border-cyan-500/30 animate-spin-slow"></div>
        <div class="absolute -inset-10 rounded-full border border-cyan-500/10"></div>
    </div>
    
    
    <div class="mt-8 flex items-center gap-3">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
        </span>
        <p class="text-xs text-cyan-300 tracking-[0.3em] uppercase font-medium">Sincronizando Dados do Ark</p>
    </div>
    
    
    <div class="mt-6 w-48 h-0.5 bg-gray-800 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r from-cyan-400 to-blue-500 w-1/2 animate-loading-bar"></div>
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 700);
        }
    });
</script>

<style>
    @keyframes loading-bar {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
    .animate-loading-bar {
        animation: loading-bar 1.5s ease-in-out infinite;
    }
    
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 6s linear infinite;
    }
</style><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/components/loading-screen.blade.php ENDPATH**/ ?>