{{-- resources/views/fichas/index.blade.php --}}
<x-app-layout>
    {{-- Fundo dinâmico --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/Fundo_index.png') }}" alt="Background"
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="fixed inset-0 -z-5 pointer-events-none opacity-20"
         style="background-image: radial-gradient(circle, #06b6d4 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative py-12 px-6 max-w-7xl mx-auto">

        {{-- Header da Página --}}
        <div class="flex flex-col items-center mb-12">
            <x-ark-title title="Suas Fichas" />
            <div class="max-w-2xl mt-6 relative p-4 border-l-2 border-cyan-500/50 bg-cyan-950/20 backdrop-blur-sm animate-fadeIn">
                <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-cyan-400"></div>
                <p class="text-gray-300 font-mono text-[11px] leading-relaxed uppercase tracking-widest">
                    <span class="text-cyan-400 font-bold">Bem vindo sobrevivente!</span> Abaixo estão listados os seus <span class="text-cyan-300">registros de sobreviventes</span>. Cada ficha representa a codificação biológica e as memórias de um sobrevivente que nasceu ou já explorou o Ark.
                    <br><br>
                    <span class="italic text-gray-400">Use o livro de Regras do sistema de Rpg-Ark como base na criação da Ficha.</span>
                </p>
            </div>
        </div>

        {{-- Barra de Ações do Topo --}}
        <div class="flex justify-between items-center mb-6 px-2">
            <div class="flex gap-4 items-center">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-cyan-500"></span>
                    </span>
                    <span class="text-[10px] text-cyan-400 font-bold tracking-[0.25em] uppercase">Sincronização Ativa</span>
                </div>
                <div class="h-[1px] w-32 bg-gradient-to-r from-cyan-500/50 to-transparent"></div>
            </div>
            <div>
                <button onclick="document.getElementById('resgatar-modal').classList.remove('hidden')" class="text-[11px] font-bold bg-cyan-500/20 hover:bg-cyan-500/40 px-4 py-2 rounded border border-cyan-500/40 text-cyan-300 transition-all hover:shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                    Resgatar Ficha
                </button>
            </div>
        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">

            {{-- Card Criar Ficha --}}
            <a href="{{ route('fichas.create') }}"
               class="ark-card group h-[400px] flex flex-col items-center justify-center border-dashed !border-2 !border-cyan-500/40 hover:!border-cyan-400 transition-all duration-500 hover:shadow-[0_0_35px_rgba(0,242,255,0.3)] bg-black/40 backdrop-blur-md relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-cyan-500/5 to-transparent -translate-y-full group-hover:translate-y-full transition-all duration-[2s] linear infinite"></div>
                <span class="text-6xl text-cyan-400 group-hover:scale-125 group-hover:rotate-90 transition-all duration-500 drop-shadow-[0_0_12px_cyan] font-thin">+</span>
                <span class="mt-6 font-display font-black text-[11px] tracking-[0.3em] text-cyan-300 group-hover:text-cyan-100 transition-colors uppercase">Criar Ficha</span>
                <span class="mt-2 text-[9px] text-gray-400 uppercase tracking-widest">Novo Sobrevivente</span>
            </a>

            {{-- Loop de Personagens --}}
            @foreach($characters as $char)
                @php $isPinned = $char->is_pinned ?? false; @endphp
                
                <div class="ark-card group h-[400px] p-0 flex flex-col animate-fadeInUp relative overflow-hidden backdrop-blur-md bg-black/60 border {{ $char->is_resgatada ? 'border-emerald-500/40' : ($isPinned ? 'is-pinned border-amber-400/60' : 'border-cyan-500/30') }} hover:border-cyan-400 transition-all duration-500 shadow-lg hover:shadow-[0_0_30px_rgba(0,242,255,0.25)]"
                     style="animation-delay: {{ $loop->index * 0.1 }}s">

                    @if($isPinned)
                        <div class="pin-stripes absolute inset-0 pointer-events-none z-[1]"></div>
                    @endif

                    {{-- TOPO DO CARD: Classe + Badges + Botões de Ação --}}
                    <div class="p-3 pb-0 flex justify-between items-start gap-2 relative z-20">
                        {{-- Esquerda: Classe e status --}}
                        <div class="flex flex-col gap-1.5 items-start max-w-[60%]">
                            <span class="bg-gradient-to-r from-cyan-600 to-blue-700 text-white font-black text-[9px] uppercase px-2.5 py-1 rounded shadow-md tracking-wider truncate w-full">
                                {{ $char->class_sub }}
                            </span>

                            @if($isPinned)
                                <span class="pin-badge">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                        <path d="M16 3l5 5-4 4-1 5-3-3-5 5-1-1 5-5-3-3 5-1 4-4z"/>
                                    </svg>
                                    FIXADA
                                </span>
                            @endif
                        </div>

                        {{-- Direita: Botões de Ação --}}
                        <div class="flex items-center gap-1 bg-black/80 backdrop-blur-md p-1 rounded-lg border border-white/10 shadow-lg">
                            <a href="{{ route('fichas.edit', $char->id) }}"
                               class="text-gray-300 hover:text-amber-400 hover:bg-white/10 p-1.5 rounded transition-all"
                               title="Editar">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>

                            <form action="{{ route('fichas.destroy', $char->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Deseja deletar permanentemente este registro de DNA?')">
                                @csrf @method('DELETE')
                                <button class="text-gray-300 hover:text-red-400 hover:bg-white/10 p-1.5 rounded transition-all" title="Deletar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>

                            <button onclick="pinFicha({{ $char->id }})"
                                    class="pin-button {{ $isPinned ? 'is-active' : '' }} text-gray-300 hover:text-amber-300 hover:bg-white/10 p-1.5 rounded transition-all"
                                    title="{{ $isPinned ? 'Desafixar' : 'Fixar' }}">
                                <svg class="w-3.5 h-3.5 pin-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7V4a1 1 0 00-1-1H9a1 1 0 00-1 1v3m8 0l2 2-4 4v7l-2-1-2 1v-7L6 9l2-2m8 0H8"/>
                                </svg>
                            </button>

                            @if(!$char->is_resgatada && $char->user_id === Auth::id())
                                <button onclick="shareFicha({{ $char->id }})"
                                        class="text-gray-300 hover:text-emerald-400 hover:bg-white/10 p-1.5 rounded transition-all"
                                        title="Compartilhar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- CORPO DO CARD --}}
                    <a href="{{ route('fichas.show', $char->id) }}" class="flex flex-col h-full relative z-[2] justify-between pt-2">
                        <div class="p-5 flex-1 flex flex-col justify-between bg-gradient-to-b from-transparent via-black/40 to-black/80">
                            
                            {{-- Nome e Informações Principais --}}
                            <div>
                                <h3 class="text-xl font-display font-black uppercase text-white tracking-tight truncate border-l-4 border-cyan-500 pl-3 mb-3 group-hover:border-cyan-300 group-hover:text-cyan-100 transition-all">
                                    {{ $char->name }}
                                </h3>

                                <div class="space-y-2 bg-black/40 p-2.5 rounded border border-white/5">
                                    {{-- ID & Peculiaridade --}}
                                    <div class="flex items-center justify-between text-[10px]">
                                        <span class="font-mono text-cyan-400 font-bold">ID_{{ str_pad($char->id, 6, '0', STR_PAD_LEFT) }}</span>
                                        <div class="flex items-center gap-1 overflow-hidden">
                                            <span class="text-gray-400 uppercase text-[8px]">Peculiaridade:</span>
                                            <span class="text-emerald-400 font-bold uppercase truncate max-w-[90px]">{{ $char->class_sub }}</span>
                                        </div>
                                    </div>

                                    {{-- Badge Resgatada (Caso exista) --}}
                                    @if($char->is_resgatada)
                                        <div class="pt-1.5 border-t border-white/5 flex items-center justify-between gap-1">
                                            <span class="inline-flex items-center gap-1 bg-emerald-500/20 text-emerald-300 text-[8px] font-black px-2 py-0.5 rounded border border-emerald-500/30 uppercase tracking-wider">
                                                <svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                RESGATADA
                                            </span>
                                            @if($char->originalUser)
                                                <span class="text-[8px] text-gray-400 truncate">por <strong class="text-gray-200">{{ $char->originalUser->name }}</strong></span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Barra de Progresso / Nível --}}
                            <div class="pt-4">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[9px] text-gray-400 uppercase tracking-widest font-bold">Progressão</span>
                                    <span class="text-[10px] text-cyan-300 font-black italic">LVL {{ $char->level }}</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-900 rounded-full overflow-hidden border border-white/10">
                                    <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-500 shadow-[0_0_8px_cyan]" style="width: {{ min($char->level, 100) }}%"></div>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- MODAL COMPARTILHAR --}}
    <div id="share-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="bg-gray-900 border border-cyan-500/40 rounded-lg p-6 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-xl font-medieval font-black text-cyan-400 uppercase tracking-wider mb-4">Compartilhar Ficha</h3>
            <p class="text-gray-300 text-sm mb-2">Código de resgate:</p>
            <div class="flex items-center gap-3">
                <input id="share-code" type="text" readonly class="w-full bg-black/60 border border-cyan-500/30 text-cyan-300 font-mono text-lg px-4 py-2 rounded focus:outline-none">
                <button onclick="copiarCodigo()" class="bg-cyan-500/20 hover:bg-cyan-500/40 px-3 py-2 rounded border border-cyan-500/30 text-cyan-300 transition">Copiar</button>
            </div>
            <p class="text-gray-400 text-xs mt-3">Compartilhe este código com outro jogador. Ele poderá resgatar uma cópia da ficha.</p>
            <div class="mt-6 flex justify-end">
                <button onclick="fecharModalShare()" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm transition text-gray-200">Fechar</button>
            </div>
        </div>
    </div>

    {{-- MODAL RESGATAR --}}
    <div id="resgatar-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="bg-gray-900 border border-cyan-500/40 rounded-lg p-6 max-w-md w-full mx-4 shadow-2xl">
            <h3 class="text-xl font-medieval font-black text-cyan-400 uppercase tracking-wider mb-4">Resgatar Ficha</h3>
            <p class="text-gray-300 text-sm mb-2">Insira o código de compartilhamento:</p>
            <form action="{{ route('fichas.resgatar') }}" method="POST">
                @csrf
                <input type="text" name="code" placeholder="Ex: A1B2C3D4" class="w-full bg-black/60 border border-cyan-500/30 text-white font-mono text-lg px-4 py-2 rounded focus:outline-none focus:border-cyan-400">
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('resgatar-modal').classList.add('hidden')" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm transition text-gray-200">Cancelar</button>
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 px-4 py-2 rounded text-sm font-bold text-black transition">Resgatar</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
        .ark-card {
            background: linear-gradient(145deg, rgba(12, 22, 28, 0.95), rgba(5, 5, 5, 0.98));
            border-radius: 6px;
            clip-path: polygon(0 0, 93% 0, 100% 7%, 100% 100%, 7% 100%, 0 93%);
        }

        /* CARD FIXADO */
        .ark-card.is-pinned {
            border-color: rgba(251, 191, 36, 0.7) !important;
            animation: pinGlow 3s ease-in-out infinite;
        }
        @keyframes pinGlow {
            0%, 100% { box-shadow: 0 0 15px rgba(251, 191, 36, 0.15), inset 0 0 15px rgba(251, 191, 36, 0.05); }
            50%      { box-shadow: 0 0 30px rgba(251, 191, 36, 0.35), inset 0 0 25px rgba(251, 191, 36, 0.08); }
        }

        .pin-stripes {
            background: repeating-linear-gradient(
                45deg,
                transparent 0,
                transparent 18px,
                rgba(251, 191, 36, 0.03) 18px,
                rgba(251, 191, 36, 0.03) 22px
            );
        }

        .pin-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            color: #0b0b0b;
            font-weight: 900;
            font-size: 8px;
            letter-spacing: 1px;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            box-shadow: 0 0 10px rgba(251, 191, 36, 0.4);
        }

        .pin-button.is-active {
            color: #fbbf24 !important;
        }
        .pin-button.is-active .pin-icon {
            transform: rotate(-20deg);
        }
    </style>

    <script>
        function shareFicha(id) {
            fetch(`/fichas/${id}/share`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(async (res) => {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    throw new Error(data.message || 'Erro ao compartilhar ficha.');
                }
                return data;
            })
            .then(data => {
                if (data.code) {
                    document.getElementById('share-code').value = data.code;
                    document.getElementById('share-modal').classList.remove('hidden');
                } else {
                    alert('Erro ao gerar código de compartilhamento.');
                }
            })
            .catch(err => {
                alert(err.message || 'Erro ao compartilhar ficha.');
                console.error(err);
            });
        }

        function pinFicha(id) {
            fetch(`/fichas/${id}/pin`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            })
            .then(async (res) => {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    throw new Error(data.message || 'Erro ao fixar ficha.');
                }
                return data;
            })
            .then(data => {
                window.location.reload();
            })
            .catch(err => {
                alert(err.message || 'Erro ao fixar ficha.');
                console.error(err);
            });
        }

        function copiarCodigo() {
            const input = document.getElementById('share-code');
            input.select();
            document.execCommand('copy');
            alert('Código copiado!');
        }

        function fecharModalShare() {
            document.getElementById('share-modal').classList.add('hidden');
        }

        document.getElementById('share-modal').addEventListener('click', function(e) {
            if (e.target === this) fecharModalShare();
        });
        document.getElementById('resgatar-modal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>
</x-app-layout>