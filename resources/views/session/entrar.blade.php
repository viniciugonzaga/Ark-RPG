{{-- resources/views/session/entrar.blade.php --}}
<x-app-layout>
    <x-slot name="title">Entrar em Sessão - ARK RPG</x-slot>

    {{-- Fundo com imagem e overlay (mesmo padrão das outras telas) --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_entrar_sessao.png') }}" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    {{-- Canvas para partículas (já existente) --}}
    <canvas id="particles-canvas" class="fixed inset-0 pointer-events-none z-0"></canvas>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        /* Variáveis de tema (padrão, mas podem ser sobrescritas) */
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

        /* Painel com clip-path e vidro */
        .ark-panel {
            @apply bg-black/40 backdrop-blur-md shadow-xl;
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
            transition: all 0.3s ease;
        }

        /* Input estilizado */
        .ark-input {
            @apply bg-black/60 border border-cyan-500/30 text-white rounded-sm px-4 py-2.5 transition-all duration-300 font-mono text-sm;
        }
        .ark-input:focus {
            @apply border-cyan-400 shadow-[0_0_15px_rgba(0,242,255,0.3)] outline-none bg-black/80;
        }

        /* Botão neon arredondado (padrão) */
        .btn-neon {
            @apply relative px-8 py-3 text-sm font-black uppercase tracking-[0.25em] transition-all duration-300 overflow-hidden;
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

        /* Estilo para o bloco de informações */
        .info-box {
            background: rgba(0,0,0,0.4);
            border-left: 3px solid var(--theme-primary);
            transition: all 0.2s;
        }
        .info-box:hover {
            background: rgba(0,0,0,0.6);
            border-left-color: var(--theme-secondary);
        }
    </style>

    <div class="relative z-10 max-w-md mx-auto p-6 mt-20">
        <div class="ark-panel p-8 text-center relative overflow-hidden animate-fadeInUp">
            {{-- Linha de scanner no topo --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>

            {{-- Ícone decorativo --}}
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-900/30 to-blue-900/30 rounded-2xl flex items-center justify-center border border-cyan-500/40 shadow-[0_0_15px_rgba(0,242,255,0.3)]">
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-medieval font-black theme-text-primary mb-2 tracking-wider">ENTRAR NA SESSÃO</h1>
            <p class="text-sm text-gray-300 mb-6">Digite o código de 6 caracteres fornecido pelo Mestre.</p>

            {{-- Caixa de instruções estilizada --}}
            <div class="info-box rounded p-4 mb-6 text-xs text-left text-gray-300">
                <p class="flex items-start gap-2">
                    <span class="theme-text-primary font-bold text-sm">ⓘ</span>
                    <span><strong class="theme-text-primary">Como funciona?</strong> Ao entrar em uma sessão, você poderá ver as rolagens de todos os participantes em tempo real. Suas próprias rolagens (dados e eventos) serão automaticamente compartilhadas com o grupo. Use o botão <strong class="text-red-400">"Sair da Sessão"</strong> na barra de navegação a qualquer momento.</span>
                </p>
            </div>

            <form action="{{ route('session.entrar') }}" method="POST">
                @csrf
                <div class="relative mb-6">
                    <input type="text" name="codigo" placeholder="Ex: A7B3F9" maxlength="6" 
                           class="ark-input w-full text-center uppercase text-xl tracking-[0.3em] font-mono" 
                           required autocomplete="off">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-500 pointer-events-none"></span>
                </div>
                <button type="submit" class="btn-neon w-full flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Conectar à Mesa
                </button>
            </form>

            @if($errors->any())
                <div class="mt-5 p-3 bg-red-500/20 border border-red-500/50 rounded text-red-300 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mt-6 pt-4 border-t border-cyan-500/20">
                <a href="{{ route('rolagens.index') }}" class="text-xs theme-text-primary hover:text-white transition flex items-center justify-center gap-1 group">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar para Rolagens
                </a>
            </div>
        </div>
    </div>

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
    </script>
</x-app-layout>