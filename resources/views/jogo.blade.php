{{-- resources/views/jogo.blade.php --}}
<x-app-layout>
    <x-slot name="title">Dino Runner - RPG ARK</x-slot>

    <div class="min-h-[80vh] flex flex-col items-center justify-center text-center p-6">
        <div class="relative w-full max-w-5xl">
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500/30 to-blue-500/30 rounded-lg blur-xl"></div>
            <div class="relative ark-panel !p-8 !border-cyan-500/30">
                {{-- Título do jogo --}}
                <div class="mb-6">
                    <h1 class="text-4xl md:text-5xl font-display font-black text-transparent bg-clip-text bg-gradient-to-b from-slate-100 to-cyan-300 drop-shadow-[0_0_30px_rgba(6,182,212,0.6)]">
                        Dino Runner
                    </h1>
                    <p class="text-slate-300 text-sm mt-2">Corra, desvie e quebre seu recorde!</p>
                </div>

                {{-- Jogo --}}
                <div class="w-full max-w-4xl mx-auto my-6">
                    <div class="bg-black/80 rounded-xl p-4 border border-cyan-500/20 shadow-[0_0_30px_rgba(0,242,255,0.1)]">
                        {{-- HUD --}}
                        <div class="flex justify-between items-center mb-2 px-2 text-cyan-400 font-mono text-sm">
                            <div>
                                <span class="uppercase tracking-widest">Tempo</span>
                                <span id="dinoTimer" class="ml-2 text-white font-bold">0.0s</span>
                            </div>
                            <div>
                                <span class="uppercase tracking-widest">Recorde</span>
                                <span id="dinoBest" class="ml-2 text-cyan-300 font-bold">0.0s</span>
                            </div>
                        </div>

                        {{-- Canvas --}}
                        <div class="relative bg-black/60 rounded-lg overflow-hidden border border-cyan-500/20">
                            <canvas id="dinoCanvas" width="800" height="260" class="w-full h-auto"></canvas>
                            <img id="dinoSprite" alt="" draggable="false" class="absolute pointer-events-none select-none" style="display:none; image-rendering: pixelated;">
                            <div id="dinoOverlay" class="absolute inset-0 flex flex-col items-center justify-center text-cyan-300 bg-black/70 backdrop-blur-sm cursor-pointer">
                                <span class="text-3xl font-bold">▶ Pressione Espaço</span>
                                <span class="text-base opacity-70 mt-1">ou toque para correr</span>
                            </div>
                        </div>

                        {{-- Controles mobile --}}
                        <div class="flex gap-3 mt-3 justify-center">
                            <button id="dinoDuck" class="flex-1 max-w-[160px] py-4 border border-cyan-500/50 rounded-lg text-cyan-300 font-bold text-base hover:bg-cyan-500/20 transition">⬇ Agachar</button>
                            <button id="dinoJump" class="flex-1 max-w-[160px] py-4 border border-cyan-500/50 rounded-lg text-cyan-300 font-bold text-base hover:bg-cyan-500/20 transition">⬆ Pular</button>
                        </div>

                        <p class="text-[10px] text-cyan-500/60 text-center mt-3 tracking-widest">
                            Espaço / ↑ / toque no jogo = pular · ↓ / segurar = agachar (passa sob pássaros)
                        </p>
                    </div>
                </div>

                {{-- Botão voltar --}}
                <div class="flex justify-center mt-6">
                    <a href="{{ route('home') }}" class="ark-btn !bg-cyan-950/30 !border-cyan-500/50 hover:!bg-cyan-900/40 !text-cyan-200">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Voltar para o Início
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tela de Morte — fullscreen, fora do contêiner do canvas para nunca cortar --}}
    <div id="gameOverOverlay" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/85 backdrop-blur-md p-4">
        <div class="relative w-full max-w-md mx-auto">
            <div class="absolute -inset-1 bg-gradient-to-r from-red-500/20 to-orange-500/20 rounded-xl blur-xl"></div>
            <div class="relative rounded-xl border-2 border-red-500/40 bg-slate-950/90 shadow-[0_0_60px_rgba(239,68,68,0.35)] px-6 py-8 md:px-10 md:py-10 text-center">
                {{-- cantos decorativos estilo HUD --}}
                <span class="absolute top-2 left-2 w-5 h-5 border-t-2 border-l-2 border-cyan-400/60"></span>
                <span class="absolute top-2 right-2 w-5 h-5 border-t-2 border-r-2 border-cyan-400/60"></span>
                <span class="absolute bottom-2 left-2 w-5 h-5 border-b-2 border-l-2 border-cyan-400/60"></span>
                <span class="absolute bottom-2 right-2 w-5 h-5 border-b-2 border-r-2 border-cyan-400/60"></span>

                <div class="relative inline-block mb-3">
                    <div class="absolute inset-0 bg-red-500/30 blur-2xl rounded-full"></div>
                    <img id="dinoDeadSprite" src="{{ asset('images/Dino_sprite_morto.png') }}" alt="Dino derrotado" class="relative w-24 h-24 md:w-28 md:h-28 mx-auto pixelated drop-shadow-[0_0_25px_rgba(239,68,68,0.55)]">
                </div>

                <span class="block text-3xl md:text-4xl font-black uppercase tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-red-600 drop-shadow-[0_0_25px_rgba(239,68,68,0.6)]">
                    Você morreu
                </span>

                <span id="newRecordBadge" class="hidden mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full border border-cyan-400/50 bg-cyan-500/10 text-cyan-300 text-[11px] font-bold uppercase tracking-widest">
                    ✦ Novo Recorde
                </span>

                <div class="flex items-center justify-center gap-3 mt-5 text-[10px] text-slate-500 uppercase tracking-widest">
                    <span class="w-8 h-px bg-slate-700"></span>
                    <span>Tempo sobrevivido</span>
                    <span class="w-8 h-px bg-slate-700"></span>
                </div>
                <span id="finalTime" class="block text-cyan-300 text-3xl font-bold mt-1 drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]">0.0s</span>

                <button id="dinoRetry" type="button" class="mt-6 w-full py-3 rounded-lg border border-cyan-500/50 bg-cyan-500/10 text-cyan-200 font-bold text-sm uppercase tracking-widest hover:bg-cyan-500/20 transition">
                    🔁 Tentar Novamente
                </button>
                <p class="text-slate-500 text-[11px] mt-3 tracking-widest">ou pressione Espaço</p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            'use strict';

            // ========== RECORDE (SERVIDOR + LOCAL FALLBACK) ==========
            function getLocalBest() {
                try {
                    const local = localStorage.getItem('dino_record_local');
                    return local ? parseFloat(local) : 0;
                } catch (e) { return 0; }
            }
            function setLocalBest(record) {
                try { localStorage.setItem('dino_record_local', record.toString()); } catch (e) { }
            }

            async function syncLocalBest() {
                const localBest = getLocalBest();
                if (localBest <= 0) return;
                try {
                    const response = await fetch('{{ route("dino.record") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ record: localBest })
                    });
                    if (response.ok) localStorage.removeItem('dino_record_local');
                } catch (e) {
                    console.warn('Falha ao sincronizar recorde local:', e);
                }
            }

            // ========== CONFIGURAÇÕES ==========
            const CONFIG = {
                width: 800,
                height: 260,
                groundOffset: 34,
                gravity: 1400,
                jumpForce: 540,
                initialSpeed: 6.5,
                maxSpeed: 16,
                speedGainPerSecond: 0.14,
                spawnFreqMultiplier: 1,
                birdUnlockTime: 12,
                duckHeightFactor: 0.60,   // ← AQUI: agachado com 60% da altura (natural)
                birdAnimInterval: 0.5,
                birdFlightOffset: 76,     // pássaro mais alto
                waveAmplitudeBase: 7,
                waveFrequencyBase: 0.016,
                waveSpeedBase: 0.5,
            };
            const SPEED_SCALE = 45;

            // ========== ELEMENTOS DOM ==========
            const canvas = document.getElementById('dinoCanvas');
            const ctx = canvas.getContext('2d');
            const overlay = document.getElementById('dinoOverlay');
            const gameOverOverlay = document.getElementById('gameOverOverlay');
            const finalTimeEl = document.getElementById('finalTime');
            const newRecordBadge = document.getElementById('newRecordBadge');
            const timerEl = document.getElementById('dinoTimer');
            const bestEl = document.getElementById('dinoBest');
            const dinoSpriteEl = document.getElementById('dinoSprite');

            // ========== SETUP CANVAS ==========
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
                dinoRun: '{{ asset("images/Dino_correndo.gif") }}',
                dinoJump: '{{ asset("images/Dino_sprite_pulando.png") }}',
                dinoDuck: '{{ asset("images/Dino_sprite_agachando.png") }}',
                obstFront: '{{ asset("images/Obstaculo_sprite1_planta.png") }}',
                obstBack: '{{ asset("images/Obstaculo_sprite2_planta.png") }}',
                bird1: '{{ asset("images/Obstaculo_aereo1.png") }}',
                bird2: '{{ asset("images/Obstaculo_aereo2.png") }}',
            };

            const sprites = {};

            function loadSprite(key, src) {
                return new Promise((resolve) => {
                    const img = new Image();
                    img.onload = () => { sprites[key] = img; resolve(img); };
                    img.onerror = () => {
                        const fallback = document.createElement('canvas');
                        fallback.width = 32; fallback.height = 32;
                        const fctx = fallback.getContext('2d');
                        if (key === 'dinoRun' || key === 'dinoJump' || key === 'dinoDuck') fctx.fillStyle = '#00ff00';
                        else if (key === 'obstFront' || key === 'obstBack') fctx.fillStyle = '#ff0000';
                        else if (key === 'bird1' || key === 'bird2') fctx.fillStyle = '#ff8800';
                        fctx.fillRect(0, 0, 32, 32);
                        fctx.strokeStyle = '#ffffff';
                        fctx.lineWidth = 1;
                        fctx.strokeRect(0, 0, 32, 32);
                        fctx.fillStyle = '#ffffff';
                        fctx.font = '6px monospace';
                        fctx.fillText(key, 2, 10);
                        sprites[key] = fallback;
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

            // ========== ESTRELAS DE FUNDO ==========
            let stars = [];
            function initStars() {
                stars = [];
                for (let i = 0; i < 40; i++) {
                    stars.push({
                        x: Math.random() * CONFIG.width,
                        y: Math.random() * (groundY * 0.7),
                        r: 0.6 + Math.random() * 1.4,
                        phase: Math.random() * Math.PI * 2,
                        speed: 0.5 + Math.random() * 1.5,
                    });
                }
            }
            function drawStars(time) {
                ctx.fillStyle = '#bfe3ff';
                for (const s of stars) {
                    const tw = 0.35 + 0.65 * Math.abs(Math.sin(time * s.speed + s.phase));
                    ctx.globalAlpha = tw * 0.7;
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                    ctx.fill();
                }
                ctx.globalAlpha = 1;
            }
            initStars();

            // ========== ESTADO DO JOGO ==========
            let player, obstacles, speed, elapsed, best, gameState, groundTicks, spawnTimer;
            let bgOffsetX = 0;
            let clouds = [];
            let cloudSpawnTimer = 0;

            let serverBest = 0;
            let isAuthenticated = false;

            async function fetchBest() {
                try {
                    const response = await fetch('{{ route("dino.record.get") }}');
                    const data = await response.json();
                    serverBest = data.record || 0;
                    isAuthenticated = data.authenticated || false;

                    if (!isAuthenticated) {
                        const localBest = getLocalBest();
                        serverBest = Math.max(serverBest, localBest);
                    } else {
                        await syncLocalBest();
                        const response2 = await fetch('{{ route("dino.record.get") }}');
                        const data2 = await response2.json();
                        serverBest = data2.record || 0;
                    }

                    best = serverBest;
                    bestEl.textContent = best.toFixed(1) + 's';
                } catch (e) {
                    console.warn('Erro ao buscar recorde:', e);
                    const localBest = getLocalBest();
                    if (localBest > 0) {
                        serverBest = localBest;
                        best = localBest;
                        bestEl.textContent = best.toFixed(1) + 's';
                    }
                }
            }

            async function saveBest(record) {
                if (record <= serverBest) return;
                try {
                    const response = await fetch('{{ route("dino.record") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ record: record })
                    });
                    if (response.ok) {
                        serverBest = record;
                        localStorage.removeItem('dino_record_local');
                        return;
                    }
                    if (response.status === 401) {
                        setLocalBest(record);
                        serverBest = record;
                    }
                } catch (e) {
                    console.warn('Erro ao salvar recorde no servidor, salvando localmente:', e);
                    setLocalBest(record);
                    serverBest = record;
                }
            }

            fetchBest();

            function resetGame() {
                player = {
                    x: 46,
                    width: 52,
                    heightStand: 68,
                    heightDuck: Math.round(68 * CONFIG.duckHeightFactor), // agora ~41px
                    y: groundY - 68,
                    vy: 0,
                    grounded: true,
                    ducking: false,
                };
                obstacles = [];
                speed = CONFIG.initialSpeed;
                elapsed = 0;
                spawnTimer = 1.0;
                bgOffsetX = 0;
                groundTicks = [];
                for (let i = 0; i < 40; i++) groundTicks.push(Math.random() * CONFIG.width);

                clouds = [];
                for (let i = 0; i < 5; i++) spawnCloud(true);
                cloudSpawnTimer = 0;

                gameState = 'idle';
                overlay.classList.remove('hidden');
                gameOverOverlay.classList.add('hidden');
                overlay.innerHTML = '<span class="text-3xl font-bold">▶ Pressione Espaço</span><span class="text-base opacity-70 mt-1">ou toque para correr</span>';
                timerEl.textContent = '0.0s';
                dinoSpriteEl.style.display = 'none';
                best = serverBest;
                bestEl.textContent = best.toFixed(1) + 's';
            }

            // ========== NUVENS ==========
            function spawnCloud(force = false) {
                if (!force && clouds.length >= 8) return;
                const width = 60 + Math.random() * 100;
                const height = 20 + Math.random() * 30;
                const y = 10 + Math.random() * (groundY - 50);
                const x = CONFIG.width + 20 + Math.random() * 100;
                const speed = 0.2 + Math.random() * 0.4;
                clouds.push({ x, y, width, height, speed, opacity: 0.2 + Math.random() * 0.3 });
            }
            function updateClouds(dt, pxPerSec) {
                cloudSpawnTimer -= dt;
                if (cloudSpawnTimer <= 0) {
                    spawnCloud();
                    cloudSpawnTimer = 2 + Math.random() * 3;
                }
                for (const cloud of clouds) cloud.x -= pxPerSec * cloud.speed * 0.3;
                clouds = clouds.filter(cloud => cloud.x + cloud.width > -20);
            }
            function drawClouds() {
                for (const cloud of clouds) {
                    ctx.globalAlpha = cloud.opacity;
                    ctx.fillStyle = '#08152e';
                    ctx.shadowColor = '#08152e';
                    ctx.shadowBlur = 10;
                    const cx = cloud.x + cloud.width / 2;
                    const cy = cloud.y + cloud.height / 2;
                    const r = cloud.width / 3;
                    ctx.beginPath(); ctx.arc(cx - r * 0.4, cy, r * 0.5, 0, Math.PI * 2); ctx.fill();
                    ctx.beginPath(); ctx.arc(cx + r * 0.4, cy, r * 0.5, 0, Math.PI * 2); ctx.fill();
                    ctx.beginPath(); ctx.arc(cx, cy - r * 0.2, r * 0.6, 0, Math.PI * 2); ctx.fill();
                    ctx.shadowBlur = 0;
                    ctx.globalAlpha = 1;
                }
            }

            // ========== OBSTÁCULOS ==========
            const OBSTACLE_TYPES = [
                { kind: 'cactus-small',   width: 34, height: 46, weight: 4 },
                { kind: 'cactus-big',     width: 40, height: 56, weight: 3 },
                { kind: 'cactus-cluster', width: 60, height: 48, weight: 2 },
                { kind: 'bird',           width: 48, height: 36, weight: 2 },
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
                        y: flying ? groundY - CONFIG.birdFlightOffset : groundY - type.height,
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
                if (gameState !== 'running') return;
                if (player.grounded && !player.ducking) {
                    player.vy = -CONFIG.jumpForce;
                    player.grounded = false;
                    beep(700, 0.08, 'square');
                }
            }

            // Agachar com ajuste instantâneo de posição
            function setDuck(value) {
                if (gameState === 'idle') startRun();
                if (value && player.grounded) {
                    player.ducking = true;
                    player.y = groundY - player.heightDuck; // mantém os pés no chão
                } else if (!value && player.ducking) {
                    player.ducking = false;
                    player.y = groundY - player.heightStand;
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
                    if (!ob.jumpedOver && !player.grounded && player.y + h < ob.y + 5 && player.x + player.width > ob.x + 5) {
                        ob.jumpedOver = true;
                        ob.spriteState = 'back';
                    }
                }
                return false;
            }

            function showGameOver(isNewRecord) {
                overlay.classList.add('hidden');
                gameOverOverlay.classList.remove('hidden');
                finalTimeEl.textContent = elapsed.toFixed(1) + 's';
                newRecordBadge.classList.toggle('hidden', !isNewRecord);
                dinoSpriteEl.style.display = 'none';
            }

            // ========== ATUALIZAÇÃO MUNDO ==========
            function updateWorld(dt) {
                elapsed += dt;
                speed = Math.min(CONFIG.maxSpeed, CONFIG.initialSpeed + elapsed * CONFIG.speedGainPerSecond);
                updateSpawning(dt);
                updatePlayer(dt);

                const pxPerSec = speed * SPEED_SCALE;
                bgOffsetX = (bgOffsetX + pxPerSec * dt) % CONFIG.width;
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
                    const isNewRecord = elapsed > best;
                    if (isNewRecord) {
                        best = elapsed;
                        bestEl.textContent = best.toFixed(1) + 's';
                        if (best > serverBest) saveBest(best);
                    }
                    showGameOver(isNewRecord);
                    return;
                }

                timerEl.textContent = elapsed.toFixed(1) + 's';
            }

            // ========== DESENHO ==========
            function drawWave(time, amplitude, frequency, phase, color) {
                ctx.beginPath();
                ctx.moveTo(0, groundY);
                for (let x = 0; x <= CONFIG.width; x += 2) {
                    const y = groundY - amplitude * Math.sin(x * frequency + time * phase);
                    ctx.lineTo(x, y);
                }
                ctx.strokeStyle = color;
                ctx.lineWidth = 2;
                ctx.shadowColor = color;
                ctx.shadowBlur = 10;
                ctx.stroke();
                ctx.shadowBlur = 0;
            }

            function draw() {
                ctx.clearRect(0, 0, CONFIG.width, CONFIG.height);

                const grad = ctx.createLinearGradient(0, 0, 0, CONFIG.height);
                grad.addColorStop(0, '#04060d');
                grad.addColorStop(0.3, '#070f24');
                grad.addColorStop(0.6, '#0c1f3f');
                grad.addColorStop(1, '#123257');
                ctx.fillStyle = grad;
                ctx.fillRect(0, 0, CONFIG.width, CONFIG.height);

                const time = performance.now() / 1000;
                drawStars(time);
                drawClouds();

                const ampBase = CONFIG.waveAmplitudeBase;
                const freqBase = CONFIG.waveFrequencyBase;
                const speedBase = CONFIG.waveSpeedBase;
                drawWave(time, ampBase * 1.2, freqBase * 0.8, speedBase * 0.7, '#234d72');
                drawWave(time + 0.5, ampBase * 0.9, freqBase * 1.1, speedBase * 0.9, '#2f6390');
                drawWave(time + 1.2, ampBase * 0.6, freqBase * 1.4, speedBase * 1.2, '#3f7aa8');

                ctx.fillStyle = '#03050b';
                ctx.fillRect(0, groundY + 6, CONFIG.width, CONFIG.height - groundY - 6);
                ctx.fillStyle = '#0e1c33';
                for (let i = 0; i < 26; i++) {
                    const x = (i * 26 + bgOffsetX * 0.2) % CONFIG.width;
                    ctx.fillRect(x, groundY + 10 + (i % 5) * 4, 2, 2);
                }

                ctx.shadowColor = '#3a82bb';
                ctx.shadowBlur = 8;
                ctx.strokeStyle = '#3a82bb';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(0, groundY + 2);
                ctx.lineTo(CONFIG.width, groundY + 2);
                ctx.stroke();
                ctx.shadowBlur = 0;

                ctx.fillStyle = '#5aa0d0';
                ctx.globalAlpha = 0.5;
                for (const tx of groundTicks) ctx.fillRect(tx, groundY - 4, 2, 8);
                ctx.globalAlpha = 1;

                for (const ob of obstacles) {
                    let img;
                    const w = ob.width, h = ob.height;
                    if (ob.kind === 'bird') {
                        const frame = Math.floor(ob.wingPhase / CONFIG.birdAnimInterval) % 2;
                        img = (frame === 0) ? sprites.bird1 : sprites.bird2;
                    } else {
                        img = (ob.spriteState === 'back') ? sprites.obstBack : sprites.obstFront;
                    }
                    ctx.drawImage(img, ob.x, ob.y, w, h);
                }
            }

            // ========== SPRITE DO DINOSSAURO ==========
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
            overlay.addEventListener('pointerdown', (e) => {
                e.preventDefault();
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

            gameOverOverlay.addEventListener('pointerdown', (e) => {
                e.preventDefault();
                resetGame();
            });
            document.getElementById('dinoRetry').addEventListener('pointerdown', (e) => {
                e.preventDefault();
                e.stopPropagation();
                resetGame();
            });
        })();
    </script>
    @endpush
</x-app-layout>