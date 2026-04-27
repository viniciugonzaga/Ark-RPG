{{-- resources/views/master/sessao.blade.php --}}
<x-app-layout>
    <x-slot name="title">Sessão: {{ $session->session_code }}</x-slot>

    {{-- Fundo fixo com overlay --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_sessao.png') }}" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>
    {{-- Canvas para partículas --}}
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

        /* Botões neon */
        .btn-neon {
            @apply relative px-4 py-2 text-sm font-black uppercase tracking-[0.2em] transition-all duration-300 overflow-hidden;
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

        /* Botão encerrar (vermelho) */
        .btn-danger {
            @apply relative px-4 py-2 text-sm font-black uppercase tracking-[0.2em] transition-all duration-300;
            background: rgba(0,0,0,0.7);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #f87171;
            box-shadow: 0 0 8px rgba(239,68,68,0.3);
            border-radius: 40px;
            padding: 6px 16px;
        }
        .btn-danger:hover {
            background: #dc2626;
            color: white;
            border-color: #ef4444;
            box-shadow: 0 0 20px #ef4444;
            transform: translateY(-2px);
        }

        /* Estilo para o código da mesa */
        .code-block {
            background: rgba(0,0,0,0.6);
            border: 1px solid var(--theme-border);
            border-radius: 12px;
            padding: 8px 16px;
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
            padding: 6px 16px;
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

        /* Cards de participantes */
        .participant-card {
            background: rgba(0,0,0,0.4);
            border: 1px solid var(--theme-border);
            border-radius: 16px;
            transition: all 0.2s;
        }
        .participant-card:hover {
            border-color: var(--theme-primary);
            background: rgba(0,0,0,0.6);
        }
    </style>

    <div class="relative z-10 max-w-7xl mx-auto p-6 space-y-6 text-white">
        {{-- Cabeçalho da mesa --}}
        <div class="ark-panel p-6 flex justify-between items-center flex-wrap gap-4 relative overflow-hidden animate-fadeInUp">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>
            <div>
                <h1 class="text-3xl font-medieval font-black theme-text-primary">Mesa de Sessão</h1>
                <div class="flex items-center gap-3 mt-2">
                    <p class="text-sm text-gray-300">Código:</p>
                    <div class="code-block" id="session-code">{{ $session->session_code }}</div>
                    <button id="copy-code-btn" class="btn-copy flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Copiar
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Compartilhe este código com os jogadores.</p>
            </div>
            <div class="flex gap-4">
                <form action="{{ route('master.encerrar.mesa', $session->session_code) }}" method="POST" onsubmit="return confirm('Encerrar a mesa removerá todos os participantes. Continuar?')">
                    @csrf
                    <button type="submit" class="btn-danger">Encerrar Mesa</button>
                </form>
                <a href="{{ route('master.mesa') }}" class="btn-neon flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        {{-- Participantes --}}
        <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
                <h2 class="text-xl font-medieval font-bold theme-text-primary">Participantes e Últimas Rolagens</h2>
                <div class="flex gap-4 items-center">
                    <button id="reload-participantes" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm transition-all">⟳ Recarregar</button>
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" id="auto-reload-mesa"> Auto (5s)</label>
                </div>
            </div>
            <div id="participantes-list" class="space-y-3"><p class="text-gray-400">Carregando participantes...</p></div>
        </div>

        {{-- Sistema de rolagens do mestre (mesmo da página de rolagens) --}}
        <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-medieval font-black theme-text-primary mb-4">Rolagens do Mestre</h2>
            <p class="text-sm text-gray-300 mb-6">Role dados e eventos como se fosse um jogador. Suas rolagens serão salvas e visíveis para os participantes da sua mesa.</p>
            @include('partials.rolagens-sistema', ['characters' => Auth::user()->characters])
        </div>
    </div>

    {{-- Toast de cópia --}}
    <div id="copy-toast" class="toast-copy">📋 Código copiado!</div>

    <script>
        // Partículas
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

        // Participantes da mesa (auto-reload)
        let autoInterval = null;
        const sessionCode = "{{ $session->session_code }}";

        function carregarParticipantes() {
            fetch(`/mestre/sessao/${sessionCode}/participantes`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('participantes-list');
                    if (!data.participants.length) {
                        container.innerHTML = '<p class="text-gray-400">Nenhum participante ainda. Compartilhe o código!</p>';
                        return;
                    }
                    container.innerHTML = data.participants.map(p => `
                        <div class="participant-card p-4 flex flex-wrap justify-between items-center gap-2">
                            <div><strong class="text-cyan-300">${p.name}</strong><span class="text-xs text-gray-400 ml-2">${p.crystal_id}</span></div>
                            <div class="text-right">
                                <div class="text-sm">Dado: <span class="font-mono text-cyan-200">${p.last_dice}</span></div>
                                <div class="text-sm">Evento: <span class="font-mono text-purple-200">${p.last_event}</span></div>
                                <div class="text-xs text-gray-500">${p.last_time || ''}</div>
                            </div>
                        </div>
                    `).join('');
                });
        }

        document.getElementById('reload-participantes').addEventListener('click', carregarParticipantes);
        const autoCheck = document.getElementById('auto-reload-mesa');
        autoCheck.addEventListener('change', (e) => {
            if (e.target.checked) {
                if (autoInterval) clearInterval(autoInterval);
                autoInterval = setInterval(carregarParticipantes, 5000);
            } else {
                if (autoInterval) clearInterval(autoInterval);
            }
        });
        carregarParticipantes();

        // Botão copiar código da mesa
        const copyBtn = document.getElementById('copy-code-btn');
        const toast = document.getElementById('copy-toast');
        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const codeElement = document.getElementById('session-code');
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
</x-app-layout>