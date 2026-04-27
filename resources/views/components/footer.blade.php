{{-- ARK THEME FOOTER — Enhanced with CSS animations & effects --}}
<footer class="relative bg-gradient-to-b from-black to-gray-950 border-t border-cyan-500/40 py-8 mt-auto overflow-hidden">

    {{-- Linha scanner superior animada (mais intensa) --}}
    <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-cyan-400 to-transparent opacity-90 animate-scan-line"></div>

    {{-- Grid de fundo com brilho pulsante --}}
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBkPSJNMCAwaDQwdjQwSDB6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDBmMmZmIiBzdHJva2Utd2lkdGg9IjAuNSIgb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-20 pointer-events-none animate-grid-pulse"></div>

    {{-- Efeito de ruído CRT (opcional) --}}
    <div class="absolute inset-0 bg-noise opacity-5 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
        
        {{-- Status com animações individuais e glow --}}
        <div class="flex justify-center gap-8 mb-6 flex-wrap">
            {{-- ARK SURVIVAL --}}
            <div class="status-item flex items-center gap-2 text-cyan-300 text-[11px] font-black uppercase tracking-[0.3em] drop-shadow-[0_0_5px_rgba(34,211,238,0.4)] group">
                <span class="relative w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_#00f2ff] animate-pulse-slow">
                    <span class="absolute inset-0 rounded-full bg-cyan-400 animate-ping opacity-40"></span>
                </span>
                <span class="group-hover:text-cyan-200 transition-all duration-300 group-hover:tracking-[0.35em]">ARK SURVIVAL</span>
            </div>

            {{-- STATUS: ATIVO --}}
            <div class="status-item flex items-center gap-2 text-emerald-300 text-[11px] font-black uppercase tracking-[0.3em] drop-shadow-[0_0_5px_rgba(52,211,153,0.4)] group">
                <span class="relative w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_10px_#4ade80]">
                    <span class="absolute inset-0 rounded-full bg-emerald-400 animate-pulse-ring"></span>
                </span>
                <span class="group-hover:text-emerald-200 transition-all duration-300">STATUS: ATIVO</span>
            </div>

            {{-- VERSÃO com brilho --}}
            <div class="status-item flex items-center gap-2 text-cyan-200 text-[11px] font-black uppercase tracking-[0.3em] group">
                <span class="w-2 h-2 rounded-full bg-cyan-300 shadow-[0_0_8px_rgba(165,243,252,0.5)] animate-breathe"></span>
                <span class="group-hover:text-cyan-100 transition-all duration-300">VERSÃO: 2.6.7</span>
            </div>
        </div>

        {{-- Copyright com efeito glitch sutil e gradiente animado --}}
        <p class="text-[10px] uppercase tracking-[0.4em] font-black relative">
            <span class="text-gray-200 relative inline-block glitch-text" data-text="&copy; {{ date('Y') }} ARK RPG">
                &copy; {{ date('Y') }} ARK RPG
            </span>
            <span class="mx-3 text-cyan-500 animate-pulse-glow">//</span>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-400 to-cyan-300 bg-[length:200%_auto] animate-gradient-flow drop-shadow-[0_0_8px_rgba(0,242,255,0.3)]">
                TODOS OS DIREITOS RESERVADOS AOS SOBREVIVENTES
            </span>
        </p>
        
        {{-- Assinatura técnica com borda animada e hover --}}
        <div class="mt-4 text-[9px] text-gray-400 tracking-[0.5em] font-bold">
            <div class="inline-block group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-lg blur opacity-0 group-hover:opacity-70 transition duration-500"></div>
                <div class="relative cursor-default border-x border-cyan-500/20 px-4 py-1 bg-cyan-950/20 backdrop-blur-sm hover:bg-cyan-950/40 transition-all duration-300">
                    <span class="hover:text-cyan-300 transition-colors duration-300">
                        SISTEMA NEURAL ARK v1.0
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- CSS customizado para animações e efeitos extras --}}
<style>
/* Animações principais */
@keyframes scan-line {
    0% { transform: translateX(-100%); opacity: 0; }
    50% { transform: translateX(0%); opacity: 1; }
    100% { transform: translateX(100%); opacity: 0; }
}
.animate-scan-line {
    animation: scan-line 4s ease-in-out infinite;
}

@keyframes grid-pulse {
    0%, 100% { opacity: 0.15; }
    50% { opacity: 0.3; }
}
.animate-grid-pulse {
    animation: grid-pulse 6s ease-in-out infinite;
}

@keyframes pulse-slow {
    0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 5px #00f2ff; }
    50% { opacity: 0.7; transform: scale(1.1); box-shadow: 0 0 15px #00f2ff; }
}
.animate-pulse-slow {
    animation: pulse-slow 2s ease-in-out infinite;
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 0.8; }
    100% { transform: scale(2.5); opacity: 0; }
}
.animate-pulse-ring {
    animation: pulse-ring 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
}

@keyframes breathe {
    0%, 100% { opacity: 0.6; transform: scale(0.95); }
    50% { opacity: 1; transform: scale(1.05); }
}
.animate-breathe {
    animation: breathe 2.2s ease-in-out infinite;
}

@keyframes pulse-glow {
    0%, 100% { text-shadow: 0 0 2px #00f2ff, 0 0 4px #00aaff; opacity: 0.8; }
    50% { text-shadow: 0 0 6px #00f2ff, 0 0 12px #00aaff; opacity: 1; }
}
.animate-pulse-glow {
    animation: pulse-glow 1.8s ease-in-out infinite;
    display: inline-block;
}

@keyframes gradient-flow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.animate-gradient-flow {
    animation: gradient-flow 5s ease infinite;
    background-size: 200% auto;
}

/* Efeito glitch para o copyright */
.glitch-text {
    position: relative;
    display: inline-block;
}
.glitch-text::before,
.glitch-text::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: transparent;
}
.glitch-text::before {
    left: 2px;
    text-shadow: -1px 0 #00f2ff;
    animation: glitch-1 0.8s infinite linear alternate-reverse;
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
}
.glitch-text::after {
    left: -2px;
    text-shadow: 1px 0 #ff00c1;
    animation: glitch-2 0.6s infinite linear alternate-reverse;
    clip-path: polygon(0 80%, 100% 20%, 100% 100%, 0 100%);
}
@keyframes glitch-1 {
    0% { transform: translate(0); opacity: 0.7; }
    100% { transform: translate(-2px, 1px); opacity: 0.9; }
}
@keyframes glitch-2 {
    0% { transform: translate(0); opacity: 0.6; }
    100% { transform: translate(2px, -1px); opacity: 0.8; }
}

/* Ruído CRT */
.bg-noise {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
    background-repeat: repeat;
    opacity: 0.04;
    pointer-events: none;
}

/* Hover geral nos status */
.status-item {
    transition: all 0.2s ease;
}
.status-item:hover span:first-child {
    animation-play-state: paused;
}

/* Responsividade */
@media (max-width: 640px) {
    .status-item span:last-child {
        font-size: 8px;
        letter-spacing: 0.2em;
    }
    .glitch-text {
        display: inline-block;
        white-space: nowrap;
    }
    .text-transparent.bg-clip-text {
        font-size: 8px;
        letter-spacing: 0.2em;
    }
}

/* Redução de movimento para acessibilidade */
@media (prefers-reduced-motion: reduce) {
    .animate-scan-line,
    .animate-grid-pulse,
    .animate-pulse-slow,
    .animate-pulse-ring,
    .animate-breathe,
    .animate-pulse-glow,
    .animate-gradient-flow,
    .glitch-text::before,
    .glitch-text::after {
        animation: none !important;
    }
    .bg-noise {
        opacity: 0.01;
    }
}
</style>