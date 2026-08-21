<x-app-layout>
    {{-- Fundo fixo com imagem (mesmo padrão das outras telas) --}}
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/fundo_perfil.png') }}" alt="Background Perfil" 
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="relative z-10 py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="ark-panel !p-0 overflow-hidden grid grid-cols-1 md:grid-cols-3 shadow-[0_0_35px_rgba(0,242,255,0.2)]">
                    
                    {{-- Coluna do Avatar (sem scanner) --}}
                    <div class="bg-black/40 p-8 flex flex-col items-center border-r border-cyan-500/20">
                        <div class="relative group">
                            <div class="w-32 h-32 bg-black/50 border-2 border-cyan-500/40 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(0,242,255,0.2)] mb-4 overflow-hidden transition-all duration-300 group-hover:shadow-[0_0_30px_cyan]">
                               @if($user->foto)
                                  <img id="img_preview" src="{{ route('media.show', $user->foto) }}" class="w-full h-full object-cover">
                               @else
                                   <div id="img_placeholder" class="w-full h-full flex items-center justify-center">
                                        <span class="text-5xl font-black text-cyan-400 uppercase">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                              </div>
                                   <img id="img_preview" class="w-full h-full object-cover hidden">
                               @endif
                            </div>
                            <label for="foto" class="absolute inset-0 flex items-center justify-center bg-black/70 opacity-0 group-hover:opacity-100 transition cursor-pointer rounded-full backdrop-blur-sm">
                                <span class="text-[10px] text-white font-bold uppercase tracking-wider">Alterar</span>
                            </label>
                            <input type="file" id="foto" name="foto" class="hidden" onchange="previewImage(event)">
                        </div>

                        <div class="text-center w-full mt-2">
                            <div class="bg-black/60 border border-cyan-500/20 py-1 px-3 rounded-sm">
                                @if($user->cargo == 'mestre')
                                    <span class="text-purple-400 text-[10px] font-bold uppercase tracking-widest">Cargo: Mestre</span>
                                @else
                                    <span class="text-emerald-400 text-[10px] font-bold uppercase tracking-widest">Cargo: Jogador</span>
                                @endif
                            </div>
                            <p class="text-[8px] text-gray-500 mt-2 uppercase tracking-tighter italic">Atribuição de Unidade Inalterável</p>
                        </div>
                    </div>

                    {{-- Coluna dos Dados --}}
                    <div class="md:col-span-2 p-8 space-y-6">
                        {{-- Nome --}}
                        <div>
                            <label class="text-[10px] text-cyan-400 uppercase tracking-[0.2em] font-bold block mb-1">Identificação</label>
                            <input type="text" name="name" value="{{ $user->name }}" 
                                class="ark-input text-lg font-medieval">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="text-[10px] text-cyan-400 uppercase tracking-[0.2em] font-bold block mb-1">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" 
                                class="ark-input">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Metadados --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-[10px] text-cyan-400/80 uppercase tracking-widest block mb-1">ID de Cristal</span>
                                <p class="text-gray-300 font-mono text-sm py-2 border-b border-cyan-500/20">{{ $user->crystal_id }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] text-cyan-400/80 uppercase tracking-widest block mb-1">Sincronização</span>
                                <p class="text-gray-300 font-mono text-sm py-2 border-b border-cyan-500/20">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        {{-- Ações --}}
                        <div class="pt-6 border-t border-cyan-500/20 flex items-center justify-between">
                            <button type="submit" class="ark-btn !py-2 !px-8 !text-xs group relative overflow-hidden">
                                <span class="relative z-10">Atualizar Dados</span>
                                <span class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-600 opacity-0 group-hover:opacity-100 transition duration-300"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Botão de logout --}}
            <div class="flex justify-end mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[9px] text-red-400 hover:text-red-300 uppercase font-black tracking-widest transition border border-red-500/30 px-4 py-2 rounded-full hover:bg-red-950/30">
                        Terminar Sessão
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('img_preview');
                const placeholder = document.getElementById('img_placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>