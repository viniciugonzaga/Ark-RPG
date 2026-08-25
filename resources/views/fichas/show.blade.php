<x-app-layout>
    @php
        $peculiaridade = $ficha->class_sub;
        $origem = $ficha->class_main;

        $cores = [
            'Padrão' => ['primary' => '#00f2ff', 'secondary' => '#4deaff'],
            'Caribidis' => ['primary' => '#facc15', 'secondary' => '#fde047'],
            'Pandora' => ['primary' => '#eab308', 'secondary' => '#22c55e'],
            'Pandemônio' => ['primary' => '#991b1b', 'secondary' => '#f43f5e'],
            'Argana' => ['primary' => '#3b82f6', 'secondary' => '#1e3a8a'],
            'Cabibis' => ['primary' => '#f8fafc', 'secondary' => '#93c5fd'],
            'Hades' => ['primary' => '#f97316', 'secondary' => '#fbbf24'],
            'Abismo' => ['primary' => '#7e22ce', 'secondary' => '#1e3a8a'],
            'Hipnos' => ['primary' => '#dc2626', 'secondary' => '#93c5fd'],
        ];

        $watermarksByPeculiaridade = [
            'Padrão' => 'watermark_pegada.png',
            'Caribidis' => 'watermark_pegada_caribidis.png',
            'Pandora' => 'watermark_pegada_pandora.png',
            'Pandemônio' => 'watermark_pegada_pandemonio.png',
            'Argana' => 'watermark_pegada_Argana.png',
            'Cabibis' => 'watermark_pegada_Cabibis.png',
            'Hades' => 'watermark_pegada_hades.png',
            'Abismo' => 'watermark_pegada_abismo.png',
            'Hipnos' => 'watermark_pegada_hipnos.png',
        ];

        $primaryColor = $cores[$peculiaridade]['primary'] ?? '#00f2ff';
        $secondaryColor = $cores[$peculiaridade]['secondary'] ?? '#4deaff';

        $watermarkFile = $watermarksByPeculiaridade[$peculiaridade] ?? 'watermark_pegada.png';
        $watermarkFilePdf = $watermarksByPeculiaridade[$peculiaridade] ?? 'watermark_pegada.png';

        $backgroundShowByOrigin = [
            'Gládio' => 'Fundo_show_gladios.png',
            'Iberos' => 'Fundo_show_iberus.png',
            'Orc' => 'Fundo_show_orcs.png',
            'Fungo' => 'Fundo_show_fungos.png',
            'Escarlate' => 'Fundo_show_escarlate.png',
            'Bandidos' => 'Fundo_show_bandidos.png',
            'Tormenta' => 'Fundo_show_tormenta.png',
        ];
        $backgroundShowByPeculiaridade = [
            'Padrão' => 'Fundo_show_padrao.png',
            'Caribidis' => 'Fundo_show_caribidis.png',
            'Pandora' => 'Fundo_show_pandora.png',
            'Pandemônio' => 'Fundo_show_pandemonio.png',
            'Argana' => 'Fundo_show_argana.png',
            'Cabibis' => 'Fundo_show_cabibis.png',
            'Hades' => 'Fundo_show_hades.png',
            'Abismo' => 'Fundo_show_abismo.png',
            'Hipnos' => 'Fundo_show_hipnos.png',
        ];
        $bgShow = $backgroundShowByOrigin[$origem] ?? $backgroundShowByPeculiaridade[$peculiaridade] ?? 'Fundo_show_padrao.png';

        $atributosImg = [
            'Padrão' => 'icon_atributos_ark.png',
            'Caribidis' => 'icon_atributos_caribidis.png',
            'Pandora' => 'icon_atributos_pandora.png',
            'Pandemônio' => 'icon_atributos_pandemonio.png',
            'Argana' => 'icon_atributos_argano.png',
            'Cabibis' => 'icon_atributos_cabibis.png',
            'Hades' => 'icon_atributos_hades.png',
            'Abismo' => 'icon_atributos_abismo.png',
            'Hipnos' => 'icon_atributos_hipnos.png',
        ];
        $atributosFile = $atributosImg[$peculiaridade] ?? 'icon_atributos_ark.png';

        $posicoes = [
            'Padrão' => [
                'for' => ['top' => '12%', 'left' => '39%'],
                'agi' => ['top' => '27%', 'left' => '16%'],
                'int' => ['top' => '27%', 'right' => '16%'],
                'set' => ['bottom' => '20%', 'left' => '19%'],
                'vig' => ['bottom' => '20%', 'right' => '19%'],
            ],
            'Caribidis' => [
                'for' => ['top' => '10%', 'left' => '39%'],
                'agi' => ['top' => '27%', 'left' => '12%'],
                'int' => ['top' => '27%', 'right' => '12%'],
                'set' => ['bottom' => '15%', 'left' => '14%'],
                'vig' => ['bottom' => '14%', 'right' => '13%'],
            ],
            'Pandora' => [
                'for' => ['top' => '7%', 'left' => '38%'],
                'agi' => ['top' => '30%', 'left' => '5%'],
                'int' => ['top' => '29%', 'right' => '5%'],
                'set' => ['bottom' => '13%', 'left' => '19%'],
                'vig' => ['bottom' => '12%', 'right' => '19%'],
            ],
            'Pandemônio' => [
                'for' => ['top' => '13%', 'left' => '39%'],
                'agi' => ['top' => '23%', 'left' => '13%'],
                'int' => ['top' => '25%', 'right' => '11%'],
                'set' => ['bottom' => '21%', 'left' => '15%'],
                'vig' => ['bottom' => '21%', 'right' => '15%'],
            ],
            'Argana' => [
                'for' => ['top' => '10%', 'left' => '36%'],
                'agi' => ['top' => '26%', 'left' => '5%'],
                'int' => ['top' => '26%', 'right' => '5%'],
                'set' => ['bottom' => '14%', 'left' => '17%'],
                'vig' => ['bottom' => '14%', 'right' => '17%'],
            ],
            'Cabibis' => [
                'for' => ['top' => '11%', 'left' => '38%'],
                'agi' => ['top' => '27%', 'left' => '15%'],
                'int' => ['top' => '27%', 'right' => '15%'],
                'set' => ['bottom' => '16%', 'left' => '18%'],
                'vig' => ['bottom' => '16%', 'right' => '18%'],
            ],
            'Hades' => [
                'for' => ['top' => '8%', 'left' => '38%'],
                'agi' => ['top' => '30%', 'left' => '8%'],
                'int' => ['top' => '30%', 'right' => '8%'],
                'set' => ['bottom' => '9%', 'left' => '14%'],
                'vig' => ['bottom' => '9%', 'right' => '15%'],
            ],
            'Abismo' => [
                'for' => ['top' => '8%', 'left' => '38%'],
                'agi' => ['top' => '30%', 'left' => '5%'],
                'int' => ['top' => '30%', 'right' => '5%'],
                'set' => ['bottom' => '10%', 'left' => '15%'],
                'vig' => ['bottom' => '10%', 'right' => '15%'],
            ],
            'Hipnos' => [
                'for' => ['top' => '5%', 'left' => '38%'],
                'agi' => ['top' => '28%', 'left' => '3%'],
                'int' => ['top' => '28%', 'right' => '3%'],
                'set' => ['bottom' => '7%', 'left' => '16%'],
                'vig' => ['bottom' => '7%', 'right' => '16%'],
            ],
        ];
        $posAtual = $posicoes[$peculiaridade] ?? $posicoes['Padrão'];
    @endphp

    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/'.$bgShow) }}" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        :root {
            --theme-primary: {{ $primaryColor }};
            --theme-secondary: {{ $secondaryColor }};
            --theme-glow: {{ $primaryColor }}80;
            --theme-border: {{ $primaryColor }}40;
        }

        .theme-text-primary { color: var(--theme-primary); }
        .theme-border-primary { border-color: var(--theme-primary); }

        .ark-panel {
            @apply bg-black/40 backdrop-blur-md shadow-xl;
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
            transition: all 0.3s ease;
        }

        .btn-neon {
            @apply relative px-6 py-2.5 text-sm font-black uppercase tracking-[0.2em] rounded-md transition-all duration-300 overflow-hidden;
            background: rgba(0,0,0,0.7);
            border: 2px solid var(--theme-primary);
            padding: 10px 20px;
            border-radius: 20px;
            color: var(--theme-primary);
            box-shadow: 0 0 12px var(--theme-glow);
        }
        .btn-neon:hover {
            background: var(--theme-primary);
            color: #000;
            box-shadow: 0 0 25px var(--theme-glow);
            transform: translateY(-2px);
        }

        .atributos-container {
            position: relative;
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
            min-height: 320px;
        }
        .atributos-imagem { width: 100%; height: auto; object-fit: contain; }
        .atributo-bolha {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.85);
            border: 2px solid var(--theme-primary);
            border-radius: 50%;
            width: 85px; height: 85px;
            backdrop-filter: blur(5px);
            box-shadow: 0 0 20px var(--theme-glow);
            text-align: center;
            padding: 6px;
            transition: all 0.3s ease;
        }
        .atributo-sigla { font-size:12px;font-weight:900;color:var(--theme-primary);text-transform:uppercase;letter-spacing:2px;margin-top:15px; }
        .atributo-valor { font-size:24px;font-weight:bold;color:white;font-family:monospace;margin:2px 0; }

        .collapse-container { overflow:hidden;transition:max-height 0.4s cubic-bezier(0.4,0,0.2,1);position:relative; }
        .collapse-container.collapsed { max-height:180px; }
        .collapse-container.collapsed-inventory { max-height:240px; }
        .collapse-container.expanded { max-height:9999px !important; }
        .collapse-container.collapsed::after,
        .collapse-container.collapsed-inventory::after {
            content:'';position:absolute;bottom:0;left:0;right:0;height:40px;
            background:linear-gradient(to bottom,transparent,rgba(0,0,0,0.8));pointer-events:none;
        }

        .dna-overlay { position:relative;overflow:hidden; }
        .dna-overlay::after {
            content:'';position:absolute;inset:0;
            background:repeating-linear-gradient(45deg,transparent,transparent 10px,{{ $primaryColor }}0d 10px,{{ $primaryColor }}0d 20px);
            background-size:200% 200%;animation:dnaWave 6s ease-in-out infinite alternate;
            pointer-events:none;mix-blend-mode:overlay;
        }
        @keyframes dnaWave { 0%{background-position:0% 0%}100%{background-position:100% 100%} }

        .toggle-btn { @apply text-cyan-400 hover:text-cyan-200 transition-colors p-1 rounded focus:outline-none; }
        .toggle-btn svg { width:18px;height:18px; }

        .pdf-page { display:none !important; }

        @media print {
            .no-print { display:none !important; }
            body { background:#000 !important; }
            .ark-panel { break-inside:avoid; }
            .collapse-container { max-height:none !important;overflow:visible !important; }
            .collapse-container::after { display:none !important; }
        }
    </style>

    <div id="capture-area" class="relative py-12 px-6 max-w-7xl mx-auto mb-20 min-h-screen">
        <div class="flex justify-between items-center mb-10 animate-fadeInUp no-print">
            <a href="{{ route('fichas.index') }}"
               class="theme-text-primary font-medieval font-black text-sm hover:text-white transition flex items-center gap-3 group">
                <span class="text-xl group-hover:-translate-x-2 transition-transform">◀</span>
                <span class="tracking-widest">VOLTAR À VISUALIZAÇÃO DA FICHA</span>
            </a>
            <div class="flex gap-4">
                @if($ficha->user_id === Auth::id())
                    <a href="{{ route('fichas.edit', $ficha->id) }}" class="btn-neon">EDITAR DADOS</a>
                    @if(!$ficha->is_resgatada)
                        <button onclick="compartilharFicha({{ $ficha->id }})" class="btn-neon" style="border-color: #fbbf24; color: #fbbf24; box-shadow: 0 0 12px rgba(251,191,36,0.5);">
                            COMPARTILHAR
                        </button>
                    @endif
                @endif
                <button onclick="gerarPDF(this)" class="btn-neon flex items-center gap-2">
                    <span id="btn-text">GERAR PDF</span>
                </button>
            </div>
        </div>

        @if($ficha->is_resgatada && $ficha->originalUser)
            <div class="mb-4 p-2 bg-white/10 border border-white/20 rounded-lg text-center text-sm text-gray-300">
                <span class="font-bold text-white">Ficha Resgatada</span> — Criador original: 
                <span class="text-cyan-300 font-bold">{{ $ficha->originalUser->name }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna 1: Imagem, Status, Atributos -->
            <div class="space-y-6 animate-fadeInUp" style="animation-delay:0.1s">
                <div class="ark-panel !p-1 relative group overflow-hidden dna-overlay">
                    <div id="watermark-image-show" class="absolute inset-0 bg-cover bg-center opacity-20 pointer-events-none"
                         style="background-image: url('{{ asset('images/'.$watermarkFile) }}'); background-repeat: no-repeat; background-position: center;"></div>
                    @if($ficha->image)
                        <img src="{{ route('media.show', $ficha->image) }}" class="w-full grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full aspect-square bg-black/60 flex items-center justify-center">
                            <span class="text-gray-500 font-black tracking-tighter uppercase">Sem Registro de Aparência</span>
                        </div>
                    @endif
                    <div class="absolute bottom-4 left-4 right-4 bg-black/70 backdrop-blur-sm p-4 rounded-lg border border-cyan-500/30">
                        <span class="text-[10px] block theme-text-primary uppercase tracking-widest">Visual de Corpo</span>
                        <span class="text-xl font-medieval font-black text-white uppercase tracking-tighter">Aparência</span>
                    </div>
                </div>

                <div class="ark-panel !p-6">
                    <h3 class="text-sm font-medieval font-black mb-6 theme-text-primary uppercase tracking-widest border-b pb-3" style="border-color:var(--theme-border)">Status Vitais</h3>
                    <div class="grid grid-cols-1 gap-5">
                        @php $stats=['vida'=>['color'=>'text-emerald-400','label'=>'Vida'],'armadura'=>['color'=>'text-gray-300','label'=>'Armadura'],'determinacao'=>['color'=>'text-purple-400','label'=>'Determinação'],'folego'=>['color'=>'text-cyan-300','label'=>'Fôlego'],'resistencia'=>['color'=>'text-amber-400','label'=>'Resistência']]; @endphp
                        @foreach($stats as $key => $data)
                            <div class="flex justify-between items-end border-b border-white/10 pb-2">
                                <span class="text-xs font-black uppercase tracking-wider text-gray-400">{{ $data['label'] }}</span>
                                <span class="{{ $data['color'] }} font-medieval font-black text-3xl">{{ $ficha->$key ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="ark-panel !p-6">
                    <h3 class="text-sm font-medieval font-black mb-6 theme-text-primary uppercase tracking-widest border-b pb-3" style="border-color:var(--theme-border)">Atributos</h3>
                    <div class="atributos-container">
                        <img src="{{ asset('images/'.$atributosFile) }}" alt="Árvore de Atributos" class="atributos-imagem">
                        <div class="atributo-bolha" style="top: {{ $posAtual['for']['top'] ?? 'auto' }}; left: {{ $posAtual['for']['left'] ?? 'auto' }};">
                            <span class="atributo-sigla">FOR</span>
                            <span class="atributo-valor">{{ $ficha->for ?? 0 }}</span>
                        </div>
                        <div class="atributo-bolha" style="top: {{ $posAtual['agi']['top'] ?? 'auto' }}; left: {{ $posAtual['agi']['left'] ?? 'auto' }};">
                            <span class="atributo-sigla">AGI</span>
                            <span class="atributo-valor">{{ $ficha->agi ?? 0 }}</span>
                        </div>
                        <div class="atributo-bolha" style="top: {{ $posAtual['int']['top'] ?? 'auto' }}; right: {{ $posAtual['int']['right'] ?? 'auto' }}; left: {{ $posAtual['int']['left'] ?? 'auto' }};">
                            <span class="atributo-sigla">INT</span>
                            <span class="atributo-valor">{{ $ficha->int ?? 0 }}</span>
                        </div>
                        <div class="atributo-bolha" style="bottom: {{ $posAtual['set']['bottom'] ?? 'auto' }}; left: {{ $posAtual['set']['left'] ?? 'auto' }}; top: {{ $posAtual['set']['top'] ?? 'auto' }};">
                            <span class="atributo-sigla">SET</span>
                            <span class="atributo-valor">{{ $ficha->set ?? 0 }}</span>
                        </div>
                        <div class="atributo-bolha" style="bottom: {{ $posAtual['vig']['bottom'] ?? 'auto' }}; right: {{ $posAtual['vig']['right'] ?? 'auto' }}; top: {{ $posAtual['vig']['top'] ?? 'auto' }}; left: {{ $posAtual['vig']['left'] ?? 'auto' }};">
                            <span class="atributo-sigla">VIG</span>
                            <span class="atributo-valor">{{ $ficha->vig ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colunas 2 e 3: Detalhes -->
            <div class="lg:col-span-2 space-y-6 animate-fadeInUp" style="animation-delay:0.2s">
                <div class="ark-panel !p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 text-8xl font-medieval font-black uppercase italic pointer-events-none">{{ $ficha->class_main }}</div>
                    <div class="flex flex-col md:flex-row justify-between items-start mb-6 relative gap-6">
                        <div>
                            <h1 class="text-6xl font-medieval font-black text-white leading-none uppercase tracking-tighter">{{ $ficha->name }}</h1>
                            <p class="theme-text-primary tracking-[0.3em] font-bold uppercase mt-3 text-sm">{{ $ficha->class_sub }} · {{ $ficha->class_main }}</p>
                            <p class="text-xs text-gray-400 mt-2 uppercase tracking-wider">Origem: {{ $ficha->class_main }} | Idade: {{ $ficha->age ?? '??' }} anos</p>
                        </div>
                        <div class="text-right border-l pl-8 min-w-[120px]" style="border-color:var(--theme-border)">
                            <span class="text-xs theme-text-primary block font-bold uppercase tracking-wider">NÍVEL</span>
                            <span class="text-7xl font-medieval font-black text-white">{{ $ficha->level }}</span>
                        </div>
                    </div>
                    <div x-data="{ expanded: false }" class="mt-4">
                        <div class="flex items-center justify-between border-b border-cyan-500/20 pb-2 mb-3">
                            <span class="text-[11px] theme-text-primary font-bold uppercase tracking-widest">Registro Histórico</span>
                            <button @click="expanded = !expanded" class="toggle-btn">
                                <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                        </div>
                        <div :class="expanded ? 'expanded' : 'collapsed'" class="collapse-container collapsed relative">
                            <div class="bg-black/40 p-5 rounded-lg border-l-4 leading-relaxed text-sm italic text-gray-300" style="border-left-color:var(--theme-primary)">
                                {{ $ficha->lore ?: 'Nenhum registro de lore encontrado.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MUTAÇÕES -->
                <div class="ark-panel !p-6" x-data="{ expanded: false }">
                    <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color:var(--theme-border)">
                        <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Mutações</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] theme-text-primary opacity-70">Genéticas</span>
                            <button @click="expanded = !expanded" class="toggle-btn">
                                <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div :class="expanded ? 'expanded' : 'collapsed'" class="collapse-container collapsed">
                        <div class="space-y-4">
                            @forelse($ficha->mutations ?? [] as $m)
                                <div class="bg-black/40 p-4 rounded-lg border border-white/10 hover:border-opacity-50 transition-all" style="border-color:var(--theme-border)">
                                    <div class="text-[10px] theme-text-primary font-bold uppercase tracking-wider">{{ $m->origin }}</div>
                                    <div class="font-medieval font-bold text-white uppercase text-base mt-1">{{ $m->name }}</div>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $m->description }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">Nenhuma mutação registrada.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- BÔNUS -->
                <div class="ark-panel !p-6" x-data="{ expanded: false }">
                    <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color:var(--theme-border)">
                        <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Bônus</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] theme-text-primary opacity-70">Incrementos</span>
                            <button @click="expanded = !expanded" class="toggle-btn">
                                <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div :class="expanded ? 'expanded' : 'collapsed'" class="collapse-container collapsed">
                        <div class="space-y-3">
                            @forelse($ficha->bonuses ?? [] as $b)
                                <div class="flex justify-between items-center bg-black/40 p-4 rounded-lg border" style="border-color:var(--theme-border)">
                                    <span class="text-sm uppercase font-bold text-gray-200">{{ $b->name }}</span>
                                    <span class="theme-text-primary font-medieval font-black text-xl">+{{ $b->value }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">Nenhum bônus detectado.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- PODERES DE SOBREVIVENTE -->
                <div class="ark-panel !p-6" x-data="{ expanded: false }">
                    <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color:var(--theme-border)">
                        <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Poderes de Sobrevivente</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] theme-text-primary opacity-70">Habilidades</span>
                            <button @click="expanded = !expanded" class="toggle-btn">
                                <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div :class="expanded ? 'expanded' : 'collapsed'" class="collapse-container collapsed">
                        <div class="space-y-4">
                            @forelse($ficha->survivorPowers ?? [] as $p)
                                <div class="bg-black/40 p-4 rounded-lg border" style="border-color:var(--theme-border)">
                                    <div class="font-medieval font-bold text-white uppercase text-base">{{ $p->name }}</div>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $p->description }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">Sem poderes registrados.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- RITUAIS -->
                <div class="ark-panel !p-6" x-data="{ expanded: false }">
                    <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color:var(--theme-border)">
                        <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Rituais</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] theme-text-primary opacity-70">Pactos</span>
                            <button @click="expanded = !expanded" class="toggle-btn">
                                <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div :class="expanded ? 'expanded' : 'collapsed'" class="collapse-container collapsed">
                        <div class="space-y-4">
                            @forelse($ficha->rituals ?? [] as $r)
                                <div class="bg-black/40 p-4 rounded-lg border" style="border-color:var(--theme-border)">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-[8px] bg-red-900/60 text-red-200 px-2 py-0.5 rounded uppercase font-black tracking-wider">{{ $r->type ?? 'Protocolo' }}</span>
                                        <span class="font-medieval font-bold text-white uppercase text-base">{{ $r->name }}</span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $r->description }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">Sem rituais manifestados.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Inventário -->
                <div class="ark-panel !p-6" x-data="{ expanded: false }">
                    <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color:var(--theme-border)">
                        <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Inventário</h3>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] theme-text-primary opacity-70">Carga</span>
                            <button @click="expanded = !expanded" class="toggle-btn">
                                <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <div :class="expanded ? 'expanded' : 'collapsed-inventory'" class="collapse-container collapsed-inventory">
                        <div class="font-mono text-sm text-gray-300 bg-black/40 p-5 rounded-lg border whitespace-pre-wrap break-words text-left leading-relaxed shadow-inner" style="border-color:var(--theme-border)">
                            {{ trim($ficha->arsenal) ?: 'NENHUM EQUIPAMENTO REGISTRADO.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL COMPARTILHAR --}}
    <div id="share-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-gray-900 border border-cyan-500/30 rounded-lg p-6 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-xl font-medieval font-black text-cyan-400 uppercase tracking-wider mb-4">Compartilhar Ficha</h3>
            <p class="text-gray-300 text-sm mb-2">Código de resgate:</p>
            <div class="flex items-center gap-3">
                <input id="share-code" type="text" readonly class="w-full bg-black/60 border border-cyan-500/30 text-cyan-300 font-mono text-lg px-4 py-2 rounded focus:outline-none">
                <button onclick="copiarCodigo()" class="bg-cyan-500/20 hover:bg-cyan-500/40 px-3 py-2 rounded border border-cyan-500/30 text-cyan-300 transition">📋</button>
            </div>
            <p class="text-gray-500 text-xs mt-3">Compartilhe este código com outro jogador. Ele poderá resgatar uma cópia da ficha.</p>
            <div class="mt-6 flex justify-end">
                <button onclick="fecharModalShare()" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-sm transition">Fechar</button>
            </div>
        </div>
    </div>

    <div id="resgatar-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-gray-900 border border-cyan-500/30 rounded-lg p-6 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-xl font-medieval font-black text-cyan-400 uppercase tracking-wider mb-4">Resgatar Ficha</h3>
            <p class="text-gray-300 text-sm mb-2">Insira o código de compartilhamento:</p>
            <form action="{{ route('fichas.resgatar') }}" method="POST">
                @csrf
                <input type="text" name="code" placeholder="Ex: A1B2C3D4" class="w-full bg-black/60 border border-cyan-500/30 text-white font-mono text-lg px-4 py-2 rounded focus:outline-none focus:border-cyan-400">
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('resgatar-modal').classList.add('hidden')" class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-sm transition">Cancelar</button>
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 px-4 py-2 rounded text-sm font-bold transition">Resgatar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- PÁGINAS PDF --}}
    <style>
        .pdf-page { display:none !important; }
        .pdfi-root {
            font-family: 'Cinzel', serif;
            box-sizing: border-box;
            background: #0a0a0a;
            color: #ddd;
            width: 1240px;
            padding: 56px 64px 80px;
            position: relative;
        }
        .pdfi-root * { box-sizing: border-box; word-wrap: break-word; overflow-wrap: break-word; }
        .pdfi-root.pdfi-fixed-page {
            height: 1754px;
            min-height: 1754px;
            overflow: hidden;
        }
        .pdfi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--P);
            padding-bottom: 18px;
            margin-bottom: 32px;
        }
        .pdfi-header-left { display: flex; align-items: center; gap: 18px; }
        .pdfi-header-logo { width: 48px; height: 48px; object-fit: contain; filter: drop-shadow(0 0 8px var(--P)); }
        .pdfi-header-title { font-size: 20px; font-weight: 900; color: var(--P); text-transform: uppercase; letter-spacing: 5px; margin: 0; }
        .pdfi-header-sub { font-size: 9px; color: #555; text-transform: uppercase; letter-spacing: 4px; }
        .pdfi-header-right { text-align: right; }
        .pdfi-header-name { font-size: 13px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 2px; }
        .pdfi-header-class { font-size: 10px; color: var(--P); letter-spacing: 3px; text-transform: uppercase; }
        .pdfi-footer {
            margin-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.07);
            padding-top: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .pdfi-footer span { font-size: 9px; color: #333; text-transform: uppercase; letter-spacing: 3px; }
        .pdfi-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 28px 0 20px;
        }
        .pdfi-divider-line { height: 1px; flex: 1; background: linear-gradient(to right, var(--P), transparent); }
        .pdfi-divider-line.rev { background: linear-gradient(to left, var(--P), transparent); }
        .pdfi-divider-label { font-size: 15px; font-weight: 900; color: var(--P); text-transform: uppercase; letter-spacing: 5px; white-space: nowrap; }
        .pdfi-card {
            background: rgba(0,0,0,0.55);
            border: 1px solid var(--B);
            border-radius: 10px;
            padding: 20px 24px;
            position: relative;
            overflow: hidden;
            break-inside: avoid;
        }
        .pdfi-card-accent { position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(to right, var(--P), transparent); }
        .pdfi-card-origin { font-size: 9px; color: var(--P); font-weight: 700; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 4px; }
        .pdfi-card-name { font-size: 15px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 1px; }
        .pdfi-card-desc { font-size: 11px; color: #999; line-height: 1.75; border-top: 1px solid rgba(255,255,255,0.07); padding-top: 10px; margin-top: 8px; }
        .pdfi-panel {
            background: rgba(0,0,0,0.5);
            border: 1px solid var(--B);
            border-radius: 10px;
            padding: 18px 22px;
        }
        .pdfi-panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--B);
            padding-bottom: 12px;
            margin-bottom: 14px;
        }
        .pdfi-panel-title { font-size: 13px; font-weight: 900; color: var(--P); text-transform: uppercase; letter-spacing: 2px; }
        .pdfi-panel-sub { font-size: 9px; color: var(--P); opacity: 0.6; text-transform: uppercase; letter-spacing: 1px; }
        .pdfi-stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            padding: 9px 0;
        }
        .pdfi-stat-label { font-size: 10px; font-weight: 900; color: #555; text-transform: uppercase; letter-spacing: 2px; }
        .pdfi-stat-value { font-size: 26px; font-weight: 900; font-family: monospace; }
        .pdfi-attrs { display: grid; grid-template-columns: repeat(2,76px); gap: 12px; justify-content: center; margin-top: 10px; }
        .pdfi-attr-circle {
            background: rgba(0,0,0,0.7);
            border: 2px solid var(--P);
            border-radius: 50%;
            width: 72px; height: 72px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0);
        }
        .pdfi-attr-sigla { font-size: 9px; font-weight: 900; color: var(--P); letter-spacing: 2px; }
        .pdfi-attr-val { font-size: 20px; font-weight: 900; color: #fff; font-family: monospace; }
        .pdfi-attr-center { grid-column: 1 / -1; justify-self: center; }
        .pdfi-clamp { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; }
        .pdfi-lore-preview { -webkit-line-clamp: 12; max-height: 204px; }
        .pdfi-text-preview { -webkit-line-clamp: 3; max-height: 54px; }
        .pdfi-inventory-preview { -webkit-line-clamp: 7; max-height: 112px; }
        .pdfi-more-note { font-size: 8px; color: var(--P); opacity: 0.62; text-transform: uppercase; letter-spacing: 2px; margin-top: 8px; }
        .pdfi-flow-page { min-height: 1754px; padding: 56px 64px 80px; overflow: hidden; }
        .pdfi-flow-content { position: relative; z-index: 1; }
        .pdfi-flow-body { padding-top: 4px; }
        .pdfi-bonus-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0,0,0,0.55);
            border: 1px solid var(--B);
            border-radius: 8px;
            padding: 12px 18px;
            position: relative;
            overflow: hidden;
        }
        .pdfi-bonus-bar { position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--P);opacity:0.6; }
        .pdfi-bonus-num { font-size: 10px; color: var(--P); font-weight: 900; opacity: 0.5; min-width: 22px; }
        .pdfi-bonus-name { font-size: 12px; font-weight: 700; color: #ddd; text-transform: uppercase; letter-spacing: 1px; padding-left: 10px; }
        .pdfi-bonus-val { font-size: 22px; font-weight: 900; color: var(--P); letter-spacing: -1px; }
        .pdfi-big-card {
            background: rgba(0,0,0,0.55);
            border: 1px solid var(--B);
            border-radius: 10px;
            padding: 22px 26px;
            position: relative;
            overflow: hidden;
            break-inside: avoid;
        }
        .pdfi-big-card-top { position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(to right, var(--P), transparent); }
        .pdfi-big-card-icon {
            width: 46px; height: 46px; flex-shrink: 0;
            border: 2px solid var(--P); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(0,0,0,0.6);
        }
        .pdfi-big-card-icon span { font-size: 9px; font-weight: 900; color: var(--P); }
        .pdfi-big-card-name { font-size: 16px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .pdfi-big-card-desc {
            font-size: 11px; color: #999; line-height: 1.8;
            border-left: 3px solid var(--B); padding-left: 14px;
        }
        .pdfi-watermark {
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            pointer-events: none; z-index: 0;
        }
        .pdfi-watermark img { width: 480px; height: 480px; object-fit: contain; opacity: 0.18; }
    </style>

    <div id="pdf-page-1" class="pdf-page">
        <div class="pdfi-root" style="--P:{{ $primaryColor }};--B:{{ $primaryColor }}40;">
            <div class="pdfi-watermark"><img src="{{ asset('images/'.$watermarkFilePdf) }}"></div>
            <div style="position:relative;z-index:1;">
                <div class="pdfi-header">
                    <div class="pdfi-header-left">
                        <img class="pdfi-header-logo" src="{{ asset('images/Icone_ark_v4_sum_fundo.png') }}">
                        <div>
                            <div class="pdfi-header-title">FICHA DO SOBREVIVENTE</div>
                            <div class="pdfi-header-sub">PECULIARIDADE: {{ strtoupper($peculiaridade) }}</div>
                        </div>
                    </div>
                    <div class="pdfi-header-right">
                        <div class="pdfi-header-name">{{ $ficha->name }}</div>
                        <div class="pdfi-header-class">{{ $ficha->class_sub }} — NV {{ $ficha->level }}</div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:260px 220px 1fr;gap:24px;align-items:start;">
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div style="border:1px solid var(--B);border-radius:8px;overflow:hidden;position:relative;">
                            @if($ficha->image)
                                <img src="{{ route('media.show', $ficha->image) }}" style="width:100%;display:block;filter:grayscale(20%);">
                            @else
                                <div style="width:100%;height:220px;background:#111;display:flex;align-items:center;justify-content:center;">
                                    <span style="color:#444;font-size:11px;text-transform:uppercase;font-weight:900;">Sem Registro</span>
                                </div>
                            @endif
                            <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,0.75);padding:10px 14px;">
                                <span style="font-size:8px;color:var(--P);text-transform:uppercase;letter-spacing:3px;display:block;">Visual de Corpo</span>
                                <span style="font-size:14px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:1px;">Aparência</span>
                            </div>
                        </div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">STATUS VITAIS</span>
                            </div>
                            @php $sv=[['k'=>'vida','c'=>'#34d399','l'=>'Vida'],['k'=>'armadura','c'=>'#d1d5db','l'=>'Armadura'],['k'=>'determinacao','c'=>'#a78bfa','l'=>'Determinação'],['k'=>'folego','c'=>'#67e8f9','l'=>'Fôlego'],['k'=>'resistencia','c'=>'#fbbf24','l'=>'Resistência']]; @endphp
                            @foreach($sv as $s)
                                <div class="pdfi-stat-row">
                                    <span class="pdfi-stat-label">{{ $s['l'] }}</span>
                                    <span class="pdfi-stat-value" style="color:{{ $s['c'] }};">{{ $ficha->{$s['k']} ?? 0 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">ATRIBUTOS</span>
                            </div>
                            <div class="pdfi-attrs">
                                <div class="pdfi-attr-circle"><span class="pdfi-attr-sigla">FOR</span><span class="pdfi-attr-val">{{ $ficha->for ?? 0 }}</span></div>
                                <div class="pdfi-attr-circle"><span class="pdfi-attr-sigla">AGI</span><span class="pdfi-attr-val">{{ $ficha->agi ?? 0 }}</span></div>
                                <div class="pdfi-attr-circle"><span class="pdfi-attr-sigla">SET</span><span class="pdfi-attr-val">{{ $ficha->set ?? 0 }}</span></div>
                                <div class="pdfi-attr-circle"><span class="pdfi-attr-sigla">VIG</span><span class="pdfi-attr-val">{{ $ficha->vig ?? 0 }}</span></div>
                                <div class="pdfi-attr-circle pdfi-attr-center"><span class="pdfi-attr-sigla">INT</span><span class="pdfi-attr-val">{{ $ficha->int ?? 0 }}</span></div>
                            </div>
                        </div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">MUTAÇÕES</span>
                                <span class="pdfi-panel-sub">Genéticas</span>
                            </div>
                            @forelse(($ficha->mutations??collect())->take(2) as $m)
                                <div style="background:rgba(0,0,0,0.4);padding:10px;border-radius:6px;border:1px solid var(--B);margin-bottom:8px;">
                                    <div style="font-size:8px;color:var(--P);font-weight:700;text-transform:uppercase;letter-spacing:2px;">{{ $m->origin }}</div>
                                    <div style="font-size:12px;font-weight:900;color:#fff;text-transform:uppercase;margin:2px 0;">{{ $m->name }}</div>
                                    <div style="font-size:10px;color:#888;line-height:1.5;">{{ Str::limit($m->description,90) }}</div>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Nenhuma mutação.</p>
                            @endforelse
                            @if(($ficha->mutations??collect())->count()>2)
                                <p style="font-size:9px;color:var(--P);opacity:0.6;text-align:center;margin-top:4px;">+{{ ($ficha->mutations->count()-2) }} na página de mutações</p>
                            @endif
                        </div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">BÔNUS</span>
                                <span class="pdfi-panel-sub">Incrementos</span>
                            </div>
                            @forelse(collect($ficha->bonuses??[])->sortByDesc('value')->take(4) as $b)
                                <div style="display:flex;justify-content:space-between;align-items:center;background:rgba(0,0,0,0.4);padding:8px 10px;border-radius:6px;border:1px solid var(--B);margin-bottom:6px;">
                                    <span style="font-size:10px;font-weight:700;color:#ccc;text-transform:uppercase;">{{ $b->name }}</span>
                                    <span style="font-size:18px;font-weight:900;color:var(--P);">+{{ $b->value }}</span>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Nenhum bônus.</p>
                            @endforelse
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div style="background:rgba(0,0,0,0.5);border:1px solid var(--B);border-radius:10px;padding:24px;position:relative;overflow:hidden;">
                            <div style="position:absolute;top:0;right:0;padding:16px;font-size:70px;font-weight:900;color:#fff;opacity:0.03;text-transform:uppercase;font-style:italic;line-height:1;">{{ $ficha->class_main }}</div>
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
                                <div>
                                    <h1 style="font-size:40px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:-2px;line-height:1;margin:0;">{{ $ficha->name }}</h1>
                                    <p style="color:var(--P);letter-spacing:4px;font-weight:700;text-transform:uppercase;margin:6px 0 2px;font-size:10px;">{{ $ficha->class_sub }} · {{ $ficha->class_main }}</p>
                                    <p style="font-size:9px;color:#666;text-transform:uppercase;letter-spacing:2px;margin:0;">Origem: {{ $ficha->class_main }} | Idade: {{ $ficha->age ?? '??' }} anos</p>
                                </div>
                                <div style="text-align:right;border-left:1px solid var(--B);padding-left:18px;min-width:80px;flex-shrink:0;">
                                    <span style="font-size:9px;color:var(--P);font-weight:700;text-transform:uppercase;letter-spacing:2px;display:block;">NÍVEL</span>
                                    <span style="font-size:60px;font-weight:900;color:#fff;line-height:1;">{{ $ficha->level }}</span>
                                </div>
                            </div>
                            <div style="margin-top:16px;border-top:1px solid rgba(255,255,255,0.08);padding-top:14px;">
                                <span style="font-size:8px;color:var(--P);font-weight:700;text-transform:uppercase;letter-spacing:3px;display:block;margin-bottom:8px;">Registro Histórico</span>
                                <div style="background:rgba(0,0,0,0.4);padding:12px 16px;border-radius:6px;border-left:3px solid var(--P);">
                                    <p class="pdfi-clamp pdfi-lore-preview" style="font-size:10px;color:#aaa;font-style:italic;line-height:1.7;margin:0;">{{ $ficha->lore ?: 'Nenhum registro encontrado.' }}</p>
                                </div>
                                <div class="pdfi-more-note">História completa na próxima página</div>
                            </div>
                        </div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">PODERES</span>
                                <span class="pdfi-panel-sub">Habilidades</span>
                            </div>
                            @forelse(($ficha->survivorPowers??collect())->take(2) as $p)
                                <div style="background:rgba(0,0,0,0.4);padding:10px;border-radius:6px;border:1px solid var(--B);margin-bottom:8px;">
                                    <div style="font-size:12px;font-weight:900;color:#fff;text-transform:uppercase;">{{ $p->name }}</div>
                                    <div class="pdfi-clamp pdfi-text-preview" style="font-size:10px;color:#888;line-height:1.5;margin-top:3px;">{{ $p->description }}</div>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Sem poderes.</p>
                            @endforelse
                            @if(($ficha->survivorPowers??collect())->count()>2)
                                <p style="font-size:9px;color:var(--P);opacity:0.6;text-align:center;margin-top:4px;">+{{ ($ficha->survivorPowers->count()-2) }} na página de poderes</p>
                            @endif
                        </div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">RITUAIS</span>
                                <span class="pdfi-panel-sub">Pactos</span>
                            </div>
                            @forelse(($ficha->rituals??collect())->take(2) as $r)
                                <div style="background:rgba(0,0,0,0.4);padding:10px;border-radius:6px;border:1px solid var(--B);margin-bottom:8px;">
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                                        <span style="font-size:7px;background:rgba(153,27,27,0.6);color:#fca5a5;padding:2px 6px;border-radius:3px;font-weight:900;text-transform:uppercase;">{{ $r->type??'Protocolo' }}</span>
                                        <span style="font-size:12px;font-weight:900;color:#fff;text-transform:uppercase;">{{ $r->name }}</span>
                                    </div>
                                    <div class="pdfi-clamp pdfi-text-preview" style="font-size:10px;color:#888;line-height:1.5;">{{ $r->description }}</div>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Sem rituais.</p>
                            @endforelse
                            @if(($ficha->rituals??collect())->count()>2)
                                <p style="font-size:9px;color:var(--P);opacity:0.6;text-align:center;margin-top:4px;">+{{ ($ficha->rituals->count()-2) }} na página de rituais</p>
                            @endif
                        </div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">INVENTÁRIO</span>
                                <span class="pdfi-panel-sub">Carga</span>
                            </div>
                            <div class="pdfi-clamp pdfi-inventory-preview" style="font-family:monospace;font-size:10px;color:#aaa;background:rgba(0,0,0,0.4);padding:14px;border-radius:6px;border:1px solid var(--B);white-space:pre-wrap;line-height:1.6;">{{ trim($ficha->arsenal)?:'NENHUM EQUIPAMENTO REGISTRADO.' }}</div>
                        </div>
                    </div>
                </div>
                <div class="pdfi-footer">
                    <span>ARK — Sistema de RPG</span>
                    <span>{{ $ficha->name }} · Principal</span>
                    <span>Gerado em {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div id="pdf-page-history" class="pdf-page">
        <div class="pdfi-root" style="--P:{{ $primaryColor }};--B:{{ $primaryColor }}40;">
            <div class="pdfi-watermark"><img src="{{ asset('images/'.$watermarkFilePdf) }}"></div>
            <div style="position:relative;z-index:1;">
                <div class="pdfi-header">
                    <div class="pdfi-header-left">
                        <img class="pdfi-header-logo" src="{{ asset('images/Icone_ark_v4_sum_fundo.png') }}">
                        <div>
                            <div class="pdfi-header-title">HISTÓRIA COMPLETA</div>
                            <div class="pdfi-header-sub">{{ $ficha->name }} · Lore</div>
                        </div>
                    </div>
                    <div class="pdfi-header-right">
                        <div class="pdfi-header-name">{{ $ficha->name }}</div>
                        <div class="pdfi-header-class">{{ $ficha->class_sub }} — NV {{ $ficha->level }}</div>
                    </div>
                </div>
                <div class="pdfi-big-card">
                    <div class="pdfi-big-card-top"></div>
                    <div style="display:flex;gap:16px;align-items:center;margin-bottom:12px;">
                        <div class="pdfi-big-card-icon"><span>📜</span></div>
                        <div class="pdfi-big-card-name">Registro Histórico</div>
                    </div>
                    <div class="pdfi-big-card-desc" style="white-space:pre-wrap;font-size:12px;line-height:1.9;color:#bbb;">
                        {{ $ficha->lore ?: 'Nenhum registro de lore encontrado.' }}
                    </div>
                </div>
                <div class="pdfi-footer">
                    <span>ARK — Sistema de RPG</span>
                    <span>{{ $ficha->name }} · História</span>
                    <span>Gerado em {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div id="pdf-page-2" class="pdf-page">
        <div class="pdfi-root" style="--P:{{ $primaryColor }};--B:{{ $primaryColor }}40;">
            <div class="pdfi-watermark"><img src="{{ asset('images/'.$watermarkFilePdf) }}"></div>
            <div style="position:relative;z-index:1;">
                <div class="pdfi-header">
                    <div class="pdfi-header-left">
                        <img class="pdfi-header-logo" src="{{ asset('images/Icone_ark_v4_sum_fundo.png') }}">
                        <div>
                            <div class="pdfi-header-title">MUTAÇÕES E BÔNUS</div>
                            <div class="pdfi-header-sub">{{ $ficha->name }} · Complementos</div>
                        </div>
                    </div>
                    <div class="pdfi-header-right">
                        <div class="pdfi-header-name">{{ $ficha->name }}</div>
                        <div class="pdfi-header-class">{{ $ficha->class_sub }} — NV {{ $ficha->level }}</div>
                    </div>
                </div>
                <div class="pdfi-flow-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                    <div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">MUTAÇÕES</span>
                                <span class="pdfi-panel-sub">Genéticas</span>
                            </div>
                            @forelse($ficha->mutations ?? [] as $m)
                                <div style="background:rgba(0,0,0,0.4);padding:12px;border-radius:6px;border:1px solid var(--B);margin-bottom:10px;">
                                    <div style="font-size:8px;color:var(--P);font-weight:700;text-transform:uppercase;letter-spacing:2px;">{{ $m->origin }}</div>
                                    <div style="font-size:13px;font-weight:900;color:#fff;text-transform:uppercase;margin:2px 0;">{{ $m->name }}</div>
                                    <div style="font-size:11px;color:#888;line-height:1.6;">{{ $m->description }}</div>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Nenhuma mutação registrada.</p>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">BÔNUS</span>
                                <span class="pdfi-panel-sub">Incrementos</span>
                            </div>
                            @forelse($ficha->bonuses ?? [] as $b)
                                <div class="pdfi-bonus-row">
                                    <div class="pdfi-bonus-bar"></div>
                                    <span class="pdfi-bonus-name">{{ $b->name }}</span>
                                    <span class="pdfi-bonus-val">+{{ $b->value }}</span>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Nenhum bônus detectado.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="pdfi-footer">
                    <span>ARK — Sistema de RPG</span>
                    <span>{{ $ficha->name }} · Mutações/Bônus</span>
                    <span>Gerado em {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div id="pdf-page-3" class="pdf-page">
        <div class="pdfi-root" style="--P:{{ $primaryColor }};--B:{{ $primaryColor }}40;">
            <div class="pdfi-watermark"><img src="{{ asset('images/'.$watermarkFilePdf) }}"></div>
            <div style="position:relative;z-index:1;">
                <div class="pdfi-header">
                    <div class="pdfi-header-left">
                        <img class="pdfi-header-logo" src="{{ asset('images/Icone_ark_v4_sum_fundo.png') }}">
                        <div>
                            <div class="pdfi-header-title">PODERES E RITUAIS</div>
                            <div class="pdfi-header-sub">{{ $ficha->name }} · Habilidades</div>
                        </div>
                    </div>
                    <div class="pdfi-header-right">
                        <div class="pdfi-header-name">{{ $ficha->name }}</div>
                        <div class="pdfi-header-class">{{ $ficha->class_sub }} — NV {{ $ficha->level }}</div>
                    </div>
                </div>
                <div class="pdfi-flow-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                    <div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">PODERES</span>
                                <span class="pdfi-panel-sub">Habilidades</span>
                            </div>
                            @forelse($ficha->survivorPowers ?? [] as $p)
                                <div style="background:rgba(0,0,0,0.4);padding:12px;border-radius:6px;border:1px solid var(--B);margin-bottom:10px;">
                                    <div style="font-size:13px;font-weight:900;color:#fff;text-transform:uppercase;">{{ $p->name }}</div>
                                    <div style="font-size:11px;color:#888;line-height:1.6;">{{ $p->description }}</div>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Sem poderes registrados.</p>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <div class="pdfi-panel">
                            <div class="pdfi-panel-head">
                                <span class="pdfi-panel-title">RITUAIS</span>
                                <span class="pdfi-panel-sub">Pactos</span>
                            </div>
                            @forelse($ficha->rituals ?? [] as $r)
                                <div style="background:rgba(0,0,0,0.4);padding:12px;border-radius:6px;border:1px solid var(--B);margin-bottom:10px;">
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                                        <span style="font-size:7px;background:rgba(153,27,27,0.6);color:#fca5a5;padding:2px 6px;border-radius:3px;font-weight:900;text-transform:uppercase;">{{ $r->type??'Protocolo' }}</span>
                                        <span style="font-size:13px;font-weight:900;color:#fff;text-transform:uppercase;">{{ $r->name }}</span>
                                    </div>
                                    <div style="font-size:11px;color:#888;line-height:1.6;">{{ $r->description }}</div>
                                </div>
                            @empty
                                <p style="font-size:11px;color:#444;font-style:italic;text-align:center;padding:12px 0;">Sem rituais manifestados.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="pdfi-footer">
                    <span>ARK — Sistema de RPG</span>
                    <span>{{ $ficha->name }} · Poderes/Rituais</span>
                    <span>Gerado em {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div id="pdf-page-4" class="pdf-page">
        <div class="pdfi-root" style="--P:{{ $primaryColor }};--B:{{ $primaryColor }}40;">
            <div class="pdfi-watermark"><img src="{{ asset('images/'.$watermarkFilePdf) }}"></div>
            <div style="position:relative;z-index:1;">
                <div class="pdfi-header">
                    <div class="pdfi-header-left">
                        <img class="pdfi-header-logo" src="{{ asset('images/Icone_ark_v4_sum_fundo.png') }}">
                        <div>
                            <div class="pdfi-header-title">INVENTÁRIO</div>
                            <div class="pdfi-header-sub">{{ $ficha->name }} · Carga</div>
                        </div>
                    </div>
                    <div class="pdfi-header-right">
                        <div class="pdfi-header-name">{{ $ficha->name }}</div>
                        <div class="pdfi-header-class">{{ $ficha->class_sub }} — NV {{ $ficha->level }}</div>
                    </div>
                </div>
                <div class="pdfi-big-card" style="margin-top:12px;">
                    <div class="pdfi-big-card-top"></div>
                    <div style="display:flex;gap:16px;align-items:center;margin-bottom:12px;">
                        <div class="pdfi-big-card-icon"><span>🎒</span></div>
                        <div class="pdfi-big-card-name">Inventário</div>
                    </div>
                    <div style="font-family:monospace;font-size:12px;color:#aaa;background:rgba(0,0,0,0.4);padding:16px;border-radius:6px;border:1px solid var(--B);white-space:pre-wrap;line-height:1.8;">
                        {{ trim($ficha->arsenal) ?: 'NENHUM EQUIPAMENTO REGISTRADO.' }}
                    </div>
                </div>
                <div class="pdfi-footer">
                    <span>ARK — Sistema de RPG</span>
                    <span>{{ $ficha->name }} · Inventário</span>
                    <span>Gerado em {{ now()->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Botão voltar ao topo --}}
    <div class="fixed bottom-6 right-6 no-print z-50">
        <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
                class="bg-black/80 p-4 rounded-full shadow-[0_0_20px_var(--theme-glow)] transition-all hover:scale-110 border"
                style="border-color:var(--theme-primary);color:var(--theme-primary)">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const primaryColor = '{{ $primaryColor }}';
        const secondaryColor = '{{ $secondaryColor }}';
        const watermarkFilePdf = '{{ $watermarkFilePdf }}';

        document.documentElement.style.setProperty('--theme-primary', primaryColor);
        document.documentElement.style.setProperty('--theme-glow',    primaryColor + '80');
        document.documentElement.style.setProperty('--theme-border',  primaryColor + '40');

        function compartilharFicha(id) {
            fetch(`/fichas/${id}/share`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.code) {
                    document.getElementById('share-code').value = data.code;
                    document.getElementById('share-modal').classList.remove('hidden');
                } else {
                    alert('Erro ao gerar código de compartilhamento.');
                }
            })
            .catch(err => {
                alert('Erro ao compartilhar ficha.');
                console.error(err);
            });
        }

        function copiarCodigo() {
            const input = document.getElementById('share-code');
            input.select();
            document.execCommand('copy');
            alert('Código copiado!');
        }

        function fecharModalShare() {
            document.getElementById('share-modal').classList.add('hidden');
        }

        document.getElementById('share-modal').addEventListener('click', function(e) {
            if (e.target === this) fecharModalShare();
        });

        // ===== PDF =====
        function hexToRgba(color, alpha) {
            if (color.startsWith('rgba') || color.startsWith('rgb')) {
                return color.replace(/rgba?\(([^)]+)\)/, (_, inner) => {
                    const parts = inner.split(',').map(s => s.trim());
                    return `rgba(${parts[0]},${parts[1]},${parts[2]},${alpha})`;
                });
            }
            let hex = color.replace('#','');
            if (hex.length === 3) hex = hex.split('').map(c=>c+c).join('');
            const r = parseInt(hex.slice(0,2),16);
            const g = parseInt(hex.slice(2,4),16);
            const b = parseInt(hex.slice(4,6),16);
            return `rgba(${r},${g},${b},${alpha})`;
        }

        function applyPdfTheme(clone) {
            const p = primaryColor;
            const pB = hexToRgba(p, 0.3);
            const pGlow = hexToRgba(p, 0.25);
            clone.style.setProperty('--P', p);
            clone.style.setProperty('--B', primaryColor + '40');
            clone.style.width = '1240px';
            clone.style.display = 'block';
            clone.style.visibility = 'visible';
            clone.style.opacity = '1';
            clone.querySelectorAll('[style]').forEach(el => {
                let s = el.getAttribute('style') || '';
                s = s.replace(/var\(--P\)/g, p)
                     .replace(/var\(--B\)/g, pB)
                     .replace(/var\(--pdf-primary\)/g, p)
                     .replace(/var\(--pdf-border\)/g, pB);
                el.setAttribute('style', s);
            });
            clone.querySelectorAll('.pdfi-attr-circle').forEach(el => {
                el.style.boxShadow = `0 0 10px ${pGlow}`;
                el.style.borderColor = p;
            });
            clone.querySelectorAll('.pdfi-card-accent, .pdfi-big-card-top').forEach(el => {
                el.style.background = `linear-gradient(to right, ${p}, transparent)`;
            });
            clone.querySelectorAll('.pdfi-divider-line:not(.rev)').forEach(el => {
                el.style.background = `linear-gradient(to right, ${p}, transparent)`;
            });
            clone.querySelectorAll('.pdfi-divider-line.rev').forEach(el => {
                el.style.background = `linear-gradient(to left, ${p}, transparent)`;
            });
            clone.querySelectorAll('.pdfi-divider-label, .pdfi-panel-title, .pdfi-header-title, .pdfi-header-class, .pdfi-panel-sub, .pdfi-card-origin, .pdfi-attr-sigla, .pdfi-bonus-num, .pdfi-bonus-val').forEach(el => {
                el.style.color = p;
            });
            clone.querySelectorAll('.pdfi-panel, .pdfi-card, .pdfi-big-card, .pdfi-bonus-row').forEach(el => {
                el.style.borderColor = pB;
            });
            clone.querySelectorAll('.pdfi-panel-head').forEach(el => {
                el.style.borderBottomColor = pB;
            });
            clone.querySelectorAll('.pdfi-header').forEach(el => {
                el.style.borderBottomColor = p;
            });
            clone.querySelectorAll('.pdfi-big-card-icon').forEach(el => {
                el.style.borderColor = p;
            });
            clone.querySelectorAll('.pdfi-big-card-desc').forEach(el => {
                el.style.borderLeftColor = pB;
            });
            clone.querySelectorAll('.pdfi-bonus-bar').forEach(el => {
                el.style.background = p;
            });
        }

        function createMeasureWrap(PDF_W) {
            const wrap = document.createElement('div');
            wrap.style.cssText = [
                'position:fixed','left:-9999px','top:0',
                `width:${PDF_W}px`,'height:auto','background:#0a0a0a',
                'z-index:-9999','pointer-events:none','overflow:visible','visibility:visible'
            ].join(';');
            document.body.appendChild(wrap);
            return wrap;
        }

        function getPdfInner(root) {
            return Array.from(root.children).find(el => (el.getAttribute('style') || '').includes('z-index:1')) || root.querySelector('.pdfi-header')?.parentElement;
        }

        function makeBlankFlowPage(templateRoot, continuation = false) {
            const page = templateRoot.cloneNode(true);
            page.classList.add('pdfi-fixed-page');
            page.style.height = '1754px';
            page.style.minHeight = '1754px';
            page.style.overflow = 'hidden';
            const inner = getPdfInner(page);
            const header = inner.querySelector('.pdfi-header');
            const footer = inner.querySelector('.pdfi-footer');
            Array.from(inner.children).forEach(child => {
                if (child !== header && child !== footer) child.remove();
            });
            if (continuation) {
                const sub = header?.querySelector('.pdfi-header-sub');
                if (sub && !sub.textContent.includes('CONTINUACAO')) sub.textContent = `${sub.textContent} / CONTINUACAO`;
            }
            const body = document.createElement('div');
            body.className = 'pdfi-flow-body';
            if (footer) inner.insertBefore(body, footer);
            else inner.appendChild(body);
            return { page, body };
        }

        function measurePageHeight(page, measureWrap) {
            measureWrap.innerHTML = '';
            measureWrap.appendChild(page);
            return page.scrollHeight;
        }

        function pageOverflows(page, measureWrap, PDF_H) {
            return measurePageHeight(page, measureWrap) > PDF_H + 2;
        }

        function cloneContentNodes(root) {
            const inner = getPdfInner(root);
            const header = inner.querySelector('.pdfi-header');
            const footer = inner.querySelector('.pdfi-footer');
            return Array.from(inner.children)
                .filter(child => child !== header && child !== footer)
                .map(child => child.cloneNode(true));
        }

        function paginateTextPage(root, measureWrap, PDF_H) {
            const dividerTemplate = root.querySelector('.pdfi-divider')?.cloneNode(true);
            const cardTemplate = root.querySelector('.pdfi-big-card')?.cloneNode(true);
            const descTemplate = cardTemplate?.querySelector('.pdfi-big-card-desc');
            if (!cardTemplate || !descTemplate) return [root];
            const text = descTemplate.textContent.trim() || 'Nenhum registro de lore encontrado.';
            const words = text.split(/\s+/);
            const pages = [];
            let index = 0;
            while (index < words.length) {
                const { page, body } = makeBlankFlowPage(root, pages.length > 0);
                if (dividerTemplate) body.appendChild(dividerTemplate.cloneNode(true));
                const card = cardTemplate.cloneNode(true);
                const desc = card.querySelector('.pdfi-big-card-desc');
                const title = card.querySelector('.pdfi-big-card-name');
                if (pages.length > 0 && title) title.textContent = `${title.textContent} - CONTINUACAO`;
                desc.textContent = '';
                body.appendChild(card);
                const chunk = [];
                while (index < words.length) {
                    chunk.push(words[index]);
                    desc.textContent = chunk.join(' ');
                    if (pageOverflows(page, measureWrap, PDF_H)) {
                        chunk.pop();
                        desc.textContent = chunk.join(' ');
                        break;
                    }
                    index++;
                }
                if (chunk.length === 0 && index < words.length) {
                    desc.textContent = words[index];
                    index++;
                }
                pages.push(page);
            }
            return pages;
        }

        function paginateBlockPage(root, measureWrap, PDF_H) {
            root.classList.add('pdfi-fixed-page');
            root.style.height = '1754px';
            root.style.minHeight = '1754px';
            root.style.overflow = 'hidden';
            if (!pageOverflows(root, measureWrap, PDF_H)) return [root];
            const contentNodes = cloneContentNodes(root);
            const pages = [];
            let current = makeBlankFlowPage(root, false);
            const pushCurrent = () => {
                pages.push(current.page);
                current = makeBlankFlowPage(root, true);
            };
            const appendNormalNode = node => {
                current.body.appendChild(node);
                if (pageOverflows(current.page, measureWrap, PDF_H) && current.body.children.length > 1) {
                    node.remove();
                    pushCurrent();
                    current.body.appendChild(node);
                }
            };
            contentNodes.forEach(node => {
                if (node.classList?.contains('pdfi-flow-grid') || node.classList?.contains('pdfi-flow-list')) {
                    let container = node.cloneNode(false);
                    current.body.appendChild(container);
                    Array.from(node.children).forEach(item => {
                        const itemClone = item.cloneNode(true);
                        container.appendChild(itemClone);
                        if (pageOverflows(current.page, measureWrap, PDF_H) && container.children.length > 1) {
                            itemClone.remove();
                            if (container.children.length === 0) container.remove();
                            pushCurrent();
                            container = node.cloneNode(false);
                            current.body.appendChild(container);
                            container.appendChild(itemClone);
                        }
                    });
                } else {
                    appendNormalNode(node);
                }
            });
            if (current.body.children.length > 0) pages.push(current.page);
            return pages;
        }

        function buildPdfPages(sourceRoot, sourceId, measureWrap, PDF_H) {
            applyPdfTheme(sourceRoot);
            if (sourceId === 'pdf-page-history') {
                return paginateTextPage(sourceRoot, measureWrap, PDF_H);
            }
            return paginateBlockPage(sourceRoot, measureWrap, PDF_H);
        }

        async function gerarPDF(button) {
            const { jsPDF } = window.jspdf;
            const originalHTML = button.innerHTML;
            const labels = ['PREPARANDO...','PAG. 1...','HISTORIA...','MUTACOES...','BONUS...','PODERES...','EXPORTANDO...'];
            button.disabled = true;
            button.innerHTML = `<span>${labels[0]}</span>`;
            const PDF_W = 1240;
            const PDF_H = 1754;
            let measureWrap = null;
            try {
                const pageIds = ['pdf-page-1','pdf-page-history','pdf-page-2','pdf-page-4','pdf-page-3'];
                const pdf = new jsPDF({ orientation:'p', unit:'px', format:[PDF_W, PDF_H], compress:true });
                let firstPage = true;
                measureWrap = createMeasureWrap(PDF_W);
                for (let i = 0; i < pageIds.length; i++) {
                    button.innerHTML = `<span>${labels[i+1]}</span>`;
                    const sourceEl = document.getElementById(pageIds[i]);
                    const root = sourceEl?.querySelector('.pdfi-root');
                    if (!root) continue;
                    const sourceRoot = root.cloneNode(true);
                    const pages = buildPdfPages(sourceRoot, pageIds[i], measureWrap, PDF_H);
                    for (const pageRoot of pages) {
                        applyPdfTheme(pageRoot);
                        pageRoot.classList.add('pdfi-fixed-page');
                        pageRoot.style.height = `${PDF_H}px`;
                        pageRoot.style.minHeight = `${PDF_H}px`;
                        pageRoot.style.overflow = 'hidden';
                        const captureWrap = createMeasureWrap(PDF_W);
                        captureWrap.appendChild(pageRoot);
                        await new Promise(r => requestAnimationFrame(r));
                        await new Promise(r => setTimeout(r, 180));
                        const canvas = await html2canvas(captureWrap, {
                            scale: 2,
                            useCORS: true,
                            allowTaint: false,
                            backgroundColor: '#0a0a0a',
                            logging: false,
                            width: PDF_W,
                            height: PDF_H,
                            windowWidth: PDF_W,
                            windowHeight: PDF_H,
                        });
                        captureWrap.remove();
                        if (canvas.width === 0 || canvas.height === 0) continue;
                        if (!firstPage) pdf.addPage([PDF_W, PDF_H], 'p');
                        firstPage = false;
                        pdf.addImage(canvas.toDataURL('image/jpeg', 0.92), 'JPEG', 0, 0, PDF_W, PDF_H);
                    }
                }
                button.innerHTML = `<span>${labels[6]}</span>`;
                await new Promise(r => setTimeout(r, 100));
                const nome = `FICHA_ARK_{{ strtoupper(str_replace(' ', '_', $ficha->name)) }}.pdf`;
                pdf.save(nome);
                button.innerHTML = `<span>EXPORTADO</span>`;
            } catch (err) {
                console.error('Erro PDF:', err);
                button.innerHTML = `<span>FALHA</span>`;
                alert('Erro ao gerar PDF: ' + err.message);
            } finally {
                if (measureWrap) measureWrap.remove();
                document.querySelectorAll('div[style*="-9999px"]').forEach(el => el.remove());
                setTimeout(() => { button.innerHTML = originalHTML; button.disabled = false; }, 3000);
            }
        }
    </script>
</x-app-layout>