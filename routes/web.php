<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\RollController;
use App\Http\Controllers\RegraController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DinoController;
use Illuminate\Support\Facades\Route;

// =====================================================
// ROTAS PÚBLICAS (sem autenticação e SEM SESSÃO)
// =====================================================
Route::get('/media/{path}', [MediaController::class, 'show'])
    ->where('path', '.*')
    ->name('media.show')
    ->withoutMiddleware([
        \App\Http\Middleware\StartSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ]);

// =====================================================
// ROTAS PÚBLICAS (com sessão, mas sem autenticação)
// =====================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/regras', [RegraController::class, 'index'])->name('regras');
Route::get('/regras/download', [RegraController::class, 'download'])->name('regras.download');

Route::get('/jogo', function () {
    return view('jogo');
})->name('jogo');

// =====================================================
// ROTAS PROTEGIDAS (autenticação + verificação de email)
// =====================================================

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::resource('fichas', CharacterController::class);

    // NOVAS ROTAS PARA COMPARTILHAMENTO
    Route::post('/fichas/{ficha}/share', [CharacterController::class, 'share'])->name('fichas.share');
    Route::post('/fichas/resgatar', [CharacterController::class, 'resgatar'])->name('fichas.resgatar');

    Route::prefix('rolagens')->name('rolagens.')->group(function () {
        Route::get('/', [RollController::class, 'index'])->name('index');
        Route::get('/char/{id}', [RollController::class, 'loadCharacter'])->name('load');
        Route::post('/save', [RollController::class, 'saveRoll'])->name('save');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::post('/dino-record', [DinoController::class, 'saveRecord'])->name('dino.record');
    Route::get('/dino-record', [DinoController::class, 'getRecord'])->name('dino.record.get');
});

// Rotas do Mestre
Route::middleware(['auth'])->prefix('mestre')->name('master.')->group(function () {
    Route::get('/mesa', [MasterController::class, 'index'])->name('mesa');
    Route::get('/buscar/{crystalId}', [MasterController::class, 'buscarJogador'])->name('buscar.jogador');
    Route::post('/criar-mesa', [MasterController::class, 'criarMesa'])->name('criar.mesa');
    Route::get('/sessao/{code}', [MasterController::class, 'showSessao'])->name('sessao');
    Route::get('/sessao/{code}/participantes', [MasterController::class, 'getParticipantesComRolagens'])->name('sessao.participantes');
    Route::post('/sessao/{code}/encerrar', [MasterController::class, 'encerrarMesa'])->name('encerrar.mesa');
});

// Rotas de Sessão para jogadores
Route::middleware(['auth'])->prefix('sessao')->name('session.')->group(function () {
    Route::get('/entrar', [SessionController::class, 'entrarForm'])->name('entrar.form');
    Route::post('/entrar', [SessionController::class, 'entrar'])->name('entrar');
    Route::get('/minha-sessao', [SessionController::class, 'getMinhaSessao'])->name('minha');
    Route::post('/sair', [SessionController::class, 'sair'])->name('sair');
});

// =====================================================
// ROTAS DE TESTE
// =====================================================
Route::get('/criar-link-storage', function () {
    try {
        Artisan::call('storage:link');
        return '✅ Link simbólico do storage criado com sucesso!';
    } catch (\Exception $e) {
        return '❌ Erro: ' . $e->getMessage();
    }
});

Route::get('/limpar-cache', function () {
    try {
        Artisan::call('optimize:clear');
        return '✅ Cache do Laravel limpo com sucesso!';
    } catch (\Exception $e) {
        return '❌ Erro: ' . $e->getMessage();
    }
});
Route::get('/dump-autoload', function () {
    exec('composer dump-autoload');
    return 'Autoload recarregado!';
});
Route::get('/test-419', function () {
    throw new \Illuminate\Session\TokenMismatchException();
});

Route::get('/ping', function () {
    return response()->json(['status' => 'ok']);
})->middleware('auth');

require __DIR__ . '/auth.php';
//https://rpgark.com.br/limpar-cache
//https://rpgark.com.br/criar-link-storage
//https://rpgark.com.br/dump-autoload