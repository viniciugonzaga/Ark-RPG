
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
     <?php $__env->slot('title', null, []); ?> Home - RPG ARK <?php $__env->endSlot(); ?>

    
    <div class="fixed inset-0 z-0">
        <img src="<?php echo e(asset('images/Imagem_fundo_welcome.png')); ?>" alt="Background" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    
    <div class="relative z-10 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-7xl mx-auto px-6 lg:px-12 py-10">
            
            
            <div class="grid grid-cols-1 lg:grid-cols-[2fr,3fr] gap-8 items-stretch">
                
                
                <div class="flex flex-col space-y-6">
                    
                    
                    <div class="ark-panel-glossy p-10 flex flex-col items-center justify-center flex-grow text-center">
                        
                        
                        <h1 class="text-4xl md:text-5xl font-medieval font-black uppercase tracking-widest mb-4">
                            <span class="text-metallic drop-shadow-[0_0_15px_rgba(224,247,255,0.8)]">
                                Bem Vindo
                            </span>
                        </h1>
                        
                        
                        <div class="w-32 h-1 bg-cyan-300 shadow-[0_0_10px_#7fd4ff] mb-8"></div>

                        <div class="space-y-6">
                            <p class="text-3xl md:text-4xl font-medieval font-bold text-white leading-tight">
                                Você não é apenas um sobrevivente.
                            </p>
                            
                            
                            <p class="text-xl md:text-2xl font-medieval flex flex-col items-center justify-center gap-y-4 text-gray-300">
                                <span>É o autor da sua própria brutalidade no</span>
                                <img src="<?php echo e(asset('images/logo_ark_pequena.png')); ?>" alt="ARK" 
                                     class="h-10 md:h-14 w-auto drop-shadow-[0_0_12px_rgba(78,233,247,0.7)] mt-2">
                            </p>
                        </div>
                    </div>

                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('register')); ?>" class="ark-btn-neon px-12 py-4 text-lg">
                                Faça seu Cadastro
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('fichas.index')); ?>" class="ark-btn-neon px-12 py-4 text-lg">
                                Acessar Fichas
                            </a>
                        <?php endif; ?>

                        
                        <a href="<?php echo e(route('jogo')); ?>" class="ark-btn-neon px-12 py-4 text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Jogar Dino
                        </a>
                    </div>
                </div>

                
                <div class="flex items-stretch">
                    <div x-data="carousel()" x-init="init()" 
                         class="relative w-full rounded-[2.5rem] overflow-hidden border border-blue-200/50 shadow-[0_0_40px_rgba(78,233,247,0.2)] bg-black/40 backdrop-blur-md">
                        
                        
                        <div class="relative w-full h-full">
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="current === index" 
                                     x-transition:enter="transition ease-out duration-700"
                                     x-transition:enter-start="opacity-0 scale-105"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-300"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="absolute inset-0">
                                    <img :src="slide.src" :alt="slide.alt" 
                                         class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>

                        
                        <button @click="prev()" class="nav-btn left-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="next()" class="nav-btn right-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>

                        
                        <div class="absolute bottom-6 w-full flex justify-center gap-2">
                            <template x-for="(slide, idx) in slides" :key="idx">
                                <button @click="current = idx"
                                        class="h-1.5 rounded-full transition-all duration-300"
                                        :class="current === idx ? 'w-8 bg-blue-200 shadow-[0_0_8px_#007bff]' : 'w-2 bg-white/20'"></button>
                            </template>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        /* Painel com reflexo metálico (Glossy) */
        .ark-panel-glossy {
            background: linear-gradient(165deg, #1a1a1a 0%, #0a0a0a 50%, #000000 100%);
            border: 1px solid rgba(114, 255, 246, 0.4);
            border-top: 2px solid rgba(15, 247, 255, 0.3);
            border-radius: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.9), 0 0 20px rgba(78, 233, 247, 0.15);
        }

        .ark-panel-glossy::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 45%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 0%, transparent 100%);
            pointer-events: none;
        }

        .text-metallic {
            background: linear-gradient(to bottom, #ffffff 0%, #b0e0e6 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));
        }

        .ark-btn-neon {
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
        }

        .ark-btn-neon:hover {
            background: #91ecfc;
            color: #000;
            box-shadow: 0 0 30px rgba(37, 233, 233, 0.7);
            transform: translateY(-3px);
        }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.7);
            border: 1px solid rgba(69, 246, 255, 0.3);
            color: #fff;
            padding: 12px;
            border-radius: 50%;
            transition: all 0.2s;
            z-index: 20;
        }

        .nav-btn:hover {
            background: #9df4fa;
            color: #000;
        }
    </style>

    <script>
        function carousel() {
            return {
                current: 0,
                interval: null,
                slides: [
                    { src: "<?php echo e(asset('images/Gif_carrossel.gif')); ?>", alt: "Ação" },
                    { src: "<?php echo e(asset('images/Imagem2_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem3_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem4_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem5_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem6_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem7_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem8_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem9_carrossel.png')); ?>", alt: "Cenário" },
                    { src: "<?php echo e(asset('images/Imagem10_carrossel.png')); ?>", alt: "Cenário" },
                ],
                init() {
                    this.startAutoPlay();
                },
                startAutoPlay() {
                    this.stopAutoPlay();
                    this.interval = setInterval(() => {
                        this.next();
                    }, 5000);
                },
                stopAutoPlay() {
                    if (this.interval) clearInterval(this.interval);
                },
                next() {
                    this.current = (this.current + 1) % this.slides.length;
                },
                prev() {
                    this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                }
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/welcome.blade.php ENDPATH**/ ?>