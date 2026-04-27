<x-app-layout>
    {{-- Fundo dinâmico --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_index.png') }}" alt="Background" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    {{-- ELEMENTO DECORATIVO: GRID NEON DE FUNDO --}}
    <div class="fixed inset-0 -z-5 pointer-events-none opacity-20" 
         style="background-image: radial-gradient(circle, #06b6d4 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative py-12 px-6 max-w-7xl mx-auto">
        
        {{-- Título Centralizado --}}
        <div class="flex flex-col items-center mb-12">
            <x-ark-title title="Suas Fichas" />
            
            {{-- PARÁGRAFO NARRATIVO (Baseado no seu sistema) --}}
            <div class="max-w-2xl mt-6 relative p-4 border-l-2 border-cyan-500/50 bg-cyan-950/20 backdrop-blur-sm animate-fadeIn">
                <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-cyan-400"></div>
                <p class="text-gray-300 font-mono text-[11px] leading-relaxed uppercase tracking-widest">
                    <span class="text-cyan-400 font-bold">Bem vindo sobrevivente!</span> Abaixo estão listados os seus <span class="text-cyan-300">registros de sobreviventes</span>Cada ficha representa a codificação biológica e as memórias de um sobrevivente que nasceu ou já explorou o Ark. 
                    <br><br>
                    <span class="italic text-gray-500">Use o livro de Regras do sistema de Rpg-Ark como base na criação da Ficha.</span>
                </p>
            </div>
        </div>

        {{-- BARRA DE STATUS / DECORAÇÃO --}}
        <div class="flex justify-between items-end mb-6 px-2">
            <div class="flex gap-4 items-center">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <span class="text-[9px] text-cyan-400 font-bold tracking-[0.3em] uppercase">Sincronização:</span>
                </div>
                <div class="h-[1px] w-32 bg-gradient-to-r from-cyan-500/50 to-transparent"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            {{-- BOTÃO NOVO (Com ajuste de altura e brilho) --}}
            <a href="{{ route('fichas.create') }}" 
               class="ark-card group h-[400px] flex flex-col items-center justify-center border-dashed !border-2 !border-cyan-500/40 hover:!border-cyan-400 transition-all duration-500 hover:shadow-[0_0_35px_rgba(0,242,255,0.3)] bg-black/40 backdrop-blur-md relative overflow-hidden">
                
                {{-- Efeito de Scanner no botão Novo --}}
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-cyan-500/5 to-transparent -translate-y-full group-hover:translate-y-full transition-all duration-[2s] linear infinite"></div>
                
                <span class="text-6xl text-cyan-400 group-hover:scale-125 group-hover:rotate-90 transition-all duration-500 drop-shadow-[0_0_12px_cyan] font-thin">+</span>
                <span class="mt-6 font-display font-black text-[11px] tracking-[0.3em] text-cyan-300 group-hover:text-cyan-100 transition-colors uppercase">Criar Ficha</span>
                <span class="mt-2 text-[8px] text-gray-500 uppercase tracking-widest">Novo Sobrevivente</span>
            </a>

            @foreach($characters as $char)
                <div class="ark-card group h-[400px] p-0 flex flex-col animate-fadeInUp relative overflow-hidden backdrop-blur-md bg-black/40 border border-cyan-500/20 hover:border-cyan-400/60 transition-all duration-500 shadow-lg hover:shadow-[0_0_30px_rgba(0,242,255,0.2)]" 
                     style="animation-delay: {{ $loop->index * 0.1 }}s">
                    
                    {{-- HEADER DA CARTA --}}
                    <div class="absolute top-0 left-0 right-0 z-10 flex justify-between items-start pointer-events-none">
                        <div class="bg-gradient-to-r from-cyan-600 to-blue-600 px-4 py-1.5 text-[10px] font-black uppercase shadow-lg rounded-br-lg pointer-events-auto">
                            {{ $char->class_sub }}
                        </div>
                    </div>

                    {{-- BOTÕES DE AÇÃO --}}
                    <div class="absolute top-2 right-2 flex gap-2 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                        <a href="{{ route('fichas.edit', $char->id) }}" 
                           class="bg-black/60 border border-amber-500/50 hover:bg-amber-600 p-2 rounded text-white transition-all hover:scale-110 backdrop-blur-md"
                           title="Editar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('fichas.destroy', $char->id) }}" method="POST" 
                              onsubmit="return confirm('Deseja deletar permanentemente este registro de DNA?')">
                            @csrf @method('DELETE')
                            <button class="bg-black/60 border border-red-500/50 hover:bg-red-600 p-2 rounded text-white transition-all hover:scale-110 backdrop-blur-md"
                                    title="Deletar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                    
                    <a href="{{ route('fichas.show', $char->id) }}" class="flex flex-col h-full">
                        {{-- Imagem --}}
                        <div class="h-60 overflow-hidden bg-black border-b border-cyan-500/30 relative">
                            <img src="{{ asset('storage/' . $char->image) }}" 
                                 class="w-full h-full object-cover opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700 filter saturate-[0.8] group-hover:saturate-100">
                            {{-- Overlay de HUD --}}
                            <div class="absolute inset-0 border-[10px] border-transparent group-hover:border-cyan-500/10 transition-all"></div>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col bg-gradient-to-b from-black/80 to-cyan-950/20">
                            <h3 class="text-xl font-display font-black uppercase text-white tracking-tighter truncate border-l-4 border-cyan-500 pl-3 mb-1 group-hover:border-white transition-all">
                                {{ $char->name }}
                            </h3>
                            
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-[10px] font-mono text-cyan-400 font-bold">ID_{{ str_pad($char->id, 6, '0', STR_PAD_LEFT) }}</span>
                                <div class="flex items-center gap-1">
                                    <span class="text-[8px] text-gray-500 uppercase">Status:</span>
                                    <span class="text-[9px] text-emerald-400 font-bold uppercase">Vivo</span>
                                </div>
                            </div>

                            <div class="mt-auto pt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[9px] text-gray-400 uppercase tracking-widest font-bold">Progressão</span>
                                    <span class="text-[10px] text-cyan-300 font-black italic">LVL {{ $char->level }}</span>
                                </div>
                                {{-- Barra de XP Decorativa --}}
                                <div class="w-full h-1 bg-gray-800 rounded-full overflow-hidden border border-white/5">
                                    <div class="h-full bg-cyan-500 shadow-[0_0_8px_cyan]" style="width: {{ min($char->level, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .animate-fadeIn {
            animation: fadeIn 1s ease-out forwards;
        }
        .ark-card {
            background: linear-gradient(145deg, rgba(15,25,30,0.9), rgba(5,5,5,0.95));
            border-radius: 4px; /* Mais quadrado para parecer interface de computador */
            clip-path: polygon(0 0, 95% 0, 100% 5%, 100% 100%, 5% 100%, 0 95%);
        }
    </style>
</x-app-layout>