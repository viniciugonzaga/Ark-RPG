<x-app-layout>
    <style>
       /* ================= RESPONSIVO ADICIONAL — PERFIL/EDIT ================= */

@media (max-width: 1080px) {
    .ark-panel { border-radius: 12px; }
    .ark-panel .w-32.h-32 { width: 7rem !important; height: 7rem !important; }
    .ark-panel .text-5xl { font-size: 2.5rem !important; }
}

@media (max-width: 760px) {
    .ark-panel > div { padding: 1.5rem !important; }
    .ark-panel .w-32.h-32 { width: 6rem !important; height: 6rem !important; }
    .ark-panel .text-5xl { font-size: 2rem !important; }
    .ark-panel h2, .ark-panel .text-3xl { font-size: 1.5rem !important; }
    .ark-btn { padding: 10px 20px !important; font-size: 0.7rem !important; }
    .ark-panel .border-r { border-right: 0 !important; border-bottom: 1px solid rgba(0, 242, 255, 0.2); }
}

@media (max-width: 480px) {
    .ark-panel > div { padding: 1.25rem !important; }
    .ark-panel .w-32.h-32 { width: 5rem !important; height: 5rem !important; }
    .ark-panel .text-5xl { font-size: 1.75rem !important; }
    .ark-input { font-size: 0.85rem !important; padding: 0.6rem 0.75rem !important; }
    .ark-btn { padding: 9px 16px !important; font-size: 0.62rem !important; letter-spacing: 1.5px !important; }
    .ark-panel .grid-cols-2 { grid-template-columns: 1fr !important; }
    .text-\[10px\] { font-size: 8px !important; }
    .text-\[8px\] { font-size: 7px !important; }
}

@media (max-width: 300px) {
    .ark-panel > div { padding: 1rem !important; }
    .ark-panel .w-32.h-32 { width: 4rem !important; height: 4rem !important; }
    .ark-panel .text-5xl { font-size: 1.35rem !important; }
    .ark-input { font-size: 0.75rem !important; padding: 0.5rem 0.55rem !important; }
    .ark-btn { font-size: 0.55rem !important; padding: 7px 12px !important; }
    .text-\[10px\] { font-size: 7px !important; letter-spacing: 0.05em !important; }
}
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cyan-300 leading-tight font-medieval tracking-wider">
            {{ __('Configurações da Conta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Informações do Perfil --}}
            <div class="ark-panel p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Atualizar Senha --}}
            <div class="ark-panel p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Deletar Conta --}}
            <div class="ark-panel p-4 sm:p-8 border-red-500/30">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>