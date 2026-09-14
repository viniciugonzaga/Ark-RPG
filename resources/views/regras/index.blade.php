{{-- resources/views/regras/index.blade.php --}}
<x-app-layout>
    <x-slot name="title">Manual do Sobrevivente - ARK RPG</x-slot>
    <meta property="og:title" content="ARK RPG - Manual do Sobrevivente" />
    <meta property="og:description" content="Regras completas do sistema ARK RPG: combate, atributos, mutações e sobrevivência. Baixe o PDF oficial." />
    <meta property="og:image" content="{{ asset('images/capa_regras.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ARK RPG - Manual do Sobrevivente" />
    <meta name="twitter:description" content="Regras completas do sistema ARK RPG. Baixe o PDF oficial." />
    <meta name="twitter:image" content="{{ asset('images/capa_regras.png') }}" />

    {{-- Fundo fixo com imagem e overlay --}}
    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/fundo_regras.png') }}" alt="Background Regras"
             class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    {{-- Conteúdo principal --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center py-12">
        <div class="max-w-5xl mx-auto px-6 w-full space-y-8">

            {{-- ============================================================ --}}
            {{-- CARD 1: Manual do Sobrevivente                               --}}
            {{-- ============================================================ --}}
            <div class="ark-panel-glossy p-8 md:p-12 text-center border border-cyan-500/30 shadow-[0_0_40px_rgba(0,242,255,0.2)] bg-black/40 backdrop-blur-sm rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>

                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-900/30 to-blue-900/30 rounded-2xl flex items-center justify-center border border-cyan-500/40 shadow-[0_0_15px_rgba(0,242,255,0.3)]">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v6h6" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl md:text-5xl font-medieval font-black uppercase tracking-widest mb-4 drop-shadow-[0_0_10px_rgba(0,242,255,0.5)]">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-blue-300">
                        Manual do Sobrevivente
                    </span>
                </h1>

                <div class="w-32 h-1 bg-cyan-400 shadow-[0_0_8px_cyan] mx-auto mb-8"></div>

                <p class="text-gray-300 mb-8 text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
                    Este documento contém todas as regras do sistema <span class="text-cyan-400 font-bold">ARK RPG</span>.
                    Leia com atenção para compreender combate, atributos, mutações e sobrevivência.
                </p>

                <div class="bg-black/50 border border-cyan-500/20 rounded-xl p-6 mb-10 inline-block w-full max-w-md backdrop-blur-sm hover:border-cyan-400/60 transition-all duration-300">
                    <p class="text-[11px] text-cyan-300 uppercase tracking-wider mb-1 flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.255 0 2.443.29 3.5.804v-10zM13.5 4c-1.255 0-2.443.29-3.5.804v10c1.057-.514 2.245-.804 3.5-.804 1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0013.5 4z"/></svg>
                        Versão do Documento
                    </p>
                    <p class="text-white font-bold text-lg tracking-wide">
                        ARK RPG - Manual Oficial v1.0
                    </p>
                </div>

                <div class="mt-2">
                    <a href="{{ route('regras.download') }}"
                       class="ark-btn-glitch inline-flex items-center gap-3 px-10 py-4 text-base no-underline group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Baixar Agora (PDF)
                    </a>
                </div>

                <p class="text-[9px] text-gray-500 mt-8 uppercase tracking-wider">
                    Sistema de regras atualizado em {{ now()->format('d/m/Y') }}
                </p>
            </div>

            {{-- ============================================================ --}}
            {{-- CARD 2: Baixar Ark Mobile (PWA)                              --}}
            {{-- ============================================================ --}}
            <div id="ark-mobile-card"
                 class="ark-panel-glossy p-8 md:p-12 text-center border border-cyan-500/30 shadow-[0_0_40px_rgba(0,242,255,0.2)] bg-black/40 backdrop-blur-sm rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-scan-line"></div>

                {{-- Ícone: celular --}}
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-900/30 to-blue-900/30 rounded-2xl flex items-center justify-center border border-cyan-500/40 shadow-[0_0_15px_rgba(0,242,255,0.3)]">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl md:text-5xl font-medieval font-black uppercase tracking-widest mb-4 drop-shadow-[0_0_10px_rgba(0,242,255,0.5)]">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-blue-300">
                        Baixar Ark Mobile
                    </span>
                </h2>

                <div class="w-32 h-1 bg-cyan-400 shadow-[0_0_8px_cyan] mx-auto mb-8"></div>

                <p class="text-gray-300 mb-8 text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
                    Leve o <span class="text-cyan-400 font-bold">ARK RPG</span> com você.
                    Instale o <strong class="text-cyan-300">Ark Mobile</strong> no seu celular para ter acesso rápido
                    às suas fichas, rolagens e mesas — <em>com ícone próprio na tela inicial</em>.
                </p>

                {{-- Card de vantagens --}}
                <div class="bg-black/50 border border-cyan-500/20 rounded-xl p-6 mb-10 w-full max-w-md mx-auto backdrop-blur-sm hover:border-cyan-400/60 transition-all duration-300 text-left">
                    <p class="text-[11px] text-cyan-300 uppercase tracking-wider mb-3 text-center">
                        Vantagens do App
                    </p>
                    <ul class="text-sm text-gray-300 space-y-2">
                        <li class="flex items-start gap-2">
                            <span class="text-cyan-400 mt-0.5">◆</span>
                            <span>Ícone próprio na tela inicial</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-cyan-400 mt-0.5">◆</span>
                            <span>Abre em tela cheia (sem barra do navegador)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-cyan-400 mt-0.5">◆</span>
                            <span>Funciona offline para páginas já visitadas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-cyan-400 mt-0.5">◆</span>
                            <span>Atalhos rápidos: Fichas, Rolagens, Criar Ficha</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-cyan-400 mt-0.5">◆</span>
                            <span class="text-cyan-300">Atualização automática a cada nova versão</span>
                        </li>
                    </ul>
                </div>

                {{-- Botões (instalar + verificar atualização) --}}
                <div class="mt-2 flex flex-col sm:flex-row gap-4 items-center justify-center">

                    {{-- Botão principal: instalar --}}
                    <button type="button" onclick="arkMobileBaixar()"
                            class="ark-btn-glitch inline-flex items-center gap-3 px-10 py-4 text-base group">
                        <svg class="w-5 h-5 transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span id="ark-mobile-btn-text">Baixar Ark Mobile</span>
                    </button>

                    {{-- Botão secundário: verificar atualização (oculto até detectar standalone) --}}
                    <button type="button"
                            onclick="arkMobileVerificarAtualizacao()"
                            id="ark-mobile-update-btn"
                            class="ark-btn-outline hidden">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span id="ark-mobile-update-text">Verificar Atualização</span>
                    </button>
                </div>

                {{-- Área de retorno / instruções --}}
                <div id="ark-mobile-status" class="mt-6 text-sm"></div>

                <p class="text-[9px] text-gray-500 mt-8 uppercase tracking-wider">
                    Compatível com Android, iPhone, Windows e Mac
                </p>
            </div>
        </div>
    </div>

    {{-- Estilos adicionais específicos para esta página --}}
    <style>
        @keyframes scan-line {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-scan-line { animation: scan-line 3s linear infinite; }

        .ark-panel-glossy {
            background: linear-gradient(165deg, rgba(26,26,26,0.9) 0%, rgba(10,10,10,0.8) 100%);
            backdrop-filter: blur(4px);
        }

        /* ─── Botão principal (glitch) ─── */
        .ark-btn-glitch {
            background: #000;
            border: 2px solid #98effb;
            border-radius: 50px;
            color: #fff;
            font-weight: 900;
            letter-spacing: 3px;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(127, 237, 254, 0.3);
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .ark-btn-glitch:hover {
            background: #91ecfc; color: #000;
            box-shadow: 0 0 30px rgba(37, 233, 233, 0.7);
            transform: translateY(-3px);
        }
        .ark-btn-glitch:hover::after {
            content: '';
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 242, 255, 0.2);
            pointer-events: none;
            animation: glitchFlash 0.2s infinite;
        }
        @keyframes glitchFlash {
            0% { opacity: 0; transform: skew(0deg); }
            20% { opacity: 0.6; transform: skew(2deg); }
            40% { opacity: 0; transform: skew(-2deg); }
            100% { opacity: 0; transform: skew(0deg); }
        }

        /* ─── Botão secundário (outline — Verificar Atualização) ─── */
        .ark-btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            background: rgba(0, 0, 0, 0.5);
            border: 1.5px solid rgba(0, 242, 255, 0.5);
            border-radius: 50px;
            color: #67e8f9;
            font-weight: 900;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
        }
        .ark-btn-outline:hover {
            background: rgba(0, 242, 255, 0.15);
            border-color: #00f2ff;
            color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.4);
            transform: translateY(-2px);
        }
        .ark-btn-outline:active {
            transform: translateY(0) scale(0.98);
        }
        .ark-btn-outline.is-checking {
            border-color: rgba(245, 158, 11, 0.7);
            color: #fbbf24;
            cursor: wait;
        }
        .ark-btn-outline.is-checking svg {
            animation: rotate 0.9s linear infinite;
        }
        @keyframes rotate {
            to { transform: rotate(360deg); }
        }

        .font-medieval { font-family: 'Cinzel', serif; }

        /* ─── Responsivo adicional ─── */
        @media (max-width: 1080px) {
            .ark-panel-glossy { border-radius: 20px; }
            .ark-panel-glossy h1, .ark-panel-glossy h2 { font-size: 2.25rem !important; letter-spacing: 0.1em !important; }
            .ark-panel-glossy .w-16.h-16 { width: 3.5rem !important; height: 3.5rem !important; }
            .ark-panel-glossy .w-16.h-16 svg { width: 1.75rem !important; height: 1.75rem !important; }
        }
        @media (max-width: 760px) {
            .ark-panel-glossy { padding: 2rem 1.25rem !important; border-radius: 16px; }
            .ark-panel-glossy h1, .ark-panel-glossy h2 { font-size: 1.85rem !important; letter-spacing: 0.08em !important; }
            .ark-panel-glossy .w-32 { width: 5rem !important; margin-bottom: 1.5rem !important; }
            .ark-panel-glossy p { font-size: 0.9rem !important; }
            .ark-panel-glossy .bg-black\/50 { padding: 1.25rem !important; }
            .ark-btn-glitch { padding: 12px 24px !important; font-size: 0.85rem !important; letter-spacing: 2px !important; }
            .ark-btn-outline { padding: 10px 18px !important; font-size: 10px !important; letter-spacing: 1.5px !important; }
        }
        @media (max-width: 480px) {
            .ark-panel-glossy { padding: 1.5rem 1rem !important; border-radius: 14px; }
            .ark-panel-glossy h1, .ark-panel-glossy h2 { font-size: 1.5rem !important; }
            .ark-panel-glossy .w-32 { width: 4rem !important; margin-bottom: 1.25rem !important; height: 3px !important; }
            .ark-panel-glossy p { font-size: 0.8rem !important; }
            .ark-panel-glossy .bg-black\/50 { padding: 1rem !important; }
            .ark-panel-glossy .bg-black\/50 p.text-lg { font-size: 0.95rem !important; }
            .ark-btn-glitch { padding: 10px 18px !important; font-size: 0.75rem !important; letter-spacing: 1.5px !important; width: 100%; justify-content: center; }
            .ark-btn-glitch svg { width: 16px !important; height: 16px !important; }
            .ark-btn-outline { padding: 9px 16px !important; font-size: 9px !important; letter-spacing: 1px !important; width: 100%; }
            .ark-panel-glossy p.text-\[9px\] { font-size: 8px !important; }
            .ark-panel-glossy .w-16.h-16 { width: 3rem !important; height: 3rem !important; }
            .ark-panel-glossy .w-16.h-16 svg { width: 1.5rem !important; height: 1.5rem !important; }
        }
        @media (max-width: 300px) {
            .ark-panel-glossy { padding: 1rem 0.75rem !important; border-radius: 12px; }
            .ark-panel-glossy h1, .ark-panel-glossy h2 { font-size: 1.15rem !important; }
            .ark-panel-glossy .w-32 { width: 3rem !important; }
            .ark-panel-glossy p { font-size: 0.7rem !important; }
            .ark-btn-glitch { padding: 8px 12px !important; font-size: 0.65rem !important; letter-spacing: 1px !important; }
            .ark-btn-outline { padding: 7px 12px !important; font-size: 8px !important; }
            .ark-panel-glossy .w-16.h-16 { width: 2.5rem !important; height: 2.5rem !important; }
            .ark-panel-glossy .w-16.h-16 svg { width: 1.25rem !important; height: 1.25rem !important; }
        }
    </style>

    {{-- Script de instalação + verificação de atualização --}}
    @push('scripts')
    <script>
        // ============================================================
        // Mostrar botão "Verificar Atualização" somente se o app
        // já está rodando como PWA (standalone)
        // ============================================================
        document.addEventListener('DOMContentLoaded', () => {
            const updateBtn = document.getElementById('ark-mobile-update-btn');
            if (!updateBtn) return;

            const isStandalone = (window.__pwaIsStandalone && window.__pwaIsStandalone());
            if (isStandalone) {
                updateBtn.classList.remove('hidden');
            }
        });

        // ============================================================
        // INSTALAR — função principal do botão "Baixar Ark Mobile"
        // ============================================================
        function arkMobileBaixar() {
            const statusEl = document.getElementById('ark-mobile-status');
            const btnText  = document.getElementById('ark-mobile-btn-text');

            // 1. Já está instalado?
            if (window.__pwaIsStandalone && window.__pwaIsStandalone()) {
                statusEl.innerHTML = `
                    <div style="max-width:440px; margin:0 auto; padding:14px 18px;
                                background:rgba(0,242,255,0.08); border-radius:12px;
                                border:1px solid rgba(0,242,255,0.4);">
                        <p style="color:#00f2ff; font-weight:900; text-transform:uppercase;
                                  letter-spacing:2px; font-size:11px; margin:0 0 6px;">
                            ✓ Já Instalado
                        </p>
                        <p style="color:#d1d5db; font-size:13px; margin:0;">
                            O <strong>Ark Mobile</strong> já está instalado neste dispositivo.
                            Procure o ícone na tela inicial.
                        </p>
                    </div>
                `;
                return;
            }

            // 2. iPhone?
            if (window.__pwaIsIOS && window.__pwaIsIOS()) {
                statusEl.innerHTML = `
                    <div style="max-width:440px; margin:0 auto; padding:18px 20px;
                                background:rgba(0,0,0,0.55); border-radius:14px;
                                border:1px solid rgba(0,242,255,0.4); text-align:left;">
                        <p style="color:#00f2ff; font-weight:900; text-transform:uppercase;
                                  letter-spacing:2px; font-size:11px; margin:0 0 12px; text-align:center;">
                            Instalação no iPhone
                        </p>
                        <ol style="color:#d1d5db; font-size:13px; line-height:1.9;
                                   padding-left:22px; margin:0;">
                            <li>Toque em <strong style="color:#00f2ff;">Compartilhar</strong> ⎙ (embaixo, no meio do Safari)</li>
                            <li>Role e toque em <strong style="color:#00f2ff;">"Adicionar à Tela de Início"</strong></li>
                            <li>Toque em <strong style="color:#00f2ff;">Adicionar</strong> no canto superior direito</li>
                        </ol>
                        <p style="color:#94a3b8; font-size:12px; margin:12px 0 0; text-align:center;">
                            Pronto! O ícone aparecerá junto com seus outros apps.
                        </p>
                    </div>
                `;
                return;
            }

            // 3. Android/Desktop — tenta o prompt
            if (window.__pwaDeferredPrompt) {
                btnText.textContent = 'Baixando...';
                statusEl.innerHTML = `
                    <div style="display:flex; align-items:center; justify-content:center; gap:12px;">
                        <div style="width:20px; height:20px; border:3px solid rgba(0,242,255,0.25);
                                    border-top-color:#00f2ff; border-radius:50%;
                                    animation:pwa-spin 0.8s linear infinite;"></div>
                        <span style="color:#00f2ff; font-size:13px;">Preparando instalação...</span>
                    </div>
                    <style>@keyframes pwa-spin { to { transform: rotate(360deg); } }</style>
                `;

                window.__pwaTriggerInstall().then(({ outcome }) => {
                    btnText.textContent = 'Baixar Ark Mobile';

                    if (outcome === 'accepted') {
                        statusEl.innerHTML = `
                            <div style="max-width:440px; margin:0 auto; padding:14px 18px;
                                        background:rgba(0,242,255,0.08); border-radius:12px;
                                        border:1px solid rgba(0,242,255,0.4);">
                                <p style="color:#00f2ff; font-weight:900; text-transform:uppercase;
                                          letter-spacing:2px; font-size:11px; margin:0 0 6px;">
                                    ✓ Instalado com Sucesso!
                                </p>
                                <p style="color:#d1d5db; font-size:13px; margin:0;">
                                    Procure o ícone do <strong>ARK RPG</strong> na sua tela inicial.
                                </p>
                            </div>
                        `;
                    } else if (outcome === 'dismissed') {
                        statusEl.innerHTML = `
                            <p style="color:#94a3b8; font-size:13px; margin:0;">
                                Instalação cancelada. Você pode tentar novamente quando quiser.
                            </p>
                        `;
                    } else {
                        statusEl.innerHTML = `
                            <p style="color:#f59e0b; font-size:13px; margin:0;">
                                Não foi possível iniciar a instalação. Tente pelo menu do navegador (⋮ → Instalar aplicativo).
                            </p>
                        `;
                    }
                });
                return;
            }

            // 4. Sem prompt disponível
            btnText.textContent = 'Aguardando...';
            statusEl.innerHTML = `
                <div style="max-width:440px; margin:0 auto; padding:14px 18px;
                            background:rgba(0,0,0,0.5); border-radius:12px;
                            border:1px solid rgba(245,158,11,0.4);">
                    <p style="color:#f59e0b; font-size:13px; margin:0;">
                        O sistema ainda está se preparando. Tente novamente em alguns segundos.
                    </p>
                </div>
            `;

            // Tenta de novo por até 5s
            let tentativas = 0;
            const retry = setInterval(() => {
                tentativas++;
                if (window.__pwaDeferredPrompt) {
                    clearInterval(retry);
                    btnText.textContent = 'Baixar Ark Mobile';
                    arkMobileBaixar();
                } else if (tentativas >= 10) {
                    clearInterval(retry);
                    btnText.textContent = 'Baixar Ark Mobile';
                    statusEl.innerHTML = `
                        <div style="max-width:440px; margin:0 auto; padding:14px 18px;
                                    background:rgba(0,0,0,0.5); border-radius:12px;
                                    border:1px solid rgba(148,163,184,0.4);">
                            <p style="color:#d1d5db; font-size:13px; margin:0;">
                                Seu navegador não permite instalação automática.<br>
                                Tente pelo <strong style="color:#00f2ff;">Chrome</strong> (Android),
                                <strong style="color:#00f2ff;">Edge</strong> (Windows) ou
                                <strong style="color:#00f2ff;">Safari</strong> (iPhone).
                            </p>
                        </div>
                    `;
                }
            }, 500);
        }

        // ============================================================
        // VERIFICAR ATUALIZAÇÃO — checa se o SW tem versão nova
        // ============================================================
        async function arkMobileVerificarAtualizacao() {
            const statusEl = document.getElementById('ark-mobile-status');
            const updateBtn = document.getElementById('ark-mobile-update-btn');
            const updateText = document.getElementById('ark-mobile-update-text');

            if (!('serviceWorker' in navigator)) {
                statusEl.innerHTML = `
                    <p style="color:#f59e0b; font-size:13px; margin:0;">
                        Seu navegador não suporta atualização automática de PWA.
                    </p>
                `;
                return;
            }

            // Estado visual: "checando"
            updateBtn.classList.add('is-checking');
            updateText.textContent = 'Verificando...';
            statusEl.innerHTML = `
                <p style="color:#94a3b8; font-size:13px; margin:0;">
                    Consultando o servidor por uma versão mais recente...
                </p>
            `;

            try {
                const reg = await navigator.serviceWorker.getRegistration();

                if (!reg) {
                    updateBtn.classList.remove('is-checking');
                    updateText.textContent = 'Verificar Atualização';
                    statusEl.innerHTML = `
                        <p style="color:#94a3b8; font-size:13px; margin:0;">
                            O app ainda não está instalado neste dispositivo.
                        </p>
                    `;
                    return;
                }

                // Força o navegador a buscar o sw.js atualizado
                await reg.update();

                // Pequeno delay para o SW processar
                await new Promise(r => setTimeout(r, 800));

                updateBtn.classList.remove('is-checking');
                updateText.textContent = 'Verificar Atualização';

                // Há um worker novo esperando para ativar?
                if (reg.waiting) {
                    statusEl.innerHTML = `
                        <div style="max-width:440px; margin:0 auto; padding:18px 20px;
                                    background:rgba(0,242,255,0.08); border-radius:14px;
                                    border:1px solid rgba(0,242,255,0.5);">
                            <p style="color:#00f2ff; font-weight:900; text-transform:uppercase;
                                      letter-spacing:2px; font-size:11px; margin:0 0 8px; text-align:center;">
                                ⟳ Nova Versão Disponível!
                            </p>
                            <p style="color:#d1d5db; font-size:13px; margin:0 0 14px; text-align:center;">
                                Uma atualização do <strong>ARK RPG</strong> foi baixada.
                                Toque abaixo para aplicar e reiniciar.
                            </p>
                            <div style="text-align:center;">
                                <button type="button"
                                        onclick="arkMobileAplicarAtualizacao()"
                                        class="ark-btn-glitch"
                                        style="padding:10px 24px; font-size:11px;">
                                    Aplicar e Reiniciar
                                </button>
                            </div>
                        </div>
                    `;
                    return;
                }

                // Está instalando? (baixando worker novo)
                if (reg.installing) {
                    statusEl.innerHTML = `
                        <p style="color:#00f2ff; font-size:13px; margin:0;">
                            ⟳ Baixando atualização... aguarde um instante.
                        </p>
                    `;
                    return;
                }

                // Sem novidade
                statusEl.innerHTML = `
                    <div style="max-width:440px; margin:0 auto; padding:14px 18px;
                                background:rgba(34,197,94,0.08); border-radius:12px;
                                border:1px solid rgba(34,197,94,0.4);">
                        <p style="color:#4ade80; font-weight:900; text-transform:uppercase;
                                  letter-spacing:2px; font-size:11px; margin:0 0 6px;">
                            ✓ Tudo Atualizado
                        </p>
                        <p style="color:#d1d5db; font-size:13px; margin:0;">
                            Você já está na versão mais recente do <strong>ARK RPG</strong>.
                        </p>
                    </div>
                `;
            } catch (err) {
                console.warn('[PWA] Erro ao verificar atualização:', err);
                updateBtn.classList.remove('is-checking');
                updateText.textContent = 'Verificar Atualização';
                statusEl.innerHTML = `
                    <p style="color:#f59e0b; font-size:13px; margin:0;">
                        Não foi possível verificar agora. Verifique sua conexão e tente novamente.
                    </p>
                `;
            }
        }

        // ============================================================
        // APLICAR ATUALIZAÇÃO — avisa o SW para assumir e recarrega
        // ============================================================
        function arkMobileAplicarAtualizacao() {
            const statusEl = document.getElementById('ark-mobile-status');

            statusEl.innerHTML = `
                <div style="display:flex; align-items:center; justify-content:center; gap:12px;">
                    <div style="width:20px; height:20px; border:3px solid rgba(0,242,255,0.25);
                                border-top-color:#00f2ff; border-radius:50%;
                                animation:pwa-spin 0.8s linear infinite;"></div>
                    <span style="color:#00f2ff; font-size:13px;">Aplicando atualização...</span>
                </div>
                <style>@keyframes pwa-spin { to { transform: rotate(360deg); } }</style>
            `;

            navigator.serviceWorker.getRegistration().then((reg) => {
                if (reg && reg.waiting) {
                    // Avisa o SW para pular a fase de espera
                    reg.waiting.postMessage('SKIP_WAITING');
                }
                // Aguarda a troca do controller e recarrega
                setTimeout(() => {
                    window.location.reload();
                }, 600);
            }).catch(() => {
                // Se algo falhar, recarrega mesmo assim
                setTimeout(() => window.location.reload(), 400);
            });
        }
    </script>
    @endpush
</x-app-layout>