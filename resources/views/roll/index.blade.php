{{-- resources/views/rolagens/index.blade.php --}}
<x-app-layout>
    <x-slot name="title">Rolagens - ARK RPG</x-slot>

    {{-- Meta tags para prévia social --}}
    <meta property="og:title" content="Rolagens - ARK RPG" />
    <meta property="og:description" content="Sistema de rolagem de dados para ARK RPG" />
    <meta property="og:image" content="{{ asset('images/capa_rolagens.png') }}" />

    {{-- Fundo fixo com imagem e overlay --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_rolagens.png') }}" class="w-full h-full object-cover opacity-40">
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
        .animate-fadeInUp { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; opacity: 0; }
        .animate-scan-line { animation: scan-line 3s linear infinite; }
        .rotate-icon { animation: rotate-icon 0.6s ease-out; }
        .pulse-glow { animation: pulse-glow 1.5s infinite; }

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
        .historico-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .historico-scroll::-webkit-scrollbar-track {
            background: #1a1a1a;
            border-radius: 10px;
        }
        .historico-scroll::-webkit-scrollbar-thumb {
            background: var(--theme-primary);
            border-radius: 10px;
        }

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
        .attr-icon img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        /* Bloco de evento (layout em grid) */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }
        #extreme-popup.show {
         opacity: 1;
         pointer-events: auto;
     }
       #extreme-popup.show > div {
        transform: scale(1);
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
        .event-icon:hover {
            transform: scale(1.05);
        }
        .event-icon:active {
            transform: scale(0.95);
        }
        .event-text-img {
            height: 32px;
            object-fit: contain;
        }
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
        .tooltip-icon {
            position: relative;
            cursor: help;
        }
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
        .tooltip-icon:hover::after {
            opacity: 1;
        }

        /* Popup 20 Natural */
        #extreme-popup {
            transition: opacity 0.3s ease;
        }
        #extreme-popup.show {
            opacity: 1;
            pointer-events: auto;
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
                        <option value="{{ $char->id }}" data-civilization="{{ strtolower($char->class_sub) }}" class="bg-black">{{ strtoupper($char->name) }} (NÍVEL {{ $char->level }})</option>
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
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-cyan-400/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
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
            </div>

            {{-- COLUNA DIREITA: DADOS LIVRES E EVENTOS --}}
            <div class="space-y-6">
                {{-- DICE SYSTEM 3D --}}
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

                {{-- MANUAL DE EVENTOS ALEATÓRIOS --}}
                <div class="ark-panel p-6 animate-fadeInUp" style="animation-delay: 0.4s">
                    <h3 class="font-medieval font-bold text-base text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-purple-300 mb-5 uppercase tracking-wider">Manual de Eventos Aleatórios</h3>
                    
                    <div class="events-grid">
                        {{-- Sobrevivência --}}
                        <div class="event-block" data-event-type="sobrevivencia">
                            <img src="{{ asset('images/evento_sobrevivencia_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Sobrevivência">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Sobrevivência</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-sobrevivencia" class="event-result col-span-full"></div>

                        {{-- Efeito --}}
                        <div class="event-block" data-event-type="efeito">
                            <img src="{{ asset('images/evento_efeito_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Efeito">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Efeito</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-efeito" class="event-result col-span-full"></div>

                        {{-- Item --}}
                        <div class="event-block" data-event-type="item">
                            <img src="{{ asset('images/evento_item_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Item">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Item</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-item" class="event-result col-span-full"></div>

                        {{-- Traumas --}}
                        <div class="event-block" data-event-type="traumas">
                            <img src="{{ asset('images/evento_traumas_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Traumas">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Traumas</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-traumas" class="event-result col-span-full"></div>

                        {{-- Épicos --}}
                        <div class="event-block" data-event-type="epicos">
                            <img src="{{ asset('images/evento_epicos_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Épicos">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Épicos</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-epicos" class="event-result col-span-full"></div>

                        {{-- Joias --}}
                        <div class="event-block" data-event-type="joias">
                            <img src="{{ asset('images/evento_joias_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Joias">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Joias</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-joias" class="event-result col-span-full"></div>

                        {{-- Joias Raras --}}
                        <div class="event-block" data-event-type="joias_raras">
                            <img src="{{ asset('images/evento_joias_raras_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Joias Raras">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Joias Raras</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-joias_raras" class="event-result col-span-full"></div>

                        {{-- Frutas --}}
                        <div class="event-block" data-event-type="frutas">
                            <img src="{{ asset('images/evento_frutas_icon.png') }}" class="event-icon tooltip-icon pulse-glow" alt="Ícone Frutas">
                            <div class="flex flex-col items-start gap-1">
                                <span class="event-label">Frutas</span>
                                <img src="{{ asset('images/rolar_evento_text.png') }}" class="event-text-img" alt="Rolar Evento">
                            </div>
                        </div>
                        <div id="event-result-frutas" class="event-result col-span-full"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ÁREA DE SESSÃO ATIVA (oculta por padrão) --}}
        <div id="session-area" class="ark-panel p-6 hidden animate-fadeInUp mt-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-medieval font-black theme-text-primary">Mesa Ativa</h3>
                    <p class="text-sm text-gray-300">Você está participando da sessão <strong id="session-code-display" class="font-mono text-cyan-300"></strong></p>
                </div>
                <form action="{{ route('session.sair') }}" method="POST" onsubmit="return confirm('Deseja sair da sessão atual?')">
                    @csrf
                    <button type="submit" class="bg-red-800 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">Sair da Sessão</button>
                </form>
            </div>
            <div class="flex justify-between items-center mb-3">
                <div class="flex gap-3">
                    <button id="reload-session" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm">⟳ Recarregar</button>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" id="auto-reload-session"> Auto (5s)
                    </label>
                </div>
            </div>
            <div id="session-participants-list" class="space-y-3">
                <p class="text-gray-400">Carregando participantes...</p>
            </div>
        </div>
{{-- POPUP 20 NATURAL --}}
 <div id="extreme-popup" class="fixed inset-0 z-[9999] flex items-center justify-center pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="bg-black/80 backdrop-blur-md rounded-3xl p-8 text-center shadow-[0_0_30px_rgba(0,242,255,0.3)] border border-cyan-500/30 max-w-md mx-4 transform scale-95 transition-all duration-300">
        <img src="{{ asset('images/Dado_extremo.gif') }}" alt="20 Natural" class="w-40 h-40 mx-auto mb-4 drop-shadow-[0_0_15px_cyan]">
        <div class="text-5xl font-medieval font-black bg-gradient-to-r from-yellow-300 to-yellow-500 bg-clip-text text-transparent tracking-widest drop-shadow-[0_0_30px_rgba(0,242,255,0.3))] animate-pulse">
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
            void popup.offsetWidth; // força reflow
            popup.classList.add('show');
            extremeTimeout = setTimeout(() => {
                popup.classList.remove('show');
            }, 3000);
        }

        function checkNatural20(rolls, diceType) {
            if (diceType != 20) return false;
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
            padrao: { primary: '#00f2ff', secondary: '#4deaff' },
            gladio: { primary: '#f97316', secondary: '#fdba74' },
            iberos: { primary: '#38bdf8', secondary: '#f472b6' },
            orc: { primary: '#4ade80', secondary: '#854d0e' },
            fungo: { primary: '#a855f7', secondary: '#d8b4fe' },
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
                face.textContent = pos === 'front' ? faceValue : ['⚀','⚁','⚂','⚃','⚄','⚅'][Math.floor(Math.random()*6)];
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

        // CARREGA PERSONAGEM
        charSelect.addEventListener('change', async function() {
            selectedCharId = this.value;
            if(!selectedCharId) return;
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
            document.getElementById('bonus-preview').innerHTML = data.char.bonuses?.map(b => `<div class="flex justify-between"><span>${b.name}</span><span class="text-emerald-300">+${b.value}</span></div>`).join('') || 'Nenhum bônus neural.';
            document.getElementById('mutation-preview').innerHTML = data.char.mutations?.map(m => `<div>${m.name}</div>`).join('') || 'DNA estável.';
            if(data.lastRoll){
                document.getElementById('history-dice').innerText = data.lastRoll.dice_result || '--';
                document.getElementById('history-event').innerText = data.lastRoll.event_result || '--';
            }
            generateAttrBlocks();
        });

        function generateAttrBlocks() {
            const container = document.getElementById('attr-rolls');
            container.innerHTML = '';
            for(let i=0; i<3; i++){
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
                container.appendChild(div);
            }
        }

        // ========== ROLAGEM POR ATRIBUTO (com detecção de 20 natural) ==========
        function rollAttribute(i){
            if(!selectedCharData) return alert('Sincronize uma unidade primeiro!');
            const attr = document.getElementById(`attr-${i}`).value;
            const bonus = parseInt(document.getElementById(`bonus-${i}`).value) || 0;
            const qtdDados = selectedCharData[attr];
            
            let rolls = [];
            for(let x=0; x < qtdDados; x++) rolls.push(Math.floor(Math.random()*20)+1);
            const max = Math.max(...rolls);
            const total = max + bonus;
            const resultadoTexto = `TESTE ${attr.toUpperCase()}: ${total} (${max}+${bonus})`;
            
            document.getElementById(`result-${i}`).innerText = resultadoTexto;
            animateDice3D(total);
            saveToDB(resultadoTexto, null);
            document.getElementById('history-dice').innerText = resultadoTexto;
            
            if (checkNatural20(rolls, 20)) {
                showExtremePopup();
            }
        }

        // ========== ROLAGEM LIVRE (com detecção de 20 natural) ==========
        function rollDice() {
            if(!selectedCharId) return alert('Selecione uma unidade!');
            let total = 0; let rollsDetail = [];
            const mode = document.getElementById('mode').value;
            const bonus = parseInt(document.getElementById('bonus-manual').value) || 0;
            let hasNatural20 = false;

            for (let d in diceState) {
                if (diceState[d] > 0) {
                    let currentRolls = [];
                    for (let i = 0; i < diceState[d]; i++) currentRolls.push(Math.floor(Math.random() * d) + 1);
                    total += (mode === 'sum') ? currentRolls.reduce((a, b) => a + b, 0) : Math.max(...currentRolls);
                    rollsDetail.push(`D${d}:[${currentRolls.join(',')}]`);
                    if (parseInt(d) === 20 && checkNatural20(currentRolls, 20)) {
                        hasNatural20 = true;
                    }
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
            
            if (hasNatural20) {
                showExtremePopup();
            }
        }

        // ========== EVENTOS ==========
        // ============================================================
        // COLE AQUI A LISTA COMPLETA DE EVENTOS (sobrevivencia, efeito, item, traumas, epicos, joias, joias_raras, frutas)
        // ============================================================
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
                "Você encontra uma quantia de Pérolas Negras "
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

        // Adicionar evento de clique em todos os ícones de evento
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
                    resultDiv.innerHTML = `<span class="block text-purple-200">${result}</span>`;
                    resultDiv.style.display = 'block';
                    saveToDB(null, `${type.toUpperCase()}: ${result}`);
                    document.getElementById('history-event').innerText = result;
                } else {
                    console.warn(`Lista de eventos para ${type} não encontrada`);
                }
            });
        });

        function saveToDB(dice, event) {
            if (!selectedCharId) return;
            fetch('/rolagens/save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ character_id: selectedCharId, dice_result: dice, event_result: event })
            }).catch(console.error);
        }

        // ========== SESSÃO ATIVA ==========
        let sessionAutoInterval = null;

        function carregarSessaoAtiva() {
            fetch('/sessao/minha-sessao')
                .then(res => res.json())
                .then(data => {
                    if (data.in_session) {
                        document.getElementById('session-area').classList.remove('hidden');
                        document.getElementById('session-code-display').innerText = data.session_code;
                        const container = document.getElementById('session-participants-list');
                        container.innerHTML = data.participants.map(p => `
                            <div class="bg-black/40 border border-cyan-500/30 rounded-lg p-4 flex flex-wrap justify-between items-center">
                                <div>
                                    <strong class="text-cyan-300">${p.name}</strong>
                                    ${p.is_master ? '<span class="text-purple-400 text-xs ml-2">(Mestre)</span>' : ''}
                                    <span class="text-xs text-gray-400 ml-2">${p.crystal_id}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm">Dado: <span class="font-mono text-cyan-200">${p.last_dice}</span></div>
                                    <div class="text-sm">Evento: <span class="font-mono text-purple-200">${p.last_event}</span></div>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        document.getElementById('session-area').classList.add('hidden');
                    }
                });
        }

        carregarSessaoAtiva();

        document.getElementById('reload-session')?.addEventListener('click', carregarSessaoAtiva);
        document.getElementById('auto-reload-session')?.addEventListener('change', (e) => {
            if (e.target.checked) {
                if (sessionAutoInterval) clearInterval(sessionAutoInterval);
                sessionAutoInterval = setInterval(carregarSessaoAtiva, 5000);
            } else {
                if (sessionAutoInterval) clearInterval(sessionAutoInterval);
            }
        });
    </script>
</x-app-layout>