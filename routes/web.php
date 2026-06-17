<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\RollController;
use App\Http\Controllers\RegraController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Regras
Route::get('/regras', [RegraController::class, 'index'])->name('regras');
Route::get('/regras/download', [RegraController::class, 'download'])->name('regras.download');

// Rotas protegidas (auth + verificação de email)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::resource('fichas', CharacterController::class);

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
});

Route::get('/test-419', function () {
    // Força um TokenMismatchException
    throw new \Illuminate\Session\TokenMismatchException();
});

Route::get('/ping', function () {
    return response()->json(['status' => 'ok']);
})->middleware('auth'); // se suas fichas forem protegidas por autenticação

// Rotas do Mestre (apenas autenticado, com verificação de cargo dentro do controller)
Route::middleware(['auth'])->prefix('mestre')->name('master.')->group(function () {
    Route::get('/mesa', [MasterController::class, 'index'])->name('mesa');
    Route::get('/buscar/{crystalId}', [MasterController::class, 'buscarJogador'])->name('buscar.jogador');
    Route::post('/criar-mesa', [MasterController::class, 'criarMesa'])->name('criar.mesa');
    Route::get('/sessao/{code}', [MasterController::class, 'showSessao'])->name('sessao');
    Route::get('/sessao/{code}/participantes', [MasterController::class, 'getParticipantesComRolagens'])->name('sessao.participantes');
    Route::post('/sessao/{code}/encerrar', [MasterController::class, 'encerrarMesa'])->name('encerrar.mesa');

});

// Rotas de Sessão para jogadores (autenticado)
Route::middleware(['auth'])->prefix('sessao')->name('session.')->group(function () {
    Route::get('/entrar', [SessionController::class, 'entrarForm'])->name('entrar.form');
    Route::post('/entrar', [SessionController::class, 'entrar'])->name('entrar');
    Route::get('/minha-sessao', [SessionController::class, 'getMinhaSessao'])->name('minha');
    Route::post('/sair', [SessionController::class, 'sair'])->name('sair');
});

require __DIR__ . '/auth.php';