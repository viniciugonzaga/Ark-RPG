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
        <img id="bg-image" src="<?php echo e(asset('images/fundo_create_padrao.png')); ?>" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

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
        .animate-fadeInUp { animation: fadeInUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards; opacity: 0; }

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

        .dynamic-scroll-container {
            max-height: 400px;
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
    </style>

    <div class="relative py-12 px-6 max-w-7xl mx-auto">
        <form action="<?php echo e(route('fichas.update', $ficha->id)); ?>" method="POST" enctype="multipart/form-data" id="edit-character-form">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="flex flex-wrap justify-between items-end gap-4 mb-10 border-b pb-6 animate-fadeInUp" style="border-color: var(--theme-border)">
                <div>
                    <h2 class="text-5xl font-medieval font-black text-white uppercase tracking-tighter italic">Editar Ficha</h2>
                    <p class="theme-text-primary font-bold uppercase tracking-widest text-xs mt-2">Sincronizando: <?php echo e($ficha->name); ?></p>
                </div>
                <div class="flex gap-4">
                    <a href="<?php echo e(route('fichas.index')); ?>" class="btn-cancel">CANCELAR</a>
                    <button type="submit" class="btn-neon">SALVAR ALTERAÇÕES</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-6 animate-fadeInUp" style="animation-delay: 0.1s">
                    <div class="ark-panel !p-4 relative overflow-hidden dna-overlay">
                        <div id="watermark-image-edit" class="absolute inset-0 bg-cover bg-center opacity-20 pointer-events-none" 
                             style="background-image: url('<?php echo e(asset('images/watermark_pegada.png')); ?>'); background-repeat: no-repeat; background-position: center;"></div>
                        <label class="text-[10px] font-medieval font-black theme-text-primary block mb-3 uppercase tracking-widest">Pele (IMG)</label>
                       <?php if($ficha->image): ?>
                        <img src="<?php echo e(route('media.show', $ficha->image)); ?>" class="w-full h-48 object-cover rounded-lg mb-4 border" style="border-color: var(--theme-border)">
                       <?php endif; ?>
                        <input type="file" name="image" class="w-full text-xs text-gray-400 ark-input">
                    </div>

                    <div class="ark-panel !p-6">
                        <h3 class="text-sm font-medieval font-black mb-6 theme-text-primary uppercase text-center border-b pb-3" style="border-color: var(--theme-border)">Atributos</h3>
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

                    <div class="ark-panel !p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase">ORIGEM</label>
                            <select name="class_main" id="class_main_edit" onchange="updateAll()" class="ark-input w-full !py-3">
                                <option value="Humano" <?php echo e($ficha->class_main == 'Humano' ? 'selected' : ''); ?>>Humano</option>
                                <option value="Morto-Vivo" <?php echo e($ficha->class_main == 'Morto-Vivo' ? 'selected' : ''); ?>>Morto-Vivo</option>
                                <option value="Meio-Humano" <?php echo e($ficha->class_main == 'Meio-Humano' ? 'selected' : ''); ?>>Meio-Humano</option>
                                <option value="Místico" <?php echo e($ficha->class_main == 'Místico' ? 'selected' : ''); ?>>Místico</option>
                                <option value="Gládio" <?php echo e($ficha->class_main == 'Gládio' ? 'selected' : ''); ?>>Gládio</option>
                                <option value="Iberos" <?php echo e($ficha->class_main == 'Iberos' ? 'selected' : ''); ?>>Iberos</option>
                                <option value="Orc" <?php echo e($ficha->class_main == 'Orc' ? 'selected' : ''); ?>>Orc</option>
                                <option value="Fungo" <?php echo e($ficha->class_main == 'Fungo' ? 'selected' : ''); ?>>Fungo</option>
                                <option value="Escarlate" <?php echo e($ficha->class_main == 'Escarlate' ? 'selected' : ''); ?>>Escarlate</option>
                                <option value="Bandidos" <?php echo e($ficha->class_main == 'Bandidos' ? 'selected' : ''); ?>>Bandidos</option>
                                <option value="Tormenta" <?php echo e($ficha->class_main == 'Tormenta' ? 'selected' : ''); ?>>Tormenta</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase">PECULIARIDADE</label>
                            <select name="class_sub" id="class_sub_edit" onchange="updateAll()" class="ark-input w-full !py-3">
                                <option value="Padrão" <?php echo e($ficha->class_sub == 'Padrão' ? 'selected' : ''); ?>>Padrão</option>
                                <option value="Caribidis" <?php echo e($ficha->class_sub == 'Caribidis' ? 'selected' : ''); ?>>Caribidis</option>
                                <option value="Pandora" <?php echo e($ficha->class_sub == 'Pandora' ? 'selected' : ''); ?>>Pandora</option>
                                <option value="Pandemônio" <?php echo e($ficha->class_sub == 'Pandemônio' ? 'selected' : ''); ?>>Pandemônio</option>
                                <option value="Argana" <?php echo e($ficha->class_sub == 'Argana' ? 'selected' : ''); ?>>Argana</option>
                                <option value="Cabibis" <?php echo e($ficha->class_sub == 'Cabibis' ? 'selected' : ''); ?>>Cabibis</option>
                                <option value="Hades" <?php echo e($ficha->class_sub == 'Hades' ? 'selected' : ''); ?>>Hades</option>
                                <option value="Abismo" <?php echo e($ficha->class_sub == 'Abismo' ? 'selected' : ''); ?>>Abismo</option>
                                <option value="Hipnos" <?php echo e($ficha->class_sub == 'Hipnos' ? 'selected' : ''); ?>>Hipnos</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <div class="flex flex-wrap justify-between items-center gap-2 mb-4 border-b pb-3" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase italic">Mutações</h3>
                            <button type="button" onclick="addField('mutations', 'mutations-container')" class="text-[10px] bg-opacity-20 px-3 py-1 rounded font-bold transition-all border theme-text-primary" style="background-color: var(--theme-panel-bg); border-color: var(--theme-border)">+ ADICIONAR</button>
                        </div>
                        <div id="mutations-container" class="dynamic-scroll-container space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $ficha->mutations ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-2 bg-black/40 p-3 rounded-lg relative border" style="border-color: var(--theme-border)">
                                    <input type="text" name="mutations[<?php echo e($i); ?>][origin]" value="<?php echo e($m->origin); ?>" class="ark-input text-[10px]" placeholder="ORIGEM">
                                    <input type="text" name="mutations[<?php echo e($i); ?>][name]" value="<?php echo e($m->name); ?>" class="ark-input md:col-span-2 font-bold theme-text-primary" placeholder="NOME DA MUTAÇÃO">
                                    <textarea name="mutations[<?php echo e($i); ?>][description]" class="ark-input md:col-span-4 text-xs h-12 italic text-gray-400"><?php echo e($m->description); ?></textarea>
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500 text-xs text-center py-2">Nenhuma mutação registrada.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="ark-panel !p-6">
                        <div class="flex flex-wrap justify-between items-center gap-2 mb-4 border-b pb-3" style="border-color: var(--theme-border)">
                            <h3 class="text-lg font-medieval font-black theme-text-primary uppercase italic">Rituais e Pactos</h3>
                            <button type="button" onclick="addField('rituals', 'rituals-container')" class="text-[10px] bg-opacity-20 px-3 py-1 rounded font-bold transition-all border theme-text-primary" style="background-color: var(--theme-panel-bg); border-color: var(--theme-border)">+ NOVO REGISTRO</button>
                        </div>
                        <div id="rituals-container" class="dynamic-scroll-container space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $ficha->rituals ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 bg-black/40 p-3 rounded-lg relative border" style="border-color: var(--theme-border)">
                                    <select name="rituals[<?php echo e($i); ?>][type]" class="ark-input text-[10px] font-black uppercase">
                                        <option value="ritual" <?php echo e($r->type == 'ritual' ? 'selected' : ''); ?>>RITUAL</option>
                                        <option value="pacto" <?php echo e($r->type == 'pacto' ? 'selected' : ''); ?>>PACTO</option>
                                        <option value="conjuracao" <?php echo e($r->type == 'conjuracao' ? 'selected' : ''); ?>>CONJURAÇÃO</option>
                                    </select>
                                    <input type="text" name="rituals[<?php echo e($i); ?>][name]" value="<?php echo e($r->name); ?>" class="ark-input md:col-span-2 font-bold uppercase" placeholder="NOME">
                                    <textarea name="rituals[<?php echo e($i); ?>][description]" class="ark-input md:col-span-3 text-xs h-10 italic text-gray-400"><?php echo e($r->description); ?></textarea>
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg hover:scale-110 transition">✕</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-gray-500 text-xs text-center py-2">Nenhum ritual registrado.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="ark-panel !p-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-base font-medieval font-black theme-text-primary uppercase tracking-tighter">Bônus</h3>
                                <button type="button" onclick="addField('bonuses', 'bonuses-container')" class="text-[9px] bg-opacity-10 px-2 py-0.5 rounded border theme-text-primary" style="border-color: var(--theme-border)">+ ADD</button>
                            </div>
                            <div id="bonuses-container" class="dynamic-scroll-container space-y-2">
                                <?php $__empty_1 = true; $__currentLoopData = $ficha->bonuses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="bg-black/40 p-2 rounded relative border" style="border-color: var(--theme-border)">
                                        <input type="text" name="bonuses[<?php echo e($i); ?>][name]" value="<?php echo e($b->name); ?>" class="ark-input w-full text-[10px] font-bold mb-1 theme-text-primary" placeholder="NOME">
                                        <input type="number" name="bonuses[<?php echo e($i); ?>][value]" value="<?php echo e($b->value); ?>" class="ark-input w-full text-[10px]" placeholder="VALOR (ex: +5)">
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center hover:scale-110 transition">✕</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-gray-500 text-xs text-center py-2">Nenhum bônus registrado.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="ark-panel !p-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-base font-medieval font-black theme-text-primary uppercase tracking-tighter">Poderes de Sobrevivente</h3>
                                <button type="button" onclick="addField('powers', 'powers-container')" class="text-[9px] bg-opacity-10 px-2 py-0.5 rounded border theme-text-primary" style="border-color: var(--theme-border)">+ ADD</button>
                            </div>
                            <div id="powers-container" class="dynamic-scroll-container space-y-2">
                                <?php $__empty_1 = true; $__currentLoopData = $ficha->survivorPowers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="bg-black/40 p-2 rounded relative border" style="border-color: var(--theme-border)">
                                        <input type="text" name="powers[<?php echo e($i); ?>][name]" value="<?php echo e($p->name); ?>" class="ark-input w-full text-xs font-bold mb-1 theme-text-primary uppercase" placeholder="NOME">
                                        <textarea name="powers[<?php echo e($i); ?>][description]" class="ark-input w-full text-[10px] h-10 italic text-gray-400"><?php echo e($p->description); ?></textarea>
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center hover:scale-110 transition">✕</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-gray-500 text-xs text-center py-2">Nenhum poder registrado.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="ark-panel !p-6">
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase block mb-2">Histórico (Lore)</label>
                            <textarea name="lore" class="ark-input w-full h-40 text-sm italic leading-relaxed"><?php echo e($ficha->lore); ?></textarea>
                        </div>
                        <div class="ark-panel !p-6">
                            <label class="text-[10px] font-medieval font-black theme-text-primary uppercase block mb-2">Inventário</label>
                            <textarea name="arsenal" class="ark-input w-full h-40 font-mono text-xs text-gray-300 text-left"><?php echo e($ficha->arsenal); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // MAPEAMENTOS (iguais ao create) - mantenha igual ao que você já tem
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

        function setThemeEdit(primary, secondary) {
            document.documentElement.style.setProperty('--theme-primary', primary);
            document.documentElement.style.setProperty('--theme-secondary', secondary);
            document.documentElement.style.setProperty('--theme-glow', primary + '80');
            document.documentElement.style.setProperty('--theme-border', primary + '40');
            document.documentElement.style.setProperty('--theme-panel-bg', primary + '0d');
        }

        function setBackgroundEdit(image) {
            const bg = document.getElementById('bg-image');
            if (bg) bg.src = `<?php echo e(asset('images/')); ?>/${image}`;
        }

        function setWatermarkEdit(image) {
            const wm = document.getElementById('watermark-image-edit');
            if (wm) wm.style.backgroundImage = `url('<?php echo e(asset('images/')); ?>/${image}')`;
        }

        function updateAll() {
            const origin = document.getElementById('class_main_edit').value;
            const peculiaridade = document.getElementById('class_sub_edit').value;

            const colors = themeColors[peculiaridade];
            if (colors) setThemeEdit(colors.primary, colors.secondary);

            const wm = watermarkByPeculiaridade[peculiaridade] || 'watermark_pegada.png';
            setWatermarkEdit(wm);

            let bg = backgroundByOrigin[origin];
            if (!bg) bg = backgroundByPeculiaridade[peculiaridade] || 'fundo_create_padrao.png';
            setBackgroundEdit(bg);
        }

        document.addEventListener('DOMContentLoaded', updateAll);

        // ========== ADICIONAR CAMPOS ==========
        let counts = {
            mutations: <?php echo e(optional($ficha->mutations)->count() ?? 0); ?>,
            rituals: <?php echo e(optional($ficha->rituals)->count() ?? 0); ?>,
            bonuses: <?php echo e(optional($ficha->bonuses)->count() ?? 0); ?>,
            powers: <?php echo e(optional($ficha->survivorPowers)->count() ?? 0); ?>

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
<?php endif; ?><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/fichas/edit.blade.php ENDPATH**/ ?>