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
        <img src="<?php echo e(asset('images/fundo_edit.png')); ?>" alt="Background" class="w-full h-full object-cover opacity-40">
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

        .theme-text-primary { color: var(--theme-primary); }
        .theme-border-primary { border-color: var(--theme-primary); }
        .theme-bg-panel { background-color: var(--theme-panel-bg); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; opacity: 0; }
        .animate-slideDown { animation: slideDown 0.3s ease forwards; }

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
            @apply relative px-6 py-2.5 text-sm font-black uppercase tracking-[0.2em] rounded-md transition-all duration-300 overflow-hidden;
            background: rgba(0,0,0,0.7);
            border: 1px solid var(--theme-primary);
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

        /* Botão cancelar (vermelho suave) */
        .btn-cancel {
            @apply relative px-6 py-2.5 text-sm font-black uppercase tracking-[0.2em] rounded-md transition-all duration-300;
            background: rgba(0,0,0,0.7);
            border: 1px solid rgba(239, 68, 68, 0.5);
            padding: 10px 20px;
            border-radius: 20px;
            color: #f87171;
            box-shadow: 0 0 8px rgba(239,68,68,0.3);
        }
        .btn-cancel:hover {
            background: #dc2626;
            color: white;
            border-color: #ef4444;
            box-shadow: 0 0 20px #ef4444;
            transform: translateY(-2px);
        }

        /* Container de scroll para listas */
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

        /* Badge de tipo (rituais) */
        .badge-ritual { background: #7c3aed20; border-color: #a855f7; color: #d8b4fe; }
        .badge-pacto { background: #db277720; border-color: #f43f5e; color: #fda4af; }
        .badge-conjuracao { background: #3b82f620; border-color: #60a5fa; color: #93c5fd; }
    </style>

    <div class="relative py-12 px-6 max-w-7xl mx-auto">
        <form action="<?php echo e(route('fichas.update', $ficha->id)); ?>" method="POST" enctype="multipart/form-data" id="edit-character-form">
            <?php echo csrf_field(); ?> 
            <?php echo method_field('PUT'); ?>

            
            <div class="flex flex-wrap justify-between items-end gap-4 mb-10 border-b pb-6 animate-fadeInUp" style="border-color: var(--theme-border)">
                <div>
                    <h2 class="text-5xl font-medieval font-black text-white uppercase tracking-tighter italic">Reconfigurar DNA</h2>
                    <p class="theme-text-primary font-bold uppercase tracking-widest text-xs mt-2">Sincronizando: <?php echo e($ficha->name); ?></p>
                </div>
                <div class="flex gap-4">
                    <a href="<?php echo e(route('fichas.index')); ?>" class="btn-cancel">CANCELAR</a>
                    <button type="submit" class="btn-neon">SALVAR ALTERAÇÕES</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                
                <div class="space-y-6 animate-fadeInUp" style="animation-delay: 0.1s">
                    
                    <div class="ark-panel !p-4 relative overflow-hidden">
                        <div id="watermark-image-edit" class="absolute inset-0 bg-cover bg-center opacity-20 pointer-events-none" 
                             style="background-image: url('<?php echo e(asset('images/watermark_pegada.png')); ?>'); background-repeat: no-repeat; background-position: center;"></div>
                        <label class="text-[10px] font-medieval font-black theme-text-primary block mb-3 uppercase tracking-widest">Biometria (IMG)</label>
                        <?php if($ficha->image): ?>
                            <img src="<?php echo e(asset('storage/' . $ficha->image)); ?>" class="w-full h-48 object-cover rounded-lg mb-4 border" style="border-color: var(--theme-border)">
                        <?php endif; ?>
                        <input type="file" name="image" class="w-full text-xs text-gray-400 ark-input">
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <h3 class="text-sm font-medieval font-black mb-6 theme-text-primary uppercase text-center border-b pb-3" style="border-color: var(--theme-border)">Atributos de Base</h3>
                        <div class="grid grid-cols-5 gap-3">
                            <?php $__currentLoopData = ['agi','for','int','set','vig']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="text-center">
                                    <label class="text-[10px] font-medieval font-black theme-text-primary/70 uppercase"><?php echo e(strtoupper($at)); ?></label>
                                    <input type="number" name="<?php echo e($at); ?>" value="<?php echo e($ficha->$at); ?>" class="w-full bg-black/50 border rounded text-white text-center p-2 font-bold" style="border-color: var(--theme-border)">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <h3 class="text-sm font-medieval font-black mb-5 theme-text-primary uppercase text-center border-b pb-3" style="border-color: var(--theme-border)">Status Vitais</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <?php $__currentLoopData = ['vida', 'armadura', 'determinacao', 'folego', 'resistencia']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <label class="text-[9px] font-black text-gray-400 uppercase"><?php echo e($stat); ?></label>
                                    <input type="number" name="<?php echo e($stat); ?>" value="<?php echo e($ficha->$stat); ?>" class="ark-input w-full !py-2">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                
                <div class="lg:col-span-2 space-y-6 animate-fadeInUp" style="animation-delay: 0.2s">
                    
                    <div class="ark-panel !p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase">Designação do Sobrevivente</label>
                            <input type="text" name="name" value="<?php echo e($ficha->name); ?>" class="ark-input w-full !text-2xl font-medieval font-black uppercase">
                        </div>
                        <div>
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase text-center block">Nível</label>
                            <input type="number" name="level" value="<?php echo e($ficha->level); ?>" class="ark-input w-full !text-2xl text-center font-medieval font-black">
                        </div>
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <div class="flex flex-wrap justify-between items-center gap-2 mb-4 border-b pb-3" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase italic">Mutações de DNA</h3>
                            <button type="button" onclick="addField('mutations', 'mutations-container')" class="text-[10px] bg-opacity-20 px-3 py-1 rounded font-bold transition-all border theme-text-primary" style="background-color: var(--theme-panel-bg); border-color: var(--theme-border)">+ ADICIONAR</button>
                        </div>
                        <div id="mutations-container" class="dynamic-scroll-container space-y-3">
                            <?php $__currentLoopData = $ficha->mutations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 bg-black/40 p-3 rounded-lg relative border" style="border-color: var(--theme-border)">
                                    <input type="text" name="mutations[<?php echo e($i); ?>][origin]" value="<?php echo e($m->origin); ?>" class="ark-input text-[10px]" placeholder="ORIGEM">
                                    <input type="text" name="mutations[<?php echo e($i); ?>][name]" value="<?php echo e($m->name); ?>" class="ark-input md:col-span-2 font-bold theme-text-primary" placeholder="NOME DA MUTAÇÃO">
                                    <textarea name="mutations[<?php echo e($i); ?>][description]" class="ark-input md:col-span-4 text-xs h-12 italic text-gray-400"><?php echo e($m->description); ?></textarea>
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <div class="flex flex-wrap justify-between items-center gap-2 mb-4 border-b pb-3" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase italic">Conhecimento Arcano / Pactos</h3>
                            <button type="button" onclick="addField('rituals', 'rituals-container')" class="text-[10px] bg-opacity-20 px-3 py-1 rounded font-bold transition-all border theme-text-primary" style="background-color: var(--theme-panel-bg); border-color: var(--theme-border)">+ NOVO REGISTRO</button>
                        </div>
                        <div id="rituals-container" class="dynamic-scroll-container space-y-3">
                            <?php $__currentLoopData = $ficha->rituals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 bg-black/40 p-3 rounded-lg relative border" style="border-color: var(--theme-border)">
                                    <select name="rituals[<?php echo e($i); ?>][type]" class="ark-input text-[10px] font-black uppercase">
                                        <option value="ritual" <?php echo e($r->type == 'ritual' ? 'selected' : ''); ?> class="badge-ritual">RITUAL</option>
                                        <option value="pacto" <?php echo e($r->type == 'pacto' ? 'selected' : ''); ?> class="badge-pacto">PACTO</option>
                                        <option value="conjuracao" <?php echo e($r->type == 'conjuracao' ? 'selected' : ''); ?> class="badge-conjuracao">CONJURAÇÃO</option>
                                    </select>
                                    <input type="text" name="rituals[<?php echo e($i); ?>][name]" value="<?php echo e($r->name); ?>" class="ark-input md:col-span-2 font-bold uppercase" placeholder="NOME">
                                    <textarea name="rituals[<?php echo e($i); ?>][description]" class="ark-input md:col-span-3 text-xs h-10 italic text-gray-400"><?php echo e($r->description); ?></textarea>
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="ark-panel !p-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-base font-medieval font-black theme-text-primary uppercase tracking-tighter">Bônus Ativos</h3>
                                <button type="button" onclick="addField('bonuses', 'bonuses-container')" class="text-[9px] bg-opacity-10 px-2 py-0.5 rounded border theme-text-primary" style="border-color: var(--theme-border)">+ ADD</button>
                            </div>
                            <div id="bonuses-container" class="dynamic-scroll-container space-y-2">
                                <?php $__currentLoopData = $ficha->bonuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-black/40 p-2 rounded relative border" style="border-color: var(--theme-border)">
                                        <input type="text" name="bonuses[<?php echo e($i); ?>][name]" value="<?php echo e($b->name); ?>" class="ark-input w-full text-[10px] font-bold mb-1 theme-text-primary" placeholder="NOME">
                                        <input type="number" name="bonuses[<?php echo e($i); ?>][value]" value="<?php echo e($b->value); ?>" class="ark-input w-full text-[10px]" placeholder="VALOR (ex: +5)">
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center hover:scale-110 transition">✕</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        
                        <div class="ark-panel !p-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-base font-medieval font-black theme-text-primary uppercase tracking-tighter">Capacidades e Poderes</h3>
                                <button type="button" onclick="addField('powers', 'powers-container')" class="text-[9px] bg-opacity-10 px-2 py-0.5 rounded border theme-text-primary" style="border-color: var(--theme-border)">+ ADD</button>
                            </div>
                            <div id="powers-container" class="dynamic-scroll-container space-y-2">
                                <?php $__currentLoopData = $ficha->survivorPowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-black/40 p-2 rounded relative border" style="border-color: var(--theme-border)">
                                        <input type="text" name="powers[<?php echo e($i); ?>][name]" value="<?php echo e($p->name); ?>" class="ark-input w-full text-xs font-bold mb-1 theme-text-primary uppercase" placeholder="NOME">
                                        <textarea name="powers[<?php echo e($i); ?>][description]" class="ark-input w-full text-[10px] h-10 italic text-gray-400" placeholder="DESCRIÇÃO..."><?php echo e($p->description); ?></textarea>
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center hover:scale-110 transition">✕</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="ark-panel !p-6">
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase block mb-2">Histórico (Lore)</label>
                            <textarea name="lore" class="ark-input w-full h-40 text-sm italic leading-relaxed"><?php echo e($ficha->lore); ?></textarea>
                        </div>
                        <div class="ark-panel !p-6">
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase block mb-2">Arsenal de Combate</label>
                            <textarea name="arsenal" class="ark-input w-full h-40 font-mono text-xs text-gray-300"><?php echo e($ficha->arsenal); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    
    <script>
        // ========== SISTEMA DE TEMAS (civilização) ==========
        const themeColors = {
            padrao: { primary: '#00f2ff', secondary: '#4deaff', watermark: 'watermark_pegada.png' },
            gladio: { primary: '#f97316', secondary: '#fdba74', watermark: 'watermark_gladio.png' },
            iberos: { primary: '#38bdf8', secondary: '#f472b6', watermark: 'watermark_iberos.png' },
            orc: { primary: '#4ade80', secondary: '#854d0e', watermark: 'watermark_orc.png' },
            fungo: { primary: '#a855f7', secondary: '#d8b4fe', watermark: 'watermark_fungo.png' },
            escarlate: { primary: '#ef4444', secondary: '#fca5a5', watermark: 'watermark_escarlate.png' }
        };

        let civKey = '<?php echo e(strtolower($ficha->class_sub)); ?>';
        if (civKey.includes('gladio')) civKey = 'gladio';
        else if (civKey.includes('iberos')) civKey = 'iberos';
        else if (civKey.includes('orc')) civKey = 'orc';
        else if (civKey.includes('fungo')) civKey = 'fungo';
        else if (civKey.includes('escarlate')) civKey = 'escarlate';
        else civKey = 'padrao';

        const civ = themeColors[civKey] || themeColors.padrao;
        const primaryColor = civ.primary;
        const watermarkImage = civ.watermark;

        document.documentElement.style.setProperty('--theme-primary', primaryColor);
        document.documentElement.style.setProperty('--theme-secondary', civ.secondary);
        document.documentElement.style.setProperty('--theme-glow', `${primaryColor}80`);
        document.documentElement.style.setProperty('--theme-border', `${primaryColor}40`);
        document.documentElement.style.setProperty('--theme-panel-bg', `${primaryColor}0d`);

        const watermarkDiv = document.getElementById('watermark-image-edit');
        if (watermarkDiv) {
            watermarkDiv.style.backgroundImage = `url('<?php echo e(asset('images/')); ?>/${watermarkImage}')`;
        }

        // ========== FUNÇÕES PARA ADICIONAR CAMPOS DINÂMICOS ==========
        let counts = {
            mutations: <?php echo e($ficha->mutations->count()); ?>,
            rituals: <?php echo e($ficha->rituals->count()); ?>,
            bonuses: <?php echo e($ficha->bonuses->count()); ?>,
            powers: <?php echo e($ficha->survivorPowers->count()); ?>

        };

        function addField(type, containerId) {
            const i = counts[type]++;
            const container = document.getElementById(containerId);
            let html = '';

            if(type === 'mutations') {
                html = `<div class="grid grid-cols-1 md:grid-cols-4 gap-2 bg-black/40 p-3 rounded-lg relative border animate-slideDown" style="border-color: var(--theme-border)">
                    <input type="text" name="mutations[${i}][origin]" class="ark-input text-[10px]" placeholder="ORIGEM">
                    <input type="text" name="mutations[${i}][name]" class="ark-input md:col-span-2 font-bold theme-text-primary" placeholder="NOVA MUTAÇÃO">
                    <textarea name="mutations[${i}][description]" class="ark-input md:col-span-4 text-xs h-12 italic" placeholder="EFEITOS..."></textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                </div>`;
            } else if(type === 'rituals') {
                html = `<div class="grid grid-cols-1 md:grid-cols-3 gap-2 bg-black/40 p-3 rounded-lg relative border animate-slideDown" style="border-color: var(--theme-border)">
                    <select name="rituals[${i}][type]" class="ark-input text-[10px] font-black uppercase">
                        <option value="ritual">RITUAL</option>
                        <option value="pacto">PACTO</option>
                        <option value="conjuracao">CONJURAÇÃO</option>
                    </select>
                    <input type="text" name="rituals[${i}][name]" class="ark-input md:col-span-2 font-bold uppercase" placeholder="NOME">
                    <textarea name="rituals[${i}][description]" class="ark-input md:col-span-3 text-xs h-10 italic" placeholder="DESCRIÇÃO..."></textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                </div>`;
            } else if(type === 'bonuses') {
                html = `<div class="bg-black/40 p-2 rounded relative border animate-slideDown" style="border-color: var(--theme-border)">
                    <input type="text" name="bonuses[${i}][name]" class="ark-input w-full text-[10px] font-bold mb-1 theme-text-primary" placeholder="NOME">
                    <input type="number" name="bonuses[${i}][value]" class="ark-input w-full text-[10px]" placeholder="VALOR (ex: +5)">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center hover:scale-110 transition">✕</button>
                </div>`;
            } else if(type === 'powers') {
                html = `<div class="bg-black/40 p-2 rounded relative border animate-slideDown" style="border-color: var(--theme-border)">
                    <input type="text" name="powers[${i}][name]" class="ark-input w-full text-xs font-bold mb-1 theme-text-primary uppercase" placeholder="NOME">
                    <textarea name="powers[${i}][description]" class="ark-input w-full text-[10px] h-10 italic" placeholder="DESCRIÇÃO..."></textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center hover:scale-110 transition">✕</button>
                </div>`;
            }
            container.insertAdjacentHTML('beforeend', html);
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
<?php endif; ?><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/fichas/edit.blade.php ENDPATH**/ ?>