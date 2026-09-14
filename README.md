# Ark RPG

Plataforma web para gerenciamento de campanhas, personagens e sessões de um RPG inspirado no universo de sobrevivência, evolução e exploração de **ARK: Survival Evolved**.

> Projeto independente criado por fã. ARK: Survival Evolved e seus elementos relacionados pertencem aos respectivos criadores e detentores de direitos.

**Aplicação publicada:** [rpgark.com.br](https://rpgark.com.br)

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?logo=vite&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-06B6D4?logo=tailwindcss&logoColor=white)

## Sumário

- [Visão geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Stack](#stack)
- [Arquitetura](#arquitetura)
- [Instalação local](#instalação-local)
- [Configuração](#configuração)
- [Módulos](#módulos)
- [Rotas](#rotas)
- [Modelo de dados](#modelo-de-dados)
- [Segurança e autorização](#segurança-e-autorização)
- [Frontend e assets](#frontend-e-assets)
- [Deploy](#deploy)
- [Testes](#testes)
- [Limitações conhecidas](#limitações-conhecidas)
- [Status](#status)

## Visão geral

O Ark RPG centraliza fichas, rolagens, eventos, jogadores e sessões de mesa em uma aplicação Laravel. A interface foi criada com identidade visual própria, inspirada na estética tecnológica e selvagem de ARK.

A organização segue MVC:

- **Models** representam usuários, fichas, componentes de ficha, rolagens e sessões.
- **Controllers** concentram os fluxos HTTP e regras de negócio.
- **Views Blade** renderizam páginas e componentes.
- **Routes** separam áreas públicas, autenticadas e de mestre.
- **Migrations** versionam o banco.
- **Middleware** protegem autenticação, verificação de e-mail e CSRF.

## Funcionalidades

### Contas

- Cadastro, login e logout.
- Verificação e reenvio de verificação de e-mail.
- Recuperação, redefinição e alteração de senha.
- Confirmação de senha e exclusão da conta.
- Perfil com foto/avatar.
- `crystal_id` público gerado para cada usuário.

O fluxo usa Laravel Breeze e está em `routes/auth.php` e `app/Http/Controllers/Auth`.

### Fichas de personagem

- CRUD completo de fichas.
- Nome, nível, idade, origem, peculiaridade e lore.
- Imagem do personagem e imagem de fundo.
- Atributos e status de personagem.
- Mutações, bônus, poderes de sobrevivente e rituais.
- Arsenal armazenado como estrutura JSON/array.
- Fixar e desafixar fichas.
- Compartilhamento por código.
- Resgate/cópia de ficha compartilhada.
- Referência à ficha e ao personagem de origem.

O fluxo principal está em `CharacterController`; as views ficam em `resources/views/fichas`.

### Rolagens e eventos

- Rolagem de dados no frontend.
- Uso de ficha, atributos e bônus.
- Resultado de evento aleatório.
- Carregamento de personagem em JSON.
- Salvamento do último resultado.
- Cadastro e atualização de armas no arsenal.
- Eventos configurados em `config/eventos.php`, incluindo categorias de sobrevivência, efeitos, minérios, raridades, drops, traumas, joias, circuitos e crimes.

O comportamento atual salva o último registro de rolagem por usuário; não representa um histórico completo e imutável de todas as jogadas.

### Mesa do mestre

Usuários com `users.cargo = mestre` podem abrir a mesa, buscar jogadores por `crystal_id`, criar sessões, consultar participantes, acompanhar resultados e encerrar sessões.

### Sessões em tempo real

Jogadores entram com um código, consultam sua sessão ativa e podem sair dela. A mesa recebe atualizações por **Server-Sent Events (SSE)** em `/sessao/stream`, com polling interno e heartbeat. A tabela intermediária impede o mesmo usuário de entrar duas vezes na mesma sessão.

### Manual de regras

- Página pública: `/regras`.
- Download: `/regras/download`.
- Nome enviado ao navegador: `Manual-Ark-RPG.pdf`.
- O controller espera o arquivo `public/pdfs/manual-ark.pdf`.

No workspace atual existem `public/pdfs/Manual-Ark-RPG.pdf` e `public/pdfs/manual.pdf`, mas não `manual-ark.pdf`. Portanto, o download precisa ter o arquivo alinhado ao nome esperado antes de ser considerado funcional.

### Minijogo e PWA

- `/jogo` contém o minijogo.
- `/dino-record` salva e consulta o recorde do usuário autenticado.
- `public/manifest.webmanifest`, `public/sw.js` e `public/icons` fornecem a base PWA.
- `/offline` fornece a view de contingência.

## Stack

### Backend

- PHP `^8.2`.
- Laravel Framework `^12.0`.
- Laravel Breeze `^2.4`.
- Laravel Tinker `^2.10.1`.
- Eloquent ORM e migrations.
- Pest `^3.8` e PHPUnit.
- `resend/resend-php` `^1.3`, disponível para integração de e-mail.

### Frontend

- Blade.
- JavaScript modular.
- Alpine.js.
- Tailwind CSS `^3.1`.
- Vite `^7.0.7`.
- Laravel Vite Plugin.
- Axios, PostCSS e Autoprefixer.

### Infraestrutura publicada

A configuração registrada para produção utiliza Hostinger, domínio no Registro.br, SSL, MySQL externo e deploy manual com arquivos públicos direcionados para `public_html`. Credenciais e detalhes do painel não fazem parte do repositório.

## Arquitetura

```text
Ark-RPG/
├── app/
│   ├── Http/Controllers/       # Controllers web e autenticação
│   ├── Http/Requests/          # Validações reutilizáveis
│   ├── Http/ViewComposers/     # Dados compartilhados com views
│   ├── Models/                 # Entidades Eloquent
│   └── View/Components/        # Componentes Blade
├── bootstrap/cache/            # Cache gerado pelo Laravel
├── config/eventos.php          # Eventos aleatórios
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── build/                  # Saída do Vite
│   ├── images/                 # Imagens, sprites e fundos
│   ├── icons/                  # Ícones PWA
│   ├── pdfs/                   # Manuais
│   ├── manifest.webmanifest
│   └── sw.js
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/web.php
├── routes/auth.php
├── storage/
├── tests/
├── composer.json
├── package.json
└── vite.config.js
```

## Requisitos

- PHP 8.2+.
- Composer.
- Node.js e npm compatíveis com Vite 7.
- SQLite ou MySQL.
- Extensões PHP exigidas pelo Laravel e dependências.
- Permissão de escrita em `storage`, `bootstrap/cache` e diretórios de upload.

No Windows, OneDrive ou outro sincronizador pode reaplicar o atributo somente leitura. Se `package:discover` falhar, confirme `is_writable('bootstrap/cache')` e remova o atributo com `attrib -R bootstrap\cache /S /D`.

## Instalação local

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
npm install
npm run build
php artisan storage:link
php artisan serve
```

No Prompt de Comando, use `copy .env.example .env` no lugar de `Copy-Item`.

### Banco SQLite

O `.env.example` usa SQLite:

```env
DB_CONNECTION=sqlite
```

Crie o arquivo e execute as migrations:

```powershell
New-Item database\database.sqlite -ItemType File -Force
php artisan migrate
```

### Banco MySQL

Configure no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

Depois:

```powershell
php artisan migrate
```

### Desenvolvimento completo

```powershell
composer run dev
```

O script inicia `php artisan serve`, o listener de fila, Laravel Pail e `npm run dev` simultaneamente. Para executar somente o Vite com hot reload, use `npm run dev` em outro terminal.

## Configuração

As variáveis disponíveis estão em `.env.example`.

| Grupo | Variáveis principais |
| --- | --- |
| Aplicação | `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL`, `APP_LOCALE` |
| Banco | `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` |
| Sessão | `SESSION_DRIVER`, `SESSION_LIFETIME`, `SESSION_DOMAIN` |
| Cache/fila | `CACHE_STORE`, `QUEUE_CONNECTION` |
| Arquivos | `FILESYSTEM_DISK` |
| E-mail | `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS` |
| Frontend | `VITE_APP_NAME` |

O exemplo usa `MAIL_MAILER=log`, apropriado para desenvolvimento. Verificação de e-mail e recuperação de senha exigem um mailer real em produção. O pacote Resend está instalado, mas sua ativação depende da configuração do ambiente.

## Comandos úteis

```powershell
composer run setup                 # Instalação completa definida no composer.json
composer run dev                   # Servidor, fila, logs e Vite
composer run test                  # Limpa config e executa testes
php artisan serve                  # Servidor HTTP local
php artisan route:list              # Rotas registradas
php artisan migrate:status         # Estado das migrations
php artisan migrate                 # Executa migrations
php artisan migrate:fresh --seed   # Recria o banco local; destrutivo
php artisan optimize:clear         # Limpa caches Laravel
php artisan storage:link            # Link de armazenamento público
composer dump-autoload             # Recria autoload e dispara scripts Composer
npm run dev                        # Vite com hot reload
npm run build                      # Build de produção
php artisan test                   # Testes
```

## Módulos e arquivos principais

| Arquivo/módulo | Responsabilidade |
| --- | --- |
| `HomeController` | Página inicial |
| `CharacterController` | Fichas, uploads, compartilhamento, resgate e fixação |
| `RollController` | Fichas para rolagem, resultados e arsenal |
| `MasterController` | Mesa, busca, participantes e encerramento |
| `SessionController` | Entrada, saída, consulta e SSE |
| `RegraController` | Página e download do manual |
| `MediaController` | Entrega de mídias |
| `ProfileController` | Perfil Breeze, avatar, senha e conta |
| `PerfilController` | Perfil simplificado |
| `DinoController` | Recorde do minijogo |
| `resources/views/fichas` | Views do CRUD de fichas |
| `resources/views/rolagens` | Interface de rolagens |
| `resources/views/master` | Mesa e sessão do mestre |
| `resources/views/session` | Entrada e sessão do jogador |
| `resources/views/auth` | Telas de autenticação |
| `resources/views/regras` | Manual |

## Rotas

Use `php artisan route:list` para conferir a assinatura exata do ambiente atual.

### Públicas

| Método | URI | Identificação |
| --- | --- | --- |
| `GET` | `/` | Página inicial, nome `home` |
| `GET` | `/regras` | Página de regras, nome `regras` |
| `GET` | `/regras/download` | Download, nome `regras.download` |
| `GET` | `/offline` | View offline |
| `GET` | `/jogo` | Minijogo |
| `GET` | `/media/{path}` | Entrega de mídia |

O projeto também possui rotas de manutenção/diagnóstico como `/criar-link-storage`, `/limpar-cache` e `/test-419`. Elas devem ser protegidas ou removidas em produção.

### Fichas

Todas exigem `auth` e `verified`:

| Método | URI | Operação |
| --- | --- | --- |
| `GET` | `/fichas` | Listar |
| `GET` | `/fichas/create` | Formulário |
| `POST` | `/fichas` | Criar |
| `GET` | `/fichas/{ficha}` | Visualizar |
| `GET` | `/fichas/{ficha}/edit` | Editar |
| `PUT/PATCH` | `/fichas/{ficha}` | Atualizar |
| `DELETE` | `/fichas/{ficha}` | Excluir |
| `POST` | `/fichas/{ficha}/share` | Compartilhar |
| `POST` | `/fichas/resgatar` | Resgatar |
| `POST` | `/fichas/{ficha}/pin` | Fixar/desafixar |

### Rolagens

Também exigem `auth` e `verified`:

| Método | URI | Operação |
| --- | --- | --- |
| `GET` | `/rolagens` | Interface |
| `GET` | `/rolagens/char/{id}` | Ficha em JSON |
| `POST` | `/rolagens/save` | Último resultado |
| `POST` | `/rolagens/arma/salvar` | Arsenal |

### Perfil, jogo e recorde

| Método | URI | Operação |
| --- | --- | --- |
| `GET` | `/perfil` | Perfil da aplicação |
| `GET` | `/profile` | Perfil Breeze |
| `PATCH` | `/profile` | Atualizar perfil |
| `DELETE` | `/profile` | Excluir conta |
| `GET` | `/dino-record` | Consultar recorde |
| `POST` | `/dino-record` | Salvar recorde |

### Mestre

Exigem autenticação; o controller verifica `cargo = mestre`:

| Método | URI | Operação |
| --- | --- | --- |
| `GET` | `/mestre/mesa` | Abrir mesa |
| `GET` | `/mestre/buscar/{crystalId}` | Buscar jogador |
| `POST` | `/mestre/criar-mesa` | Criar sessão |
| `GET` | `/mestre/sessao/{code}` | Abrir sessão |
| `GET` | `/mestre/sessao/{code}/participantes` | Listar participantes |
| `POST` | `/mestre/sessao/{code}/encerrar` | Encerrar sessão |

### Sessão de jogador

| Método | URI | Operação |
| --- | --- | --- |
| `GET` | `/sessao/entrar` | Formulário |
| `POST` | `/sessao/entrar` | Entrar por código |
| `GET` | `/sessao/minha-sessao` | Consultar sessão |
| `GET` | `/sessao/stream` | Stream SSE |
| `POST` | `/sessao/sair` | Sair |

As rotas de autenticação Breeze incluem registro, login, logout, verificação de e-mail, recuperação de senha, confirmação e atualização de senha em `routes/auth.php`.

## Modelo de dados

### `User` / `users`

Conta autenticada, com nome, e-mail, senha, `email_verified_at`, `crystal_id`, `cargo`, foto e recorde do minijogo. Possui muitas fichas e gera o `crystal_id` no evento `creating`.

### `Character` / `fichas`

Ficha pertencente a um usuário. Contém identificação, imagens, nível, idade, origem, peculiaridade, lore, arsenal, atributos, status, compartilhamento, pin e referências de origem. Relaciona-se com `User`, `Mutation`, `Bonus`, `SurvivorPower` e `Ritual`.

### Componentes de ficha

- `Mutation` / `mutations`.
- `Bonus` / `bonuses`.
- `SurvivorPower` / `survivor_powers`.
- `Ritual` / `rituals`.

### Rolagens e sessões

- `RollLog` / `roll_logs`: usuário, ficha, resultado dos dados e evento.
- `Rolagem`: modelo separado com `ficha_id`, `dados` e `evento`.
- `Session` / `game_sessions`: sessão e usuário mestre.
- `SessionParticipant` / `game_session_participants`: participantes.

### Infraestrutura Laravel

O schema também inclui `sessions`, `password_reset_tokens`, `cache` e `cache_locks`, conforme migrations e configuração do ambiente.

## Segurança e autorização

- Guard padrão `web`.
- CSRF nos formulários protegidos.
- Fichas, rolagens, perfil e recorde usam `auth` e `verified`.
- Mesa e sessões usam autenticação.
- Mestre é identificado pelo campo `users.cargo`, sem guard separado.
- Propriedade de ficha é verificada comparando `user_id` com o usuário autenticado.
- Não foram encontrados Policies ou Gates específicos; as regras estão nos controllers.

Ao evoluir o projeto, regras sensíveis devem ser centralizadas em Policies/Gates e as rotas de manutenção devem ser protegidas ou removidas do ambiente público.

## Frontend e assets

`vite.config.js` compila `resources/css/app.css` e `resources/js/app.js` usando `laravel-vite-plugin`. O frontend combina Blade, Tailwind, Alpine.js, Axios e JavaScript próprio.

- `public/images`: fundos, cartas, sprites e imagens temáticas.
- `public/img`: logo e imagens auxiliares.
- `public/pdfs`: manuais.
- `public/icons`: ícones PWA.
- `public/build`: saída compilada.
- `public/storage`: armazenamento público/link simbólico.

## Deploy

1. Configure `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` e uma `APP_KEY` segura.
2. Configure MySQL, sessão, cache, fila, filesystem e mailer.
3. Execute `composer install --no-dev --optimize-autoloader`.
4. Gere ou publique os assets com `npm run build`.
5. Execute `php artisan migrate --force` depois de validar backup.
6. Garanta escrita em `storage` e `bootstrap/cache`.
7. Execute `php artisan storage:link` quando suportado.
8. Aponte o document root para `public` ou publique corretamente o conteúdo público em `public_html`.
9. Confirme HTTPS, assets, uploads, e-mail e download do manual.
10. Restrinja endpoints de manutenção e diagnóstico.

A infraestrutura registrada do projeto usa Hostinger e domínio no Registro.br. Segredos, credenciais e dados do painel nunca devem ser commitados.

## Testes

Os testes ficam em `tests/Feature` e `tests/Unit`, usando Pest, PHPUnit e a configuração de `phpunit.xml`. O ambiente de teste utiliza SQLite em memória.

```powershell
php artisan test
composer run test
```

Integrações que dependem de MySQL, mailer real, serviços externos ou arquivos da hospedagem precisam de validação específica além da suíte local.

## Limitações conhecidas

- **Download do manual:** o controller espera `public/pdfs/manual-ark.pdf`, mas o workspace possui `Manual-Ark-RPG.pdf` e `manual.pdf`; alinhar o nome é necessário.
- **PDF de ficha:** há parciais Blade com aparência de PDF, mas não há biblioteca, rota ou chamada backend confirmada para exportar uma ficha.
- **Histórico:** o fluxo atual salva o último `RollLog`, não um histórico completo.
- **Perfis:** `/perfil` e `/profile` são áreas parcialmente sobrepostas.
- **Autorização:** não há Policies/Gates específicos.
- **Rotas de manutenção:** limpeza de cache, criação de link e diagnóstico precisam de revisão para produção.
- **Migrations:** há migrations defensivas/duplicadas para alguns campos e uma migration em caminho incomum dentro de `database/migrations/database`; revisar antes de reconstruir o banco.
- **SSE:** o stream tem duração limitada e polling interno; não é um sistema de broadcasting persistente.
- **E-mail:** o exemplo usa `MAIL_MAILER=log`; produção exige um mailer real.

## Status

O projeto possui uma base funcional para autenticação, fichas, componentes de personagem, rolagens, eventos, sessões de mesa, perfil, minijogo, manual e PWA. Continua em expansão, com próximos pontos naturais de consolidação em autorização, PDF de ficha, histórico de rolagens, migrations, perfis e alinhamento do arquivo do manual.

## Créditos

Ark RPG é um projeto independente criado por fã para adaptação e uso em RPG. Os direitos sobre ARK: Survival Evolved permanecem com seus respectivos detentores.
