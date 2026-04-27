<nav x-data="{ open: false }" 
     class="relative z-50 bg-black border-b border-cyan-500/30 shadow-[0_0_20px_rgba(0,242,255,0.15)] backdrop-blur-sm">

    <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-cyan-400 to-transparent"
         style="background-size: 200% 100%; animation: scanMove 3s linear infinite;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="transition-all duration-300 hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-cyan-300 drop-shadow-[0_0_2px_rgba(0,242,255,0.8)]" />
                    </a>
                </div>

                {{-- Links Desktop --}}
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $links = [
                            ['route' => 'home', 'label' => 'Início'],
                            ['route' => 'regras', 'label' => 'Regras'],
                        ];
                        if (auth()->check()) {
                            $links[] = ['route' => 'rolagens.index', 'label' => 'Rolagens'];
                            $links[] = ['route' => 'fichas.index', 'label' => 'Fichas'];
                            if (auth()->user()->cargo === 'mestre') {
                                $links[] = ['route' => 'master.mesa', 'label' => 'Mesa'];
                            }
                            $links[] = ['route' => 'session.entrar.form', 'label' => 'Entrar Sessão'];
                        }
                    @endphp

                    @foreach ($links as $link)
                        <x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'] . '*')" 
                            class="relative px-4 py-3 text-sm font-medium tracking-[0.15em] uppercase transition-all duration-300 {{ request()->routeIs($link['route'] . '*') ? 'text-cyan-300' : 'text-gray-400 hover:text-cyan-300' }}">
                            {{ $link['label'] }}
                        </x-nav-link>
                    @endforeach

                    {{-- Sessão ativa (jogador) --}}
                    @auth
                        @if($activeSession && $activeSession->master_user_id !== auth()->id())
                            <div class="flex items-center space-x-2 ml-2">
                                <x-nav-link :href="route('rolagens.index')" class="text-yellow-300 border-yellow-500/30">
                                    Em Sessão: {{ $activeSession->session_code }}
                                </x-nav-link>
                                <form method="POST" action="{{ route('session.sair') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-400 text-xs uppercase tracking-wider hover:text-red-300">Sair</button>
                                </form>
                            </div>
                        @endif
                        {{-- Sessão ativa do mestre --}}
                        @if($activeSession && $activeSession->master_user_id === auth()->id())
                            <div class="flex items-center space-x-2 ml-2">
                                <x-nav-link :href="route('master.sessao', $activeSession->session_code)" class="text-purple-300 border-purple-500/30">
                                    Minha Mesa: {{ $activeSession->session_code }}
                                </x-nav-link>
                                <form method="POST" action="{{ route('master.encerrar.mesa', $activeSession->session_code) }}" onsubmit="return confirm('Encerrar a mesa?')">
                                    @csrf
                                    <button type="submit" class="text-red-400 text-xs uppercase tracking-wider hover:text-red-300">Encerrar</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Lado Direito (perfil) - igual ao original, omitido por brevidade --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="group inline-flex items-center px-4 py-1.5 border rounded-full text-xs font-bold uppercase border-cyan-500/40 text-gray-300 hover:text-cyan-200 shadow-[0_0_15px_rgba(0,242,255,0.2)] focus:outline-none">
                                <div class="w-8 h-8 rounded-full border border-cyan-500/50 overflow-hidden mr-2">
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-cyan-900/50 flex items-center justify-center">
                                            <span class="text-sm text-cyan-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-gray-950 border border-cyan-500/30 rounded-lg p-1">
                                <x-dropdown-link :href="route('perfil')">Meu Perfil</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">Sair</x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 hover:text-cyan-400 uppercase tracking-widest">Acessar</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-cyan-600/10 border border-cyan-500/50 text-cyan-400 text-xs font-bold uppercase rounded hover:bg-cyan-500 hover:text-black transition">Criar Conta</a>
                    </div>
                @endauth
            </div>

            {{-- Botão Mobile --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-cyan-400 hover:bg-gray-900 border border-cyan-500/20">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Mobile (resumido) --}}
    <div x-show="open" x-transition class="sm:hidden bg-black/95 border-t border-cyan-500/30">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'] . '*')">
                    {{ $link['label'] }}
                </x-responsive-nav-link>
            @endforeach
            @if($activeSession && $activeSession->master_user_id !== auth()->id())
                <x-responsive-nav-link :href="route('rolagens.index')">Sessão: {{ $activeSession->session_code }}</x-responsive-nav-link>
            @endif
            @if($activeSession && $activeSession->master_user_id === auth()->id())
                <x-responsive-nav-link :href="route('master.sessao', $activeSession->session_code)">Minha Mesa</x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-cyan-500/20">
            @auth
                <div class="px-4 flex items-center">
                    <div class="shrink-0 me-3">
                        <div class="h-10 w-10 rounded-full border border-cyan-500/50 flex items-center justify-center bg-cyan-900/30">
                            <span class="text-cyan-300 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="font-medium text-base text-cyan-300">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('perfil')">Meu Perfil</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">Sair</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="p-4 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center w-full py-2 text-gray-400 font-bold uppercase tracking-widest">Acessar</a>
                    <a href="{{ route('register') }}" class="block text-center w-full py-2 bg-cyan-600/20 border border-cyan-500 text-cyan-400 font-bold uppercase rounded">Criar Conta</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    @keyframes scanMove {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>