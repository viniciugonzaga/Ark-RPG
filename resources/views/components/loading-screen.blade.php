{{-- resources/views/components/loading-screen.blade.php --}}
<div id="global-loader" class="fixed inset-0 z-[10000] bg-black flex flex-col items-center justify-center transition-opacity duration-700" 
     style="background: radial-gradient(circle at center, #0a1a1a 0%, #000000 100%);">
    
    <div class="relative">
        {{-- Logo com brilho pulsante --}}
        <div class="w-32 h-32 relative">
            <x-application-logo class="w-full h-full text-cyan-400 filter drop-shadow-[0_0_15px_rgba(0,242,255,0.5)]" style="filter: brightness(0) invert(1);" />
            
            {{-- Brilho pulsante suave (sem movimento linear) --}}
            <div class="absolute inset-0 rounded-full bg-cyan-500/20 blur-xl animate-pulse"></div>
        </div>
        
        {{-- Anel giratório externo --}}
        <div class="absolute -inset-6 rounded-full border border-cyan-500/30 animate-spin-slow"></div>
        <div class="absolute -inset-10 rounded-full border border-cyan-500/10"></div>
    </div>
    
    {{-- Texto de status com indicador de carregamento --}}
    <div class="mt-8 flex items-center gap-3">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
        </span>
        <p class="text-xs text-cyan-300 tracking-[0.3em] uppercase font-medium">Sincronizando Dados do Ark</p>
    </div>
    
    {{-- Barra de progresso indeterminada --}}
    <div class="mt-6 w-48 h-0.5 bg-gray-800 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r from-cyan-400 to-blue-500 w-1/2 animate-loading-bar"></div>
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 700);
        }
    });
</script>

<style>
    @keyframes loading-bar {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
    .animate-loading-bar {
        animation: loading-bar 1.5s ease-in-out infinite;
    }
    
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 6s linear infinite;
    }
</style>