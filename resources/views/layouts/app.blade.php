<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ARK RPG'))</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">

    {{-- ============================================================ --}}
    {{-- PWA — Meta tags, Manifest e Ícones                            --}}
    {{-- ============================================================ --}}
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#00f2ff">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ARK RPG">
    <link rel="apple-touch-icon" href="/icons/apple-icon-180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/manifest-icon-192.maskable.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icons/manifest-icon-512.maskable.png">
    {{-- ============================================================ --}}

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('build/app.css') }}">
        <script src="{{ asset('build/app.js') }}" defer></script>
    @endif

    @stack('styles')

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

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--black);
            color: var(--white);
            font-family: 'Inter', 'Poppins', system-ui, sans-serif;
            line-height: 1.5;
            overflow-x: hidden;
            position: relative;
        }

        #particles-canvas {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none; z-index: 0; opacity: 0.6;
        }

        .ark-container {
            max-width: 1400px; margin: 0 auto;
            padding: 1.5rem; width: 100%;
            position: relative; z-index: 2;
        }

        .ark-card, .ark-panel, .biome-icon, .env-icon, .creature-card, .search-container input, .view-btn, .modal-content, .ficha-container {
            background: var(--grad-dark);
            border: var(--border-light);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        button, .clickable, .view-btn, .biome-icon, .env-icon, .creature-card, .creature-item, .modal-switch-btn, .carousel-control, .carousel-indicator {
            cursor: pointer; transition: var(--transition);
        }
        button:hover, .clickable:hover, .view-btn:hover, .biome-icon:hover, .env-icon:hover, .creature-card:hover, .creature-item:hover, .modal-switch-btn:hover, .carousel-control:hover, .carousel-indicator:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 12px rgba(142, 200, 255, 0.4);
            border-color: var(--blue-light);
        }

        h1, h2, h3, h4, p, span { color: var(--white); }
        .text-glow { color: var(--blue-light); text-shadow: 0 0 6px var(--blue-glow); }
        .text-rare { color: var(--purple-rare); text-shadow: 0 0 4px rgba(192, 132, 252, 0.6); }

        input, textarea, select {
            background: var(--gray-800);
            border: var(--border-light);
            color: var(--white);
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }
        input:focus { outline: none; border-color: var(--blue-light); box-shadow: 0 0 8px var(--blue-glow); }

        .grid-responsive {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .creature-card {
            border-radius: 16px; overflow: hidden;
            background: var(--grad-card);
            display: flex; flex-direction: column; height: 100%;
        }
        .card-image {
            height: 180px; overflow: hidden; background: var(--gray-900);
            display: flex; align-items: center; justify-content: center;
        }
        .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .creature-card:hover .card-image img { transform: scale(1.05); }
        .card-name {
            padding: 1rem; text-align: center; font-weight: 600;
            background: rgba(0,0,0,0.5); border-top: var(--border-light);
        }

        footer {
            position: relative;
            background: linear-gradient(145deg, #111, #050505);
            border-top: var(--border-light);
            margin-top: 2rem; overflow: hidden; z-index: 2;
        }
        .footer-virus-effect {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none; z-index: 1;
        }
        .virus-glow {
            position: absolute; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(142, 253, 255, 0.2) 0%, rgba(7, 31, 53, 0) 70%);
            border-radius: 50%; transform: translate(-50%, -50%);
            transition: transform 0.05s linear; will-change: transform;
        }
        .virus-lines {
            position: absolute; width: 100%; height: 100%;
            background-image: repeating-linear-gradient(45deg, rgba(12, 50, 56, 0.1) 0px, rgba(142, 255, 240, 0.1) 2px, transparent 2px, transparent 8px);
            mask: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), black 20%, transparent 80%);
            -webkit-mask: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), black 20%, transparent 80%);
        }
        .footer-content { position: relative; z-index: 2; padding: 2rem 1rem; text-align: center; }
        .footer-content p, .footer-content span { color: #ffffff; }
        .footer-content .highlight { color: var(--blue-light); }

        @media (max-width: 768px) {
            .ark-container { padding: 1rem; }
            .grid-responsive { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
            .carousel-control { width: 32px; height: 32px; }
        }
    </style>

    {{-- ============================================================ --}}
    {{-- PWA — Estilos do botão, dot e modal                           --}}
    {{-- ============================================================ --}}
    <style>
        #pwa-install-root { position: fixed; bottom: 24px; left: 24px; z-index: 9998; display: none; }
        #pwa-install-root.pwa-visible { display: block; }

        .pwa-btn-wrapper { position: relative; display: inline-block; animation: pwa-fade-in 0.5s ease; }
        @keyframes pwa-fade-in {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .pwa-btn {
            width: 52px; height: 52px; border-radius: 9999px;
            background: rgba(0, 0, 0, 0.92);
            border: 2px solid #00f2ff; color: #00f2ff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; padding: 0;
            box-shadow: 0 0 22px rgba(0, 242, 255, 0.55), 0 0 40px rgba(0, 242, 255, 0.25);
            transition: transform 0.3s cubic-bezier(.2,.9,.3,1.4), box-shadow 0.3s ease, background 0.25s ease, width 0.35s cubic-bezier(.2,.9,.3,1.2), padding 0.35s cubic-bezier(.2,.9,.3,1.2);
            overflow: hidden; white-space: nowrap;
        }
        .pwa-btn:hover {
            transform: scale(1.06);
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.8), 0 0 60px rgba(0, 242, 255, 0.35);
        }
        .pwa-btn:active { transform: scale(0.96); }

        .pwa-btn-core {
            width: 12px; height: 12px; border-radius: 50%;
            background: #00f2ff;
            box-shadow: 0 0 10px #00f2ff, 0 0 20px rgba(0, 242, 255, 0.6);
            animation: pwa-pulse 2.4s ease-in-out infinite;
            flex-shrink: 0;
            transition: width 0.3s ease, height 0.3s ease;
        }
        @keyframes pwa-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.55; transform: scale(0.8); }
        }

        .pwa-label {
            display: none; font-weight: 900; text-transform: uppercase;
            letter-spacing: 2px; font-size: 11px; color: #00f2ff;
            padding-left: 10px;
        }

        .pwa-btn.pwa-expanded { width: auto; padding: 0 22px 0 18px; border-radius: 9999px; }
        .pwa-btn.pwa-expanded .pwa-btn-core { animation: none; width: 10px; height: 10px; }
        .pwa-btn.pwa-expanded .pwa-label { display: inline-block; }

        .pwa-btn-core.pwa-loading {
            width: 16px; height: 16px;
            background: transparent;
            border: 2px solid rgba(0, 242, 255, 0.25);
            border-top-color: #00f2ff;
            border-radius: 50%;
            box-shadow: none;
            animation: pwa-spin 0.8s linear infinite !important;
        }
        @keyframes pwa-spin { to { transform: rotate(360deg); } }

        .pwa-spinner-large {
            width: 38px; height: 38px;
            border: 3px solid rgba(0, 242, 255, 0.22);
            border-top-color: #00f2ff;
            border-radius: 50%;
            animation: pwa-spin 0.8s linear infinite;
        }

        .pwa-dismiss-btn {
            position: absolute; top: -7px; right: -7px;
            width: 20px; height: 20px; border-radius: 50%;
            background: #0a0a0a;
            border: 1.5px solid rgba(255, 90, 90, 0.85);
            color: #ff5a5a;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; padding: 0;
            transition: all 0.2s ease; z-index: 3;
            box-shadow: 0 0 8px rgba(255, 90, 90, 0.4);
        }
        .pwa-dismiss-btn:hover {
            background: #ff5a5a; color: #fff;
            transform: scale(1.2);
            box-shadow: 0 0 14px rgba(255, 90, 90, 0.8);
        }
        .pwa-dismiss-btn svg { width: 10px; height: 10px; stroke-width: 3; }

        .pwa-modal {
            position: fixed; inset: 0; z-index: 10000;
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
        }
        .pwa-modal[hidden] { display: none; }
        .pwa-modal-backdrop {
            position: absolute; inset: 0;
            background: rgba(0, 0, 0, 0.82);
            backdrop-filter: blur(6px);
            cursor: pointer;
        }
        .pwa-modal-card {
            position: relative; max-width: 420px; width: 100%;
            background: linear-gradient(145deg, #0d1a1f 0%, #060a0d 100%);
            border: 1px solid rgba(0, 242, 255, 0.5);
            border-radius: 20px; padding: 28px 24px;
            box-shadow: 0 0 40px rgba(0, 242, 255, 0.25);
            animation: pwa-modal-in 0.3s cubic-bezier(.2,.9,.3,1.2);
        }
        @keyframes pwa-modal-in {
            from { opacity: 0; transform: scale(0.94) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .pwa-modal-card h3 {
            color: #00f2ff; font-size: 15px; font-weight: 900;
            text-transform: uppercase; letter-spacing: 3px;
            margin: 0 0 16px; text-align: center;
        }
        .pwa-modal-body { color: #d1d5db; font-size: 13px; line-height: 1.6; }
        .pwa-modal-body p { margin: 0 0 10px; color: #d1d5db; }
        .pwa-modal-body p:last-child { margin-bottom: 0; }
        .pwa-modal-body ol { padding-left: 22px; margin: 10px 0 12px; color: #d1d5db; }
        .pwa-modal-body ol li { margin-bottom: 8px; }
        .pwa-modal-body strong { color: #00f2ff; }

        .pwa-modal-actions {
            display: flex; gap: 10px; margin-top: 22px;
            justify-content: flex-end; flex-wrap: wrap;
        }
        .pwa-modal-actions:empty { display: none; }
        .pwa-modal-actions button {
            padding: 10px 20px; border-radius: 9999px;
            font-weight: 900; font-size: 11px; letter-spacing: 2px;
            text-transform: uppercase; cursor: pointer;
            transition: all 0.25s ease; border: 2px solid transparent;
        }
        .pwa-modal-actions button[data-action="cancel"],
        .pwa-modal-actions button[data-action="cancel-dismiss"] {
            background: transparent; color: #94a3b8;
            border-color: rgba(148, 163, 184, 0.4);
        }
        .pwa-modal-actions button[data-action="cancel"]:hover,
        .pwa-modal-actions button[data-action="cancel-dismiss"]:hover {
            color: #e5e7eb; border-color: #94a3b8;
        }
        .pwa-modal-actions button[data-action="install"] {
            background: #00f2ff; color: #000; border-color: #00f2ff;
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.5);
        }
        .pwa-modal-actions button[data-action="install"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0, 242, 255, 0.85);
        }
        .pwa-modal-actions button[data-action="confirm-dismiss"] {
            background: #ff3b3b; color: #fff; border-color: #ff3b3b;
            box-shadow: 0 0 15px rgba(255, 59, 59, 0.5);
        }
        .pwa-modal-actions button[data-action="confirm-dismiss"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(255, 59, 59, 0.85);
        }

        @media (max-width: 480px) {
            #pwa-install-root { bottom: 16px; left: 16px; }
            .pwa-btn { width: 46px; height: 46px; }
            .pwa-btn.pwa-expanded { padding: 0 18px 0 14px; }
            .pwa-label { font-size: 10px; letter-spacing: 1.5px; }
            .pwa-dismiss-btn { width: 18px; height: 18px; top: -6px; right: -6px; }
            .pwa-dismiss-btn svg { width: 9px; height: 9px; }
            .pwa-modal-card { padding: 22px 18px; }
        }
    </style>
</head>
<body>

    <canvas id="particles-canvas"></canvas>

    <x-loading-screen />

    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header class="ark-header shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl leading-tight">{{ $header }}</h2>
                </div>
            </header>
        @endisset

        <main class="flex-grow flex flex-col">
            <div class="ark-container">
                {{ $slot }}
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
                    &copy; {{ date('Y') }} ARK RPG —
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

    @stack('scripts')

    <script>
        (function() {
            const canvas = document.getElementById('particles-canvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            const PARTICLE_COUNT = 180;
            function resizeCanvas() {
                width = window.innerWidth; height = window.innerHeight;
                canvas.width = width; canvas.height = height;
            }
            function initParticles() {
                particles = [];
                for (let i = 0; i < PARTICLE_COUNT; i++) {
                    particles.push({
                        x: Math.random() * width, y: Math.random() * height,
                        radius: Math.random() * 2 + 1,
                        speedY: Math.random() * 1.2 + 0.4,
                        alpha: Math.random() * 0.6 + 0.2,
                        colorShift: Math.random()
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
                    const finalR = 255;
                    const finalG = 255 - progress * 80;
                    const finalB = 255 - progress * 40;
                    ctx.fillStyle = `rgba(${finalR}, ${finalG}, ${finalB}, ${p.alpha})`;
                    ctx.beginPath(); ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2); ctx.fill();
                }
                requestAnimationFrame(drawParticles);
            }
            window.addEventListener('resize', () => { resizeCanvas(); initParticles(); });
            resizeCanvas(); initParticles(); drawParticles();

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
                    virusGlow.style.opacity = '1'; virusLines.style.opacity = '1';
                } else {
                    virusGlow.style.opacity = '0'; virusLines.style.opacity = '0';
                }
            }
            document.addEventListener('mousemove', updateVirusEffect);
        })();

        setInterval(() => {
            fetch('/ping', { credentials: 'same-origin' })
                .then(response => response.json())
                .catch(err => console.warn('Keep-alive falhou', err));
        }, 300000);
    </script>

    {{-- ============================================================ --}}
    {{-- PWA — Registro do SW + API global de instalação               --}}
    {{--     (sempre ativo, independente de login)                     --}}
    {{-- ============================================================ --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker
                    .register('/sw.js', { scope: '/' })
                    .then((reg) => {
                        console.log('[PWA] Service Worker registrado:', reg.scope);
                        reg.addEventListener('updatefound', () => {
                            const newWorker = reg.installing;
                            newWorker?.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    if (confirm('Nova versão do ARK disponível. Recarregar?')) {
                                        newWorker.postMessage('SKIP_WAITING');
                                        window.location.reload();
                                    }
                                }
                            });
                        });
                    })
                    .catch((err) => console.warn('[PWA] Falha ao registrar SW:', err));
            });
        }

        window.__pwaDeferredPrompt = null;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            window.__pwaDeferredPrompt = e;
            window.dispatchEvent(new Event('pwa-prompt-available'));
        });

        window.__pwaIsStandalone = function() {
            return window.matchMedia('(display-mode: standalone)').matches
                || window.navigator.standalone === true;
        };
        window.__pwaIsIOS = function() {
            const ua = navigator.userAgent || '';
            return /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
        };

        window.__pwaTriggerInstall = async function() {
            const prompt = window.__pwaDeferredPrompt;
            if (!prompt) return { outcome: 'unavailable' };
            try {
                prompt.prompt();
                const { outcome } = await prompt.userChoice;
                window.__pwaDeferredPrompt = null;
                return { outcome };
            } catch (err) {
                console.warn('[PWA] Erro ao disparar prompt:', err);
                return { outcome: 'error' };
            }
        };
    </script>

    {{-- ============================================================ --}}
    {{-- PWA — Bolha de instalação (SOMENTE VISITANTES)                --}}
    {{-- ============================================================ --}}
    @guest
        <div id="pwa-install-root" aria-live="polite">
            <div class="pwa-btn-wrapper">
                <button id="pwa-install-btn" class="pwa-btn" type="button" aria-label="Baixar Ark Mobile">
                    <span class="pwa-btn-core"></span>
                    <span class="pwa-label">Baixar Ark Mobile</span>
                </button>
                <button id="pwa-dismiss-btn" class="pwa-dismiss-btn" type="button" aria-label="Não mostrar novamente">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div id="pwa-modal" class="pwa-modal" hidden>
            <div class="pwa-modal-backdrop" data-pwa-close></div>
            <div class="pwa-modal-card" role="dialog" aria-modal="true">
                <h3 id="pwa-modal-title">Instalar ARK RPG</h3>
                <div class="pwa-modal-body" id="pwa-modal-body"></div>
                <div class="pwa-modal-actions" id="pwa-modal-actions"></div>
            </div>
        </div>

        <script>
        (function() {
            const LS_KEY = 'pwa-install-dismissed';
            const root   = document.getElementById('pwa-install-root');
            const btn    = document.getElementById('pwa-install-btn');
            const core   = btn.querySelector('.pwa-btn-core');
            const label  = btn.querySelector('.pwa-label');
            const xBtn   = document.getElementById('pwa-dismiss-btn');
            const modal  = document.getElementById('pwa-modal');
            const mTitle = document.getElementById('pwa-modal-title');
            const mBody  = document.getElementById('pwa-modal-body');
            const mActs  = document.getElementById('pwa-modal-actions');

            let isExpanded = false;
            let isWorking = false;

            if (window.__pwaIsStandalone()) return;
            if (localStorage.getItem(LS_KEY) === '1') return;

            function showRoot() { root.classList.add('pwa-visible'); }

            if (window.__pwaDeferredPrompt) showRoot();
            window.addEventListener('pwa-prompt-available', showRoot);

            if (window.__pwaIsIOS()) setTimeout(showRoot, 2000);

            const isAndroid = /Android/i.test(navigator.userAgent || '');
            if (!window.__pwaIsIOS() && !isAndroid && 'serviceWorker' in navigator) {
                setTimeout(() => {
                    if (!window.__pwaDeferredPrompt) showRoot();
                }, 4000);
            }

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (isWorking) return;
                if (!isExpanded) {
                    isExpanded = true;
                    btn.classList.add('pwa-expanded');
                    return;
                }
                handlePrimaryClick();
            });

            document.addEventListener('click', (e) => {
                if (!isExpanded) return;
                if (root.contains(e.target)) return;
                if (modal && !modal.hidden) return;
                isExpanded = false;
                btn.classList.remove('pwa-expanded');
            });

            xBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                openDismissConfirmModal();
            });

            function handlePrimaryClick() {
                if (window.__pwaIsIOS()) return openIOSModal();
                if (!window.__pwaDeferredPrompt) return openUnavailableModal();
                return openConfirmModal();
            }

            function setWorking(state) {
                isWorking = state;
                core.classList.toggle('pwa-loading', state);
                label.textContent = state ? 'Baixando...' : 'Baixar Ark Mobile';
                btn.style.cursor = state ? 'wait' : 'pointer';
            }

            function openIOSModal() {
                mTitle.textContent = 'Instalar no iPhone';
                mBody.innerHTML = `
                    <p>O Safari não tem botão automático, mas o app <strong>funciona</strong> no iPhone! Siga:</p>
                    <ol>
                        <li>Toque em <strong>Compartilhar</strong> ⎙ (embaixo, no meio do Safari)</li>
                        <li>Role e toque em <strong>"Adicionar à Tela de Início"</strong></li>
                        <li>Toque em <strong>Adicionar</strong> no canto superior direito</li>
                    </ol>
                    <p>Pronto! O ícone do <strong>ARK RPG</strong> aparecerá junto com seus outros apps.</p>
                `;
                mActs.innerHTML = `<button type="button" data-action="cancel">Entendi</button>`;
                modal.hidden = false;
            }

            function openUnavailableModal() {
                mTitle.textContent = 'Instalação Indisponível';
                mBody.innerHTML = `
                    <p>Seu navegador não permite instalação automática.</p>
                    <p>Para baixar o <strong>Ark Mobile</strong>, abra no:</p>
                    <ol>
                        <li><strong>Chrome</strong> (Android/Desktop)</li>
                        <li><strong>Edge</strong> (Windows)</li>
                        <li><strong>Safari</strong> (iPhone — manual)</li>
                    </ol>
                `;
                mActs.innerHTML = `<button type="button" data-action="cancel">Fechar</button>`;
                modal.hidden = false;
            }

            function openConfirmModal() {
                mTitle.textContent = 'Baixar Ark Mobile';
                mBody.innerHTML = `
                    <p>Deseja baixar o <strong>ARK RPG</strong> para o seu dispositivo?</p>
                    <p>Você terá um ícone próprio na tela inicial — acesso rápido, sem abrir o navegador.</p>
                `;
                mActs.innerHTML = `
                    <button type="button" data-action="cancel">Agora não</button>
                    <button type="button" data-action="install">Baixar</button>
                `;
                modal.hidden = false;
            }

            function openDownloadingModal() {
                mTitle.textContent = 'Baixando...';
                mBody.innerHTML = `
                    <div style="display:flex; flex-direction:column; align-items:center; gap:16px; padding:16px 0;">
                        <div class="pwa-spinner-large"></div>
                        <p style="margin:0; text-align:center;">Preparando o <strong>Ark Mobile</strong>...</p>
                    </div>
                `;
                mActs.innerHTML = '';
                modal.hidden = false;
            }

            function openSuccessModal() {
                mTitle.textContent = 'Instalado!';
                mBody.innerHTML = `
                    <p>O <strong>Ark Mobile</strong> foi adicionado ao seu dispositivo.</p>
                    <p>Procure o ícone na <strong>tela inicial</strong> ou na <strong>gaveta de apps</strong>.</p>
                `;
                mActs.innerHTML = `<button type="button" data-action="cancel">Ótimo!</button>`;
                modal.hidden = false;
            }

            function openDismissConfirmModal() {
                mTitle.textContent = 'Remover botão?';
                mBody.innerHTML = `
                    <p>Tem certeza de que deseja <strong>esconder o botão</strong> de instalação?</p>
                    <p>Você sempre pode instalar depois pelo menu do navegador (⋮ → Instalar aplicativo).</p>
                `;
                mActs.innerHTML = `
                    <button type="button" data-action="cancel-dismiss">Voltar</button>
                    <button type="button" data-action="confirm-dismiss">Retirar</button>
                `;
                modal.hidden = false;
            }

            function closeModal() { modal.hidden = true; }

            modal.addEventListener('click', async (e) => {
                if (e.target.closest('[data-pwa-close]')) { closeModal(); return; }
                const el = e.target.closest('[data-action]');
                if (!el) return;
                const action = el.dataset.action;

                if (action === 'cancel' || action === 'cancel-dismiss') { closeModal(); return; }
                if (action === 'confirm-dismiss') {
                    localStorage.setItem(LS_KEY, '1');
                    root.classList.remove('pwa-visible');
                    closeModal();
                    return;
                }
                if (action === 'install') {
                    if (!window.__pwaDeferredPrompt) { closeModal(); return; }
                    setWorking(true);
                    openDownloadingModal();
                    await new Promise(r => setTimeout(r, 700));
                    const { outcome } = await window.__pwaTriggerInstall();
                    if (outcome === 'accepted') {
                        openSuccessModal();
                        setTimeout(() => {
                            closeModal();
                            root.classList.remove('pwa-visible');
                        }, 3500);
                    } else {
                        closeModal();
                    }
                    setWorking(false);
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.hidden) closeModal();
            });

            window.addEventListener('appinstalled', () => {
                root.classList.remove('pwa-visible');
                closeModal();
            });
        })();
        </script>
    @endguest

    <style>
        #particles-canvas { position: fixed; top: 0; left: 0; z-index: 0; }
        .ark-container, .ark-header, nav, footer { position: relative; z-index: 2; background-color: transparent; }
        body { background: var(--black); }
        .ark-card, .ark-panel, .creature-card, .modal-content { background: var(--grad-dark) !important; backdrop-filter: blur(0px); }
        .text-glow, .text-rare { background: transparent; }
        .carousel-control svg { filter: drop-shadow(0 0 2px rgba(142, 234, 255, 0.5)); }
    </style>
</body>
</html>