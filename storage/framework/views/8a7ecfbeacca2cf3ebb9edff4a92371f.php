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
    <div class="min-h-[80vh] flex flex-col items-center justify-center text-center p-6">
        <div class="relative w-full max-w-4xl">
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500/30 to-blue-500/30 rounded-lg blur-xl"></div>
            <div class="relative ark-panel !p-8 !border-cyan-500/30">
                
                <div class="mb-6">
                    <h1 class="text-8xl md:text-9xl font-black font-display text-transparent bg-clip-text bg-gradient-to-b from-slate-100 to-cyan-300 drop-shadow-[0_0_50px_rgba(6,182,212,0.6)]">
                        404
                    </h1>
                    <div class="flex justify-center my-2">
                        <svg class="w-12 h-12 text-cyan-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M6.5 12.5a9 9 0 0111 0M3 8a13 13 0 0118 0" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18" class="text-cyan-400" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-display text-white uppercase tracking-widest">Sinal Interrompido</h2>
                    <p class="text-slate-300 max-w-md mx-auto text-sm mt-2">
                        A sua sessão sua expirou ou você tentou acessar uma página que não existe.
                    </p>
                </div>

                
                <div class="w-full max-w-3xl mx-auto my-6">
                    <div class="bg-black/80 rounded-xl p-4 border border-cyan-500/20 shadow-[0_0_30px_rgba(0,242,255,0.1)]">
                        
                        <div class="flex justify-between items-center mb-2 px-2 text-cyan-400 font-mono text-xs">
                            <div>
                                <span class="uppercase tracking-widest">Tempo</span>
                                <span id="dinoTimer" class="ml-2 text-white font-bold">0.0s</span>
                            </div>
                            <div>
                                <span class="uppercase tracking-widest">Recorde</span>
                                <span id="dinoBest" class="ml-2 text-cyan-300 font-bold">0.0s</span>
                            </div>
                        </div>

                        
                        <div class="relative bg-black/60 rounded-lg overflow-hidden border border-cyan-500/20">
                            <canvas id="dinoCanvas" width="600" height="180" class="w-full h-auto"></canvas>
                            <img id="dinoSprite" alt="" draggable="false" class="absolute pointer-events-none select-none" style="display:none; image-rendering: pixelated;">
                            <div id="dinoOverlay" class="absolute inset-0 flex flex-col items-center justify-center text-cyan-300 bg-black/70 backdrop-blur-sm">
                                <span class="text-2xl font-bold">▶ Pressione Espaço</span>
                                <span class="text-sm opacity-70 mt-1">para correr</span>
                            </div>
                           
                          <div id="gameOverOverlay" class="absolute inset-0 flex flex-col items-center justify-center bg-black/80 backdrop-blur-md hidden border-2 border-red-500/50 rounded-lg overflow-y-auto p-4">
                               <div class="relative p-6 rounded-xl border-2 border-red-400/40 bg-red-950/30 shadow-[0_0_40px_rgba(239,68,68,0.2)] max-w-full">
                                  <img id="dinoDeadSprite" src="<?php echo e(asset('images/Dino_sprite_morto.png')); ?>" alt="Morto" class="w-24 h-24 md:w-28 md:h-28 mx-auto mb-3 pixelated drop-shadow-[0_0_20px_rgba(239,68,68,0.4)]">
                                    <span class="text-2xl md:text-4xl font-black uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600 drop-shadow-[0_0_30px_rgba(239,68,68,0.6)] block text-center">
                                       Você morreu!
                                     </span>
                                <div class="mt-3 flex items-center justify-center gap-4 text-cyan-300">
                                      <span class="text-sm uppercase tracking-widest">Tempo</span>
                                     <span id="finalTime" class="text-2xl font-bold text-white">0.0s</span>
                             </div>
                              <p class="text-slate-400 text-xs mt-3 tracking-widest text-center">Pressione Espaço para recomeçar</p>
                         <div class="absolute -inset-1 bg-gradient-to-r from-red-500/10 to-orange-500/10 rounded-xl blur-xl -z-10"></div>
                     </div>
                </div>

                        
                        <div class="flex gap-3 mt-3 justify-center">
                            <button id="dinoDuck" class="flex-1 max-w-[120px] py-2 border border-cyan-500/50 rounded-lg text-cyan-300 font-bold text-sm hover:bg-cyan-500/20 transition">⬇ Agachar</button>
                            <button id="dinoJump" class="flex-1 max-w-[120px] py-2 border border-cyan-500/50 rounded-lg text-cyan-300 font-bold text-sm hover:bg-cyan-500/20 transition">⬆ Pular</button>
                        </div>

                        <p class="text-[10px] text-cyan-500/60 text-center mt-3 tracking-widest">
                            Espaço / ↑ / toque no jogo = pular · ↓ / segurar = agachar
                        </p>
                    </div>
                </div>

                
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                    <a href="<?php echo e(route('home')); ?>" class="ark-btn !bg-cyan-950/30 !border-cyan-500/50 hover:!bg-cyan-900/40 !text-cyan-200">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Voltar para o Início
                        </span>
                    </a>
                    <button onclick="history.back()" class="ark-btn !bg-slate-900/50 !border-slate-600/50 hover:!bg-slate-800 !text-slate-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Voltar Página anteiror
                        </span>
                    </button>
                </div>

                <p class="mt-6 text-[10px] text-cyan-600/70 tracking-widest"></p>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        (function() {
            'use strict';

            // ========== CONFIGURAÇÕES ==========
            const CONFIG = {
                width: 600,
                height: 180,
                groundOffset: 26,
                gravity: 1400,
                jumpForce: 480,
                initialSpeed: 6,
                maxSpeed: 15,
                speedGainPerSecond: 0.12,
                spawnFreqMultiplier: 1,
                birdUnlockTime: 12,
                duckHeightFactor: 0.75,          // menos rebaixado
                birdAnimInterval: 0.5,            // troca a cada 0.5s
                cloudSpawnInterval: 2.0,
                maxClouds: 8,
                minCloudY: 10,
                maxCloudY: 80,
                minCloudWidth: 30,
                maxCloudWidth: 70,
                cloudSpeedFactor: 0.3,
            };
            const SPEED_SCALE = 45;

            // ========== ELEMENTOS DOM ==========
            const canvas = document.getElementById('dinoCanvas');
            const ctx = canvas.getContext('2d');
            const overlay = document.getElementById('dinoOverlay');
            const gameOverOverlay = document.getElementById('gameOverOverlay');
            const finalTimeEl = document.getElementById('finalTime');
            const timerEl = document.getElementById('dinoTimer');
            const bestEl = document.getElementById('dinoBest');
            const dinoSpriteEl = document.getElementById('dinoSprite');
            const dinoDeadSpriteEl = document.getElementById('dinoDeadSprite');

            // ========== SETUP DO CANVAS (DPI) ==========
            function setupCanvas() {
                const dpr = window.devicePixelRatio || 1;
                canvas.width = CONFIG.width * dpr;
                canvas.height = CONFIG.height * dpr;
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            }
            setupCanvas();
            window.addEventListener('resize', setupCanvas);

            const groundY = CONFIG.height - CONFIG.groundOffset;

            // ========== SPRITES ==========
            const SPRITE_PATHS = {
                dinoRun: '<?php echo e(asset("images/Dino_correndo.gif")); ?>',
                dinoJump: '<?php echo e(asset("images/Dino_sprite_pulando.png")); ?>',
                dinoDuck: '<?php echo e(asset("images/Dino_sprite_agachando.png")); ?>',
                obstFront: '<?php echo e(asset("images/Obstaculo_sprite1_planta.png")); ?>',
                obstBack: '<?php echo e(asset("images/Obstaculo_sprite2_planta.png")); ?>',
                bird1: '<?php echo e(asset("images/Obstaculo_aereo1.png")); ?>',
                bird2: '<?php echo e(asset("images/Obstaculo_aereo2.png")); ?>',
            };

            const sprites = {};
            let imagesLoaded = 0;

            function loadSprite(key, src) {
                return new Promise((resolve) => {
                    const img = new Image();
                    img.onload = () => {
                        sprites[key] = img;
                        imagesLoaded++;
                        resolve(img);
                    };
                    img.onerror = () => {
                        const fallback = document.createElement('canvas');
                        fallback.width = 32;
                        fallback.height = 32;
                        const fctx = fallback.getContext('2d');
                        if (key === 'dinoRun' || key === 'dinoJump' || key === 'dinoDuck') {
                            fctx.fillStyle = '#00ff00';
                        } else if (key === 'obstFront' || key === 'obstBack') {
                            fctx.fillStyle = '#ff0000';
                        } else if (key === 'bird1' || key === 'bird2') {
                            fctx.fillStyle = '#ff8800';
                        }
                        fctx.fillRect(0, 0, 32, 32);
                        fctx.strokeStyle = '#ffffff';
                        fctx.lineWidth = 1;
                        fctx.strokeRect(0, 0, 32, 32);
                        fctx.fillStyle = '#ffffff';
                        fctx.font = '6px monospace';
                        fctx.fillText(key, 2, 10);
                        sprites[key] = fallback;
                        imagesLoaded++;
                        resolve(fallback);
                        console.warn('Sprite não encontrado:', src);
                    };
                    img.src = src;
                });
            }

            const loadPromises = [
                loadSprite('dinoRun', SPRITE_PATHS.dinoRun),
                loadSprite('dinoJump', SPRITE_PATHS.dinoJump),
                loadSprite('dinoDuck', SPRITE_PATHS.dinoDuck),
                loadSprite('obstFront', SPRITE_PATHS.obstFront),
                loadSprite('obstBack', SPRITE_PATHS.obstBack),
                loadSprite('bird1', SPRITE_PATHS.bird1),
                loadSprite('bird2', SPRITE_PATHS.bird2),
            ];

            // ========== NUVENS ==========
            let clouds = [];
            let cloudSpawnTimer = 0;

            function spawnCloud() {
                if (clouds.length >= CONFIG.maxClouds) return;
                const width = CONFIG.minCloudWidth + Math.random() * (CONFIG.maxCloudWidth - CONFIG.minCloudWidth);
                const height = width * 0.35;
                const y = CONFIG.minCloudY + Math.random() * (CONFIG.maxCloudY - CONFIG.minCloudY);
                const x = CONFIG.width + 10 + Math.random() * 40;
                clouds.push({
                    x, y,
                    width, height,
                    speed: (0.5 + Math.random() * 0.8) * CONFIG.cloudSpeedFactor,
                    opacity: 0.6 + Math.random() * 0.35,
                });
            }

            function updateClouds(dt, pxPerSec) {
                cloudSpawnTimer -= dt;
                if (cloudSpawnTimer <= 0) {
                    spawnCloud();
                    cloudSpawnTimer = CONFIG.cloudSpawnInterval * (0.6 + Math.random() * 0.8);
                }
                for (const cloud of clouds) {
                    cloud.x -= pxPerSec * cloud.speed * 0.6;
                }
                clouds = clouds.filter(cloud => cloud.x + cloud.width > -20);
            }

            function drawClouds() {
                for (const cloud of clouds) {
                    ctx.globalAlpha = cloud.opacity;
                    ctx.fillStyle = '#f0f8ff';
                    ctx.shadowColor = 'rgba(255,255,255,0.1)';
                    ctx.shadowBlur = 15;
                    const cx = cloud.x + cloud.width / 2;
                    const cy = cloud.y + cloud.height / 2;
                    const r = cloud.width / 3;
                    ctx.beginPath();
                    ctx.arc(cx - r * 0.4, cy, r * 0.6, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.beginPath();
                    ctx.arc(cx + r * 0.4, cy, r * 0.6, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.beginPath();
                    ctx.arc(cx, cy - r * 0.3, r * 0.7, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.shadowBlur = 0;
                    ctx.globalAlpha = 1;
                }
            }

            // ========== SPRITE DO DINOSSAURO (via <img>) ==========
            const DINO_KEYS = { run: 'dinoRun', jump: 'dinoJump', duck: 'dinoDuck' };
            let currentDinoState = null;

            function spriteToSrc(obj) {
                if (!obj) return '';
                if (obj instanceof HTMLCanvasElement) return obj.toDataURL();
                return obj.src || '';
            }

            function desiredDinoState() {
                if (player.ducking && player.grounded) return 'duck';
                if (!player.grounded) return 'jump';
                return 'run';
            }

            function syncDinoSprite() {
                const state = desiredDinoState();
                if (state !== currentDinoState) {
                    currentDinoState = state;
                    const src = spriteToSrc(sprites[DINO_KEYS[state]]);
                    if (src) dinoSpriteEl.src = src;
                }

                const h = currentPlayerHeight();
                const scaleX = canvas.clientWidth / CONFIG.width;
                const scaleY = canvas.clientHeight / CONFIG.height;

                dinoSpriteEl.style.display = 'block';
                dinoSpriteEl.style.left = (player.x * scaleX) + 'px';
                dinoSpriteEl.style.top = (player.y * scaleY) + 'px';
                dinoSpriteEl.style.width = (player.width * scaleX) + 'px';
                dinoSpriteEl.style.height = (h * scaleY) + 'px';
            }

            // ========== ÁUDIO ==========
            let audioCtx = null;
            function beep(freq, duration, type) {
                try {
                    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    const osc = audioCtx.createOscillator();
                    const gain = audioCtx.createGain();
                    osc.type = type || 'square';
                    osc.frequency.value = freq;
                    gain.gain.value = 0.05;
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    osc.start();
                    gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + duration);
                    osc.stop(audioCtx.currentTime + duration);
                } catch (e) { }
            }

            // ========== ESTADO DO JOGO ==========
            let player, obstacles, speed, elapsed, best, gameState, groundTicks, spawnTimer;
            let bgOffsetX = 0;

            best = parseFloat(localStorage.getItem('dinoBest')) || 0;
            bestEl.textContent = best.toFixed(1) + 's';

            function resetGame() {
                player = {
                    x: 50,
                    width: 38,
                    heightStand: 42,
                    heightDuck: Math.round(42 * CONFIG.duckHeightFactor),
                    y: groundY - 42,
                    vy: 0,
                    grounded: true,
                    ducking: false,
                };
                obstacles = [];
                clouds = [];
                cloudSpawnTimer = 0;
                speed = CONFIG.initialSpeed;
                elapsed = 0;
                spawnTimer = 1.4;
                bgOffsetX = 0;
                groundTicks = [];
                for (let i = 0; i < 40; i++) groundTicks.push(Math.random() * CONFIG.width);

                gameState = 'idle';
                overlay.classList.remove('hidden');
                gameOverOverlay.classList.add('hidden');
                overlay.innerHTML = '<span class="text-2xl font-bold">▶ Pressione Espaço</span><span class="text-sm opacity-70 mt-1">para correr</span>';
                timerEl.textContent = '0.0s';
                currentDinoState = null;
                dinoSpriteEl.style.display = 'none';
            }

            // ========== OBSTÁCULOS ==========
            const OBSTACLE_TYPES = [
                { kind: 'cactus-small',   width: 24, height: 32, weight: 4 },
                { kind: 'cactus-big',     width: 28, height: 40, weight: 3 },
                { kind: 'cactus-cluster', width: 44, height: 32, weight: 2 },
                { kind: 'bird',           width: 34, height: 28, weight: 2 },
            ];

            function pickObstacleType() {
                const available = OBSTACLE_TYPES.filter(t => t.kind !== 'bird' || elapsed >= CONFIG.birdUnlockTime);
                const totalWeight = available.reduce((s, t) => s + t.weight, 0);
                let r = Math.random() * totalWeight;
                for (const t of available) {
                    if (r < t.weight) return t;
                    r -= t.weight;
                }
                return available[0];
            }

            function updateSpawning(dt) {
                spawnTimer -= dt;
                if (spawnTimer <= 0) {
                    const type = pickObstacleType();
                    const flying = type.kind === 'bird';
                    obstacles.push({
                        kind: type.kind,
                        x: CONFIG.width + 10,
                        width: type.width,
                        height: type.height,
                        y: flying ? groundY - 55 : groundY - type.height,
                        wingPhase: 0,
                        spriteState: 'front',
                        jumpedOver: false,
                    });
                    const baseGap = 0.9 + Math.random() * 0.9;
                    spawnTimer = baseGap * CONFIG.spawnFreqMultiplier * (8 / speed);
                }
            }

            // ========== FÍSICA ==========
            function startRun() {
                gameState = 'running';
                overlay.classList.add('hidden');
            }

            function jump() {
                if (gameState === 'idle') startRun();
                if (player.grounded && !player.ducking) {
                    player.vy = -CONFIG.jumpForce;
                    player.grounded = false;
                    beep(700, 0.08, 'square');
                }
            }

            function setDuck(value) {
                if (gameState === 'idle') startRun();
                if (value && player.grounded) {
                    player.ducking = true;
                } else if (!value) {
                    player.ducking = false;
                }
            }

            function currentPlayerHeight() {
                return player.ducking ? player.heightDuck : player.heightStand;
            }

            function updatePlayer(dt) {
                const h = currentPlayerHeight();
                player.vy += CONFIG.gravity * dt;
                player.y += player.vy * dt;
                const floor = groundY - h;
                if (player.y >= floor) {
                    player.y = floor;
                    player.vy = 0;
                    player.grounded = true;
                } else {
                    player.grounded = false;
                }
            }

            function rectsOverlap(ax, ay, aw, ah, bx, by, bw, bh) {
                return ax < bx + bw && ax + aw > bx && ay < by + bh && ay + ah > by;
            }

            function checkCollisionsAndJumpOver() {
                const h = currentPlayerHeight();
                const pad = 4;
                const px = player.x + pad, py = player.y + pad;
                const pw = player.width - pad * 2, ph = h - pad * 2;
                for (const ob of obstacles) {
                    if (rectsOverlap(px, py, pw, ph, ob.x + 2, ob.y + 2, ob.width - 4, ob.height - 4)) {
                        return true;
                    }
                    // pula sobre a planta -> troca sprite
                    if (!ob.jumpedOver && !player.grounded && player.y + h < ob.y + 5 && player.x + player.width > ob.x + 5) {
                        ob.jumpedOver = true;
                        ob.spriteState = 'back';
                    }
                }
                return false;
            }

            // ========== ATUALIZAÇÃO MUNDO ==========
            function updateWorld(dt) {
                elapsed += dt;
                speed = Math.min(CONFIG.maxSpeed, CONFIG.initialSpeed + elapsed * CONFIG.speedGainPerSecond);
                updateSpawning(dt);
                updatePlayer(dt);

                const pxPerSec = speed * SPEED_SCALE;
                bgOffsetX = (bgOffsetX + pxPerSec * dt) % 600;

                updateClouds(dt, pxPerSec);

                for (const ob of obstacles) {
                    ob.x -= pxPerSec * dt;
                    if (ob.kind === 'bird') ob.wingPhase += dt;
                }
                obstacles = obstacles.filter(ob => ob.x + ob.width > -10);

                for (let i = 0; i < groundTicks.length; i++) {
                    groundTicks[i] -= pxPerSec * dt;
                    if (groundTicks[i] < -10) groundTicks[i] += CONFIG.width + 20;
                }

                if (checkCollisionsAndJumpOver()) {
                    gameState = 'gameover';
                    beep(160, 0.25, 'sawtooth');
                    if (elapsed > best) {
                        best = elapsed;
                        localStorage.setItem('dinoBest', best);
                        bestEl.textContent = best.toFixed(1) + 's';
                    }
                    overlay.classList.add('hidden');
                    gameOverOverlay.classList.remove('hidden');
                    finalTimeEl.textContent = elapsed.toFixed(1) + 's';
                    dinoSpriteEl.style.display = 'none';
                    return;
                }

                timerEl.textContent = elapsed.toFixed(1) + 's';
            }

            // ========== DESENHO ==========
            function drawSprite(img, x, y, w, h) {
                if (!img) return;
                ctx.drawImage(img, x, y, w, h);
            }

            function draw() {
                ctx.clearRect(0, 0, CONFIG.width, CONFIG.height);

                // --- Céu gradiente ---
                const grad = ctx.createLinearGradient(0, 0, 0, CONFIG.height);
                grad.addColorStop(0, '#b3d9ff');
                grad.addColorStop(0.6, '#d4ecff');
                grad.addColorStop(1, '#e8f4fd');
                ctx.fillStyle = grad;
                ctx.fillRect(0, 0, CONFIG.width, CONFIG.height);

                // --- Nuvens ---
                drawClouds();

                // --- Terra (marrom) abaixo da grama ---
                ctx.fillStyle = '#5d3a1a';
                ctx.fillRect(0, groundY + 4, CONFIG.width, CONFIG.height - groundY - 4);
                // Pequeno detalhe de textura
                ctx.fillStyle = '#7a4f2b';
                for (let i = 0; i < 20; i++) {
                    const x = (i * 30 + bgOffsetX * 0.1) % CONFIG.width;
                    ctx.fillRect(x, groundY + 8 + Math.random() * 6, 2, 2);
                }

                // --- Linha da grama ---
                ctx.shadowColor = '#22c55e';
                ctx.shadowBlur = 6;
                ctx.strokeStyle = '#22c55e';
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(0, groundY + 2);
                ctx.lineTo(CONFIG.width, groundY + 2);
                ctx.stroke();
                ctx.shadowBlur = 0;

                // Lâminas de grama
                ctx.fillStyle = '#4ade80';
                ctx.globalAlpha = 0.55;
                for (const tx of groundTicks) ctx.fillRect(tx, groundY - 5, 2, 9);
                ctx.globalAlpha = 1;

                // --- Obstáculos ---
                for (const ob of obstacles) {
                    let img;
                    const w = ob.width, h = ob.height;
                    if (ob.kind === 'bird') {
                        const frame = Math.floor(ob.wingPhase / CONFIG.birdAnimInterval) % 2;
                        img = (frame === 0) ? sprites.bird1 : sprites.bird2;
                    } else {
                        img = (ob.spriteState === 'back') ? sprites.obstBack : sprites.obstFront;
                    }
                    drawSprite(img, ob.x, ob.y, w, h);
                }
            }

            // ========== LOOP ==========
            let lastTime = null;
            function frame(timestamp) {
                if (lastTime === null) lastTime = timestamp;
                let dt = (timestamp - lastTime) / 1000;
                dt = Math.min(dt, 0.05);
                lastTime = timestamp;

                if (gameState === 'running') updateWorld(dt);
                draw();
                if (gameState !== 'gameover') syncDinoSprite();
                requestAnimationFrame(frame);
            }

            Promise.all(loadPromises).then(() => {
                resetGame();
                requestAnimationFrame(frame);
            });

            // ========== CONTROLES ==========
            document.addEventListener('keydown', (e) => {
                if (e.code === 'Space' || e.code === 'ArrowUp') {
                    e.preventDefault();
                    if (gameState === 'gameover') { resetGame(); return; }
                    jump();
                } else if (e.code === 'ArrowDown' || e.code === 'KeyS') {
                    e.preventDefault();
                    setDuck(true);
                }
            });
            document.addEventListener('keyup', (e) => {
                if (e.code === 'ArrowDown' || e.code === 'KeyS') setDuck(false);
            });

            canvas.addEventListener('pointerdown', (e) => {
                e.preventDefault();
                if (gameState === 'gameover') { resetGame(); return; }
                jump();
            });

            document.getElementById('dinoJump').addEventListener('pointerdown', (e) => {
                e.preventDefault();
                if (gameState === 'gameover') { resetGame(); return; }
                jump();
            });
            const duckBtn = document.getElementById('dinoDuck');
            duckBtn.addEventListener('pointerdown', (e) => { e.preventDefault(); setDuck(true); });
            duckBtn.addEventListener('pointerup', () => setDuck(false));
            duckBtn.addEventListener('pointerleave', () => setDuck(false));
        })();
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Projetos-ligmas\Projeto_Ark_Laravel\ark-rpg\resources\views/errors/404.blade.php ENDPATH**/ ?>