<x-app-layout>
    {{-- Conteúdo centralizado --}}
    <div class="flex-1 flex flex-col items-center justify-center min-h-[70vh] py-12 px-4">
        <div class="max-w-2xl w-full bg-black/60 backdrop-blur-md border border-cyan-500/30 rounded-2xl p-8 md:p-12 text-center shadow-2xl shadow-cyan-500/10 transition-all duration-500 hover:border-cyan-400/60">
            
            {{-- Logo do ARK --}}
            <div class="mb-6">
                <img src="{{ asset('img/Logo_ark.png') }}" alt="ARK RPG" class="w-48 md:w-56 mx-auto drop-shadow-[0_0_30px_rgba(0,242,255,0.3)] transition-all duration-500 hover:drop-shadow-[0_0_50px_rgba(0,242,255,0.6)] hover:scale-105">
            </div>

            {{-- Código do erro --}}
            <div class="text-7xl md:text-8xl font-black text-cyan-400 drop-shadow-[0_0_30px_#4deaff] tracking-wider mb-2">
                419
            </div>

            {{-- Título --}}
            <h1 class="text-3xl md:text-4xl font-bold uppercase tracking-[0.2em] text-white mb-4">
                Sessão Expirada
            </h1>

            {{-- Mensagem descritiva --}}
            <p class="text-gray-300 text-base md:text-lg max-w-md mx-auto mb-8 leading-relaxed">
                Sua sessão expirou por inatividade.<br>
                <span class="text-cyan-300">Recarregue a página</span> para continuar suas operações.
            </p>

            {{-- Botão recarregar --}}
            <button onclick="location.reload();" 
                    class="inline-flex items-center gap-3 px-8 py-4 bg-transparent border-2 border-cyan-400 text-cyan-400 font-bold uppercase tracking-[0.15em] rounded-full transition-all duration-300 hover:bg-cyan-400 hover:text-black hover:shadow-[0_0_30px_#4deaff] hover:scale-105 group">
                <svg class="w-5 h-5 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Recarregar Página
            </button>

            {{-- Rodapé informativo --}}
            <div class="mt-8 text-xs text-gray-500 uppercase tracking-widest">
                ARK RPG · Sistema de Sobrevivência
            </div>
        </div>
    </div>
</x-app-layout>