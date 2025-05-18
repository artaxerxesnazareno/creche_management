<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CriancaController;
use App\Http\Controllers\DocumentoController;
use App\Models\Turma;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/




// Rotas de Autenticação
Auth::routes();

// Rotas Protegidas
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
// Rota temporária para criar turmas de teste
Route::get('/criar-turmas-teste', function() {
    // Criar algumas turmas básicas se não existirem
    if (Turma::count() == 0) {
        Turma::create(['nome' => 'Berçário', 'descricao' => 'Turma para bebês de 0 a 1 ano', 'idade_minima' => 0, 'idade_maxima' => 1]);
        Turma::create(['nome' => 'Maternal I', 'descricao' => 'Turma para crianças de 1 a 2 anos', 'idade_minima' => 1, 'idade_maxima' => 2]);
        Turma::create(['nome' => 'Maternal II', 'descricao' => 'Turma para crianças de 2 a 3 anos', 'idade_minima' => 2, 'idade_maxima' => 3]);
        Turma::create(['nome' => 'Jardim I', 'descricao' => 'Turma para crianças de 3 a 4 anos', 'idade_minima' => 3, 'idade_maxima' => 4]);
        Turma::create(['nome' => 'Jardim II', 'descricao' => 'Turma para crianças de 4 a 5 anos', 'idade_minima' => 4, 'idade_maxima' => 5]);
    }

    return redirect()->route('criancas.create')->with('success', 'Turmas de teste criadas com sucesso!');
});

// Rotas de Crianças
Route::get('/criancas', [CriancaController::class, 'index'])->name('criancas.index');
Route::get('/criancas/create', [CriancaController::class, 'create'])->name('criancas.create');
Route::post('/criancas', [CriancaController::class, 'store'])->name('criancas.store');
Route::get('/criancas/{crianca}', [CriancaController::class, 'show'])->name('criancas.show');
Route::get('/criancas/{crianca}/edit', [CriancaController::class, 'edit'])->name('criancas.edit');
Route::put('/criancas/{crianca}', [CriancaController::class, 'update'])->name('criancas.update');
Route::delete('/criancas/{crianca}', [CriancaController::class, 'destroy'])->name('criancas.destroy');

// Rotas de Documentos
Route::get('/criancas/{crianca}/documentos/create', [DocumentoController::class, 'create'])->name('criancas.documentos.create');
Route::post('/criancas/{crianca}/documentos', [DocumentoController::class, 'store'])->name('criancas.documentos.store');
Route::get('/documentos/{documento}/download', [DocumentoController::class, 'download'])->name('documentos.download');
Route::delete('/documentos/{documento}', [DocumentoController::class, 'destroy'])->name('documentos.destroy');


    // Rotas do Sistema de Creche
    Route::prefix('admin')->middleware(['auth'])->group(function () {



    });
});
