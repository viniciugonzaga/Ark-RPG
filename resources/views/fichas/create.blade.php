<x-app-layout>
    <div class="fixed inset-0 -z-10">
        <img id="bg-image" src="{{ asset('images/fundo_create_padrao.png') }}" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <style>
        /* (CSS completo igual ao que você já tem) */
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

        .ark-panel {
            @apply bg-black/40 backdrop-blur-md shadow-xl;
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
        }

        .dynamic-scroll-container {
            max-height: 500px;
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

        .dna-overlay {
            position: relative;
            overflow: hidden;
        }
        .dna-overlay::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(0, 242, 255, 0.05) 10px,
                rgba(0, 242, 255, 0.05) 20px
            );
            background-size: 200% 200%;
            animation: dnaWave 6s ease-in-out infinite alternate;
            pointer-events: none;
            mix-blend-mode: overlay;
        }
        @keyframes dnaWave {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        .btn-abort {
            @apply relative px-10 py-3 font-bold uppercase tracking-[0.3em] text-[10px] rounded-sm transition-all duration-300 overflow-hidden;
            background: rgba(0,0,0,0.9);
            border: 2px solid var(--theme-primary);
            color: var(--theme-primary);
            padding: 12px 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px var(--theme-glow);
        }
        .btn-abort:hover {
            background: var(--theme-primary);
            color: black;
            box-shadow: 0 0 30px var(--theme-glow);
            transform: translateY(-2px);
        }
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
            text-align: center;
            padding: 6px;
            transition: all 0.3s ease;
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

        @media (max-width: 768px) {
            .atributos-container { max-width: 320px; }
            .atributo-bolha { width: 75px; height: 75px; }
            .atributo-sigla { font-size: 9px; }
            .atributo-valor { font-size: 18px; }
            .atributo-btn { width: 16px; height: 16px; font-size: 10px; }
        }
    </style>

    <form action="{{ route('fichas.store') }}" method="POST" enctype="multipart/form-data" id="create-character-form" class="relative max-w-7xl mx-auto p-6 space-y-10 pb-20 text-gray-100">
        @csrf

        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-red-300 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CABEÇALHO --}}
        <div class="grid lg:grid-cols-4 gap-6 animate-fadeInUp">
            <div class="ark-panel !p-1 relative group h-80 overflow-hidden dna-overlay">
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
                        <select name="class_main" id="class_main" onchange="updateWatermarkAndBackground()" class="ark-input !py-3">
                            <option value="Humano">Humano</option>
                            <option value="Morto-Vivo">Morto-Vivo</option>
                            <option value="Meio-Humano">Meio-Humano</option>
                            <option value="Místico">Místico</option>
                            <option value="Gládio">Gládio</option>
                            <option value="Iberos">Iberos</option>
                            <option value="Orc">Orc</option>
                            <option value="Fungo">Fungo</option>
                            <option value="Escarlate">Escarlate</option>
                            <option value="Bandidos">Bandidos</option>
                            <option value="Tormenta">Tormenta</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-2">PECULIARIDADE</label>
                        <select name="class_sub" id="class_sub" onchange="updateThemeAndAttributes()" class="ark-input !py-3">
                            <option value="Padrão">Padrão</option>
                            <option value="Caribidis">Caribidis</option>
                            <option value="Pandora">Pandora</option>
                            <option value="Pandemônio">Pandemônio</option>
                            <option value="Argana">Argana</option>
                            <option value="Cabibis">Cabibis</option>
                            <option value="Hades">Hades</option>
                            <option value="Abismo">Abismo</option>
                            <option value="Hipnos">Hipnos</option>
                        </select>
                    </div>
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
                <img id="atributos-img" src="{{ asset('images/icon_atributos_ark.png') }}" alt="Árvore de Atributos" class="atributos-imagem">
                <div id="bolha-for" class="atributo-bolha">
                    <span class="atributo-sigla">FOR</span>
                    <span class="atributo-valor" id="display-for">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="for" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="for" data-delta="1">+</button>
                    </div>
                </div>
                <div id="bolha-agi" class="atributo-bolha">
                    <span class="atributo-sigla">AGI</span>
                    <span class="atributo-valor" id="display-agi">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="agi" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="agi" data-delta="1">+</button>
                    </div>
                </div>
                <div id="bolha-int" class="atributo-bolha">
                    <span class="atributo-sigla">INT</span>
                    <span class="atributo-valor" id="display-int">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="int" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="int" data-delta="1">+</button>
                    </div>
                </div>
                <div id="bolha-set" class="atributo-bolha">
                    <span class="atributo-sigla">SET</span>
                    <span class="atributo-valor" id="display-set">1</span>
                    <div class="atributo-controles">
                        <button type="button" class="atributo-btn" data-attr="set" data-delta="-1">-</button>
                        <button type="button" class="atributo-btn" data-attr="set" data-delta="1">+</button>
                    </div>
                </div>
                <div id="bolha-vig" class="atributo-bolha">
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

        {{-- Mutações e Bônus --}}
        <div class="grid md:grid-cols-2 gap-8">
            <div class="ark-panel !p-8 animate-fadeInUp delay-200">
                <div class="section-title">
                    <span>Mutações</span>
                    <button type="button" onclick="addMutation()" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                </div>
                <div id="mutations-container" class="dynamic-scroll-container space-y-4"></div>
            </div>
            <div class="ark-panel !p-8 animate-fadeInUp delay-300">
                <div class="section-title">
                    <span>Bônus</span>
                    <button type="button" onclick="addBonus()" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                </div>
                <div id="bonus-container" class="dynamic-scroll-container space-y-3"></div>
                <div class="mt-4 text-right text-[10px] uppercase font-bold tracking-widest theme-text-primary">
                    Custo Total (Barras / 5): <span id="bonusTotal" class="text-white text-sm ml-2">0</span>
                </div>
            </div>
        </div>

        {{-- Poderes e Rituais --}}
        <div class="grid md:grid-cols-2 gap-8">
            <div class="ark-panel !p-8 animate-fadeInUp delay-400">
                <div class="section-title">
                    <span>Poderes de Sobrevivente</span>
                    <button onclick="addPower()" type="button" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                </div>
                <div id="powers-container" class="dynamic-scroll-container space-y-4"></div>
            </div>
            <div class="ark-panel !p-8 animate-fadeInUp delay-500">
                <div class="section-title">
                    <span>Rituais</span>
                    <button onclick="addRitual()" type="button" class="bg-opacity-10 hover:bg-opacity-100 border rounded w-8 h-8 flex items-center justify-center text-xl font-bold transition-all theme-add-btn">+</button>
                </div>
                <div id="rituals-container" class="dynamic-scroll-container space-y-4"></div>
            </div>
        </div>

        {{-- Lore e Inventário --}}
        <div class="grid md:grid-cols-2 gap-8 animate-fadeInUp delay-600">
            <div class="ark-panel !p-8">
                <h3 class="section-title">Registro de História</h3>
                <textarea name="lore" class="ark-input w-full h-48 text-sm italic !bg-cyan-950/10" placeholder="Escreva a trajetória do sobrevivente..."></textarea>
            </div>
            <div class="ark-panel !p-8">
                <h3 class="section-title">Inventário</h3>
                <textarea name="arsenal" class="ark-input w-full h-48 text-sm font-mono !bg-cyan-950/10 text-left" placeholder="Itens, armas e recursos..."></textarea>
            </div>
        </div>

        {{-- STATUS VITAIS --}}
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
        // ========== MAPEAMENTOS ==========
        const backgroundByPeculiaridade = {
            'Padrão': 'fundo_create_padrao.png',
            'Caribidis': 'fundo_create_caribidis.png',
            'Pandora': 'fundo_create_pandora.png',
            'Pandemônio': 'fundo_create_pandemonio.png',
            'Argana': 'fundo_create_argana.png',
            'Cabibis': 'fundo_create_cabibis.png',
            'Hades': 'fundo_create_hades.png',
            'Abismo': 'fundo_create_abismo.png',
            'Hipnos': 'fundo_create_hipnos.png'
        };

        const backgroundByOrigin = {
            'Gládio': 'fundo_create_gladios.png',
            'Iberos': 'fundo_create_iberus.png',
            'Orc': 'fundo_create_orcs.png',
            'Fungo': 'fundo_create_fungos.png',
            'Escarlate': 'fundo_create_escarlate.png',
            'Bandidos': 'fundo_create_bandidos.png',
            'Tormenta': 'fundo_create_tormenta.png'
        };

        const themeColors = {
            'Padrão': { primary: '#00f2ff', secondary: '#4deaff' },
            'Caribidis': { primary: '#facc15', secondary: '#fde047' },
            'Pandora': { primary: '#eab308', secondary: '#22c55e' },
            'Pandemônio': { primary: '#991b1b', secondary: '#f43f5e' },
            'Argana': { primary: '#3b82f6', secondary: '#1e3a8a' },
            'Cabibis': { primary: '#f8fafc', secondary: '#93c5fd' },
            'Hades': { primary: '#f97316', secondary: '#fbbf24' },
            'Abismo': { primary: '#7e22ce', secondary: '#1e3a8a' },
            'Hipnos': { primary: '#dc2626', secondary: '#93c5fd' }
        };

        // Watermarks por PECULIARIDADE (usado no create também)
        const watermarkByPeculiaridade = {
            'Padrão': 'watermark_pegada.png',
            'Caribidis': 'watermark_pegada_caribidis.png',
            'Pandora': 'watermark_pegada_pandora.png',
            'Pandemônio': 'watermark_pegada_pandemonio.png',
            'Argana': 'watermark_pegada_Argana.png',
            'Cabibis': 'watermark_pegada_Cabibis.png',
            'Hades': 'watermark_pegada_hades.png',
            'Abismo': 'watermark_pegada_abismo.png',
            'Hipnos': 'watermark_pegada_hipnos.png'
        };

        // Watermarks por ORIGEM (não usado para a watermark do upload, apenas referência)
        const watermarkByOrigin = {
            'Humano': 'watermark_pegada.png',
            'Morto-Vivo': 'watermark_pegada.png',
            'Meio-Humano': 'watermark_pegada.png',
            'Místico': 'watermark_pegada.png',
            'Gládio': 'watermark_gladios.png',
            'Iberos': 'watermark_iberus.png',
            'Orc': 'watermark_orcs.png',
            'Fungo': 'watermark_fungos.png',
            'Escarlate': 'watermark_escarlate.png',
            'Bandidos': 'watermark_bandidos.png',
            'Tormenta': 'watermark_tormenta.png'
        };

        const atributosImages = {
            'Padrão': 'icon_atributos_ark.png',
            'Caribidis': 'icon_atributos_caribidis.png',
            'Pandora': 'icon_atributos_pandora.png',
            'Pandemônio': 'icon_atributos_pandemonio.png',
            'Argana': 'icon_atributos_argano.png',
            'Cabibis': 'icon_atributos_cabibis.png',
            'Hades': 'icon_atributos_hades.png',
            'Abismo': 'icon_atributos_abismo.png',
            'Hipnos': 'icon_atributos_hipnos.png'
        };

        // Posições das bolinhas por peculiaridade (mesmas do show)
        const posicoes = {
            'Padrão': {
                for:  { top: '12%', left: '39%' },
                agi:  { top: '27%', left: '16%' },
                int:  { top: '27%', right: '16%' },
                set:  { bottom: '20%', left: '19%' },
                vig:  { bottom: '20%', right: '19%' }
            },
            'Caribidis': {
                for:  { top: '10%', left: '40%' },
                agi:  { top: '27%', left: '10%' },
                int:  { top: '27%', right: '10%' },
                set:  { bottom: '15%', left: '15%' },
                vig:  { bottom: '15%', right: '16%' }
            },
            'Pandora': {
                for:  { top: '7%', left: '38%' },
                agi:  { top: '33%', left: '6%' },
                int:  { top: '32%', right: '6%' },
                set:  { bottom: '13%', left: '20%' },
                vig:  { bottom: '12%', right: '20%' }
            },
            'Pandemônio': {
                for:  { top: '14%', left: '39%' },
                agi:  { top: '25%', left: '15%' },
                int:  { top: '25%', right: '13%' },
                set:  { bottom: '21%', left: '17%' },
                vig:  { bottom: '21%', right: '17%' }
            },
            'Argana': {
                for:  { top: '8%', left: '39%' },
                agi:  { top: '28%', left: '7%' },
                int:  { top: '30%', right: '5%' },
                set:  { bottom: '16%', left: '20%' },
                vig:  { bottom: '14%', right: '20%' }
            },
            'Cabibis': {
                for:  { top: '40%', left: '39%' },
                agi:  { top: '27%', left: '15%' },
                int:  { top: '27%', right: '15%' },
                set:  { bottom: '17%', left: '23%' },
                vig:  { bottom: '17%', right: '23%' }
            },
            'Hades': {
                for:  { top: '8%', left: '39%' },
                agi:  { top: '30%', left: '8%' },
                int:  { top: '30%', right: '8%' },
                set:  { bottom: '11%', left: '15%' },
                vig:  { bottom: '10%', right: '17%' }
            },
            'Abismo': {
                for:  { top: '6%', left: '39%' },
                agi:  { top: '33%', left: '6%' },
                int:  { top: '33%', right: '6%' },
                set:  { bottom: '11%', left: '15%' },
                vig:  { bottom: '11%', right: '15%' }
            },
            'Hipnos': {
                for:  { top: '4%', left: '39%' },
                agi:  { top: '30%', left: '4%' },
                int:  { top: '30%', right: '4%' },
                set:  { bottom: '8%', left: '18%' },
                vig:  { bottom: '8%', right: '18%' }
            }
        };

        // ========== FUNÇÕES ==========
        function setTheme(primaryColor, secondaryColor) {
            document.documentElement.style.setProperty('--theme-primary', primaryColor);
            document.documentElement.style.setProperty('--theme-secondary', secondaryColor);
            document.documentElement.style.setProperty('--theme-glow', `${primaryColor}80`);
            document.documentElement.style.setProperty('--theme-border', `${primaryColor}40`);
            document.documentElement.style.setProperty('--theme-panel-bg', `${primaryColor}0d`);
        }

        function setBackground(imageName) {
            const bg = document.getElementById('bg-image');
            if (bg) bg.src = `{{ asset('images/') }}/${imageName}`;
        }

        function setWatermark(imageName) {
            const wm = document.getElementById('watermark-image');
            if (wm) wm.style.backgroundImage = `url('{{ asset('images/') }}/${imageName}')`;
        }

        function setAtributosImage(imageName) {
            const img = document.getElementById('atributos-img');
            if (img) img.src = `{{ asset('images/') }}/${imageName}`;
        }

        function aplicarPosicoes(peculiaridade) {
            const pos = posicoes[peculiaridade] || posicoes['Padrão'];
            const bolhas = {
                for: document.getElementById('bolha-for'),
                agi: document.getElementById('bolha-agi'),
                int: document.getElementById('bolha-int'),
                set: document.getElementById('bolha-set'),
                vig: document.getElementById('bolha-vig')
            };
            for (let attr in pos) {
                const el = bolhas[attr];
                if (!el) continue;
                const p = pos[attr];
                el.style.top = p.top || 'auto';
                el.style.left = p.left || 'auto';
                el.style.right = p.right || 'auto';
                el.style.bottom = p.bottom || 'auto';
                if (p.top) el.style.bottom = 'auto';
                if (p.bottom) el.style.top = 'auto';
                if (p.left) el.style.right = 'auto';
                if (p.right) el.style.left = 'auto';
            }
        }

        function updateThemeAndAttributes() {
            const select = document.getElementById('class_sub');
            const peculiaridade = select.value;
            const colors = themeColors[peculiaridade];
            if (colors) {
                setTheme(colors.primary, colors.secondary);
            }
            const attrImg = atributosImages[peculiaridade] || 'icon_atributos_ark.png';
            setAtributosImage(attrImg);
            aplicarPosicoes(peculiaridade);
            updateBackgroundAndWatermark();
        }

        function updateWatermarkAndBackground() {
            updateBackgroundAndWatermark();
        }

        function updateBackgroundAndWatermark() {
            const originSelect = document.getElementById('class_main');
            const origin = originSelect.value;
            const peculiaridadeSelect = document.getElementById('class_sub');
            const peculiaridade = peculiaridadeSelect.value;

            // WATERMARK agora usa a PECULIARIDADE
            const wm = watermarkByPeculiaridade[peculiaridade] || 'watermark_pegada.png';
            setWatermark(wm);

            // Fundo: prioriza origem, senão peculiaridade
            let bgImage = backgroundByOrigin[origin];
            if (!bgImage) {
                bgImage = backgroundByPeculiaridade[peculiaridade] || 'fundo_create_padrao.png';
            }
            setBackground(bgImage);
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateThemeAndAttributes();
            updateBackgroundAndWatermark();
        });

        // ========== ATRIBUTOS (valores) ==========
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

        // ========== CAMPOS DINÂMICOS ==========
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

        window.onload = () => {
            if(document.getElementById('mutations-container').children.length === 0) addMutation();
            if(document.getElementById('powers-container').children.length === 0) addPower();
        };
    </script>
</x-app-layout>