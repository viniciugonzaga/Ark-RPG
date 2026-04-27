<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <div class="fixed inset-0 -z-10">
        <img src="<?php echo e(asset('images/fundo_show.png')); ?>" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        .font-medieval { font-family: 'Cinzel', serif; }

        /* Variáveis CSS que serão alteradas dinamicamente conforme a civilização */
        :root {
            --theme-primary: #00f2ff;
            --theme-secondary: #4deaff;
            --theme-glow: rgba(0, 242, 255, 0.5);
            --theme-border: rgba(0, 242, 255, 0.3);
            --theme-panel-bg: rgba(0, 242, 255, 0.05);
        }

        /* Classes temáticas */
        .theme-text-primary { color: var(--theme-primary); }
        .theme-border-primary { border-color: var(--theme-primary); }
        .theme-bg-panel { background-color: var(--theme-panel-bg); }

        .text-metallic {
            background: linear-gradient(to bottom, #ffffff 0%, #b0e0e6 50%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
            opacity: 0;
        }

        .ark-panel {
            @apply bg-black/40 backdrop-blur-md shadow-xl;
            border: 1px solid var(--theme-border);
            clip-path: polygon(0 0, 98% 0, 100% 4%, 100% 100%, 2% 100%, 0 96%);
            transition: all 0.3s ease;
        }

        /* Árvore de atributos (mesmo estilo do create) */
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
        /* Posições (mesmas do create) */
        .pos-for { top: 12%; left: 39%;  }
        .pos-agi { top: 28%; left: 12%; }
        .pos-int { top: 28%; right: 12%; left: auto; }
        .pos-set { bottom: 21.5%; left: 15%; top: auto; }
        .pos-vig { bottom: 21.5%; right: 15%; left: auto; top: auto; }

        @media (max-width: 768px) {
            .atributos-container { max-width: 320px; }
            .atributo-bolha { width: 75px; height: 75px; }
            .atributo-sigla { font-size: 9px; margin-top: 12px; }
            .atributo-valor { font-size: 18px; }
            .pos-for { top: 11%; left: 39%; }
            .pos-agi { top: 27%; left: 11%; }
            .pos-int { top: 27%; right: 11%; }
            .pos-set { bottom: 21%; left: 15%; }
            .pos-vig { bottom: 21%; right: 15%; }
        }
        @media (max-width: 380px) {
            .atributos-container { max-width: 260px; }
            .atributo-bolha { width: 45px; height: 45px; }
            .atributo-sigla { font-size: 7px; margin-top: 6px; }
            .atributo-valor { font-size: 14px; }
            .pos-agi { left: 6%; }
            .pos-int { right: 6%; }
            .pos-set { bottom: 18%; left: 10%; }
            .pos-vig { bottom: 18%; right: 10%; }
        }

        /* Botões */
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

        /* Container de scroll para listas (se houver muitas mutações) */
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
    </style>

    
    <div id="capture-area" class="relative py-12 px-6 max-w-7xl mx-auto mb-20 min-h-screen">
        
        
        <div class="flex justify-between items-center mb-10 animate-fadeInUp no-print">
            <a href="<?php echo e(route('fichas.index')); ?>" 
               class="theme-text-primary font-medieval font-black text-sm hover:text-white transition flex items-center gap-3 group">
                <span class="text-xl group-hover:-translate-x-2 transition-transform">◀</span> 
                <span class="tracking-widest">VOLTAR AO TERMINAL</span>
            </a>
            <div class="flex gap-4">
                <a href="<?php echo e(route('fichas.edit', $ficha->id)); ?>" 
                   class="btn-neon">
                    EDITAR DADOS
                </a>
                <button onclick="gerarPDF(this)" 
                        class="btn-neon flex items-center gap-2">
                    <span id="btn-text">GERAR PDF</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            
            <div class="space-y-6 animate-fadeInUp" style="animation-delay: 0.1s">
                
                <div class="ark-panel !p-1 relative group overflow-hidden">
                    <div id="watermark-image-show" class="absolute inset-0 bg-cover bg-center opacity-20 pointer-events-none" 
                         style="background-image: url('<?php echo e(asset('images/watermark_pegada.png')); ?>'); background-repeat: no-repeat; background-position: center;"></div>
                    <?php if($ficha->image): ?>
                        <img src="<?php echo e(asset('storage/' . $ficha->image)); ?>" 
                             class="w-full grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">
                    <?php else: ?>
                        <div class="w-full aspect-square bg-black/60 flex items-center justify-center">
                            <span class="text-gray-500 font-black tracking-tighter uppercase">Sem Registro Visual</span>
                        </div>
                    <?php endif; ?>
                    <div class="absolute bottom-4 left-4 right-4 bg-black/70 backdrop-blur-sm p-4 rounded-lg border border-cyan-500/30">
                        <span class="text-[10px] block theme-text-primary uppercase tracking-widest">SINCRONIA</span>
                        <span class="text-xl font-medieval font-black text-white uppercase tracking-tighter">Bio-Estável</span>
                    </div>
                </div>

                
                <div class="ark-panel !p-6">
                    <h3 class="text-sm font-medieval font-black mb-6 theme-text-primary uppercase tracking-widest border-b pb-3" style="border-color: var(--theme-border)">
                        Indicadores Vitais
                    </h3>
                    <div class="grid grid-cols-1 gap-5">
                        <?php
                            $stats = [
                                'vida' => ['color' => 'text-emerald-400', 'label' => 'Pontos de Vida'],
                                'armadura' => ['color' => 'text-gray-300', 'label' => 'Blindagem'],
                                'determinacao' => ['color' => 'text-purple-400', 'label' => 'Determinação'],
                                'folego' => ['color' => 'text-cyan-300', 'label' => 'Fôlego'],
                                'resistencia' => ['color' => 'text-amber-400', 'label' => 'Resistência']
                            ];
                        ?>
                        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between items-end border-b border-white/10 pb-2">
                                <span class="text-xs font-black uppercase tracking-wider text-gray-400"><?php echo e($data['label']); ?></span>
                                <span class="<?php echo e($data['color']); ?> font-medieval font-black text-3xl"><?php echo e($ficha->$key ?? 0); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="ark-panel !p-6">
                    <h3 class="text-sm font-medieval font-black mb-6 theme-text-primary uppercase tracking-widest border-b pb-3" style="border-color: var(--theme-border)">
                        Matriz de Atributos
                    </h3>
                    <div class="atributos-container">
                        <img src="<?php echo e(asset('images/arvore_atributos.png')); ?>" alt="Árvore de Atributos" class="atributos-imagem">
                        <div class="atributo-bolha pos-for">
                            <span class="atributo-sigla">FOR</span>
                            <span class="atributo-valor"><?php echo e($ficha->for ?? 0); ?></span>
                        </div>
                        <div class="atributo-bolha pos-agi">
                            <span class="atributo-sigla">AGI</span>
                            <span class="atributo-valor"><?php echo e($ficha->agi ?? 0); ?></span>
                        </div>
                        <div class="atributo-bolha pos-int">
                            <span class="atributo-sigla">INT</span>
                            <span class="atributo-valor"><?php echo e($ficha->int ?? 0); ?></span>
                        </div>
                        <div class="atributo-bolha pos-set">
                            <span class="atributo-sigla">SET</span>
                            <span class="atributo-valor"><?php echo e($ficha->set ?? 0); ?></span>
                        </div>
                        <div class="atributo-bolha pos-vig">
                            <span class="atributo-sigla">VIG</span>
                            <span class="atributo-valor"><?php echo e($ficha->vig ?? 0); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2 space-y-6 animate-fadeInUp" style="animation-delay: 0.2s">
                
                <div class="ark-panel !p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 text-8xl font-medieval font-black uppercase italic pointer-events-none">
                        <?php echo e($ficha->class_main); ?>

                    </div>
                    <div class="flex flex-col md:flex-row justify-between items-start mb-8 relative gap-6">
                        <div>
                            <h1 class="text-6xl font-medieval font-black text-white leading-none uppercase tracking-tighter">
                                <?php echo e($ficha->name); ?>

                            </h1>
                            <p class="theme-text-primary tracking-[0.3em] font-bold uppercase mt-3 text-sm"><?php echo e($ficha->class_sub); ?></p>
                            <p class="text-xs text-gray-400 mt-2 uppercase tracking-wider">
                                Origem: <?php echo e($ficha->class_main); ?> | Idade: <?php echo e($ficha->age ?? '??'); ?> anos
                            </p>
                        </div>
                        <div class="text-right border-l pl-8 min-w-[120px]" style="border-color: var(--theme-border)">
                            <span class="text-xs theme-text-primary block font-bold uppercase tracking-wider">NÍVEL</span>
                            <span class="text-7xl font-medieval font-black text-white"><?php echo e($ficha->level); ?></span>
                        </div>
                    </div>

                    <div class="bg-black/40 p-6 rounded-lg border-l-4 leading-relaxed text-sm italic text-gray-300" style="border-left-color: var(--theme-primary)">
                        <?php echo e($ficha->lore ?: 'Nenhum registro de lore encontrado no banco de dados.'); ?>

                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="ark-panel !p-6">
                        <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Mutações</h3>
                            <span class="text-[10px] theme-text-primary opacity-70">Genéticas</span>
                        </div>
                        <div class="dynamic-scroll-container space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $ficha->mutations ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="bg-black/40 p-4 rounded-lg border border-white/10 hover:border-opacity-50 transition-all" style="border-color: var(--theme-border)">
                                    <div class="text-[10px] theme-text-primary font-bold uppercase tracking-wider"><?php echo e($m->origin); ?></div>
                                    <div class="font-medieval font-bold text-white uppercase text-base mt-1"><?php echo e($m->name); ?></div>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed"><?php echo e($m->description); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500 italic text-sm text-center py-4">Nenhuma mutação registrada.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Bônus</h3>
                            <span class="text-[10px] theme-text-primary opacity-70">Incrementos</span>
                        </div>
                        <div class="dynamic-scroll-container space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $ficha->bonuses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex justify-between items-center bg-black/40 p-4 rounded-lg border" style="border-color: var(--theme-border)">
                                    <span class="text-sm uppercase font-bold text-gray-200"><?php echo e($b->name); ?></span>
                                    <span class="theme-text-primary font-medieval font-black text-xl">+<?php echo e($b->value); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500 italic text-sm text-center py-4">Nenhum bônus detectado.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="ark-panel !p-6">
                        <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Poderes</h3>
                            <span class="text-[10px] theme-text-primary opacity-70">Sobrevivente</span>
                        </div>
                        <div class="dynamic-scroll-container space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $ficha->survivorPowers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="bg-black/40 p-4 rounded-lg border" style="border-color: var(--theme-border)">
                                    <div class="font-medieval font-bold text-white uppercase text-base"><?php echo e($p->name); ?></div>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed"><?php echo e($p->description); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500 italic text-sm text-center py-4">Sem poderes registrados.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="ark-panel !p-6">
                        <div class="flex items-center justify-between border-b pb-3 mb-5" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase tracking-wider">Rituais</h3>
                            <span class="text-[10px] theme-text-primary opacity-70">Pactos</span>
                        </div>
                        <div class="dynamic-scroll-container space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $ficha->rituals ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="bg-black/40 p-4 rounded-lg border" style="border-color: var(--theme-border)">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-[8px] bg-red-900/60 text-red-200 px-2 py-0.5 rounded uppercase font-black tracking-wider"><?php echo e($r->type ?? 'Protocolo'); ?></span>
                                        <span class="font-medieval font-bold text-white uppercase text-base"><?php echo e($r->name); ?></span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2 leading-relaxed"><?php echo e($r->description); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500 italic text-sm text-center py-4">Sem rituais manifestados.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="ark-panel !p-6">
                    <h3 class="text-sm font-medieval font-black mb-4 theme-text-primary uppercase tracking-widest border-b pb-3" style="border-color: var(--theme-border)">
                        Carga & Equipamento
                    </h3>
                    <div class="font-mono text-sm text-cyan-300 bg-black/40 p-5 rounded-lg border whitespace-pre-wrap break-words text-left uppercase tracking-wider leading-relaxed shadow-inner" style="border-color: var(--theme-border)">
                        <?php echo e(trim($ficha->arsenal) ?: 'NENHUM EQUIPAMENTO REGISTRADO.'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="fixed bottom-6 right-6 no-print z-50">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="bg-black/80 p-4 rounded-full shadow-[0_0_20px_var(--theme-glow)] transition-all hover:scale-110 border" style="border-color: var(--theme-primary); color: var(--theme-primary)">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>

    
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #000 !important; }
            .ark-panel { break-inside: avoid; }
        }
        .pdf-flash {
            animation: flashEffect 0.4s ease-out;
        }
        @keyframes flashEffect {
            0% { filter: brightness(1); }
            50% { filter: brightness(2) contrast(1.2); box-shadow: 0 0 50px var(--theme-glow); }
            100% { filter: brightness(1); }
        }
    </style>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        // ========== SISTEMA DE TEMAS (civilização) ==========
        // Mapeamento das cores e imagens de marca d'água
        const themeColors = {
            padrao: { primary: '#00f2ff', secondary: '#4deaff', watermark: 'watermark_pegada.png' },
            gladio: { primary: '#f97316', secondary: '#fdba74', watermark: 'watermark_gladio.png' },
            iberos: { primary: '#38bdf8', secondary: '#f472b6', watermark: 'watermark_iberos.png' },
            orc: { primary: '#4ade80', secondary: '#854d0e', watermark: 'watermark_orc.png' },
            fungo: { primary: '#a855f7', secondary: '#d8b4fe', watermark: 'watermark_fungo.png' },
            escarlate: { primary: '#ef4444', secondary: '#fca5a5', watermark: 'watermark_escarlate.png' }
        };

        // Pega a civilização do personagem (vinda do PHP)
        let civKey = '<?php echo e(strtolower($ficha->class_sub)); ?>';
        // Normaliza: remove espaços, acentos etc. (ex: "Companhia Escarlate" vira "escarlate")
        if (civKey.includes('gladio')) civKey = 'gladio';
        else if (civKey.includes('iberos')) civKey = 'iberos';
        else if (civKey.includes('orc')) civKey = 'orc';
        else if (civKey.includes('fungo')) civKey = 'fungo';
        else if (civKey.includes('escarlate')) civKey = 'escarlate';
        else civKey = 'padrao';

        const civ = themeColors[civKey] || themeColors.padrao;
        const primaryColor = civ.primary;
        const watermarkImage = civ.watermark;

        // Aplica as cores nas variáveis CSS
        document.documentElement.style.setProperty('--theme-primary', primaryColor);
        document.documentElement.style.setProperty('--theme-secondary', civ.secondary);
        document.documentElement.style.setProperty('--theme-glow', `${primaryColor}80`);
        document.documentElement.style.setProperty('--theme-border', `${primaryColor}40`);
        document.documentElement.style.setProperty('--theme-panel-bg', `${primaryColor}0d`);

        // Troca a imagem de fundo (marca d'água) da caixa de foto
        const watermarkDiv = document.getElementById('watermark-image-show');
        if (watermarkDiv) {
            watermarkDiv.style.backgroundImage = `url('<?php echo e(asset('images/')); ?>/${watermarkImage}')`;
        }

        // ========== FUNÇÃO PARA GERAR PDF ==========
        async function gerarPDF(button) {
            const { jsPDF } = window.jspdf;
            const element = document.getElementById('capture-area');
            const originalText = button.innerHTML;
            
            button.innerHTML = "<span>SINCRONIZANDO...</span>";
            button.disabled = true;

            // Efeito de flash
            element.classList.add('pdf-flash');
            await new Promise(resolve => setTimeout(resolve, 200));

            try {
                const options = {
                    scale: 2.8,
                    useCORS: true,
                    allowTaint: false,
                    backgroundColor: "#0a0a0a",
                    onclone: (clonedDoc) => {
                        const area = clonedDoc.getElementById('capture-area');
                        area.querySelectorAll('.animate-fadeInUp').forEach(el => {
                            el.style.animation = 'none';
                            el.style.opacity = '1';
                            el.style.transform = 'none';
                        });
                        area.querySelectorAll('.no-print').forEach(el => el.remove());
                        area.querySelectorAll('img').forEach(img => {
                            img.style.filter = 'brightness(1.05) contrast(1.05)';
                        });
                    }
                };

                const canvas = await html2canvas(element, options);
                const imgData = canvas.toDataURL('image/png', 1.0);
                
                const pdf = new jsPDF({
                    orientation: canvas.width > canvas.height ? 'l' : 'p',
                    unit: 'px',
                    format: [canvas.width, canvas.height]
                });

                pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
                pdf.save(`FICHA_ARK_<?php echo e(strtoupper(str_replace(' ', '_', $ficha->name))); ?>.pdf`);
                
                button.innerHTML = "<span>EXPORTADO</span>";
            } catch (error) {
                console.error("Erro na geração do PDF:", error);
                button.innerHTML = "<span>FALHA</span>";
            } finally {
                element.classList.remove('pdf-flash');
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/fichas/show.blade.php ENDPATH**/ ?>