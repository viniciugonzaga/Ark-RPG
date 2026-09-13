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
                "Nada acontece", "Você ouve um barulho desconhecido", "Você ouve ou vê algo muito útil",
                "O chão cai", "Você ouve ou vê algo verdadeiramente útil", "Você encontra um comerciante de alguma área da região",
                "Você encontra um NPC conhecido ou novo na região", "Você encontra um NPC com vontade de aventura",
                "Você encontra um NPC útil", "Você encontra um NPC verdadeiramente útil", "A PIOR situação acontece...",
                "A MELHOR situação acontece...", "Um nevoeiro ou neblina domina a região até a noite",
                "Um nevoeiro ou neblina domina a região até amanhecer", "Uma onda de calor domina a região",
                "Uma onda de frio domina a região", "Uma onda climática estacional domina a região nesse dia",
                "Um item da base é saqueado por alguém ou algo, enquanto em jornada",
                "Um item valioso da base é saqueado por alguém ou algo, enquanto em jornada",
                "Um item é encontrado", "Um item valioso é encontrado", "Armas de fogo travam ou ficam com defeito na aventura",
                "Uma arma do grupo enferruja em jornada", "Uma arma do grupo enferruja na base",
                "Um caminho de sorte é guiado sobre a missão", "Um rastro de um inimigo fica aparente na região",
                "Um rastro de uma criatura fica aparente na região", "Um rastro de uma criatura Apex ou maior fica aparente na região",
                "Um rastro de um tesouro ou templo fica aparente na região", "Um rastro de um 'drop' fica aparente no céu",
                "Um conjunto de recursos animais fica aparente na região", "Um tipo de minério fica aparente na região",
                "Um tipo de minério raro fica aparente na região", "Um tipo de joia aparece nas praias próximas",
                "Um item aparece nas praias próximas", "Um náufrago aparece nas praias próximas",
                "Um item aparece no meio da floresta mais próxima", "Uma carcaça fica aparente na praia",
                "Um mega tesouro ou estrutura abandonada é encontrada nas praias mais próximas",
                "Um mega tesouro ou estrutura abandonada é encontrada nas florestas mais próximas",
                "Uma carcaça de um inimigo fica aparente na região", "Uma carcaça de um inimigo com itens fica à mostra na região",
                "Você lembra de momentos bons, recupera +20 de Sanidade", "Você lembra de momentos bons, recupera +30 de Sanidade",
                "Você lembra de momentos ruins, perde 10 de Sanidade", "Você lembra de momentos ruins, perde 20 de Sanidade",
                "Você lembra de momentos ruins, perde 30 de Sanidade", "Você não se sente bem e contrai uma doença",
                "Algo do cenário cai em você", "Você tropeça", "Você tropeça e acha algo escondido no chão",
                "Você encontra uma carcaça grande", "Você encontra uma carcaça pequena", "Você encontra uma carcaça média",
                "Você encontra uma carcaça de Apex Predador velho ou morto", "Os Deuses não gostaram de você hoje, jogue um dado de efeito",
                "O Deus Ancião não gostou das suas ações hoje, sua mutação é bloqueada temporariamente.",
                "O Deus Ancião gostou das suas ações hoje, se for diabólico, recebe +2 dados de dano contra humanos.",
                "Os Deuses gostaram das suas ações hoje, se tiver religião, ganha +5 em um bônus por 1 dia.",
                "Você se sente com muita fome, a ilha sabe que todos são animais", "Você sente sede",
                "Você reflete sobre um cenário em sua mente e ganha uma dica da narrativa.",
                "Você se sente motivado hoje, recebe mais cargas de mutação (1d4)",
                "Você encontra um animal do bioma de sua escolha", "Você encontra uma criatura pequena, do bioma",
                "Você encontra um casal pequeno com filhotes do bioma", "Você encontra um filhote pequeno indefeso do bioma",
                "Você encontra um animal médio, do bioma", "Você encontra um casal médio, com filhotes do bioma",
                "Você encontra um filhote médio indefeso do bioma", "Você encontra animais maldosos médios ou pequenos te espreitando",
                "Você encontra um animal grande ou Apex do bioma", "Você encontra um casal grande ou Apex do bioma, com filhotes",
                "Você encontra um filhote maldoso grande ou Apex sozinho do bioma", "Você encontra um filhote grande ou Apex indefeso do bioma",
                "Sua mente é abalada com um encontro de um APEX Predador", "Seu corpo reage contra uma emboscada de um APEX Predador",
                "Vocês são salvos de algum problema por uma manada de herbívoros",
                "Vocês são salvos de um Apex Predador por surgir uma manada APEX de herbívoros",
                "Uma manada surge com filhotes bonzinhos ao lado da base", "Desculpe, mas um chefe encontrou vocês..."
            ],
            efeito: [
                "Buff do dia, acorda estimulado, +5 em algo", "Buff do dia, acorda estimulado, +1 dado em algo",
                "Buff do dia, acorda estimulado, +1 dado de dano", "Buff do dia, acorda estimulado, Mana infinita",
                "Buff do dia, acorda estimulado, causa +2 dados de dano em sangramento ou em peste",
                "Nerf do dia, acorda preguiçoso, -5 no bônus mais usável", "Nerf do dia, acorda amedrontado, -5 de sanidade sempre que errar",
                "Nerf do dia, acorda defeituoso, -1 dado em vigor e força", "Nerf do dia, dor de cabeça, -1 dado de inteligência e sabedoria",
                "Condição, se for mulher, acorda com sangramento, 1d12 de dano de sangramento",
                "Condição, se for homem, acorda distraído, fica marcado a sessão toda",
                "Condição, sortudo, dobro de rolagens em dados de itens, minérios e drops",
                "Condição, destroçado, sobreviveu a um combate intenso, -5 em ações no resto do dia",
                "Condição, protagonista, se sente o especial, fica marcado a sessão toda",
                "Condição, doente, acorda ou fica fraco no resto do dia, recebe 2d6 de dano de peste",
                "Condição, calorento, não consegue usar armaduras sem superaquecer ou cheirar mal no resto do dia",
                "Condição, friento, não consegue ficar sem roupas grossas sem ficar lento, -1 de agilidade",
                "Condição, com fé, pode usar religião em bônus adicionais de testes",
                "Condição, sem fé, é proibido o uso de bônus em equipe durante a sessão",
                "Condição, caçado pelo Lobo, ele está te observando, infelizmente você está exposto no resto da sessão",
                "Condição, tímido, durante a sessão começa qualquer combate com o efeito Furtivo",
                "Condição, Diabólico, se sente solitário e raivoso à noite, se tornando diabólico durante a sessão",
                "Condição, Distorção de mutação, suas mutações possuem chance de evoluir (1d2)",
                "Condição, Alimentado, se sente satisfeito e não precisa comer durante o dia na sessão",
                "Condição, Apaixonado, se sente unido e depende de um jogador, ganhando +5 em uma ação em conjunto com ele",
                "Condição, Amigo dos animais, se sente confortável com dinossauros e tem chance de ser ignorado (1d2) por predadores na cena",
                "Condição, Bondade, cura 30 pontos de vida", "Condição, Reflexivo, recupera 30 pontos de sanidade"
            ],
            item: [
                "Pedra", "Um Saco de Moedas aleatório 1d10 (Moeda de Prata)", "Um Saco de Moedas aleatório 1d4 (Moeda de Ouro)",
                "Sílex", "Areia", "Pelo Seco", "Roupa do Ark Básica", "Roupa de Couro com Parte", "Roupa do Inverno",
                "Roupa de Banho", "Madeira natural", "Madeira refinada", "palha", "Monte grande de Palha", "Fibra",
                "Fibra do Campos", "Seda", "Seda de Inseto", "Lã", "Lã rara", "Quitina comum", "Quitina grossa",
                "Quitina rara", "Ossos de um dinossauro", "Fóssil preservado de um Dinossauro",
                "Parte de dinossauro ou criatura", "Couro comunm", "Couro de Penas", "Couro", "Couro de jacaré",
                "Couro de Abelissauro", "Couro de Ceratopcideos", "Couro de Acrocantosssaurideos",
                "Couro de tiranossaurideos", "Couro de raptores", "Couro de Handrossaurideos",
                "Couro de Saurópodes", "Couro de Espinossaurideos", "Couro de Presas", "Couro de Dragão",
                "Couro de Criatura da Caveira", "Couro de réptil Marinho", "Couro de Grupo dos Pterossauros",
                "Couro de Mamiferos", "Couro de Criatura Mágica", "Couro de Apex predador", "Couro de Apex esquecido",
                "Cimento Natural", "Cimento Industrial", "Resina", "Resina vermelha", "Ambâr comum", "Ambâr do pantâno",
                "Ambâr com inseto", "pólvora", "pólvora negra", "pólvora do véu", "Argila", "Fertilizante",
                "Caixa de temperos", "Pétróleo", "óleo", "Petróelo Natural rochosso", "Pétróelo refinado",
                "Óleo Carmsein", "Polimero Orgânico", "Polimero industrial", "Eletrônico", "Eletrônico tek",
                "Eletrônico Quebrado", "Criopod vazia", "Criopod com Animal comum", "Criopod com Animal de A-M aleatório",
                "Criopod com Animal de N-Z aleatório", "Criopod com Animal Médio de Seleção", "Mapa Rasgado de Explorador"
            ],
            traumas: [
                "Estressado", "Medroso", "Ganancioso", "Paranoico", "Egoísta",
                "Estresse Pós-Traumático", "Insano", "Desesperado", "Letárgico",
                "Fanático", "Degenerado", "Obsessivo", "Delirante", "Silencioso", "Detentor"
            ],
            epicos: [
                "Você encontra um Lendário Diamante(1d4)",
                "Você encontra uma Lendária Magnetita(1d4)",
                "Você encontra um Lendário Netherite(1d4)",
                "Você encontra um Lendário Elemento(1d4)",
                "Você encontra uma Lendária Cianita(1d4)",
                "Você encontra um Lendário Módulo de Minério(1d4)"
            ],
            joias: [
                "Você encontra uma Jóia de Sáfira",
                "Você encontra uma Jóia de Esmeralda",
                "Você encontra uma Jóia de Rubi",
                "Você encontra uma Jóia de Redstone",
                "Você encontra uma Jóia de Diamante",
                "Você encontra uma Jóia Hypo",
                "Você encontra uma Jóia da Noite",
                "Você encontra uma quantia de Pérolas Sílicas",
                "Você encontra uma quantia de Pérolas Negras"
            ],
            joias_raras: [
                "Você encontra uma Jóia de Elemento",
                "Você encontra uma Jóia de Cristal da Caveira",
                "Você encontra uma Jóia de Cristal do Inferno",
                "Você encontra uma Jóia do Véu",
                "Você encontra uma Jóia de Mefisto",
                "Você encontra um Dente de Lobo Escuro",
                "Você encontra um Pelo liso branco de Ovelha",
                "Você encontra uma Esféra de Ion",
                "Você encontra um Medalão de Ouro Maldito",
                "Você encontra uma Jóia Solar"
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
        // SESSAO EM TEMPO REAL — SSE primário, polling como fallback
        // ============================================================
        let sessionEventSource = null;
        let sessionPollingTimer = null;
        const SESSION_POLL_INTERVAL = 1500; // usado apenas se SSE falhar

        // Guarda a última rolagem vista por usuário para destacar mudanças
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

            // Ordena: mestre primeiro, depois por nome
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

        // ---------- Fallback: polling rápido ----------
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
            return fetch('/sessao/minha-sessao', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => renderSession(data))
            .catch(() => {});
        }

        // ---------- Primário: SSE ----------
        function startSessionStream() {
            if (sessionEventSource) return;
            if (!window.EventSource) {
                startSessionPolling();
                return;
            }

            // Carrega estado inicial imediatamente
            carregarSessaoAtiva();

            try {
                sessionEventSource = new EventSource('/sessao/stream');
            } catch (e) {
                sessionEventSource = null;
                startSessionPolling();
                return;
            }

            sessionEventSource.addEventListener('update', (e) => {
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

            // Reconexão: o browser faz automaticamente. Se falhar 3x, cai para polling.
            let errorCount = 0;
            sessionEventSource.onerror = () => {
                errorCount++;
                if (errorCount >= 3) {
                    stopSessionStream();
                    startSessionPolling();
                }
            };

            // Reset do contador quando recebe algo
            sessionEventSource.addEventListener('update', () => { errorCount = 0; });
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

        // Reconectar quando a aba volta a ficar visível
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                carregarSessaoAtiva();
                const auto = document.getElementById('auto-reload-session')?.checked;
                if (auto && !sessionEventSource) {
                    startSessionStream();
                }
            }
        });

        // Fechar stream ao sair da página
        window.addEventListener('beforeunload', () => {
            stopSessionStream();
            stopSessionPolling();
        });
    </script>
</x-app-layout>