
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
     <?php $__env->slot('title', null, []); ?> Manual do Sobrevivente - ARK RPG <?php $__env->endSlot(); ?>
    <meta property="og:title" content="ARK RPG - Manual do Sobrevivente" />
    <meta property="og:description" content="Regras completas do sistema ARK RPG: combate, atributos, mutações e sobrevivência. Baixe o PDF oficial." />
    <meta property="og:image" content="<?php echo e(asset('images/capa_regras.png')); ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ARK RPG - Manual do Sobrevivente" />
    <meta name="twitter:description" content="Regras completas do sistema ARK RPG. Baixe o PDF oficial." />
    <meta name="twitter:image" content="<?php echo e(asset('images/capa_regras.png')); ?>" />

    
    <div class="fixed inset-0 z-0">
        <img src="<?php echo e(asset('images/fundo_regras.png')); ?>" alt="Background Regras" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    
    <div class="relative z-10 min-h-screen flex items-center justify-center py-12">
        <div class="max-w-5xl mx-auto px-6 w-full">
            
            
            <div class="ark-panel-glossy p-8 md:p-12 text-center border border-cyan-500/30 shadow-[0_0_40px_rgba(0,242,255,0.2)] bg-black/40 backdrop-blur-sm rounded-2xl relative overflow-hidden">
                
                
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>
                
                
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-900/30 to-blue-900/30 rounded-2xl flex items-center justify-center border border-cyan-500/40 shadow-[0_0_15px_rgba(0,242,255,0.3)]">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v6h6" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl md:text-5xl font-medieval font-black uppercase tracking-widest mb-4 drop-shadow-[0_0_10px_rgba(0,242,255,0.5)]">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-blue-300">
                        Manual do Sobrevivente
                    </span>
                </h1>
                
                
                <div class="w-32 h-1 bg-cyan-400 shadow-[0_0_8px_cyan] mx-auto mb-8"></div>

                <p class="text-gray-300 mb-8 text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
                    Este documento contém todas as regras do sistema <span class="text-cyan-400 font-bold">ARK RPG</span>. 
                    Leia com atenção para compreender combate, atributos, mutações e sobrevivência.
                </p>

                
                <div class="bg-black/50 border border-cyan-500/20 rounded-xl p-6 mb-10 inline-block w-full max-w-md backdrop-blur-sm hover:border-cyan-400/60 transition-all duration-300">
                    <p class="text-[11px] text-cyan-300 uppercase tracking-wider mb-1 flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.255 0 2.443.29 3.5.804v-10zM13.5 4c-1.255 0-2.443.29-3.5.804v10c1.057-.514 2.245-.804 3.5-.804 1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0013.5 4z"/></svg>
                        Versão do Documento
                    </p>
                    <p class="text-white font-bold text-lg tracking-wide">
                        ARK RPG - Manual Oficial v1.0
                    </p>
                </div>

                
                <div class="mt-2">
                    <a href="<?php echo e(route('regras.download')); ?>"
                       class="ark-btn-glitch inline-flex items-center gap-3 px-10 py-4 text-base no-underline group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Baixar Agora (PDF)
                    </a>
                </div>

                
                <p class="text-[9px] text-gray-500 mt-8 uppercase tracking-wider">
                    Sistema de regras atualizado em <?php echo e(now()->format('d/m/Y')); ?>

                </p>
            </div>
        </div>
    </div>

    
    <style>
        @keyframes scan-line {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-scan-line {
            animation: scan-line 3s linear infinite;
        }
        /* Garante que o painel glossy herde os estilos globais */
        .ark-panel-glossy {
            background: linear-gradient(165deg, rgba(26,26,26,0.9) 0%, rgba(10,10,10,0.8) 100%);
            backdrop-filter: blur(4px);
        }
        /* Ajuste para o botão glitch (caso não esteja definido globalmente) */
        .ark-btn-glitch {
            background: #000;
            border: 2px solid #98effb;
            border-radius: 50px;
            color: #fff;
            font-weight: 900;
            letter-spacing: 3px;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(127, 237, 254, 0.3);
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .ark-btn-glitch:hover {
            background: #91ecfc;
            color: #000;
            box-shadow: 0 0 30px rgba(37, 233, 233, 0.7);
            transform: translateY(-3px);
        }
        .ark-btn-glitch:hover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 242, 255, 0.2);
            pointer-events: none;
            animation: glitchFlash 0.2s infinite;
        }
        @keyframes glitchFlash {
            0% { opacity: 0; transform: skew(0deg); }
            20% { opacity: 0.6; transform: skew(2deg); }
            40% { opacity: 0; transform: skew(-2deg); }
            100% { opacity: 0; transform: skew(0deg); }
        }
        .font-medieval {
            font-family: 'Cinzel', serif;
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/regras/index.blade.php ENDPATH**/ ?>