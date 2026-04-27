<x-app-layout>
    {{-- Fundo fixo com overlay --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_create.png') }}" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        /* Variáveis CSS que serão alteradas dinamicamente */
        :root {
            --theme-primary: #00f2ff;
            --theme-secondary: #4deaff;
            --theme-glow: rgba(0, 242, 255, 0.5);
            --theme-border: rgba(0, 242, 255, 0.3);
            --theme-panel-bg: rgba(0, 242, 255, 0.05);
        }

        /* Classes temáticas que usam as variáveis */
        .theme-text-primary { color: var(--theme-primary); }
        .theme-border-primary { border-color: var(--theme-primary); }
        .theme-border-glow { box-shadow: 0 0 8px var(--theme-glow); }
        .theme-bg-panel { background-color: var(--theme-panel-bg); }
        .theme-btn-neon {
            background: #000;
            border: 2px solid var(--theme-primary);
            color: #fff;
            box-shadow: 0 0 15px var(--theme-glow);
        }
        .theme-btn-neon:hover {
            background: var(--theme-primary);
            color: #000;
            box-shadow: 0 0 30px var(--theme-glow);
        }

        .text-metallic {
            background: linear-gradient(to bottom, #ffffff 0%, #b0e0e6 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));
        }

        .text-glow-white {
            text-shadow: 0 0 6px rgba(255,255,255,0.7), 0 0 3px rgba(255,255,255,0.9);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slideDown { animation: slideDown 0.3s ease forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        .delay-600 { animation-delay: 0.6s; }
        .delay-700 { animation-delay: 0.7s; }

        .ark-input {
            @apply bg-black/60 border border-cyan-500/30 text-white rounded-sm px-4 py-2.5 transition-all duration-300 font-mono text-sm;
        }
        .ark-input:focus {
            @apply border-cyan-400 shadow-[0_0_15px_rgba(0,242,255,0.3)] outline-none bg-black/80;
        }
        .section-title {
            @apply flex items-center justify-between gap-4 text-sm font-medieval font-black uppercase tracking-[0.2em] pb-3 mb-5;
            border-bottom: 1px solid var(--theme-border);
        }
        .section-title span:first-child {
            @apply flex items-center gap-2 whitespace-nowrap;
            color: var(--theme-primary);
        }
        .section-title button {
            @apply flex-shrink-0;
        }
        .ark-panel {
            @apply bg-black/40 backdrop-blur-md shadow-xl;
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
        }

        select.ark-input {
            @apply appearance-none bg-black/60 cursor-pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2300f2ff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }

        /* Árvore de atributos */
        .atributos-container {
            position: relative;
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
            min-height: 320px;
        }
        .atributos-imagem {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .atributo-bolha {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.85);
            border: 2px solid var(--theme-primary);
            border-radius: 50%;
            width: 85px;
            height: 85px;
            backdrop-filter: blur(5px);
            box-shadow: 0 0 20px var(--theme-glow);
            transition: all 0.2s;
            text-align: center;
            padding: 6px;
        }
        .atributo-bolha:hover {
            transform: scale(1.05);
            border-color: var(--theme-secondary);
            box-shadow: 0 0 30px var(--theme-primary);
        }
        .atributo-sigla {
            font-size: 12px;
            font-weight: 900;
            color: var(--theme-primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 15px;
        }
        .atributo-valor {
            font-size: 24px;
            font-weight: bold;
            color: white;
            font-family: monospace;
            margin: 2px 0;
        }
        .atributo-controles {
            display: flex;
            gap: 8px;
            margin-top: 2px;
        }
        .atributo-btn {
            background: rgba(0,0,0,0.6);
            border: 1px solid var(--theme-primary);
            color: var(--theme-primary);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .atributo-btn:hover {
            background: var(--theme-primary);
            color: black;
            transform: scale(1.1);
        }
        /* Posições das bolas */
        .pos-for { top: 12%; left: 39%;  }
        .pos-agi { top: 28%; left: 12%; }
        .pos-int { top: 28%; right: 12%; left: auto; }
        .pos-set { bottom: 21.5%; left: 15%; top: auto; }
        .pos-vig { bottom: 21.5%; right: 15%; left: auto; top: auto; }

        @media (max-width: 768px) {
            .atributos-container { max-width: 320px; }
            .atributo-bolha { width: 75px; height: 75px; }
            .atributo-sigla { font-size: 9px; }
            .atributo-valor { font-size: 18px; }
            .atributo-btn { width: 16px; height: 16px; font-size: 10px; }
            .pos-for { top: 11%; left: 39%; }
            .pos-agi { top: 27%; left: 11%; }
            .pos-int { top: 27%; right: 11%; }
            .pos-set { bottom: 21%; left: 15%; }
            .pos-vig { bottom: 21%; right: 15%; }
        }
        @media (max-width: 380px) {
            .atributos-container { max-width: 260px; }
            .atributo-bolha { width: 45px; height: 45px; }
            .atributo-valor { font-size: 16px; }
            .atributo-controles { gap: 2px; }
            .pos-agi { left: 6%; }
            .pos-int { right: 6%; }
            .pos-set { bottom: 18%; left: 10%; }
            .pos-vig { bottom: 18%; right: 10%; }
        }

        /* Botão Abortar (também temático) */
        .btn-abort {
            @apply relative px-10 py-3 font-bold uppercase tracking-[0.3em] text-[10px] rounded-sm transition-all duration-300 overflow-hidden;
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary);
            padding: 12px 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px var(--theme-glow);
        }
        .btn-abort:hover {
            background: var(--theme-primary);
            color: black;
            border-color: var(--theme-primary);
            box-shadow: 0 0 30px var(--theme-glow);
            transform: translateY(-2px);
        }

        /* Container de scroll */
        .dynamic-scroll-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .dynamic-scroll-container::-webkit-scrollbar {
            width: 5px;
        }
        .dynamic-scroll-container::-webkit-scrollbar-track {
            background: #1a1a1a;
            border-radius: 10px;
        }
        .dynamic-scroll-container::-webkit-scrollbar-thumb {
            background: var(--theme-primary);
            border-radius: 10px;
        }
    </style>

    <form action="{{ route('fichas.store') }}" method="POST" enctype="multipart/form-data" id="create-character-form" class="relative max-w-7xl mx-auto p-6 space-y-10 pb-20 text-gray-100">
        @csrf

        {{-- EXIBIÇÃO DE ERROS DE VALIDAÇÃO --}}
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-red-300 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CABEÇALHO: FOTO + INFO --}}
        <div class="grid lg:grid-cols-4 gap-6 animate-fadeInUp">
            {{-- Área de upload com imagem de fundo dinâmica --}}
            <div class="ark-panel !p-1 relative group h-80 overflow-hidden">
                <div id="watermark-image" class="absolute inset-0 bg-cover bg-center opacity-20 pointer-events-none" 
                     style="background-image: url('{{ asset('images/watermark_pegada.png') }}'); background-repeat: no-repeat; background-position: center;"></div>
                <input type="file" name="image" id="photo-input" hidden accept="image/*">
                <label for="photo-input" class="cursor-pointer block h-full relative z-10">
                    <div class="h-full bg-gradient-to-br from-cyan-900/10 to-black flex flex-col items-center justify-center relative">
                        <span id="photo-label" class="z-20 font-medieval font-black text-cyan-400 group-hover:text-cyan-200 transition-all duration-300 text-center px-4">
                            <svg class="w-16 h-16 mx-auto mb-3 opacity-70 drop-shadow-[0_0_5px_cyan]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Carregar sua Imagem de Sobrevivente
                        </span>
                        <img id="preview" class="absolute inset-0 w-full h-full object-contain hidden opacity-90 group-hover:opacity-100 transition-all duration-700 filter grayscale">
                        <div class="absolute inset-0 border-2 border-cyan-500/20 group-hover:border-cyan-400/50 m-2 transition-all pointer-events-none"></div>
                    </div>
                </label>
            </div>

            <div class="lg:col-span-3 ark-panel !p-8 flex flex-col justify-center space-y-8">
                <div class="relative">
                    <span class="absolute -top-6 left-0 text-[10px] text-cyan-500 font-bold tracking-widest uppercase italic">Nome do Sobrevivente</span>
                    <input name="name" class="ark-input !text-4xl !py-4 w-full font-medieval font-black italic uppercase placeholder:text-cyan-900/50 border-x-0 border-t-0 border-b-2 !bg-transparent !rounded-none" 
                           placeholder="NOME DO SOBREVIVENTE" required>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-2">NÍVEL</label>
                        <input type="number" name="level" value="1" class="ark-input !text-xl font-bold">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-2">IDADE</label>
                        <input type="number" name="age" class="ark-input !text-xl font-bold">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-2">ORIGEM</label>
                        <select name="class_main" class="ark-input !py-3">
                            <option class="bg-black">Humano</option>
                            <option class="bg-black">Morto-Vivo</option>
                            <option class="bg-black">Meio-Humano</option>
                            <option class="bg-black">Místico</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-2">Civilização</label>
                        <select name="class_sub" id="class_sub" onchange="updateTheme()" class="ark-input !py-3">
                            <option value="padrao" class="bg-black">Sobrevivente Padrão</option>
                            <option value="gladio" class="bg-black">Gladio</option>
                            <option value="iberos" class="bg-black">Iberos</option>
                            <option value="orc" class="bg-black">Orc</option>
                            <option value="fungo" class="bg-black">Fungo</option>
                            <option value="escarlate" class="bg-black">Companhia Escarlate</option>
                            <option value="nova" class="bg-black">Nova Civilização +</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <input type="text" name="custom_class_name" id="custom_class" 
                           class="ark-input flex-1 hidden border-dashed border-cyan-400 animate-pulse" placeholder="DIGITE O NOME DA NOVA CIVILIZAÇÃO...">
                    <input type="color" id="custom_color" class="h-10 w-12 rounded border border-cyan-500 bg-black hidden" value="#00f2ff">
                </div>
            </div>
        </div>

        {{-- ATRIBUTOS --}}
        <div class="ark-panel !p-4 animate-fadeInUp delay-100">
            <div class="section-title">
                <span>Seus Atributos</span>
                <span class="ml-auto text-xs font-mono bg-cyan-500/10 px-3 py-1 rounded border border-cyan-500/20">
                    PONTOS: <span id="total" class="text-white font-bold">0</span>
                </span>
            </div>

            <div class="atributos-container">
                <img src="{{ asset('images/arvore_atributos.png') }}" alt="Árvore de Atributos" class="atributos-imagem">
                <div class="atributo-bolha pos-for">
                    <span class="atributo-sigla">FOR</span>
                    <span class="atributo-valor" id="display-for">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="for" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="for" data-delta="1">+</button>
                    </div>
                </div>
                <div class="atributo-bolha pos-agi">
                    <span class="atributo-sigla">AGI</span>
                    <span class="atributo-valor" id="display-agi">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="agi" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="agi" data-delta="1">+</button>
                    </div>
                </div>
                <div class="atributo-bolha pos-int">
                    <span class="atributo-sigla">INT</span>
                    <span class="atributo-valor" id="display-int">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="int" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="int" data-delta="1">+</button>
                    </div>
                </div>
                <div class="atributo-bolha pos-set">
                    <span class="atributo-sigla">SET</span>
                    <span class="atributo-valor" id="display-set">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="set" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="set" data-delta="1">+</button>
                    </div>
                </div>
                <div class="atributo-bolha pos-vig">
                    <span class="atributo-sigla">VIG</span>
                    <span class="atributo-valor" id="display-vig">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="vig" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="vig" data-delta="1">+</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="for" id="hidden-for" value="1">
            <input type="hidden" name="agi" id="hidden-agi" value="1">
            <input type="hidden" name="int" id="hidden-int" value="1">
            <input type="hidden" name="set" id="hidden-set" value="1">
            <input type="hidden" name="vig" id="hidden-vig" value="1">
        </div>

        {{-- GRIDS DINÂMICOS --}}
        <div class="grid md:grid-cols-2 gap-8">
            <div class="ark-panel !p-8 animate-fadeInUp delay-200">
                <div class="section-title">
                    <span>Mutações</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="scrollToBottom('mutations-container')" class="transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </button>
                        <button type="button" onclick="addMutation()" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                    </div>
                </div>
                <div id="mutations-container" class="dynamic-scroll-container space-y-4"></div>
            </div>
            <div class="ark-panel !p-8 animate-fadeInUp delay-300">
                <div class="section-title">
                    <span>Bônus em Ações</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="scrollToBottom('bonus-container')" class="transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </button>
                        <button type="button" onclick="addBonus()" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                    </div>
                </div>
                <div id="bonus-container" class="dynamic-scroll-container space-y-3"></div>
                <div class="mt-4 text-right text-[10px] uppercase font-bold tracking-widest theme-text-primary">
                    Custo Total (Barras / 5): <span id="bonusTotal" class="text-white text-sm ml-2">0</span>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <div class="ark-panel !p-8 animate-fadeInUp delay-400">
                <div class="section-title">
                    <span>Poderes de Sobreviente</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="scrollToBottom('powers-container')" class="transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </button>
                        <button onclick="addPower()" type="button" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                    </div>
                </div>
                <div id="powers-container" class="dynamic-scroll-container space-y-4"></div>
            </div>
            <div class="ark-panel !p-8 animate-fadeInUp delay-500">
                <div class="section-title">
                    <span>Manipulações Arcanas</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="scrollToBottom('rituals-container')" class="transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </button>
                        <button onclick="addRitual()" type="button" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                    </div>
                </div>
                <div id="rituals-container" class="dynamic-scroll-container space-y-4"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 animate-fadeInUp delay-600">
            <div class="ark-panel !p-8">
                <h3 class="section-title">Registro de História</h3>
                <textarea name="lore" class="ark-input w-full h-48 text-sm italic !bg-cyan-950/10" placeholder="Escreva a trajetória do sobrevivente..."></textarea>
            </div>
            <div class="ark-panel !p-8">
                <h3 class="section-title">Arsenal de Equipamentos</h3>
                <textarea name="arsenal" class="ark-input w-full h-48 text-sm font-mono !bg-cyan-950/10" placeholder="Itens, armas e recursos..."></textarea>
            </div>
        </div>

        {{-- STATUS VITAIS CORRIGIDOS --}}
        <div class="ark-panel !p-8 bg-cyan-900/10 animate-fadeInUp delay-700">
            <div class="section-title !border-white/20">Status Vitais</div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 pt-4">
                @foreach(['vida','armadura','determinacao','folego','resistencia'] as $stat)
                    <div class="flex flex-col">
                        <label class="text-[10px] font-black text-cyan-400 uppercase mb-3 tracking-widest">{{ $stat }}</label>
                        <input name="{{ $stat }}" type="number" class="ark-input !text-center font-bold !text-xl" value="0">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center gap-6 pt-8 pb-12">
            <a href="{{ route('fichas.index') }}" class="btn-abort">Cancelar</a>
            <button type="submit" class="ark-btn !px-20 !py-4 !text-sm shadow-[0_0_40px_rgba(0,242,255,0.2)] hover:shadow-[0_0_60px_rgba(0,242,255,0.4)] transition-all theme-btn-neon">Salvar Ficha</button>
        </div>
    </form>

    <script>
        // ========== SISTEMA DE TEMAS ==========
        const themeColors = {
            padrao: { primary: '#00f2ff', secondary: '#4deaff', watermark: 'watermark_pegada.png' },
            gladio: { primary: '#f97316', secondary: '#fdba74', watermark: 'watermark_gladio.png' },
            iberos: { primary: '#38bdf8', secondary: '#f472b6', watermark: 'watermark_iberos.png' },
            orc: { primary: '#4ade80', secondary: '#854d0e', watermark: 'watermark_orc.png' },
            fungo: { primary: '#a855f7', secondary: '#d8b4fe', watermark: 'watermark_fungo.png' },
            escarlate: { primary: '#ef4444', secondary: '#fca5a5', watermark: 'watermark_escarlate.png' }
        };

        function setTheme(primaryColor, secondaryColor, watermarkImage) {
            document.documentElement.style.setProperty('--theme-primary', primaryColor);
            document.documentElement.style.setProperty('--theme-secondary', secondaryColor);
            document.documentElement.style.setProperty('--theme-glow', `${primaryColor}80`);
            document.documentElement.style.setProperty('--theme-border', `${primaryColor}40`);
            document.documentElement.style.setProperty('--theme-panel-bg', `${primaryColor}0d`);
            // Trocar imagem de fundo da caixa de upload
            const watermarkDiv = document.getElementById('watermark-image');
            if (watermarkImage) {
                watermarkDiv.style.backgroundImage = `url('{{ asset('images/') }}/${watermarkImage}')`;
            }
        }

        function updateTheme() {
            const select = document.getElementById('class_sub');
            const selected = select.value;
            const customClassInput = document.getElementById('custom_class');
            const customColorInput = document.getElementById('custom_color');

            if (selected === 'nova') {
                customClassInput.classList.remove('hidden');
                customColorInput.classList.remove('hidden');
                // Aplica a cor atual do color picker
                const customColor = customColorInput.value;
                setTheme(customColor, customColor, 'watermark_pegada.png');
            } else if (themeColors[selected]) {
                customClassInput.classList.add('hidden');
                customColorInput.classList.add('hidden');
                const { primary, secondary, watermark } = themeColors[selected];
                setTheme(primary, secondary, watermark);
            } else {
                // fallback
                setTheme('#00f2ff', '#4deaff', 'watermark_pegada.png');
            }
        }

        // Atualiza tema quando o color picker mudar
        document.getElementById('custom_color')?.addEventListener('input', function(e) {
            if (document.getElementById('class_sub').value === 'nova') {
                setTheme(e.target.value, e.target.value, 'watermark_pegada.png');
            }
        });

        // Inicializa tema padrão
        updateTheme();

        // ========== CONTROLE DE ATRIBUTOS ==========
        const attrValues = { for: 1, agi: 1, int: 1, set: 1, vig: 1 };
        const hiddenInputs = {
            for: document.getElementById('hidden-for'),
            agi: document.getElementById('hidden-agi'),
            int: document.getElementById('hidden-int'),
            set: document.getElementById('hidden-set'),
            vig: document.getElementById('hidden-vig')
        };
        const displaySpans = {
            for: document.getElementById('display-for'),
            agi: document.getElementById('display-agi'),
            int: document.getElementById('display-int'),
            set: document.getElementById('display-set'),
            vig: document.getElementById('display-vig')
        };
        const totalSpan = document.getElementById('total');

        function updateTotal() {
            let total = 0;
            for (let attr of ['agi','for','int','set','vig']) {
                total += (attrValues[attr] - 1);
            }
            totalSpan.innerText = total;
        }

        function updateAttrUI(attr, newVal) {
            if (newVal < 0) newVal = 0;
            if (newVal > 10) newVal = 10;
            attrValues[attr] = newVal;
            displaySpans[attr].innerText = newVal;
            hiddenInputs[attr].value = newVal;
            updateTotal();
        }

        document.querySelectorAll('.atributo-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const attr = this.dataset.attr;
                const delta = parseInt(this.dataset.delta);
                const newVal = attrValues[attr] + delta;
                updateAttrUI(attr, newVal);
            });
        });

        for (let attr of ['for','agi','int','set','vig']) {
            updateAttrUI(attr, 1);
        }

        // ========== SCROLL E CAMPOS DINÂMICOS ==========
        function scrollToBottom(containerId) {
            const container = document.getElementById(containerId);
            if (container) {
                container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
            }
        }

        let counters = { mutation: 0, bonus: 0, power: 0, ritual: 0 };

        document.getElementById('photo-input').onchange = e => {
            const [file] = e.target.files;
            if (file) {
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                document.getElementById('photo-label').classList.add('hidden');
            }
        };

        function createField(containerId, html) {
            const container = document.getElementById(containerId);
            const wrapper = document.createElement('div');
            wrapper.className = "relative group animate-slideDown p-4 bg-black/40 border border-white/5 rounded-sm mb-2";
            wrapper.innerHTML = html + `
                <button type="button" onclick="this.parentElement.remove(); if('${containerId}' === 'bonus-container') sumBonus();" 
                        class="absolute top-2 right-2 text-gray-500 hover:text-red-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>`;
            container.appendChild(wrapper);
            scrollToBottom(containerId);
        }

        function addMutation() {
            const i = counters.mutation++;
            createField('mutations-container', `
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <input name="mutations[${i}][origin]" class="ark-input !py-2 text-[10px]" placeholder="ORIGEM (Ex: Radioativa)">
                    <input name="mutations[${i}][name]" class="ark-input !py-2 text-[10px] font-bold" placeholder="NOME DA MUTAÇÃO">
                </div>
                <textarea name="mutations[${i}][description]" class="ark-input w-full text-xs h-16 !bg-transparent" placeholder="Efeitos e detalhes biológicos..."></textarea>
            `);
        }

        function addBonus() {
            const i = counters.bonus++;
            createField('bonus-container', `
                <div class="flex gap-4 items-center">
                    <input name="bonuses[${i}][name]" class="ark-input flex-1 !py-2 text-[10px]" placeholder="Ação ou Perícia">
                    <select name="bonuses[${i}][value]" onchange="sumBonus()" class="ark-input !py-2 text-[10px] w-28">
                        <option value="5">+5</option><option value="10">+10</option><option value="15">+15</option>
                        <option value="20">+20</option><option value="25">+25</option><option value="30">+30</option>
                    </select>
                </div>
            `);
            sumBonus();
        }

        function sumBonus() {
            let total = 0;
            document.querySelectorAll('select[name*="bonuses"]').forEach(s => {
                total += (parseInt(s.value) / 5);
            });
            document.getElementById('bonusTotal').innerText = total;
        }

        function addPower() {
            const i = counters.power++;
            createField('powers-container', `
                <input name="powers[${i}][name]" class="ark-input w-full mb-3 font-bold !py-2 text-[10px]" placeholder="NOME DO PODER">
                <textarea name="powers[${i}][description]" class="ark-input w-full text-xs h-16 !bg-transparent" placeholder="Mecânica de jogo..."></textarea>
            `);
        }

        function addRitual() {
            const i = counters.ritual++;
            createField('rituals-container', `
                <div class="flex gap-4 mb-3">
                    <select name="rituals[${i}][type]" class="ark-input !py-2 text-[10px] w-32">
                        <option>Ritual</option><option>Pacto</option><option>Conjuração</option>
                    </select>
                    <input name="rituals[${i}][name]" class="ark-input flex-1 font-bold !py-2 text-[10px]" placeholder="NOME DO RITUAL">
                </div>
                <textarea name="rituals[${i}][description]" class="ark-input w-full text-xs h-16 !bg-transparent" placeholder="Custo de fôlego e efeito místico..."></textarea>
            `);
        }

        function toggleCustom() {
            // Função mantida para compatibilidade, mas a lógica de tema já trata
        }

        window.onload = () => {
            if(document.getElementById('mutations-container').children.length === 0) addMutation();
            if(document.getElementById('powers-container').children.length === 0) addPower();
        };
    </script>
</x-app-layout>