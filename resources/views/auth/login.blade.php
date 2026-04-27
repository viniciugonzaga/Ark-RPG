<x-guest-layout>
    {{-- Fundo temático --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_login.png') }}" alt="ARK Background" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="ark-panel !p-8 max-w-md mx-auto mt-10 border-t-4 border-cyan-400 shadow-[0_0_30px_rgba(0,242,255,0.3)]">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo_ark_pequena.png') }}" alt="ARK" class="h-12 w-auto drop-shadow-[0_0_8px_cyan]">
        </div>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-medieval font-black uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-amber-200">
                Faça seu Login
            </h2>
            <p class="text-[10px] text-cyan-400/80 uppercase tracking-widest">Login do Sobrevivente</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="text-[10px] text-gray-400 uppercase tracking-widest">Email</label>
                    <input type="email" name="email" :value="old('email')" required autofocus class="ark-input">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label class="text-[10px] text-gray-400 uppercase tracking-widest">Senha</label>
                    <input type="password" name="password" required class="ark-input">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <label class="inline-flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="rounded bg-black border-gray-800 text-cyan-500 focus:ring-cyan-500/50 focus:ring-1">
                    <span class="ms-2 text-[10px] text-gray-400 uppercase group-hover:text-cyan-300 transition">Manter Conectado</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] text-cyan-400 hover:text-cyan-200 uppercase tracking-tighter transition" href="{{ route('password.request') }}">
                        Recuperar Acesso?
                    </a>
                @endif
            </div>

            <button type="submit" class="ark-btn w-full mt-6 !py-3 font-bold uppercase tracking-[0.2em]">
                Entrar
            </button>
        </form>

        {{-- LINK PARA CADASTRO (estilo neon secundário) --}}
        <div class="mt-6 text-center border-t border-cyan-500/20 pt-5">
            <p class="text-[10px] text-gray-500 uppercase tracking-wider mb-3">Ainda não está preparado para o ARK?</p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-200 text-xs font-bold uppercase tracking-[0.15em] transition-all duration-300 border border-cyan-500/30 hover:border-cyan-400 rounded-full px-6 py-2 bg-black/40 backdrop-blur-sm group">
                <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Criar Sobrevivente
            </a>
        </div>
    </div>
</x-guest-layout>