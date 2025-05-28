<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtividadeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Redirecionamento da rota /
|--------------------------------------------------------------------------
| Se o usuário estiver logado, vai para /atividades.
| Se não estiver logado, vai para /login.
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('atividades.index')
        : redirect()->route('login');
});

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Atividades
    Route::resource('atividades', AtividadeController::class);

    // Atividades finalizadas por data
    Route::get('/atividades-finalizadas', [AtividadeController::class, 'finalizadas'])->name('atividades.finalizadas');
});

require __DIR__.'/auth.php';
