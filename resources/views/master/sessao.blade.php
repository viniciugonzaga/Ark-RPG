<x-app-layout>
    <x-slot name="title">Sessão: {{ $session->session_code }}</x-slot>

    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_sessao.png') }}" class="w-full h-full object-cover opacity-40" alt="">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>
    <canvas id="particles-canvas" class="fixed inset-0 z-0 pointer-events-none"></canvas>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        :root {
            --theme-primary: #00f2ff;
            --theme-glow: rgba(0, 242, 255, 0.5);
            --theme-border: rgba(0, 242, 255, 0.3);
        }
        .theme-text-primary { color: var(--theme-primary); }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scan-line { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
        @keyframes live-pulse { 0%,100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.35); opacity: 0.5; } }
        @keyframes rollFlash {
            0%   { background-color: rgba(0, 242, 255, 0.25); }
            100% { background-color: transparent; }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; opacity: 0; }
        .animate-scan-line { animation: scan-line 3s linear infinite; }
        .live-dot { animation: live-pulse 1.4s infinite; }
        .roll-updated { animation: rollFlash 1.2s ease-out; border-radius: 6px; padding: 2px 4px; margin: -2px -4px; }

        .ark-panel {
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(12px);
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .btn-neon {
            position: relative; padding: 8px 20px;
            font-size: 12px; font-weight: 900; text-transform: uppercase;
            letter-spacing: 0.25em; transition: all 0.3s ease;
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
        .btn-danger {
            padding: 8px 20px; font-size: 12px; font-weight: 900;
            text-transform: uppercase; letter-spacing: 0.2em;
            background: rgba(0,0,0,0.7);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #f87171;
            border-radius: 40px;
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            background: #dc2626; color: white;
            box-shadow: 0 0 20px #ef4444;
            transform: translateY(-2px);
        }

        .code-block {
            background: rgba(0,0,0,0.6);
            border: 1px solid var(--theme-border);
            border-radius: 12px;
            padding: 8px 16px;
            font-family: ui-monospace, monospace;
            font-size: 1.5rem;
            letter-spacing: 4px;
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
            color: #e5e7eb;
        }
        .btn-copy:hover {
            background: var(--theme-primary);
            color: #000;
            transform: scale(1.02);
        }

        /* Session card */
        .session-card {
            background: linear-gradient(145deg, rgba(0,20,30,0.7) 0%, rgba(0,0,0,0.65) 100%);
            border: 1px solid var(--theme-border);
            border-radius: 14px;
            padding: 14px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .session-card:hover {
            transform: translateY(-2px);
            border-color: var(--theme-primary);
            box-shadow: 0 0 22px var(--theme-glow);
        }
        .session-avatar {
            width: 56px; height: 56px; border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--theme-primary);
            box-shadow: 0 0 12px var(--theme-glow);
            flex-shrink: 0;
        }
        .session-avatar-fallback {
            width: 56px; height: 56px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(0,242,255,0.1);
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary);
            font-family: 'Cinzel', serif; font-weight: 900; font-size: 22px;
            box-shadow: 0 0 12px var(--theme-glow);
            flex-shrink: 0;
        }
        .master-badge {
            font-size: 8px; font-weight: 900; letter-spacing: 1.5px;
            text-transform: uppercase;
            background: rgba(168, 85, 247, 0.2);
            border: 1px solid rgba(168, 85, 247, 0.5);
            color: #e9d5ff;
            padding: 2px 8px; border-radius: 20px;
        }
        .roll-line { font-size: 11px; display: flex; gap: 6px; align-items: flex-start; line-height: 1.35; }
        .roll-line .label { font-weight: 900; letter-spacing: 1px; text-transform: uppercase; flex-shrink: 0; }
        .roll-line.dice .label { color: #67e8f9; }
        .roll-line.event .label { color: #d8b4fe; }
        .roll-line .value { font-family: ui-monospace, monospace; color: #e5e7eb; word-break: break-word; }

        .toast-copy {
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            background: #1a1a1a; border: 1px solid var(--theme-primary);
            color: var(--theme-primary); padding: 8px 20px;
            border-radius: 40px; font-size: 12px; z-index: 9999;
            opacity: 0; transition: opacity 0.3s; pointer-events: none;
        }

        /* Indicador de status de conexão */
        .conn-status {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase;
            padding: 3px 10px; border-radius: 20px;
            border: 1px solid transparent;
        }
        .conn-status.live {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.5);
            color: #6ee7b7;
        }
        .conn-status.poll {
            background: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.5);
            color: #fcd34d;
        }
        .conn-status.off {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.5);
            color: #fca5a5;
        }
    </style>

    <div class="relative z-10 max-w-7xl mx-auto p-6 space-y-6 text-white">

        {{-- HEADER --}}
        <div class="ark-panel p-6 relative overflow-hidden animate-fadeInUp">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>

            <div class="flex flex-wrap justify-between items-start gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                        <span class="relative flex h-3 w-3">
                            <span class="live-dot absolute inline-flex h-full w-full rounded-full bg-emerald-400"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <h1 class="text-3xl font-medieval font-black theme-text-primary tracking-widest">Mesa Ativa</h1>
                        <span id="conn-status" class="conn-status live">Conectando...</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        <p class="text-xs text-gray-400 uppercase tracking-widest">Código da sessão:</p>
                        <div class="code-block" id="session-code">{{ $session->session_code }}</div>
                        <button id="copy-code-btn" class="btn-copy flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Copiar
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">
                        Compartilhe este código com os jogadores. As rolagens aparecem aqui em tempo real.
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('master.mesa') }}" class="btn-neon flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar
                    </a>
                    <form action="{{ route('master.encerrar.mesa', $session->session_code) }}" method="POST" onsubmit="return confirm('Encerrar a mesa removerá todos os participantes. Continuar?')">
                        @csrf
                        <button type="submit" class="btn-danger">Encerrar Mesa</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- PARTICIPANTES --}}
        <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="flex justify-between items-center mb-5 pb-4 border-b flex-wrap gap-3" style="border-color: var(--theme-border)">
                <h2 class="text-xl font-medieval font-black theme-text-primary tracking-widest">Participantes e Últimas Rolagens</h2>
                <div class="flex gap-3 items-center">
                    <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest text-gray-400 cursor-pointer">
                        <input type="checkbox" id="auto-reload" checked class="accent-cyan-500">
                        Tempo real
                    </label>
                    <button id="reload-btn" class="bg-cyan-500/20 hover:bg-cyan-500/40 border border-cyan-500/30 px-3 py-1.5 rounded text-xs uppercase tracking-widest text-cyan-200 transition">
                        Atualizar
                    </button>
                </div>
            </div>
            <div id="participantes-list" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <p class="text-gray-400 text-sm">Carregando participantes...</p>
            </div>
        </div>

        {{-- ROLAGENS DO MESTRE --}}
        <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-medieval font-black theme-text-primary mb-4 tracking-widest">Rolagens do Mestre</h2>
            <p class="text-sm text-gray-300 mb-6">
                Role dados e eventos como se fosse um jogador. Suas rolagens serão salvas e visíveis para os participantes da sua mesa.
            </p>
            @include('partials.rolagens-sistema', ['characters' => Auth::user()->characters])
        </div>
    </div>

    <div id="copy-toast" class="toast-copy">Código copiado!</div>

    <script>
        // ========== PARTÍCULAS ==========
        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');
        let width, height, particles = [];

        function resizeCanvas() { width = window.innerWidth; height = window.innerHeight; canvas.width = width; canvas.height = height; }
        function initParticles() {
            particles = [];
            for (let i = 0; i < 180; i++) {
                particles.push({
                    x: Math.random() * width, y: Math.random() * height,
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
                if (p.y < 0) { p.y = height; p.x = Math.random() * width; }
                const progress = 1 - (p.y / height);
                ctx.fillStyle = `rgba(255, ${255 - progress * 80}, ${255 - progress * 40}, ${p.alpha})`;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fill();
            }
            requestAnimationFrame(drawParticles);
        }
        window.addEventListener('resize', () => { resizeCanvas(); initParticles(); });
        resizeCanvas(); initParticles(); drawParticles();

        // ========== CONFIG ==========
        const SESSION_CODE = "{{ $session->session_code }}";
        const ENDPOINT_REST = `/mestre/sessao/${SESSION_CODE}/participantes`;
        const ENDPOINT_SSE  = '/sessao/stream?code=' + encodeURIComponent(SESSION_CODE);

        let es = null;
        let pollTimer = null;
        let sseErrorCount = 0;
        let lastUpdate = Date.now();

        const lastSeenRolls = {};
        const lastSeenEvents = {};

        const connStatus = document.getElementById('conn-status');

        function setConnStatus(mode, text) {
            if (!connStatus) return;
            connStatus.classList.remove('live', 'poll', 'off');
            connStatus.classList.add(mode);
            connStatus.textContent = text;
        }

        // ========== HELPERS ==========
        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, (c) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
            }[c]));
        }

        function buildAvatar(p) {
            const initial = (p.name || '?').charAt(0).toUpperCase();
            if (p.foto) {
                return `<img src="${p.foto}" alt="${escapeHtml(p.name)}" class="session-avatar"
                    onerror="this.replaceWith(Object.assign(document.createElement('div'),{className:'session-avatar-fallback',textContent:'${initial}'}))">`;
            }
            return `<div class="session-avatar-fallback">${initial}</div>`;
        }

        // ========== RENDER ==========
        function renderParticipants(participants) {
            const c = document.getElementById('participantes-list');
            if (!c) return;

            if (!participants || !participants.length) {
                c.innerHTML = '<p class="text-gray-400 text-sm col-span-full">Nenhum participante ainda. Compartilhe o código da mesa.</p>';
                return;
            }

            participants.sort((a, b) => {
                if (a.is_master && !b.is_master) return -1;
                if (!a.is_master && b.is_master) return 1;
                return (a.name || '').localeCompare(b.name || '');
            });

            c.innerHTML = participants.map(p => {
                const uid = p.user_id;
                const diceChanged  = lastSeenRolls[uid]  !== undefined && lastSeenRolls[uid]  !== p.last_dice  && p.last_dice;
                const eventChanged = lastSeenEvents[uid] !== undefined && lastSeenEvents[uid] !== p.last_event && p.last_event;

                lastSeenRolls[uid]  = p.last_dice;
                lastSeenEvents[uid] = p.last_event;

                return `
                    <div class="session-card">
                        ${buildAvatar(p)}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <strong class="text-cyan-200 truncate">${escapeHtml(p.name)}</strong>
                                ${p.is_master ? '<span class="master-badge">Mestre</span>' : ''}
                            </div>
                            <div class="text-[10px] text-gray-500 font-mono mt-0.5">${escapeHtml(p.crystal_id || '')}</div>
                            <div class="mt-2 space-y-1">
                                <div class="roll-line dice">
                                    <span class="label">Dado:</span>
                                    <span class="value ${diceChanged ? 'roll-updated' : ''}">${escapeHtml(p.last_dice || '--')}</span>
                                </div>
                                <div class="roll-line event">
                                    <span class="label">Evento:</span>
                                    <span class="value ${eventChanged ? 'roll-updated' : ''}">${escapeHtml(p.last_event || '--')}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            lastUpdate = Date.now();
        }

        // ========== REST (fallback + estado inicial) ==========
        function carregarParticipantes() {
            return fetch(ENDPOINT_REST + '?_=' + Date.now(), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                cache: 'no-store'
            })
            .then(res => res.json())
            .then(data => renderParticipants(data.participants || []))
            .catch(() => {});
        }

        // ========== SSE (primário) ==========
        function startStream() {
            if (es) return;
            if (!window.EventSource) { startPolling(); return; }

            // Estado inicial
            carregarParticipantes();

            try {
                es = new EventSource(ENDPOINT_SSE + '&_=' + Date.now());
            } catch (e) {
                es = null;
                startPolling();
                return;
            }

            es.onopen = () => {
                sseErrorCount = 0;
                setConnStatus('live', 'Tempo real');
            };

            es.addEventListener('update', (ev) => {
                sseErrorCount = 0;
                setConnStatus('live', 'Tempo real');
                try {
                    const data = JSON.parse(ev.data);
                    if (data.in_session) renderParticipants(data.participants || []);
                } catch (err) { console.error('SSE parse', err); }
            });

            es.addEventListener('ended', () => {
                stopStream(); stopPolling();
                setConnStatus('off', 'Encerrada');
                const c = document.getElementById('participantes-list');
                if (c) c.innerHTML = '<p class="text-red-400 text-sm col-span-full">Sessão encerrada.</p>';
            });

            es.addEventListener('nosession', () => {
                // Cai para polling (talvez o master não esteja registrado como participante)
                stopStream();
                startPolling();
            });

            es.onerror = () => {
                sseErrorCount++;
                if (sseErrorCount >= 5) {
                    stopStream();
                    startPolling();
                }
            };
        }

        function stopStream() {
            if (es) { try { es.close(); } catch (e) {} es = null; }
        }

        // ========== POLLING (fallback — 1s) ==========
        function startPolling() {
            if (pollTimer) return;
            setConnStatus('poll', 'Polling 1s');
            carregarParticipantes();
            pollTimer = setInterval(carregarParticipantes, 1000);
        }
        function stopPolling() {
            if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
        }

        // ========== CONTROLES ==========
        document.getElementById('reload-btn')?.addEventListener('click', carregarParticipantes);

        document.getElementById('auto-reload')?.addEventListener('change', (e) => {
            if (e.target.checked) {
                startStream();
                if (!window.EventSource) startPolling();
            } else {
                stopStream();
                stopPolling();
                setConnStatus('off', 'Pausado');
            }
        });

        // Reconectar quando volta à aba
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                carregarParticipantes();
                if (document.getElementById('auto-reload')?.checked && !es && !pollTimer) {
                    startStream();
                }
            }
        });

        // Fechar ao sair
        window.addEventListener('beforeunload', () => { stopStream(); stopPolling(); });

        // ========== ROLAGENS DO MESTRE (refresh imediato) ==========
        // Quando o mestre rola na própria página, força atualização da lista.
        // O partial de rolagens dispara saveToDB() — escutamos via MutationObserver
        // simples nos campos de histórico, ou via evento custom.
        (function interceptSaveFetch() {
            const originalFetch = window.fetch;
            window.fetch = function(url, options) {
                const isSave = typeof url === 'string' && url.indexOf('/rolagens/save') !== -1;
                const promise = originalFetch.apply(this, arguments);
                if (isSave) {
                    promise.then(() => {
                        // Pequeno delay para o BD propagar
                        setTimeout(carregarParticipantes, 200);
                    }).catch(() => {});
                }
                return promise;
            };
        })();

        // ========== INICIALIZAÇÃO ==========
        carregarParticipantes();
        startStream();

        // Copiar código
        const copyBtn = document.getElementById('copy-code-btn');
        const toast = document.getElementById('copy-toast');
        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const code = document.getElementById('session-code')?.innerText || '';
                navigator.clipboard.writeText(code).then(() => {
                    toast.style.opacity = '1';
                    setTimeout(() => { toast.style.opacity = '0'; }, 2000);
                });
            });
        }
    </script>
</x-app-layout>