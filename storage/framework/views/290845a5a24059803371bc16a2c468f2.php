<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'ARK RPG')); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>?v=2">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        /* ========== VARIÁVEIS ========== */
        :root {
            --black: #0a0a0a;
            --gray-900: #111111;
            --gray-800: #1a1a1a;
            --gray-700: #2a2a2a;
            --white: #f0f0f0;
            --blue-light: #a2ffff;
            --blue-glow: #4deaff;
            --purple-rare: #c084fc;
            
            --grad-dark: linear-gradient(145deg, var(--gray-800), var(--black));
            --grad-card: linear-gradient(135deg, var(--gray-800), var(--gray-900));
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.4);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.5);
            --border-light: 1px solid rgba(182, 219, 254, 0.55);
            --transition: all 0.25s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--black);
            color: var(--white);
            font-family: 'Inter', 'Poppins', system-ui, sans-serif;
            line-height: 1.5;
            overflow-x: hidden;
            position: relative;
        }

        /* ========== PARTÍCULAS DE FUNDO (CANVAS) ========== */
        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        /* ========== ESTILOS BASE ========== */
        .ark-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* Gradiente reflexivo em blocos */
        .ark-card, .ark-panel, .biome-icon, .env-icon, .creature-card, .search-container input, .view-btn, .modal-content, .ficha-container {
            background: var(--grad-dark);
            border: var(--border-light);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        /* Apenas elementos clicáveis têm hover */
        button, .clickable, .view-btn, .biome-icon, .env-icon, .creature-card, .creature-item, .modal-switch-btn, .carousel-control, .carousel-indicator {
            cursor: pointer;
            transition: var(--transition);
        }

        button:hover, .clickable:hover, .view-btn:hover, .biome-icon:hover, .env-icon:hover, .creature-card:hover, .creature-item:hover, .modal-switch-btn:hover, .carousel-control:hover, .carousel-indicator:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 12px rgba(142, 200, 255, 0.4);
            border-color: var(--blue-light);
        }

        /* Textos */
        h1, h2, h3, h4, p, span {
            color: var(--white);
        }
        .text-glow {
            color: var(--blue-light);
            text-shadow: 0 0 6px var(--blue-glow);
        }
        .text-rare {
            color: var(--purple-rare);
            text-shadow: 0 0 4px rgba(192, 132, 252, 0.6);
        }

        /* Botões e inputs */
        input, textarea, select {
            background: var(--gray-800);
            border: var(--border-light);
            color: var(--white);
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }
        input:focus {
            outline: none;
            border-color: var(--blue-light);
            box-shadow: 0 0 8px var(--blue-glow);
        }

        /* Grid responsivo */
        .grid-responsive {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        /* Cards melhorados */
        .creature-card {
            border-radius: 16px;
            overflow: hidden;
            background: var(--grad-card);
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .card-image {
            height: 180px;
            overflow: hidden;
            background: var(--gray-900);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .creature-card:hover .card-image img {
            transform: scale(1.05);
        }
        .card-name {
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            background: rgba(0,0,0,0.5);
            border-top: var(--border-light);
        }

       
        /* ========== FOOTER COM EFEITO VÍRUS (MOUSE TRACKING) ========== */
        footer {
            position: relative;
            background: linear-gradient(145deg, #111, #050505);
            border-top: var(--border-light);
            margin-top: 2rem;
            overflow: hidden;
            z-index: 2;
        }
        /* Camada de efeito que segue o mouse */
        .footer-virus-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        .virus-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(142, 253, 255, 0.2) 0%, rgba(7, 31, 53, 0) 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: transform 0.05s linear;
            will-change: transform;
        }
        .virus-lines {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(45deg, rgba(12, 50, 56, 0.1) 0px, rgba(142, 255, 240, 0.1) 2px, transparent 2px, transparent 8px);
            mask: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), black 20%, transparent 80%);
            -webkit-mask: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), black 20%, transparent 80%);
        }
        /* Conteúdo do footer fica acima do efeito */
        .footer-content {
            position: relative;
            z-index: 2;
            padding: 2rem 1rem;
            text-align: center;
        }
        .footer-content p, .footer-content span {
            color: #ffffff;
        }
        .footer-content .highlight {
            color: var(--blue-light);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .ark-container { padding: 1rem; }
            .grid-responsive { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
            .carousel-control { width: 32px; height: 32px; }
        }
    </style>
</head>
<body>

    <canvas id="particles-canvas"></canvas>

    <?php if (isset($component)) { $__componentOriginal50a73e7d57605f77e4f417026f0ee281 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50a73e7d57605f77e4f417026f0ee281 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-screen','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-screen'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal50a73e7d57605f77e4f417026f0ee281)): ?>
<?php $attributes = $__attributesOriginal50a73e7d57605f77e4f417026f0ee281; ?>
<?php unset($__attributesOriginal50a73e7d57605f77e4f417026f0ee281); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal50a73e7d57605f77e4f417026f0ee281)): ?>
<?php $component = $__componentOriginal50a73e7d57605f77e4f417026f0ee281; ?>
<?php unset($__componentOriginal50a73e7d57605f77e4f417026f0ee281); ?>
<?php endif; ?>

    <div class="min-h-screen flex flex-col">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php if(isset($header)): ?>
            <header class="ark-header shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl leading-tight"><?php echo e($header); ?></h2>
                </div>
            </header>
        <?php endif; ?>

        <main class="flex-grow flex flex-col">
            <div class="ark-container">
                <?php echo e($slot); ?>

            </div>
        </main>

        
        <footer>
            <div class="footer-virus-effect">
                <div class="virus-glow" id="virusGlow"></div>
                <div class="virus-lines" id="virusLines"></div>
            </div>
            <div class="footer-content">
                <div class="flex justify-center gap-6 mb-4 flex-wrap">
                    <span class="text-sm uppercase tracking-wider">Ark-Rpg</span>
                    <span class="text-sm uppercase tracking-wider">VERSÃO 2.6.7</span>
                </div>
                <p class="text-xs uppercase tracking-wider">
                    &copy; <?php echo e(date('Y')); ?> ARK RPG — 
                    <span class="highlight">Todos os direitos reservados</span>
                </p>
                <div class="mt-3 text-[10px] text-gray-400 tracking-widest">
                    SISTEMA RPG-ARK v2.6.7
                </div>
            </div>
        </footer>

        
        <div id="animacaoDado" class="ark-panel" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; padding: 2rem 3rem; text-align: center; background: #000000cc; backdrop-filter: blur(8px); border: var(--border-light); border-radius: 20px;">
            <div class="text-4xl mb-2 text-blue-300" id="dadoResultado"></div>
            <div class="tracking-[0.2em] uppercase text-blue-200">Sincronizando Dados...</div>
        </div>
        <audio id="somDado" src="/sons/dado.mp3" preload="auto"></audio>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        (function() {
            // ========== PARTÍCULAS DE FUNDO ==========
            const canvas = document.getElementById('particles-canvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            const PARTICLE_COUNT = 180;

            function resizeCanvas() {
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width = width;
                canvas.height = height;
            }

            function initParticles() {
                particles = [];
                for (let i = 0; i < PARTICLE_COUNT; i++) {
                    particles.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        radius: Math.random() * 2 + 1,
                        speedY: Math.random() * 1.2 + 0.4,
                        alpha: Math.random() * 0.6 + 0.2,
                        colorShift: Math.random() // 0 a 1, controla gradiente branco->azul
                    });
                }
            }

            function drawParticles() {
                if (!ctx) return;
                ctx.clearRect(0, 0, width, height);
                for (let p of particles) {
                    // Atualiza posição (sobe)
                    p.y -= p.speedY;
                    if (p.y < 0) {
                        p.y = height;
                        p.x = Math.random() * width;
                    }
                    // Quanto mais alto (menor Y), mais azul
                    const progress = 1 - (p.y / height); // 0 em baixo, 1 no topo
                    const r = 255;
                    const g = 255 - (progress * 100); // diminui verde
                    const b = 255 - (progress * 50);
                    // Branco (255,255,255) no início, azul claro (180,220,255) no topo
                    const finalR = 255;
                    const finalG = 255 - progress * 80;
                    const finalB = 255 - progress * 40;
                    ctx.fillStyle = `rgba(${finalR}, ${finalG}, ${finalB}, ${p.alpha})`;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    ctx.fill();
                }
                requestAnimationFrame(drawParticles);
            }

            window.addEventListener('resize', () => {
                resizeCanvas();
                initParticles();
            });
            resizeCanvas();
            initParticles();
            drawParticles();

            // ========== EFEITO VÍRUS NO FOOTER (SEGUE O MOUSE) ==========
            const footer = document.querySelector('footer');
            const virusGlow = document.getElementById('virusGlow');
            const virusLines = document.getElementById('virusLines');
            
            function updateVirusEffect(e) {
                if (!footer) return;
                const rect = footer.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;
                const mouseY = e.clientY - rect.top;
                if (mouseX >= 0 && mouseX <= rect.width && mouseY >= 0 && mouseY <= rect.height) {
                    virusGlow.style.transform = `translate(${mouseX}px, ${mouseY}px) translate(-50%, -50%)`;
                    virusLines.style.setProperty('--mouse-x', `${mouseX}px`);
                    virusLines.style.setProperty('--mouse-y', `${mouseY}px`);
                    virusGlow.style.opacity = '1';
                    virusLines.style.opacity = '1';
                } else {
                    virusGlow.style.opacity = '0';
                    virusLines.style.opacity = '0';
                }
            }

        
            document.addEventListener('mousemove', updateVirusEffect);
            // Garantir que o efeito só funcione dentro do footer
        })();
              setInterval(() => {
        fetch('/ping', { credentials: 'same-origin' })
        .then(response => response.json())
        .catch(err => console.warn('Keep-alive falhou', err));
        }, 300000); // 5 minutos
    </script>

    
    <style>
        #particles-canvas { position: fixed; top: 0; left: 0; z-index: 0; }
        .ark-container, .ark-header, nav, footer { position: relative; z-index: 2; background-color: transparent; }
        /* Para que os gradientes apareçam, mantemos o fundo escuro nos elementos, mas o canvas por baixo */
        body { background: var(--black); }
        .ark-card, .ark-panel, .creature-card, .modal-content { background: var(--grad-dark) !important; backdrop-filter: blur(0px); }
        /* Garantir que textos não fiquem transparentes */
        .text-glow, .text-rare { background: transparent; }
        /* Corrigir botões de carrossel */
        .carousel-control svg { filter: drop-shadow(0 0 2px rgba(142, 234, 255, 0.5)); }
    </style>
</body>
</html><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/layouts/app.blade.php ENDPATH**/ ?>