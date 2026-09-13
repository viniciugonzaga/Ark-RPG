{{-- resources/views/rolagens/index.blade.php --}}
<x-app-layout>
    <x-slot name="title">Rolagens - ARK RPG</x-slot>

    {{-- Meta tags para prévia social --}}
    <meta property="og:title" content="Rolagens - ARK RPG" />
    <meta property="og:description" content="Sistema de rolagem de dados para ARK RPG" />
    <meta property="og:image" content="{{ asset('images/capa_rolagens.png') }}" />

    {{-- Fundo fixo com imagem e overlay --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_rolagens.png') }}" class="w-full h-full object-cover opacity-40" alt="">
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
        @keyframes rotate-icon {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { filter: drop-shadow(0 0 2px var(--theme-primary)); }
            50% { filter: drop-shadow(0 0 8px var(--theme-primary)); }
        }
        @keyframes live-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.35); opacity: 0.5; }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; opacity: 0; }
        .animate-scan-line { animation: scan-line 3s linear infinite; }
        .rotate-icon { animation: rotate-icon 0.6s ease-out; }
        .pulse-glow { animation: pulse-glow 1.5s infinite; }
        .live-dot { animation: live-pulse 1.4s infinite; }

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

        .dice-3d-container {
            perspective: 800px;
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        .dice-3d {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .dice-face {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(0,0,0,0.85);
            border: 2px solid var(--theme-primary);
            border-radius: 16px;
            box-shadow: 0 0 15px var(--theme-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: 900;
            color: var(--theme-primary);
            text-shadow: 0 0 5px currentColor;
            backdrop-filter: blur(4px);
        }
        .face-front  { transform: rotateY(0deg) translateZ(50px); }
        .face-back   { transform: rotateY(180deg) translateZ(50px); }
        .face-right  { transform: rotateY(90deg) translateZ(50px); }
        .face-left   { transform: rotateY(-90deg) translateZ(50px); }
        .face-top    { transform: rotateX(90deg) translateZ(50px); }
        .face-bottom { transform: rotateX(-90deg) translateZ(50px); }

        .historico-scroll {
            max-height: 120px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .historico-scroll::-webkit-scrollbar { width: 5px; }
        .historico-scroll::-webkit-scrollbar-track { background: #1a1a1a; border-radius: 10px; }
        .historico-scroll::-webkit-scrollbar-thumb { background: var(--theme-primary); border-radius: 10px; }

        .attr-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: rgba(0,0,0,0.6);
            border-radius: 50%;
            border: 1px solid var(--theme-primary);
            margin-right: 8px;
        }
        .attr-icon img { width: 20px; height: 20px; filter: brightness(0) invert(1); }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }
        .event-block {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0,0,0,0.4);
            border-radius: 16px;
            padding: 12px 16px;
            border: 1px solid var(--theme-border);
            transition: all 0.2s;
        }
        .event-block:hover {
            border-color: var(--theme-primary);
            background: rgba(0,0,0,0.6);
        }
        .event-icon {
            width: 48px;
            height: 48px;
            object-fit: contain;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .event-icon:hover { transform: scale(1.05); }
        .event-icon:active { transform: scale(0.95); }
        .event-text-img { height: 32px; object-fit: contain; }
        .event-label {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--theme-primary);
            background: rgba(0,0,0,0.5);
            padding: 2px 8px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .event-result {
            margin-top: 8px;
            padding: 8px 12px;
            background: rgba(0,0,0,0.5);
            border-radius: 12px;
            font-size: 12px;
            color: #d8b4fe;
            display: none;
        }
        .tooltip-icon { position: relative; cursor: help; }
        .tooltip-icon::after {
            content: "Clique para girar";
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #000000cc;
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
            z-index: 10;
        }
        .tooltip-icon:hover::after { opacity: 1; }

        /* Popup 20 Natural */
        #extreme-popup { transition: opacity 0.3s ease; }
        #extreme-popup.show { opacity: 1; pointer-events: auto; }
        #extreme-popup.show > div { transform: scale(1); }

        /* ========== MESA ATIVA ========== */
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
        .session-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(0,242,255,0.05) 50%, transparent 100%);
            transform: translateX(-100%);
            transition: transform 0.8s ease;
            pointer-events: none;
        }
        .session-card:hover {
            transform: translateY(-2px);
            border-color: var(--theme-primary);
            box-shadow: 0 0 22px var(--theme-glow);
        }
        .session-card:hover::before { transform: translateX(100%); }

        .session-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--theme-primary);
            box-shadow: 0 0 12px var(--theme-glow);
            flex-shrink: 0;
        }
        .session-avatar-fallback {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,242,255,0.1);
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary);
            font-family: 'Cinzel', serif;
            font-weight: 900;
            font-size: 22px;
            box-shadow: 0 0 12px var(--theme-glow);
            flex-shrink: 0;
        }
        .master-badge {
            font-size: 8px;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            background: rgba(168, 85, 247, 0.2);
            border: 1px solid rgba(168, 85, 247, 0.5);
            color: #e9d5ff;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .roll-line {
            font-size: 11px;
            display: flex;
            gap: 6px;
            align-items: flex-start;
            line-height: 1.35;
        }
        .roll-line .label {
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            flex-shrink: 0;
        }
        .roll-line.dice .label { color: #67e8f9; }
        .roll-line.event .label { color: #d8b4fe; }
        .roll-line .value {
            font-family: ui-monospace, monospace;
            color: #e5e7eb;
            word-break: break-word;
        }

        /* Pulse para atualização (destaca quando o dado muda) */
        @keyframes rollFlash {
            0%   { background-color: rgba(0, 242, 255, 0.25); }
            100% { background-color: transparent; }
        }
        .roll-updated {
            animation: rollFlash 1.2s ease-out;
            border-radius: 6px;
            padding: 2px 4px;
            margin: -2px -4px;
        }

        /* ========== PAINEL DE ARMAS ========== */
        .weapon-card {
            background: rgba(0,0,0,0.45);
            border: 1px solid var(--theme-border);
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: all 0.25s ease;
        }
        .weapon-card:hover {
            border-color: var(--theme-primary);
            box-shadow: 0 0 18px var(--theme-glow);
        }
        .weapon-title {
            color: var(--theme-primary);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 13px;
        }
        .weapon-formula {
            font-family: ui-monospace, monospace;
            font-size: 11px;
            color: #cbd5e1;
        }
        .weapon-formula strong { color: #67e8f9; }
        .weapon-btn {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .weapon-btn.attack {
            background: rgba(6, 182, 212, 0.25);
            border-color: rgba(6, 182, 212, 0.6);
            color: #cffafe;
        }
        .weapon-btn.attack:hover {
            background: rgba(6, 182, 212, 0.6);
            color: #001b1f;
        }
        .weapon-btn.damage {
            background: rgba(168, 85, 247, 0.25);
            border-color: rgba(168, 85, 247, 0.6);
            color: #f3e8ff;
        }
        .weapon-btn.damage:hover {
            background: rgba(168, 85, 247, 0.6);
            color: #1b0020;
        }
        /* ================= RESPONSIVO ADICIONAL — ROLAGENS ================= */

@media (max-width: 1080px) {
    .ark-panel { border-radius: 12px; }
    #dice-container { grid-template-columns: repeat(6, minmax(0, 1fr)) !important; }
    .session-card { padding: 12px; gap: 12px; }
    .session-avatar, .session-avatar-fallback { width: 48px; height: 48px; font-size: 18px; }
    .events-grid { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); }
    .relative.z-10.max-w-7xl { padding: 1.25rem !important; }
}

@media (max-width: 760px) {
    .relative.z-10.max-w-7xl { padding: 1rem !important; }
    .ark-panel { padding: 1rem !important; }

    /* Dados livres */
    #dice-container { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; gap: 6px !important; }
    #dice-container > div { padding: 6px !important; border-radius: 10px !important; }
    #dice-container > div .text-\[11px\] { font-size: 9px !important; }
    #dice-container > div .text-2xl { font-size: 1.1rem !important; }
    #dice-container > div span.text-xl { font-size: 1rem !important; }

    /* Eventos */
    .events-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .event-block { padding: 10px; gap: 10px; border-radius: 12px; }
    .event-icon { width: 40px; height: 40px; }
    .event-text-img { height: 24px; }
    .event-label { font-size: 10px; padding: 2px 6px; }

    /* Preview de atributos */
    #attr-preview { gap: 6px !important; }
    #attr-preview > div { padding: 8px 4px !important; }
    #attr-preview .text-2xl { font-size: 1.1rem !important; }
    #attr-preview .text-\[10px\] { font-size: 8px !important; }

    /* Bloco de rolagem de atributo */
    #attr-rolls > div { flex-wrap: wrap !important; gap: 8px !important; padding: 12px !important; }
    #attr-rolls > div button { margin-left: 0 !important; flex: 1 1 100% !important; }

    /* Dado 3D */
    .dice-3d-container { width: 80px; height: 80px; }
    .dice-face { width: 80px; height: 80px; font-size: 32px; border-radius: 12px; }
    .face-front  { transform: rotateY(0deg) translateZ(40px); }
    .face-back   { transform: rotateY(180deg) translateZ(40px); }
    .face-right  { transform: rotateY(90deg) translateZ(40px); }
    .face-left   { transform: rotateY(-90deg) translateZ(40px); }
    .face-top    { transform: rotateX(90deg) translateZ(40px); }
    .face-bottom { transform: rotateX(-90deg) translateZ(40px); }
    #total-result { font-size: 3rem !important; }

    /* Sessão */
    .session-card { padding: 10px; gap: 10px; flex-wrap: wrap; }
    .session-avatar, .session-avatar-fallback { width: 42px; height: 42px; font-size: 16px; }
    .roll-line { font-size: 10px; }

    /* Botões */
    .btn-neon { padding: 10px 20px !important; font-size: 0.8rem !important; letter-spacing: 0.15em !important; }

    /* Armas */
    #weapon-panel .grid-cols-3 { grid-template-columns: 1fr !important; }
    #weapon-list { grid-template-columns: 1fr !important; }

    /* Popup 20 natural */
    #extreme-popup img { width: 7rem !important; height: 7rem !important; }
    #extreme-popup .text-5xl { font-size: 2rem !important; }
    #extreme-popup .text-3xl { font-size: 1.25rem !important; }
}

@media (max-width: 480px) {
    .relative.z-10.max-w-7xl { padding: 0.75rem !important; }
    .ark-panel { padding: 0.85rem !important; border-radius: 10px !important; }

    #dice-container { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; gap: 5px !important; }
    #dice-container > div { padding: 5px !important; }
    #dice-container > div .text-2xl { font-size: 0.95rem !important; }
    #dice-container > div .text-\[11px\] { font-size: 8px !important; }

    .events-grid { grid-template-columns: 1fr; gap: 8px; }
    .event-icon { width: 36px; height: 36px; }
    .event-text-img { height: 20px; }
    .event-label { font-size: 9px; }

    #attr-preview { gap: 4px !important; }
    #attr-preview > div { padding: 6px 2px !important; border-radius: 8px !important; }
    #attr-preview .text-2xl { font-size: 0.95rem !important; }
    #attr-preview .text-\[10px\] { font-size: 7px !important; letter-spacing: 0 !important; }

    .dice-3d-container { width: 64px; height: 64px; }
    .dice-face { width: 64px; height: 64px; font-size: 26px; border-radius: 10px; }
    .face-front  { transform: rotateY(0deg) translateZ(32px); }
    .face-back   { transform: rotateY(180deg) translateZ(32px); }
    .face-right  { transform: rotateY(90deg) translateZ(32px); }
    .face-left   { transform: rotateY(-90deg) translateZ(32px); }
    .face-top    { transform: rotateX(90deg) translateZ(32px); }
    .face-bottom { transform: rotateX(-90deg) translateZ(32px); }

    #total-result { font-size: 2.25rem !important; }
    #individual-rolls { font-size: 10px !important; }

    .session-avatar, .session-avatar-fallback { width: 38px; height: 38px; font-size: 14px; }
    .master-badge { font-size: 7px; padding: 1px 6px; }
    .session-card strong { font-size: 0.85rem; }

    .btn-neon { padding: 9px 16px !important; font-size: 0.7rem !important; letter-spacing: 0.1em !important; }

    #extreme-popup img { width: 5.5rem !important; height: 5.5rem !important; }
    #extreme-popup .text-5xl { font-size: 1.5rem !important; }
    #extreme-popup .text-3xl { font-size: 1rem !important; }
    #extreme-popup .max-w-md { margin: 0.75rem !important; padding: 1.25rem !important; }
}

@media (max-width: 300px) {
    #dice-container { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
    .event-label { font-size: 8px; padding: 1px 5px; }
    .event-icon { width: 30px; height: 30px; }
    .event-text-img { height: 18px; }

    #attr-preview { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; }

    .dice-3d-container { width: 52px; height: 52px; }
    .dice-face { width: 52px; height: 52px; font-size: 20px; border-radius: 8px; }
    .face-front  { transform: rotateY(0deg) translateZ(26px); }
    .face-back   { transform: rotateY(180deg) translateZ(26px); }
    .face-right  { transform: rotateY(90deg) translateZ(26px); }
    .face-left   { transform: rotateY(-90deg) translateZ(26px); }
    .face-top    { transform: rotateX(90deg) translateZ(26px); }
    .face-bottom { transform: rotateX(-90deg) translateZ(26px); }

    #total-result { font-size: 1.75rem !important; }

    .btn-neon { font-size: 0.6rem !important; padding: 8px 12px !important; }
    .session-card { padding: 8px; gap: 8px; }
}
    </style>

    <div class="relative z-10 max-w-7xl mx-auto p-6 space-y-8 text-white">

        {{-- PARÁGRAFO EXPLICATIVO --}}
        <div class="ark-panel p-4 text-center animate-fadeInUp">
            <p class="text-sm theme-text-primary">
                Para utilizar o sistema de rolagens, você deve ter pelo menos uma <strong class="font-bold">Ficha de Personagem</strong> salva na página de <strong class="font-bold">Fichas</strong>.
                Selecione uma ficha no menu abaixo para sincronizar os atributos e bônus.
            </p>
        </div>

        {{-- ============================================================ --}}
        {{-- MESA ATIVA (no TOPO da página)                               --}}
        {{-- ============================================================ --}}
        <div id="session-area" class="ark-panel p-6 hidden animate-fadeInUp">
            <div class="flex flex-wrap justify-between items-start gap-4 mb-5 pb-4 border-b" style="border-color: var(--theme-border)">
                <div class="flex items-center gap-3">
                    <span class="relative flex h-3 w-3">
                        <span class="live-dot absolute inline-flex h-full w-full rounded-full bg-emerald-400"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <div>
                        <h3 class="text-xl font-medieval font-black theme-text-primary tracking-widest">MESA ATIVA</h3>
                        <p class="text-xs text-gray-400 mt-1">
                            Código da sessão:
                            <strong id="session-code-display" class="font-mono text-cyan-300 tracking-widest"></strong>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <label class="flex items-center gap-2 text-[10px] uppercase tracking-widest text-gray-400 cursor-pointer">
                        <input type="checkbox" id="auto-reload-session" checked class="accent-cyan-500">
                        Tempo real
                    </label>
                    <button id="reload-session" class="bg-cyan-500/20 hover:bg-cyan-500/40 border border-cyan-500/30 px-3 py-1.5 rounded text-xs uppercase tracking-widest text-cyan-200 transition">
                        Atualizar
                    </button>
                    <form action="{{ route('session.sair') }}" method="POST" onsubmit="return confirm('Deseja sair da sessão atual?')">
                        @csrf
                        <button type="submit" class="bg-red-900/40 hover:bg-red-800/60 border border-red-500/30 text-red-200 px-3 py-1.5 rounded text-xs uppercase tracking-widest transition">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
            <div id="session-participants-list" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <p class="text-gray-400 text-sm">Carregando participantes...</p>
            </div>
        </div>

        {{-- HEADER E HISTÓRICO RÁPIDO --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 ark-panel p-6 relative overflow-hidden animate-fadeInUp">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>
                <div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none bg-no-repeat bg-right"
                     style="background-image: url('{{ asset('images/bg_scan.gif') }}'); background-size: 200px; background-position: right center;"></div>
                <h2 class="relative text-xl font-medieval font-black uppercase tracking-widest theme-text-primary mb-4">
                    [ Menu de Operações de Ficha ]
                </h2>
                <select id="character-select" class="ark-input w-full">
                    <option value="" class="bg-black">-- Selecione uma Ficha --</option>
                    @foreach($characters as $char)
                        <option value="{{ $char->id }}" data-civilization="{{ strtolower($char->class_sub) }}" class="bg-black">
                            {{ strtoupper($char->name) }} (NÍVEL {{ $char->level }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="ark-panel p-5 animate-fadeInUp" style="animation-delay: 0.1s">
                <h3 class="text-xs theme-text-primary uppercase mb-3 font-bold tracking-widest border-b pb-2" style="border-color: var(--theme-border)">Última Rolagem de Dado</h3>
                <div id="history-dice" class="text-sm text-white font-mono italic bg-black/20 p-3 rounded-lg border" style="border-color: var(--theme-border)">--</div>

                <h3 class="text-xs text-purple-300 uppercase mt-5 mb-3 font-bold tracking-widest border-b pb-2" style="border-color: rgba(168,85,247,0.4)">Última Rolagem de Evento</h3>
                <div id="history-event" class="text-sm text-purple-200 font-mono italic bg-black/20 p-3 rounded-lg border" style="border-color: rgba(168,85,247,0.4)">--</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- COLUNA ESQUERDA: STATUS E TESTES --}}
            <div class="space-y-6">
                <div id="char-preview" class="ark-panel p-6 relative overflow-hidden opacity-40 transition-all duration-700">
                    <h3 class="text-xs uppercase theme-text-primary mb-5 tracking-widest font-medieval">Status da Ficha Selecionada</h3>

                    <div id="attr-preview" class="grid grid-cols-5 gap-3 text-center text-[10px] mb-8">
                        @foreach(['for','agi','int','vig','set'] as $a)
                            <div class="bg-black/30 backdrop-blur-sm p-3 rounded-xl border" style="border-color: var(--theme-border)">
                                <span class="block theme-text-primary/70 font-bold uppercase mb-1">{{ $a }}</span>
                                <span class="text-2xl font-medieval font-black text-white">--</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs uppercase text-emerald-300 mb-2 font-medieval tracking-wider">Bônus Ativos</h4>
                            <div id="bonus-preview" class="text-xs text-gray-200 leading-relaxed bg-black/20 p-3 rounded-lg border" style="border-color: rgba(16,185,129,0.3)">--</div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase theme-text-primary mb-2 font-medieval tracking-wider">Mutações</h4>
                            <div id="mutation-preview" class="text-xs text-gray-200 leading-relaxed bg-black/20 p-3 rounded-lg border" style="border-color: var(--theme-border)">--</div>
                        </div>
                    </div>
                </div>

                <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.2s">
                    <h3 class="text-base font-medieval font-black theme-text-primary mb-5 uppercase tracking-wider">Menu de Atributos</h3>
                    <div id="attr-rolls" class="space-y-4">
                        <div class="text-center text-xs theme-text-primary/50 py-6 italic">Aguardando sincronização com Ficha...</div>
                    </div>
                </div>

                {{-- ARMAS SALVAS --}}
                <div id="weapon-panel" class="ark-panel p-6 hidden animate-fadeInUp" style="animation-delay: 0.25s">
                    <h3 class="text-base font-medieval font-black theme-text-primary mb-5 uppercase tracking-wider">Armas Salvas</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                        <input id="weapon-name"   type="text" placeholder="Nome da arma"      class="ark-input text-sm">
                        <input id="weapon-hit"    type="text" placeholder="Acerto: 3d20+15"    class="ark-input text-sm">
                        <input id="weapon-damage" type="text" placeholder="Dano: 6d12+15"      class="ark-input text-sm">
                    </div>
                    <button id="save-weapon-btn" class="btn-neon w-full">Definir arma</button>

                    <div id="weapon-list" class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-3"></div>
                </div>
            </div>

            {{-- COLUNA DIREITA: DADOS LIVRES E EVENTOS --}}
            <div class="space-y-6">
                <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.3s">
                    <h3 class="text-xs font-bold theme-text-primary uppercase mb-5 tracking-widest font-medieval border-b pb-3 flex justify-between items-center" style="border-color: var(--theme-border)">
                        Manual De Dados
                        <span class="text-[8px] text-gray-400 font-normal normal-case tracking-normal">Clique esquerdo: +1 | Clique direito: -1</span>
                    </h3>

                    <div id="dice-container" class="grid grid-cols-7 gap-2 mb-8"></div>

                    <div class="space-y-5">
                        <div class="flex gap-3">
                            <select id="mode" class="ark-input flex-1 text-xs uppercase font-bold">
                                <option value="sum">Somar Tudo</option>
                                <option value="max">Maior Valor</option>
                            </select>
                            <input type="number" id="bonus-manual" placeholder="Bônus" class="ark-input w-24 text-center text-sm font-bold">
                        </div>

                        <div class="grid grid-cols-6 gap-2">
                            @foreach([5,10,15,20,25,30] as $b)
                                <button onclick="setBonus({{ $b }})" class="bg-black/40 border border-cyan-400/20 hover:bg-cyan-500/30 text-cyan-200 text-xs font-bold p-2 rounded-lg transition-all hover:scale-105">
                                    +{{ $b }}
                                </button>
                            @endforeach
                        </div>

                        <button onclick="rollDice()" class="btn-neon w-full flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm0-10V7a2 2 0 012-2h10a2 2 0 012 2v6a2 2 0 01-2 2h-2"></path>
                            </svg>
                            Rolar Dados
                        </button>
                    </div>

                    <div id="dice-result-display" class="mt-8 p-6 bg-black/40 backdrop-blur-sm border rounded-xl hidden" style="border-color: var(--theme-border)">
                        <div class="flex items-center justify-center gap-8 flex-wrap md:flex-nowrap">
                            <div id="dice-3d-container" class="dice-3d-container"></div>
                            <div class="flex-1 text-center md:text-left">
                                <div id="total-result" class="text-6xl font-medieval font-black theme-text-primary">0</div>
                                <div id="individual-rolls" class="text-xs theme-text-primary/80 mt-2 font-mono uppercase tracking-wider"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.4s">
                    <h3 class="font-medieval font-bold text-base text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-purple-300 mb-5 uppercase tracking-wider">Manual de Eventos Aleatórios</h3>

                    <div class="events-grid">
                        @foreach([
                            'sobrevivencia' => 'Sobrevivência',
                            'efeito'        => 'Efeito',
                            'item'          => 'Item',
                            'traumas'       => 'Traumas',
                            'epicos'        => 'Épicos',
                            'joias'         => 'Joias',
                            'joias_raras'   => 'Joias Raras',
                            'frutas'        => 'Frutas',
                        ] as $key => $label)
                            <div class="event-block" data-event-type="{{ $key }}">
                                <img src="{{ asset('images/evento_'.$key.'_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone {{ $label }}">
                                <div class="flex flex-col items-start gap-1">
                                    <span class="event-label">{{ $label }}</span>
                                    <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                                </div>
                            </div>
                            <div id="event-result-{{ $key }}" class="event-result col-span-full"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- POPUP 20 NATURAL --}}
    <div id="extreme-popup" class="fixed inset-0 z-[9999] flex items-center justify-center pointer-events-none opacity-0 transition-opacity duration-300">
        <div class="bg-black/80 backdrop-blur-md rounded-3xl p-8 text-center shadow-[0_0_30px_rgba(0,242,255,0.3)] border border-cyan-500/30 max-w-md mx-4 transform scale-95 transition-all duration-300">
            <img src="{{ asset('images/Dado_extremo.gif') }}" alt="20 Natural" class="w-40 h-40 mx-auto mb-4 drop-shadow-[0_0_15px_cyan]">
            <div class="text-5xl font-medieval font-black bg-gradient-to-r from-yellow-300 to-yellow-500 bg-clip-text text-transparent tracking-widest drop-shadow-[0_0_30px_rgba(0,242,255,0.3)] animate-pulse">
                20 NATURAL
            </div>
            <div class="text-3xl font-bold text-red-500 uppercase mt-3 animate-bounce drop-shadow-[0_0_6px_red]">
                EXTREMO!
            </div>
            <div class="mt-4 w-24 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent mx-auto"></div>
        </div>
    </div>

    <script>
        // ========== COMPONENTE 20 NATURAL ==========
        let extremeTimeout = null;

        function showExtremePopup() {
            const popup = document.getElementById('extreme-popup');
            if (!popup) return;
            if (extremeTimeout) clearTimeout(extremeTimeout);
            popup.classList.remove('show');
            void popup.offsetWidth;
            popup.classList.add('show');
            extremeTimeout = setTimeout(() => popup.classList.remove('show'), 3000);
        }

        function checkNatural20(rolls, diceType) {
            if (parseInt(diceType) !== 20) return false;
            return rolls.includes(20);
        }

        // ========== PARTÍCULAS DE FUNDO ==========
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

        // ========== SISTEMA DE TEMAS ==========
        const themeColors = {
            padrao:    { primary: '#00f2ff', secondary: '#4deaff' },
            gladio:    { primary: '#f97316', secondary: '#fdba74' },
            iberos:    { primary: '#38bdf8', secondary: '#f472b6' },
            orc:       { primary: '#4ade80', secondary: '#854d0e' },
            fungo:     { primary: '#a855f7', secondary: '#d8b4fe' },
            escarlate: { primary: '#ef4444', secondary: '#fca5a5' }
        };

        function applyTheme(civilizationKey) {
            let civ = themeColors[civilizationKey] || themeColors.padrao;
            document.documentElement.style.setProperty('--theme-primary', civ.primary);
            document.documentElement.style.setProperty('--theme-secondary', civ.secondary);
            document.documentElement.style.setProperty('--theme-glow', `${civ.primary}80`);
            document.documentElement.style.setProperty('--theme-border', `${civ.primary}40`);
            document.documentElement.style.setProperty('--theme-panel-bg', `${civ.primary}0d`);
        }

        const charSelect = document.getElementById('character-select');
        charSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const civ = selectedOption?.dataset?.civilization || 'padrao';
            applyTheme(civ);
        });
        if (charSelect.options.length > 0) {
            const initialCiv = charSelect.options[charSelect.selectedIndex]?.dataset?.civilization || 'padrao';
            applyTheme(initialCiv);
        }

        // ========== LÓGICA DE ROLAGEM ==========
        const diceTypes = [4, 6, 8, 10, 12, 20, 100];
        let diceState = {};
        let selectedCharId = null;
        let selectedCharData = null;

        const container = document.getElementById('dice-container');
        diceTypes.forEach(d => {
            diceState[d] = 0;
            const dieDiv = document.createElement('div');
            dieDiv.className = "bg-black/40 backdrop-blur-sm border rounded-xl p-2 text-center cursor-pointer hover:border-cyan-400 hover:shadow-[0_0_15px_rgba(0,242,255,0.4)] transition-all select-none group relative";
            dieDiv.style.borderColor = "var(--theme-border)";
            dieDiv.innerHTML = `
                <div class="text-[11px] theme-text-primary/70 font-bold uppercase tracking-wider">D${d}</div>
                <div id="count-${d}" class="text-2xl font-medieval font-black text-white">0</div>
                <div class="flex justify-between mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-emerald-400 text-xl font-bold cursor-pointer hover:scale-125" onclick="event.stopPropagation(); updateDice(${d}, 1)">+</span>
                    <span class="text-rose-400 text-xl font-bold cursor-pointer hover:scale-125" onclick="event.stopPropagation(); updateDice(${d}, -1)">−</span>
                </div>
            `;
            dieDiv.addEventListener('click', (e) => {
                if (!e.target.closest('span')) updateDice(d, 1);
            });
            dieDiv.addEventListener('contextmenu', (e) => {
                e.preventDefault();
                updateDice(d, -1);
            });
            container.appendChild(dieDiv);
        });

        function updateDice(d, val) {
            diceState[d] = Math.max(0, diceState[d] + val);
            document.getElementById(`count-${d}`).innerText = diceState[d];
        }

        function setBonus(val) {
            document.getElementById('bonus-manual').value = val;
        }

        function animateDice3D(finalValue) {
            const container3d = document.getElementById('dice-3d-container');
            container3d.innerHTML = '';
            const dice = document.createElement('div');
            dice.className = 'dice-3d';
            const faceValue = finalValue || '?';
            const positions = ['front', 'back', 'right', 'left', 'top', 'bottom'];
            positions.forEach(pos => {
                const face = document.createElement('div');
                face.className = `dice-face face-${pos}`;
                face.textContent = pos === 'front' ? faceValue : ['1', '2', '3', '4', '5', '6'][Math.floor(Math.random() * 6)];
                dice.appendChild(face);
            });
            container3d.appendChild(dice);
            let rotX = Math.random() * 360;
            let rotY = Math.random() * 360;
            dice.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
            const startTime = performance.now();
            const duration = 600;
            function animateSpin(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const spinX = rotX + (1 - easeOut) * 720;
                const spinY = rotY + (1 - easeOut) * 720;
                dice.style.transform = `rotateX(${spinX}deg) rotateY(${spinY}deg)`;
                if (progress < 1) requestAnimationFrame(animateSpin);
                else dice.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
            }
            requestAnimationFrame(animateSpin);
        }

        // ========== CARREGA PERSONAGEM ==========
        charSelect.addEventListener('change', async function() {
            selectedCharId = this.value;
            if (!selectedCharId) return;
            const res = await fetch(`/rolagens/char/${selectedCharId}`);
            const data = await res.json();
            selectedCharData = data.char;
            const preview = document.getElementById('char-preview');
            preview.classList.remove('opacity-40');
            document.getElementById('attr-preview').innerHTML = `
                ${['for','agi','int','vig','set'].map(a => `
                    <div class="bg-black/30 backdrop-blur-sm p-3 rounded-xl border" style="border-color: var(--theme-border)">
                        <span class="block theme-text-primary/70 font-bold uppercase mb-1">${a}</span>
                        <span class="text-2xl font-medieval font-black text-white">${data.char[a]}</span>
                    </div>
                `).join('')}
            `;
            document.getElementById('bonus-preview').innerHTML = data.char.bonuses?.map(b => `<div class="flex justify-between"><span>${escapeHtml(b.name)}</span><span class="text-emerald-300">+${b.value}</span></div>`).join('') || 'Nenhum bônus neural.';
            document.getElementById('mutation-preview').innerHTML = data.char.mutations?.map(m => `<div>${escapeHtml(m.name)}</div>`).join('') || 'DNA estável.';
            if (data.lastRoll) {
                document.getElementById('history-dice').innerText = data.lastRoll.dice_result || '--';
                document.getElementById('history-event').innerText = data.lastRoll.event_result || '--';
            }
            generateAttrBlocks();
            renderArmas();
        });

        function generateAttrBlocks() {
            const c = document.getElementById('attr-rolls');
            c.innerHTML = '';
            for (let i = 0; i < 3; i++) {
                const div = document.createElement('div');
                div.className = "bg-black/40 backdrop-blur-sm border p-4 rounded-xl flex items-center gap-3 flex-wrap md:flex-nowrap";
                div.style.borderColor = "var(--theme-border)";
                div.innerHTML = `
                    <div class="flex items-center gap-2">
                        <div class="attr-icon">
                            <img src="{{ asset('images/dice_icon_atributo.png') }}" alt="dado">
                        </div>
                        <select id="attr-${i}" class="bg-black/60 border border-cyan-400/30 text-cyan-200 p-2 rounded-lg text-xs font-bold uppercase focus:ring-cyan-400/50">
                            <option value="for">FOR</option><option value="agi">AGI</option>
                            <option value="int">INT</option><option value="vig">VIG</option>
                            <option value="set">SET</option>
                        </select>
                    </div>
                    <input id="bonus-${i}" type="number" placeholder="Bônus" class="w-20 bg-black/60 border border-cyan-400/30 p-2 rounded-lg text-center text-xs text-white focus:ring-cyan-400/50">
                    <button onclick="rollAttribute(${i})" class="bg-cyan-600 hover:bg-cyan-500 px-5 py-2 rounded-lg text-xs font-black uppercase tracking-wider text-black transition-all ml-auto">Rolar</button>
                    <div id="result-${i}" class="min-w-[100px] text-right font-medieval font-black theme-text-primary text-lg">---</div>
                `;
                c.appendChild(div);
            }
        }

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
            }[char]));
        }

        function normalizeArsenal(raw) {
            if (!raw) return [];
            try {
                const parsed = typeof raw === 'string' ? JSON.parse(raw) : raw;
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }
        }

        function parseDiceExpression(expr) {
            const value = String(expr ?? '').trim();
            if (!value) return null;
            const match = value.match(/^([0-9]+)d([0-9]+)([+-][0-9]+)?$/i);
            if (!match) return null;
            const diceQty = parseInt(match[1], 10);
            const diceSides = parseInt(match[2], 10);
            const modifier = match[3] ? parseInt(match[3], 10) : 0;
            if (!diceQty || !diceSides) return null;
            return { diceQty, diceSides, modifier };
        }

        function rollDiceExpression(expr, mode = 'damage') {
            const parsed = parseDiceExpression(expr);
            if (!parsed) throw new Error('Fórmula de dado inválida. Use algo como 3d20+15 ou 6d12+15.');
            const rolls = [];
            for (let i = 0; i < parsed.diceQty; i++) {
                rolls.push(Math.floor(Math.random() * parsed.diceSides) + 1);
            }
            let total = 0;
            if (mode === 'attack') {
                total = Math.max(...rolls) + parsed.modifier;
            } else {
                total = rolls.reduce((sum, current) => sum + current, 0) + parsed.modifier;
            }
            return { total, rolls, modifier: parsed.modifier, mode, label: mode === 'attack' ? 'ATAQUE' : 'DANO' };
        }

        function renderArmas() {
            const panel = document.getElementById('weapon-panel');
            const list = document.getElementById('weapon-list');
            if (!panel || !list) return;

            const arsenal = normalizeArsenal(selectedCharData?.arsenal || []);
            if (!selectedCharId || !arsenal.length) {
                panel.classList.add('hidden');
                list.innerHTML = '';
                return;
            }

            panel.classList.remove('hidden');
            list.innerHTML = arsenal.map((weapon, index) => {
                const name   = escapeHtml(weapon?.name || 'Arma');
                const hit    = escapeHtml(weapon?.hit  || '--');
                const damage = escapeHtml(weapon?.damage || '--');
                return `
                    <div class="weapon-card">
                        <div class="weapon-title">${name}</div>
                        <div class="weapon-formula">
                            <div>Acerto: <strong>${hit}</strong></div>
                            <div>Dano:   <strong>${damage}</strong></div>
                        </div>
                        <div class="flex gap-2">
                            <button data-weapon-index="${index}" data-weapon-action="attack" class="weapon-roll weapon-btn attack">Rolar Acerto</button>
                            <button data-weapon-index="${index}" data-weapon-action="damage" class="weapon-roll weapon-btn damage">Rolar Dano</button>
                        </div>
                    </div>
                `;
            }).join('');

            document.querySelectorAll('.weapon-roll').forEach((button) => {
                button.addEventListener('click', () => {
                    const weaponIndex = Number(button.dataset.weaponIndex);
                    const action = button.dataset.weaponAction;
                    const weapon = arsenal[weaponIndex];
                    if (!weapon) return;
                    const expression = action === 'attack' ? weapon.hit : weapon.damage;
                    if (!expression) {
                        alert('Esta arma ainda não tem a fórmula de ' + (action === 'attack' ? 'acerto' : 'dano') + '.');
                        return;
                    }
                    try {
                        const result = rollDiceExpression(expression, action === 'attack' ? 'attack' : 'damage');
                        const label = action === 'attack' ? 'ACERTO' : 'DANO';
                        const finalText = `${label} ${weapon.name.toUpperCase()}: ${result.total} (${result.rolls.join(', ')}${result.modifier !== 0 ? ` ${result.modifier >= 0 ? '+' : ''}${result.modifier}` : ''})`;

                        animateDice3D(result.total);
                        const display = document.getElementById('dice-result-display');
                        display.classList.remove('hidden');
                        document.getElementById('total-result').innerText = result.total;
                        document.getElementById('individual-rolls').innerText = `${label} - [${result.rolls.join(', ')}] ${result.modifier >= 0 ? '+' : ''}${result.modifier}`;

                        saveToDB(finalText, null);
                        document.getElementById('history-dice').innerText = finalText;

                        if (action === 'attack' && checkNatural20(result.rolls, 20)) {
                            showExtremePopup();
                        }
                    } catch (error) {
                        alert(error.message);
                    }
                });
            });
        }

        async function saveWeapon() {
            if (!selectedCharId) {
                alert('Selecione uma ficha antes de salvar a arma.');
                return;
            }
            const name   = document.getElementById('weapon-name').value.trim();
            const hit    = document.getElementById('weapon-hit').value.trim();
            const damage = document.getElementById('weapon-damage').value.trim();

            if (!name) {
                alert('Digite o nome da arma.');
                return;
            }
            if (!hit && !damage) {
                alert('Informe ao menos o acerto ou o dano da arma.');
                return;
            }
            try {
                const response = await fetch('/rolagens/arma/salvar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        character_id: selectedCharId,
                        weapon: { name, hit, damage }
                    })
                });
                const payload = await response.json();
                if (!response.ok) throw new Error(payload.message || 'Não foi possível salvar a arma.');
                selectedCharData.arsenal = payload.arsenal || [];
                document.getElementById('weapon-name').value = '';
                document.getElementById('weapon-hit').value = '';
                document.getElementById('weapon-damage').value = '';
                renderArmas();
            } catch (error) {
                alert(error.message);
            }
        }

        document.getElementById('save-weapon-btn')?.addEventListener('click', saveWeapon);

        // ========== ROLAGEM POR ATRIBUTO ==========
        function rollAttribute(i) {
            if (!selectedCharData) return alert('Sincronize uma unidade primeiro!');
            const attr = document.getElementById(`attr-${i}`).value;
            const bonus = parseInt(document.getElementById(`bonus-${i}`).value) || 0;
            const qtdDados = selectedCharData[attr];

            let rolls = [];
            for (let x = 0; x < qtdDados; x++) rolls.push(Math.floor(Math.random() * 20) + 1);
            const max = Math.max(...rolls);
            const total = max + bonus;
            const resultadoTexto = `TESTE ${attr.toUpperCase()}: ${total} (${max}+${bonus})`;

            document.getElementById(`result-${i}`).innerText = resultadoTexto;
            animateDice3D(total);
            saveToDB(resultadoTexto, null);
            document.getElementById('history-dice').innerText = resultadoTexto;

            if (checkNatural20(rolls, 20)) showExtremePopup();
        }

        // ========== ROLAGEM LIVRE ==========
        function rollDice() {
            if (!selectedCharId) return alert('Selecione uma unidade!');
            let total = 0;
            let rollsDetail = [];
            const mode = document.getElementById('mode').value;
            const bonus = parseInt(document.getElementById('bonus-manual').value) || 0;
            let hasNatural20 = false;

            for (let d in diceState) {
                if (diceState[d] > 0) {
                    let currentRolls = [];
                    for (let i = 0; i < diceState[d]; i++) currentRolls.push(Math.floor(Math.random() * d) + 1);
                    total += (mode === 'sum') ? currentRolls.reduce((a, b) => a + b, 0) : Math.max(...currentRolls);
                    rollsDetail.push(`D${d}:[${currentRolls.join(',')}]`);
                    if (parseInt(d) === 20 && checkNatural20(currentRolls, 20)) hasNatural20 = true;
                }
            }
            total += bonus;
            const resultadoTexto = `LIVRE: ${total} ${rollsDetail.join(' ')}`;

            const display = document.getElementById('dice-result-display');
            display.classList.remove('hidden');
            document.getElementById('total-result').innerText = total;
            document.getElementById('individual-rolls').innerText = rollsDetail.join(' | ');
            animateDice3D(total);
            saveToDB(resultadoTexto, null);
            document.getElementById('history-dice').innerText = resultadoTexto;

            if (hasNatural20) showExtremePopup();
        }

        // ========== EVENTOS ==========
        const eventos = {
    sobrevivencia: [
        "A desolação se faz presente em um silêncio perturbador; nada acontece, apenas o peso do tempo.", 
        "Um estalhar ecoa na vegetação: você ouve um ruído desconhecido que faz seu sangue gelhar.", 
        "Entre os destroços do bioma, o brilho de algo extremamente útil chama a sua atenção.",
        "A terra cede sob seus pés num colapso repentino; o chão cai e o perigo se revela.", 
        "Em meio ao caos, você descobre algo de valor incalculável para a sua sobrevivência.", 
        "Vagando pelas sombras da região, surge um comerciante itinerante oferecendo mercadorias raras.",
        "Seus passos cruzam com os de um sobrevivente — uma face conhecida ou um rosto novo marcados pelas cicatrizes da ilha.", 
        "Você encontra um andarilho com o olhar ardendo em sede de aventura e perigos.",
        "Um viajante solitário cruza o seu caminho, disposto a oferecer auxílio prático.", 
        "Você encontra um aliado extraordinário, cujos recursos e conhecimento mudam o rumo do dia.", 
        "O céu escurece e o ar pesa: a PIOR situação imaginável começa a se desenrolar...",
        "Um vislumbre de esperança surge no horizonte: a MELHOR situação possível acontece!", 
        "Uma névoa espessa e melancólica engole a região, sufocando a visão até a chegada da noite.",
        "Um nevoeiro denso e soturno domina o ambiente, ocultando os perigos até o amanhecer.", 
        "O ar torna-se escaldante e sufocante; uma onda de calor avassaladora consome a região.",
        "O sopro gélido da morte atravessa os vales; uma onda de frio extremo domina a terra.", 
        "O clima manifesta a sua fúria estacional, alterando drasticamente o ecossistema durante este dia.",
        "Ao retornar, percebe que o silêncio da base foi violado: um item foi saqueado por algo ou alguém durante a sua ausência.",
        "Uma perda dolorosa: um dos itens mais valiosos da sua base foi pilhado enquanto você explorava a região.",
        "Em meio aos escombros da terra esquecida, você descobre um item abandonado.", 
        "Escondido sob a poeira do tempo, um item valioso e preservado é encontrado.", 
        "Um estalo seco e o desespero: a engrenagem trava e sua arma de fogo falha no momento mais crítico.",
        "A umidade e o tempo cobram seu preço: uma das armas do grupo enferruja tragicamente durante a jornada.", 
        "O descaso na base cobra seu valor: uma arma mantida no abrigo enferrujou.",
        "Um presságio favorável guia seus passos com sorte inesperada no cumprimento da missão.", 
        "Marcas profundas e recentes no solo denunciam a passagem de um inimigo na região.",
        "Pegadas cobertas de lama revelam o rastro de uma criatura que ronda as proximidades.", 
        "O solo tremeu aqui: marcas gigantescas revelam a passagem de uma criatura Apex ou superior.",
        "Ruínas esquecidas chamam por você: o rastro de um tesouro ou templo antigo surge na vegetação.", 
        "Um feixe luminoso rasga as nuvens: o rastro de um suprimento 'drop' corta o céu.",
        "Um aroma de caça no ar: um rastro denso de recursos animais manifesta-se no bioma.", 
        "Veios expostos na rocha revelam um depósito de minério utilizável na região.",
        "Um brilho metálico incomum chama a atenção: minérios raros estão expostos na região.", 
        "O balanço das ondas trouxe fragmentos de joias reluzentes para a areia da praia.",
        "Trazido pelas marés melancólicas, um item misterioso repousa na praia.", 
        "O mar devolve o que tomou: um náufrago desacordado é encontrado nas praias próximas.",
        "No coração sombrio da floresta mais próxima, um objeto esquecido aguarda ser descoberto.", 
        "A carcaça em decomposição de um animal marinho repousa tragicamente sobre a areia da praia.",
        "Um vislumbre de tempos gloriosos: um mega tesouro ou uma estrutura colossal abandonada é encontrada no litoral.",
        "Entre árvores seculares e sombras espessas, uma estrutura colossal abandonada e repleta de riquezas é descoberta.",
        "Restos mortais e sangue seco: a carcaça de um inimigo tomba na região.", 
        "A carcaça de um rival abatido Jaz na terra, ainda ostentando seus pertences intactos.",
        "Lembranças doces de um passado distante aquecem seu peito calejado. Você recupera 20 pontos de Sanidade.", 
        "A memória de um abraço esquecido traz paz à sua alma inquieta. Você recupera 30 pontos de Sanidade.",
        "Fantasmas do passado sussurram falhas e perdas na sua mente. Você perde 10 pontos de Sanidade.", 
        "Uma dor profunda sufoca seu peito ao lembrar de quem você deixou para trás. Você perde 20 pontos de Sanidade.",
        "O horror e o luto da ilha despedaçam a sua psique. Você perde 30 pontos de Sanidade.", 
        "Seu corpo fraqueja, tomado por um calafrio doentio; você contrai uma enfermidade.",
        "A estrutura acima de você cede: detritos do cenário despencam sobre o seu corpo.", 
        "Seu pé prende-se às raízes e você tropeça dolorosamente contra a terra dura.", 
        "Ao tropeçar e cair de cara no solo, seus olhos encontram algo misterioso escondido sob a folhagem.",
        "Uma ossada colossal em decomposição jaz esquecida, exalando a melancolia dos gigantes que já dominaram esta terra.", 
        "Uma pequena carcaça repousa esquecida na vegetação.", 
        "Restos em decomposição de um animal de médio porte cobrem o solo.",
        "A carcaça imponente de um antigo Apex Predador repousa como um monumento à decadência da vida.", 
        "A sorte lhe deu as costas e o destino cobra seu preço: os Deuses desaprovaram suas ações hoje. Jogue um dado de efeito.",
        "A fúria dos Deuses Anciões recai sobre seu sangue: sua mutação é temporariamente bloqueada.",
        "Sua crueldade agradou às entidades sombrias: se você for diabólico, recebe +2 dados de dano contra humanos.",
        "A providência divina sorri para os seus rituais: se possuir religião, ganha +5 em um bônus por 1 dia.",
        "O estômago ronca com a ferocidade dos selvagens; a ilha lembra que, no fundo, todos são apenas feras famintas.", 
        "Sua garganta seca e a sede consome suas forças.",
        "Ao contemplar as sombras do horizonte, uma revelação cruza a sua mente: você ganha uma pista crucial da narrativa.",
        "Uma energia primitiva inflama seu espírito: motivado pela sobrevivência, você recebe +1d4 cargas de mutação.",
        "Entre a foz e a mata, surge um animal nativo do bioma de sua escolha.", 
        "Nas sombras dos arbustos, uma pequena criatura do bioma observa seus passos.",
        "Um casal de pequenas criaturas cuida com ternura de seus filhotes em meio ao perigo constante do bioma.", 
        "Um filhote indefeso e solitário pia fragilmente na vegetação do bioma.",
        "Um espécime de porte médio atravessa o seu caminho no bioma.", 
        "Um casal de criaturas de médio porte vigia atentamente seus filhotes no ecossistema.",
        "Um filhote de médio porte, desprotegido de seus progenitores, vagueia pelo bioma.", 
        "Olhos famintos e silenciosos brilham na escuridão: predadores de pequeno ou médio porte espreitam seus passos.",
        "O solo vibra sob o peso de uma fera gigantesca: um animal de grande porte ou um Apex do bioma surge à vista.", 
        "Uma família de titãs: um casal de feras Apex de grande porte guarda sua ninhada no bioma.",
        "Um filhote hostil e agressivo de um Apex Predador vagueia solitário, trazendo o instinto violento no sangue.", 
        "Um filhote vulnerável de uma grande besta Apex chora em busca da mãe no bioma.",
        "A presença esmagadora de um APEX Predador faz sua mente balançar à beira do colapso.", 
        "Seus instintos primais assumem o controle enquanto seu corpo reage instantaneamente à emboscada de um APEX Predador.",
        "Quando o destino parecia selado, o estouro de uma manada de herbívoros atropela os seus problemas e abre uma rota de fuga.",
        "O terror do Apex Predador é interrompido quando uma manada colossal de herbívoros gigantes surge, gerando um combate caótico que salva a sua vida.",
        "A pureza da vida renasce: uma manada serena com filhotes dceis estabelece-se ao lado da sua base.", 
        "O chão estremece, os pássaros calam-se e a esperança morre... Um Chefe ancestral encontrou vocês."
    ],
    efeito: [
        "Vigor revigorado: você acorda estimulado e ganha +5 em um atributo ou perícia hoje.", 
        "Inspiração arcana: você acorda estimulado e ganha +1 dado em suas rolagens hoje.",
        "Fúria nas veias: você acorda estimulado e adiciona +1 dado ao seu dano.", 
        "Conexão primordial: você acorda estimulado e canaliza Mana infinita durante este dia.",
        "Toque pestilento: você acorda estimulado e causa +2 dados de dano adicional por sangramento ou peste.",
        "Letargia matinal: você acorda preguiçoso e sofre um penalizador de -5 no seu bônus mais utilizado.", 
        "Assombrado por sombras: você acorda amedrontado e perde 5 de sanidade sempre que cometer uma falha.",
        "Corpo enfraquecido: você acorda combalido e sofre a perda de -1 dado em testes de Vigor e Força.", 
        "Mente nublada: uma enxaqueca lancinante consome seus pensamentos; receba -1 dado em Inteligência e Sabedoria.",
        "Dores profundas: se for mulher, acorda tomada por um sangramento doloroso, sofrendo 1d12 de dano de sangramento.",
        "Atenção dispersa: se for homem, acorda distraído e vulnerável, ficando com a condição 'Marcado' durante toda a sessão.",
        "Favorecido pela sorte: as estrelas alinham-se; receba o dobro de rolagens em dados para encontrar itens, minérios e suprimentos.",
        "Marcado pela guerra: seu corpo carrega os traumas de um combate brutal; receba -5 em todas as ações pelo resto do dia.",
        "Delírios de grandeza: tomado por uma autoconfiança cega, você se sente o protagonista e fica 'Marcado' durante toda a sessão.",
        "Praga no sangue: você acorda debilitado por uma enfermidade e sofre 2d6 de dano por peste no decorrer do dia.",
        "Corpo ardente: incapaz de regular a temperatura corporal, você não consegue usar armaduras sem superaquecer ou exalar um odor desagradável.",
        "Sensibilidade ao frio: o gelo penetra nos seus ossos; sem roupas espessas você fica lento, sofrendo -1 de Agilidade.",
        "Devoção inabalável: com a fé renovada, você pode aplicar sua religião para obter bônus adicionais em testes.",
        "Dúvida devastadora: sem fé para guiá-los, fica proibido o uso de qualquer bônus em equipe durante esta sessão.",
        "O Olhar da Morte: o Lobo Sombrio espreita seus passos nas sombras. Você fica completamente exposto pelo resto da sessão.",
        "Sombra discreta: sua timidez o torna invisível; você inicia qualquer combate desta sessão com o efeito Furtivo.",
        "Natureza sombria: a solidão e a raiva da noite o consomem, tornando-o Diabólico durante esta sessão.",
        "Instabilidade genética: a energia da ilha altera seu DNA; suas mutações ganham chance de evoluir (1d2).",
        "Saciado: seu corpo encontra-se plenamente nutrido; você não precisa consumir alimentos durante a sessão.",
        "Laço predestinado: um sentimento de devoção o conecta a outro jogador; ganhe +5 em qualquer ação realizada em conjunto com ele.",
        "Harmonia com a natureza: os predadores reconhecem a sua aura serena; você ganha chance de ser ignorado (1d2) por feras em cena.",
        "Aura restauradora: uma onda de bondade ilumina seu ser, curando 30 pontos de vida.", 
        "Clareza de espírito: momentos de reflexão profunda restauram 30 pontos de sua sanidade."
    ],
    item: [
        "Pedra", "Saco de Moedas (1d10 Moedas de Prata)", "Saco de Moedas (1d4 Moedas de Ouro)",
        "Sílex", "Areia", "Pelo Seco", "Traje Básico do Ark", "Peça de Vestuário de Couro", "Traje de Inverno",
        "Traje de Banho", "Madeira Bruta", "Madeira Refinada", "Palha", "Fardo Grande de Palha", "Fibra Vegetal",
        "Fibra dos Campos", "Seda", "Seda de Inseto", "Lã", "Lã Rara", "Quitina Comum", "Quitina Espessa",
        "Quitina Rara", "Ossos de Dinossauro", "Fóssil Preservado de Dinossauro",
        "Fragmento Anatômico de Criatura", "Couro Comum", "Couro Emplumado", "Couro Tratado", "Couro de Jacaré",
        "Couro de Abelissauro", "Couro de Ceratopsídeo", "Couro de Acrocantossaurídeo",
        "Couro de Tiranossaurídeo", "Couro de Raptor", "Couro de Hadrossaurídeo",
        "Couro de Saurópode", "Couro de Espinossaurídeo", "Couro de Besta com Presas", "Couro de Dragão",
        "Couro de Criatura da Caveira", "Couro de Réptil Marinho", "Couro de Pterossauro",
        "Couro de Mamífero", "Couro de Criatura Mágica", "Couro de Apex Predador", "Couro de Apex Esquecido",
        "Cimento Natural", "Cimento Industrial", "Resina", "Resina Vermelha", "Âmbar Comum", "Âmbar do Pântano",
        "Âmbar com Inseto Fossilizado", "Pólvora", "Pólvora Negra", "Pólvora do Véu", "Argila", "Fertilizante",
        "Caixa de Temperos", "Petróleo Bruto", "Óleo", "Petróleo Rochoso Natural", "Petróleo Refinado",
        "Óleo Carmesim", "Polímero Orgânico", "Polímero Industrial", "Componente Eletrônico", "Componente Eletrônico TEK",
        "Componente Eletrônico Danificado", "Criopod Vazia", "Criopod com Criatura Comum", "Criopod com Criatura Aleatória (A-M)",
        "Criopod com Criatura Aleatória (N-Z)", "Criopod com Criatura Média à Escolha", "Mapa Rasgado de Explorador"
    ],
    traumas: [
        "Estressado", "Medroso", "Ganancioso", "Paranoico", "Egoísta",
        "Estresse Pós-Traumático", "Insano", "Desesperado", "Letárgico",
        "Fanático", "Degenerado", "Obsessivo", "Delirante", "Silencioso", "Detentor"
    ],
    epicos: [
        "Você encontra um Diamante Lendário (1d4)",
        "Você encontra uma Magnetita Lendária (1d4)",
        "Você encontra uma Netherita Lendária (1d4)",
        "Você encontra um Elemento Lendário (1d4)",
        "Você encontra uma Cianita Lendária (1d4)",
        "Você encontra um Módulo de Minério Lendário (1d4)"
    ],
    joias: [
        "Você encontra uma Gema de Safira",
        "Você encontra uma Gema de Esmeralda",
        "Você encontra uma Gema de Rubi",
        "Você encontra uma Pedra de Redstone",
        "Você encontra um Diamante Reluzente",
        "Você encontra uma Gema Hypo",
        "Você encontra uma Gema da Noite",
        "Você encontra um lote de Pérolas de Sílica",
        "Você encontra um lote de Pérolas Negras"
    ],
    joias_raras: [
        "Você encontra uma Jóia de Elemento",
        "Você encontra um Cristal da Caveira",
        "Você encontra um Cristal do Inferno",
        "Você encontra uma Gema do Véu",
        "Você encontra uma Joia de Mefisto",
        "Você encontra um Dente de Lobo Sombrio",
        "Você encontra uma Lã Lisa e Alva de Ovelha",
        "Você encontra uma Esfera de Íons",
        "Você encontra um Medalhão de Ouro Amaldiçoado",
        "Você encontra uma Gema Solar"
    ],
    frutas: [
        "Amarberry", "Azulberry", "Mejoberry", "Narcoberry", "Stimberry",
        "Tintoberry", "Planta X", "Semente de Trigo", "Semente de Arroz",
        "Semente de Soja", "Limão", "Milho", "Cenoura", "Batata", "Maçã",
        "Banana", "Manga", "Cereja"
    ]
};

        document.querySelectorAll('.event-icon').forEach(icon => {
            const block = icon.closest('.event-block');
            const type = block.dataset.eventType;
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.add('rotate-icon');
                setTimeout(() => this.classList.remove('rotate-icon'), 600);
                const list = eventos[type];
                if (list && list.length) {
                    const result = list[Math.floor(Math.random() * list.length)];
                    const resultDiv = document.getElementById(`event-result-${type}`);
                    resultDiv.innerHTML = `<span class="block text-purple-200">${escapeHtml(result)}</span>`;
                    resultDiv.style.display = 'block';
                    saveToDB(null, `${type.toUpperCase()}: ${result}`);
                    document.getElementById('history-event').innerText = result;
                } else {
                    console.warn(`Lista de eventos para ${type} não encontrada`);
                }
            });
        });

        // ========== SALVAR + REFRESH IMEDIATO ==========
        function saveToDB(dice, event) {
            if (!selectedCharId) return;
            return fetch('/rolagens/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    character_id: selectedCharId,
                    dice_result: dice,
                    event_result: event
                })
            })
            .then(() => {
                // Atualização local instantânea (não espera o SSE empurrar de volta)
                carregarSessaoAtiva();
            })
            .catch(console.error);
        }

        // ============================================================
        // SESSÃO EM TEMPO REAL — SSE com reconexão, polling como fallback
        // ============================================================
        let sessionEventSource = null;
        let sessionPollingTimer = null;
        const SESSION_POLL_INTERVAL = 1000; // 1 segundo (fallback rápido)

        const lastSeenRolls = {};
        const lastSeenEvents = {};

        function buildAvatar(p) {
            const initial = (p.name || '?').charAt(0).toUpperCase();
            if (p.foto) {
                return `<img src="${p.foto}" alt="${escapeHtml(p.name)}" class="session-avatar"
                    onerror="this.replaceWith(Object.assign(document.createElement('div'),{className:'session-avatar-fallback',textContent:'${initial}'}))">`;
            }
            return `<div class="session-avatar-fallback">${initial}</div>`;
        }

        function renderSession(data) {
            const area = document.getElementById('session-area');
            if (!area) return;

            if (!data || !data.in_session) {
                area.classList.add('hidden');
                return;
            }

            area.classList.remove('hidden');
            const codeEl = document.getElementById('session-code-display');
            if (codeEl) codeEl.innerText = data.session_code || '';

            const c = document.getElementById('session-participants-list');
            if (!c) return;

            const participants = data.participants || [];

            participants.sort((a, b) => {
                if (a.is_master && !b.is_master) return -1;
                if (!a.is_master && b.is_master) return 1;
                return (a.name || '').localeCompare(b.name || '');
            });

            c.innerHTML = participants.map(p => {
                const uid = p.user_id;
                const diceChanged  = lastSeenRolls[uid] !== undefined && lastSeenRolls[uid] !== p.last_dice && p.last_dice;
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
        }

        // ---------- Polling (fallback rápido) ----------
        function startSessionPolling() {
            if (sessionPollingTimer) return;
            carregarSessaoAtiva();
            sessionPollingTimer = setInterval(carregarSessaoAtiva, SESSION_POLL_INTERVAL);
        }
        function stopSessionPolling() {
            if (sessionPollingTimer) {
                clearInterval(sessionPollingTimer);
                sessionPollingTimer = null;
            }
        }

        function carregarSessaoAtiva() {
            return fetch('/sessao/minha-sessao?_=' + Date.now(), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                cache: 'no-store'
            })
            .then(res => res.json())
            .then(data => renderSession(data))
            .catch(() => {});
        }

        // ---------- SSE (primário) ----------
        let sseErrorCount = 0;

        function startSessionStream() {
            if (sessionEventSource) return;
            if (!window.EventSource) {
                startSessionPolling();
                return;
            }

            carregarSessaoAtiva();

            try {
                sessionEventSource = new EventSource('/sessao/stream?_=' + Date.now());
            } catch (e) {
                sessionEventSource = null;
                startSessionPolling();
                return;
            }

            // RESET do contador ao abrir (corrige o bug dos 90s)
            sessionEventSource.onopen = () => {
                sseErrorCount = 0;
            };

            sessionEventSource.addEventListener('update', (e) => {
                sseErrorCount = 0; // Zera também a cada mensagem recebida
                try {
                    const data = JSON.parse(e.data);
                    renderSession(data);
                } catch (err) {
                    console.error('SSE parse error', err);
                }
            });

            sessionEventSource.addEventListener('ended', () => {
                stopSessionStream();
                stopSessionPolling();
                const area = document.getElementById('session-area');
                if (area) area.classList.add('hidden');
            });

            sessionEventSource.addEventListener('nosession', () => {
                stopSessionStream();
                const area = document.getElementById('session-area');
                if (area) area.classList.add('hidden');
            });

            // Só cai para polling se falhar MUITAS vezes seguidas.
            // O browser reconecta automaticamente, então erros esporádicos
            // (ex: fechamento normal a cada 5s) não contam.
            sessionEventSource.onerror = () => {
                sseErrorCount++;
                if (sseErrorCount >= 10) {
                    console.warn('SSE falhou 10x seguidas, alternando para polling.');
                    stopSessionStream();
                    startSessionPolling();
                }
            };
        }

        function stopSessionStream() {
            if (sessionEventSource) {
                try { sessionEventSource.close(); } catch (e) {}
                sessionEventSource = null;
            }
        }

        // ---------- Inicialização ----------
        carregarSessaoAtiva();
        startSessionStream();

        // ---------- Controles manuais ----------
        document.getElementById('reload-session')?.addEventListener('click', () => {
            carregarSessaoAtiva();
        });

        document.getElementById('auto-reload-session')?.addEventListener('change', (e) => {
            if (e.target.checked) {
                startSessionStream();
                if (!window.EventSource) startSessionPolling();
            } else {
                stopSessionStream();
                stopSessionPolling();
            }
        });

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                carregarSessaoAtiva();
                const auto = document.getElementById('auto-reload-session')?.checked;
                if (auto && !sessionEventSource) {
                    startSessionStream();
                }
            }
        });

        window.addEventListener('beforeunload', () => {
            stopSessionStream();
            stopSessionPolling();
        });
    </script>
</x-app-layout>