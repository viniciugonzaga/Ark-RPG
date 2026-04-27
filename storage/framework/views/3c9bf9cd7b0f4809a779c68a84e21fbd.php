
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
     <?php $__env->slot('title', null, []); ?> Mesa do Mestre - ARK RPG <?php $__env->endSlot(); ?>

    
    <div class="fixed inset-0 -z-10">
        <img src="<?php echo e(asset('images/fundo_mesa.png')); ?>" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>
    
    <canvas id="particles-canvas" class="fixed inset-0 z-0 pointer-events-none"></canvas>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        :root {
            --theme-primary: #00f2ff;
            --theme-secondary: #4deaff;
            --theme-glow: rgba(0, 242, 255, 0.5);
            --theme-border: rgba(0, 242, 255, 0.3);
            --theme-panel-bg: rgba(0, 242, 255, 0.05);
        }

        .theme-text-primary { color: var(--theme-primary); }
        .theme-border-primary { border-color: var(--theme-primary); }
        .theme-bg-panel { background-color: var(--theme-panel-bg); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scan-line {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; opacity: 0; }
        .animate-scan-line { animation: scan-line 3s linear infinite; }

        .ark-panel {
            @apply bg-black/40 backdrop-blur-md shadow-xl;
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
            transition: all 0.3s ease;
        }

        .ark-input {
            @apply bg-black/60 border border-cyan-500/30 text-white rounded-sm px-4 py-2.5 transition-all duration-300 font-mono text-sm;
        }
        .ark-input:focus {
            @apply border-cyan-400 shadow-[0_0_15px_rgba(0,242,255,0.3)] outline-none bg-black/80;
        }

        .btn-neon {
            @apply relative px-6 py-2 text-sm font-black uppercase tracking-[0.2em] transition-all duration-300 overflow-hidden;
            background: rgba(0,0,0,0.7);
            border: 1px solid var(--theme-primary);
            color: var(--theme-primary);
            box-shadow: 0 0 12px var(--theme-glow);
            border-radius: 40px;
        }
        .btn-neon:hover {
            background: var(--theme-primary);
            color: #000;
            box-shadow: 0 0 25px var(--theme-glow);
            transform: translateY(-2px);
        }

        /* Estilo para o código da mesa */
        .code-block {
            background: rgba(0,0,0,0.6);
            border: 1px solid var(--theme-border);
            border-radius: 12px;
            padding: 12px 16px;
            font-family: monospace;
            font-size: 1.5rem;
            letter-spacing: 4px;
            text-align: center;
            color: var(--theme-primary);
            text-shadow: 0 0 5px currentColor;
        }
        .btn-copy {
            background: rgba(0,0,0,0.5);
            border: 1px solid var(--theme-border);
            border-radius: 40px;
            padding: 8px 20px;
            font-size: 0.75rem;
            transition: all 0.2s;
        }
        .btn-copy:hover {
            background: var(--theme-primary);
            color: black;
            border-color: var(--theme-primary);
            transform: scale(1.02);
        }
        .toast-copy {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            border: 1px solid var(--theme-primary);
            color: var(--theme-primary);
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 12px;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
    </style>

    <div class="relative z-10 max-w-7xl mx-auto p-6 space-y-8 text-white">
        
        <div class="ark-panel p-6 text-center relative overflow-hidden animate-fadeInUp">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>
            <h1 class="text-3xl font-medieval font-black theme-text-primary">Mesa do Mestre</h1>
            <p class="text-gray-300 mt-2">Aqui você pode criar uma mesa de sessão, procurar jogadores pelo ID de Cristal e também rolar dados como um jogador. Compartilhe o código da mesa com seus amigos para eles entrarem na sessão.</p>
        </div>

        
        <?php if(isset($mesaCode) && $mesaCode): ?>
        <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.05s">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-medieval font-bold theme-text-primary">Código da Mesa Ativa</h2>
                    <p class="text-xs text-gray-400">Compartilhe este código com seus jogadores.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="code-block" id="mesa-code"><?php echo e($mesaCode); ?></div>
                    <button id="copy-code-btn" class="btn-copy flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copiar
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-8">
            
            <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.1s">
                <h2 class="text-xl font-medieval font-bold theme-text-primary mb-4">Procurar Jogador</h2>
                <div class="flex gap-2">
                    <input type="text" id="crystal-search" placeholder="ID de Cristal ex: CRY-ABC12345" class="ark-input flex-1">
                    <button id="btn-buscar" class="btn-neon px-6 py-2">Buscar</button>
                </div>
                <div id="resultado-jogador" class="mt-6 hidden">
                    <div class="bg-black/40 border border-cyan-500/30 rounded-lg p-4">
                        <p><strong>Nome:</strong> <span id="player-name"></span></p>
                        <p><strong>ID Cristal:</strong> <span id="player-crystal"></span></p>
                        <div class="mt-3 pt-3 border-t border-gray-600">
                            <p class="text-purple-300 text-sm">Última rolagem de dado:</p>
                            <p id="last-dice" class="font-mono text-cyan-300">--</p>
                            <p class="text-purple-300 text-sm mt-2">Último evento:</p>
                            <p id="last-event" class="font-mono text-purple-200">--</p>
                            <p id="last-time" class="text-xs text-gray-500 mt-2"></p>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button id="btn-reload" class="text-xs bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded transition-all">⟳ Recarregar</button>
                        <label class="flex items-center gap-2 text-sm"><input type="checkbox" id="auto-reload"> Auto (5s)</label>
                    </div>
                </div>
                <div id="erro-busca" class="text-red-400 mt-4 hidden">Jogador não encontrado.</div>
            </div>

            
            <div class="ark-panel p-6 flex flex-col items-center text-center animate-fadeInUp" style="animation-delay: 0.15s">
                <h2 class="text-xl font-medieval font-bold theme-text-primary mb-4">Criar Nova Mesa</h2>
                <p class="text-sm text-gray-300 mb-6">Gere um código único para que os jogadores possam entrar na sessão.</p>
                <?php if(session('error')): ?>
                    <div class="text-red-400 mb-4 bg-red-500/20 border border-red-500/30 rounded p-2 w-full"><?php echo e(session('error')); ?></div>
                <?php endif; ?>
                <form action="<?php echo e(route('master.criar.mesa')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-neon px-8 py-3 text-lg transition-all">CRIAR MESA +</button>
                </form>
            </div>
        </div>

        
        <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-medieval font-black theme-text-primary mb-4">Rolagens do Mestre</h2>
            <p class="text-sm text-gray-300 mb-6">Role dados e eventos como se fosse um jogador. Suas rolagens serão salvas e visíveis para os participantes da sua mesa.</p>
            <?php echo $__env->make('partials.rolagens-sistema', ['characters' => Auth::user()->characters], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    
    <div id="copy-toast" class="toast-copy">Código copiado!</div>

    <script>
        // Partículas (igual ao da página de rolagens)
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');
        let width, height;
        let particles = [];

        function resizeCanvas() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;
        }

        function initParticles() {
            particles = [];
            for (let i = 0; i < 180; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    radius: Math.random() * 2 + 1,
                    speedY: Math.random() * 1.2 + 0.4,
                    alpha: Math.random() * 0.6 + 0.2,
                });
            }
        }

        function drawParticles() {
            if (!ctx) return;
            ctx.clearRect(0, 0, width, height);
            for (let p of particles) {
                p.y -= p.speedY;
                if (p.y < 0) {
                    p.y = height;
                    p.x = Math.random() * width;
                }
                const progress = 1 - (p.y / height);
                const r = 255;
                const g = 255 - progress * 80;
                const b = 255 - progress * 40;
                ctx.fillStyle = `rgba(${r}, ${g}, ${b}, ${p.alpha})`;
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

        // Busca de jogador (mantida original)
        let currentCrystal = null;
        let autoReloadInterval = null;

        function carregarJogador(crystalId, auto = false) {
            if (!auto && autoReloadInterval) clearInterval(autoReloadInterval);
            fetch(`/mestre/buscar/${crystalId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('resultado-jogador').classList.remove('hidden');
                    document.getElementById('erro-busca').classList.add('hidden');
                    document.getElementById('player-name').innerText = data.user.name;
                    document.getElementById('player-crystal').innerText = data.user.crystal_id;
                    document.getElementById('last-dice').innerText = data.last_roll?.dice || 'Nenhuma';
                    document.getElementById('last-event').innerText = data.last_roll?.event || 'Nenhum';
                    document.getElementById('last-time').innerText = data.last_roll?.created_at || '';
                })
                .catch(() => {
                    document.getElementById('resultado-jogador').classList.add('hidden');
                    document.getElementById('erro-busca').classList.remove('hidden');
                });
        }

        document.getElementById('btn-buscar').addEventListener('click', () => {
            currentCrystal = document.getElementById('crystal-search').value.trim();
            if (currentCrystal) carregarJogador(currentCrystal);
        });
        document.getElementById('btn-reload').addEventListener('click', () => { if (currentCrystal) carregarJogador(currentCrystal); });
        document.getElementById('auto-reload').addEventListener('change', (e) => {
            if (e.target.checked) {
                if (autoReloadInterval) clearInterval(autoReloadInterval);
                autoReloadInterval = setInterval(() => { if (currentCrystal) carregarJogador(currentCrystal, true); }, 5000);
            } else {
                if (autoReloadInterval) clearInterval(autoReloadInterval);
            }
        });

        // Botão copiar código da mesa
        const copyBtn = document.getElementById('copy-code-btn');
        const toast = document.getElementById('copy-toast');
        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const codeElement = document.getElementById('mesa-code');
                if (codeElement) {
                    const code = codeElement.innerText;
                    navigator.clipboard.writeText(code).then(() => {
                        toast.style.opacity = '1';
                        setTimeout(() => { toast.style.opacity = '0'; }, 2000);
                    }).catch(err => {
                        console.error('Falha ao copiar: ', err);
                    });
                }
            });
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
<?php endif; ?><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/master/mesa.blade.php ENDPATH**/ ?>