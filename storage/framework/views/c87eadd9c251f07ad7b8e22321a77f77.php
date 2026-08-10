
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['characters']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['characters']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<style>
    .ark-panel {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(12px);
        border: 1px solid var(--theme-border, rgba(0, 242, 255, 0.3));
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .ark-input {
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(0, 242, 255, 0.3);
        color: white;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.875rem;
        transition: all 0.3s;
    }
    .ark-input:focus {
        border-color: #00f2ff;
        box-shadow: 0 0 15px rgba(0, 242, 255, 0.3);
        outline: none;
        background: rgba(0, 0, 0, 0.8);
    }
    .btn-neon {
        background: rgba(0, 0, 0, 0.7);
        border: 1px solid var(--theme-primary, #00f2ff);
        color: var(--theme-primary, #00f2ff);
        border-radius: 40px;
        padding: 10px 20px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-neon:hover {
        background: var(--theme-primary, #00f2ff);
        color: black;
        box-shadow: 0 0 20px var(--theme-glow, rgba(0, 242, 255, 0.5));
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
        background: rgba(0, 0, 0, 0.85);
        border: 2px solid var(--theme-primary, #00f2ff);
        border-radius: 16px;
        box-shadow: 0 0 15px var(--theme-glow, rgba(0, 242, 255, 0.5));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
        font-weight: 900;
        color: var(--theme-primary, #00f2ff);
        text-shadow: 0 0 5px currentColor;
        backdrop-filter: blur(4px);
    }
    .face-front  { transform: rotateY(0deg) translateZ(50px); }
    .face-back   { transform: rotateY(180deg) translateZ(50px); }
    .face-right  { transform: rotateY(90deg) translateZ(50px); }
    .face-left   { transform: rotateY(-90deg) translateZ(50px); }
    .face-top    { transform: rotateX(90deg) translateZ(50px); }
    .face-bottom { transform: rotateX(-90deg) translateZ(50px); }
    .attr-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        border: 1px solid var(--theme-primary, #00f2ff);
        margin-right: 8px;
    }
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .event-block {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 16px;
        padding: 12px 16px;
        border: 1px solid var(--theme-border, rgba(0, 242, 255, 0.3));
        transition: all 0.2s;
        cursor: pointer;
    }
    .event-block:hover {
        border-color: var(--theme-primary, #00f2ff);
        background: rgba(0, 0, 0, 0.6);
        transform: scale(1.02);
    }
    .event-icon {
        width: 48px;
        height: 48px;
        object-fit: contain;
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
        color: var(--theme-primary, #00f2ff);
        background: rgba(0, 0, 0, 0.5);
        padding: 2px 8px;
        border-radius: 20px;
    }
    .event-result {
        margin-top: 8px;
        padding: 8px 12px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 12px;
        font-size: 12px;
        color: #d8b4fe;
        display: none;
    }
    .font-medieval {
        font-family: 'Cinzel', serif;
    }
    .theme-text-primary {
        color: var(--theme-primary, #00f2ff);
    }
    .pulse-glow {
        animation: pulse-glow 1.5s infinite;
    }
    @keyframes pulse-glow {
        0%, 100% { filter: drop-shadow(0 0 2px var(--theme-primary, #00f2ff)); }
        50% { filter: drop-shadow(0 0 8px var(--theme-primary, #00f2ff)); }
    }

    /* Popup 20 Natural */
    #extreme-popup {
        transition: opacity 0.3s ease;
    }
    #extreme-popup.show {
        opacity: 1;
        pointer-events: auto;
    }
    #extreme-popup.show > div {
        transform: scale(1);
    }
</style>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <div class="space-y-6">
        
        <div class="ark-panel p-6">
            <h3 class="text-xs uppercase theme-text-primary mb-3">Modo de Rolagem</h3>
            <div class="flex gap-3 items-center">
                <label class="flex items-center gap-2">
                    <input type="radio" name="roll_mode" value="ficha" checked> Usar Ficha
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="roll_mode" value="manual"> Modo Manual
                </label>
            </div>
            <div id="ficha-selector" class="mt-3">
                <select id="character-select" class="ark-input w-full">
                    <option value="">-- Selecione uma Ficha --</option>
                    <?php $__currentLoopData = $characters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $char): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($char->id); ?>" data-civilization="<?php echo e(strtolower($char->class_sub)); ?>"><?php echo e(strtoupper($char->name)); ?> (Nível <?php echo e($char->level); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div id="manual-attributes" class="mt-3 hidden">
                <p class="text-xs text-gray-400 mb-2">Defina os atributos manualmente (0 a 10):</p>
                <div class="grid grid-cols-5 gap-2">
                    <?php $__currentLoopData = ['for','agi','int','vig','set']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label class="text-[10px] uppercase block"><?php echo e($a); ?></label>
                            <input type="number" id="manual-<?php echo e($a); ?>" value="1" min="0" max="10" class="ark-input w-full text-center text-sm">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div id="char-preview" class="ark-panel p-6 opacity-40 transition-all duration-700">
            <h3 class="text-xs uppercase theme-text-primary mb-5 tracking-widest">Status da Ficha</h3>
            <div id="attr-preview" class="grid grid-cols-5 gap-3 text-center text-[10px] mb-8">
                <?php $__currentLoopData = ['for','agi','int','vig','set']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-black/30 backdrop-blur-sm p-3 rounded-xl border border-cyan-500/30">
                        <span class="block theme-text-primary/70 font-bold uppercase mb-1"><?php echo e($a); ?></span>
                        <span class="text-2xl font-medieval font-black text-white">--</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div><h4 class="text-xs uppercase text-emerald-300 mb-2">Bônus Ativos</h4><div id="bonus-preview" class="text-xs text-gray-200 bg-black/20 p-3 rounded-lg">--</div></div>
                <div><h4 class="text-xs uppercase theme-text-primary mb-2">Mutações</h4><div id="mutation-preview" class="text-xs text-gray-200 bg-black/20 p-3 rounded-lg">--</div></div>
            </div>
        </div>

        <div class="ark-panel p-6">
            <h3 class="text-base font-medieval font-black theme-text-primary mb-5">Menu de Atributos</h3>
            <div id="attr-rolls" class="space-y-4"><div class="text-center text-xs theme-text-primary/50 py-6 italic">Aguardando seleção...</div></div>
        </div>
    </div>

    
    <div class="space-y-6">
        <div class="ark-panel p-6">
            <h3 class="text-xs font-bold theme-text-primary uppercase mb-5 flex justify-between items-center">
                Manual De Dados <span class="text-[8px] text-gray-400">Clique esquerdo: +1 | Direito: -1</span>
            </h3>
            <div id="dice-container" class="grid grid-cols-7 gap-2 mb-8"></div>
            <div class="space-y-5">
                <div class="flex gap-3">
                    <select id="mode" class="ark-input flex-1 text-xs uppercase font-bold"><option value="sum">Somar Tudo</option><option value="max">Maior Valor</option></select>
                    <input type="number" id="bonus-manual" placeholder="Bônus" class="ark-input w-24 text-center">
                </div>
                <div class="grid grid-cols-6 gap-2">
                    <?php $__currentLoopData = [5,10,15,20,25,30]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button onclick="setBonus(<?php echo e($b); ?>)" class="bg-black/40 border border-cyan-400/20 hover:bg-cyan-500/30 text-cyan-200 text-xs font-bold p-2 rounded-lg transition-all hover:scale-105">+<?php echo e($b); ?></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button onclick="rollDice()" class="btn-neon w-full flex items-center justify-center gap-2 transition-all">Rolar Dados</button>
            </div>
            <div id="dice-result-display" class="mt-8 p-6 bg-black/40 backdrop-blur-sm border rounded-xl hidden">
                <div class="flex items-center justify-center gap-8 flex-wrap"><div id="dice-3d-container" class="dice-3d-container"></div><div class="flex-1 text-center"><div id="total-result" class="text-6xl font-medieval font-black theme-text-primary">0</div><div id="individual-rolls" class="text-xs theme-text-primary/80 mt-2"></div></div></div>
            </div>
        </div>

        <div class="ark-panel p-6">
            <h3 class="font-medieval font-bold text-base text-purple-300 mb-5">Manual de Eventos Aleatórios</h3>
            <div class="events-grid">
                <?php $__currentLoopData = ['sobrevivencia','efeito','item','traumas','epicos','joias','joias_raras','frutas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="event-block" data-event-type="<?php echo e($tipo); ?>">
                    <img src="<?php echo e(asset("images/evento_{$tipo}_icon.png")); ?>" class="event-icon pulse-glow" style="cursor:pointer">
                    <div class="flex flex-col items-start gap-1"><span class="event-label"><?php echo e(ucfirst($tipo)); ?></span><img src="<?php echo e(asset('images/rolar_evento_text.png')); ?>" class="event-text-img"></div>
                </div>
                <div id="event-result-<?php echo e($tipo); ?>" class="event-result col-span-full"></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>


<div id="extreme-popup" class="fixed inset-0 z-[9999] flex items-center justify-center pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="bg-black/80 backdrop-blur-md rounded-3xl p-8 text-center shadow-[0_0_30px_rgba(0,242,255,0.3)] border border-cyan-500/30 max-w-md mx-4 transform scale-95 transition-all duration-300">
        <img src="<?php echo e(asset('images/Dado_extremo.gif')); ?>" alt="20 Natural" class="w-40 h-40 mx-auto mb-4 drop-shadow-[0_0_15px_cyan]">
        <div class="text-5xl font-medieval font-black bg-gradient-to-r from-yellow-300 to-yellow-500 bg-clip-text text-transparent tracking-widest drop-shadow-[0_0_8px_rgba(255,200,0,0.5)] animate-pulse">
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

    // ========== LÓGICA DE ROLAGEM ==========
    const diceTypes = [4, 6, 8, 10, 12, 20, 100];
    let diceState = {};
    let selectedCharId = null;
    let selectedCharData = null;
    let rollMode = 'ficha';

    // Cria os dados na tela
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
        dieDiv.addEventListener('click', (e) => { if (!e.target.closest('span')) updateDice(d, 1); });
        dieDiv.addEventListener('contextmenu', (e) => { e.preventDefault(); updateDice(d, -1); });
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

    // ========== ATUALIZAÇÃO EM TEMPO REAL DO MODO MANUAL ==========
    function updateManualPreview() {
        const attrs = {};
        ['for','agi','int','vig','set'].forEach(a => {
            attrs[a] = parseInt(document.getElementById(`manual-${a}`).value) || 0;
        });
        // Atualiza prévia
        document.getElementById('attr-preview').innerHTML = `
            ${['for','agi','int','vig','set'].map(a => `
                <div class="bg-black/30 backdrop-blur-sm p-3 rounded-xl border border-cyan-500/30">
                    <span class="block theme-text-primary/70 font-bold uppercase mb-1">${a}</span>
                    <span class="text-2xl font-medieval font-black text-white">${attrs[a]}</span>
                </div>
            `).join('')}
        `;
        // Recria os blocos de atributos (se estiver em modo manual)
        if (rollMode === 'manual') {
            generateAttrBlocksManual(attrs);
        }
    }

    // Adiciona listeners para cada campo manual
    document.querySelectorAll('#manual-attributes input').forEach(input => {
        input.addEventListener('input', updateManualPreview);
    });

    // ========== ALTERNÂNCIA ENTRE MODO FICHA E MANUAL ==========
    const radioFicha = document.querySelector('input[value="ficha"]');
    const radioManual = document.querySelector('input[value="manual"]');
    const fichaSelector = document.getElementById('ficha-selector');
    const manualAttrs = document.getElementById('manual-attributes');
    const charPreview = document.getElementById('char-preview');

    function updateMode() {
        if (rollMode === 'ficha') {
            fichaSelector.classList.remove('hidden');
            manualAttrs.classList.add('hidden');
            if (charSelect) charSelect.dispatchEvent(new Event('change'));
        } else {
            fichaSelector.classList.add('hidden');
            manualAttrs.classList.remove('hidden');
            selectedCharId = null;
            selectedCharData = null;
            // Atualiza prévia com valores manuais atuais
            updateManualPreview();
        }
    }

    function generateAttrBlocksManual(attrs) {
        const container = document.getElementById('attr-rolls');
        container.innerHTML = '';
        for(let i=0; i<3; i++){
            const div = document.createElement('div');
            div.className = "bg-black/40 backdrop-blur-sm border p-4 rounded-xl flex items-center gap-3 flex-wrap md:flex-nowrap";
            div.style.borderColor = "var(--theme-border)";
            div.innerHTML = `
                <div class="flex items-center gap-2">
                    <div class="attr-icon"><img src="<?php echo e(asset('images/dice_icon_atributo.png')); ?>" alt="dado" style="width:20px"></div>
                    <select id="attr-${i}" class="bg-black/60 border border-cyan-400/30 text-cyan-200 p-2 rounded-lg text-xs font-bold uppercase">
                        <option value="for">FOR</option><option value="agi">AGI</option><option value="int">INT</option><option value="vig">VIG</option><option value="set">SET</option>
                    </select>
                </div>
                <input id="bonus-${i}" type="number" placeholder="Bônus" class="w-20 bg-black/60 border border-cyan-400/30 p-2 rounded-lg text-center text-xs text-white">
                <button onclick="rollAttributeManual(${i})" class="bg-cyan-600 hover:bg-cyan-500 px-5 py-2 rounded-lg text-xs font-black uppercase tracking-wider text-black transition-all ml-auto">Rolar</button>
                <div id="result-${i}" class="min-w-[100px] text-right font-medieval font-black theme-text-primary text-lg">---</div>
            `;
            container.appendChild(div);
        }
    }

    function rollAttributeManual(i) {
        const attr = document.getElementById(`attr-${i}`).value;
        const bonus = parseInt(document.getElementById(`bonus-${i}`).value) || 0;
        const qtdDados = parseInt(document.getElementById(`manual-${attr}`).value) || 0;
        let rolls = [];
        for(let x=0; x < qtdDados; x++) rolls.push(Math.floor(Math.random()*20)+1);
        const max = rolls.length ? Math.max(...rolls) : 0;
        const total = max + bonus;
        const resultadoTexto = `TESTE ${attr.toUpperCase()}: ${total} (${max}+${bonus})`;
        document.getElementById(`result-${i}`).innerText = resultadoTexto;
        animateDice3D(total);
        saveToDB(resultadoTexto, null);
        if (document.getElementById('history-dice')) document.getElementById('history-dice').innerText = resultadoTexto;

        // Verifica 20 natural
        if (checkNatural20(rolls, 20)) {
            showExtremePopup();
        }
    }

    // ========== CARREGAR PERSONAGEM (MODO FICHA) ==========
    const charSelect = document.getElementById('character-select');
    if (charSelect) {
        charSelect.addEventListener('change', async function() {
            if (rollMode !== 'ficha') return;
            selectedCharId = this.value;
            if(!selectedCharId) return;
            const res = await fetch(`/rolagens/char/${selectedCharId}`);
            const data = await res.json();
            selectedCharData = data.char;
            charPreview.classList.remove('opacity-40');
            document.getElementById('attr-preview').innerHTML = `
                ${['for','agi','int','vig','set'].map(a => `
                    <div class="bg-black/30 backdrop-blur-sm p-3 rounded-xl border border-cyan-500/30">
                        <span class="block theme-text-primary/70 font-bold uppercase mb-1">${a}</span>
                        <span class="text-2xl font-medieval font-black text-white">${data.char[a]}</span>
                    </div>
                `).join('')}
            `;
            document.getElementById('bonus-preview').innerHTML = data.char.bonuses?.map(b => `<div class="flex justify-between"><span>${b.name}</span><span class="text-emerald-300">+${b.value}</span></div>`).join('') || 'Nenhum bônus neural.';
            document.getElementById('mutation-preview').innerHTML = data.char.mutations?.map(m => `<div>${m.name}</div>`).join('') || 'DNA estável.';
            if(data.lastRoll){
                if (document.getElementById('history-dice')) document.getElementById('history-dice').innerText = data.lastRoll.dice_result || '--';
                if (document.getElementById('history-event')) document.getElementById('history-event').innerText = data.lastRoll.event_result || '--';
            }
            generateAttrBlocksFicha();
        });
    }

    function generateAttrBlocksFicha() {
        const container = document.getElementById('attr-rolls');
        container.innerHTML = '';
        for(let i=0; i<3; i++){
            const div = document.createElement('div');
            div.className = "bg-black/40 backdrop-blur-sm border p-4 rounded-xl flex items-center gap-3 flex-wrap md:flex-nowrap";
            div.style.borderColor = "var(--theme-border)";
            div.innerHTML = `
                <div class="flex items-center gap-2">
                    <div class="attr-icon"><img src="<?php echo e(asset('images/dice_icon_atributo.png')); ?>" alt="dado" style="width:20px"></div>
                    <select id="attr-${i}" class="bg-black/60 border border-cyan-400/30 text-cyan-200 p-2 rounded-lg text-xs font-bold uppercase">
                        <option value="for">FOR</option><option value="agi">AGI</option><option value="int">INT</option><option value="vig">VIG</option><option value="set">SET</option>
                    </select>
                </div>
                <input id="bonus-${i}" type="number" placeholder="Bônus" class="w-20 bg-black/60 border border-cyan-400/30 p-2 rounded-lg text-center text-xs text-white">
                <button onclick="rollAttributeFicha(${i})" class="bg-cyan-600 hover:bg-cyan-500 px-5 py-2 rounded-lg text-xs font-black uppercase tracking-wider text-black transition-all ml-auto">Rolar</button>
                <div id="result-${i}" class="min-w-[100px] text-right font-medieval font-black theme-text-primary text-lg">---</div>
            `;
            container.appendChild(div);
        }
    }

    function rollAttributeFicha(i){
        if(!selectedCharData) return alert('Selecione uma ficha!');
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
        if (document.getElementById('history-dice')) document.getElementById('history-dice').innerText = resultadoTexto;

        // Verifica 20 natural
        if (checkNatural20(rolls, 20)) {
            showExtremePopup();
        }
    }

    // ========== ROLAGEM LIVRE (DADOS MANUAIS) ==========
    function rollDice() {
        if (rollMode === 'ficha' && !selectedCharId) {
            alert('Selecione uma ficha ou mude para modo manual.');
            return;
        }
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
        if (document.getElementById('history-dice')) document.getElementById('history-dice').innerText = resultadoTexto;

        if (hasNatural20) {
            showExtremePopup();
        }
    }

    // ========== EVENTOS (com todas as novas categorias) ==========
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

    document.querySelectorAll('.event-block').forEach(block => {
        const type = block.dataset.eventType;
        block.addEventListener('click', function(e) {
            if (!e.target.closest('.event-icon')) return;
            const list = eventos[type];
            if (list && list.length) {
                const result = list[Math.floor(Math.random() * list.length)];
                const resultDiv = document.getElementById(`event-result-${type}`);
                resultDiv.innerHTML = `<span class="block text-purple-200"> ${result}</span>`;
                resultDiv.style.display = 'block';
                saveToDB(null, `${type.toUpperCase()}: ${result}`);
                if (document.getElementById('history-event')) document.getElementById('history-event').innerText = result;
            }
        });
    });

    // ========== SALVAR ROLAGEM (MODO FICHA E MANUAL) ==========
    async function saveToDB(dice, event) {
        let charId = null;
        if (rollMode === 'ficha' && selectedCharId) {
            charId = selectedCharId;
        } else if (rollMode === 'manual') {
            // No modo manual, tenta usar a primeira ficha do usuário (se existir)
            const fichas = <?php echo json_encode($characters->pluck('id')->toArray()); ?>;
            if (fichas.length > 0) {
                charId = fichas[0];
            } else {
                alert('Você precisa criar pelo menos uma ficha para salvar rolagens manuais. Crie uma ficha em "Fichas".');
                return;
            }
        }
        if (!charId) return;
        await fetch('/rolagens/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ character_id: charId, dice_result: dice, event_result: event })
        }).catch(console.error);
    }

    // Inicialização
    if (radioFicha && radioManual) {
        radioFicha.addEventListener('change', () => { rollMode = 'ficha'; updateMode(); });
        radioManual.addEventListener('change', () => { rollMode = 'manual'; updateMode(); });
        updateMode();
    }
    // Força atualização dos campos manuais
    updateManualPreview();
</script><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/partials/rolagens-sistema.blade.php ENDPATH**/ ?>