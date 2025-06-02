<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CriancaController;
use App\Http\Controllers\DocumentoController;
use App\Models\Turma;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\ResponsavelController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/




// Rotas de Autenticação
Auth::routes();

// Rotas Protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rota temporária para criar turmas de teste
    Route::get('/criar-turmas-teste', function () {
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

    // Rotas de presenças
    Route::get('/presencas', [PresencaController::class, 'index'])->name('presenca.index');
    Route::get('/presencas/criar', [PresencaController::class, 'create'])->name('presenca.create');
    Route::post('/presencas', [PresencaController::class, 'store'])->name('presenca.store');
    Route::get('/presencas/{crianca}/historico', [PresencaController::class, 'historico'])->name('presenca.historico');
    Route::get('/presencas/relatorio', [PresencaController::class, 'relatorio'])->name('presenca.relatorio');
    Route::get('/criancas/{crianca}/registrar-entrada', [PresencaController::class, 'registrarEntrada'])->name('presenca.registrar-entrada');
    Route::post('/criancas/{crianca}/registrar-entrada', [PresencaController::class, 'salvarEntrada'])->name('presenca.salvar-entrada');
    Route::get('/criancas/{crianca}/registrar-saida', [PresencaController::class, 'registrarSaida'])->name('presenca.registrar-saida');
    Route::post('/criancas/{crianca}/registrar-saida', [PresencaController::class, 'salvarSaida'])->name('presenca.salvar-saida');

    // Novas rotas AJAX para registro de entrada e saída via modal
    Route::post('/presenca/{crianca}/entrada', [PresencaController::class, 'processarEntrada'])->name('presenca.ajax.entrada');
    Route::post('/presenca/{crianca}/saida', [PresencaController::class, 'processarSaida'])->name('presenca.ajax.saida');

    // Rotas de Responsáveis (modificadas para corrigir o erro de parâmetro)
Route::get('/responsaveis', [ResponsavelController::class, 'index'])->name('responsaveis.index');
Route::get('/responsaveis/create', [ResponsavelController::class, 'create'])->name('responsaveis.create');
Route::post('/responsaveis', [ResponsavelController::class, 'store'])->name('responsaveis.store');
Route::get('/responsaveis/{responsavel}', [ResponsavelController::class, 'show'])->name('responsaveis.show');
Route::get('/responsaveis/{responsavel}/edit', [ResponsavelController::class, 'edit'])->name('responsaveis.edit');
Route::put('/responsaveis/{responsavel}', [ResponsavelController::class, 'update'])->name('responsaveis.update');
Route::delete('/responsaveis/{responsavel}', [ResponsavelController::class, 'destroy'])->name('responsaveis.destroy');

Route::get('/criancas/{crianca}/responsaveis/atribuir', [ResponsavelController::class, 'atribuirForm'])->name('criancas.responsaveis.atribuir');
Route::post('/criancas/{crianca}/responsaveis/atribuir', [ResponsavelController::class, 'atribuir'])->name('criancas.responsaveis.salvar');

// Rotas para matrículas
Route::resource('matriculas', MatriculaController::class);

// Rotas para turmas
Route::resource('turmas', TurmaController::class);

// Rotas para relatórios
Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
Route::get('/relatorios/criancas', [RelatorioController::class, 'criancas'])->name('relatorios.criancas');
Route::get('/relatorios/criancas/exportar', [RelatorioController::class, 'exportarCriancas'])->name('relatorios.criancas.exportar');
Route::get('/relatorios/financeiro', [RelatorioController::class, 'financeiro'])->name('relatorios.financeiro');
Route::get('/relatorios/pagamentos', [RelatorioController::class, 'pagamentos'])->name('relatorios.pagamentos');
Route::get('/relatorios/presenca', [RelatorioController::class, 'presenca'])->name('relatorios.presenca');
Route::get('/relatorios/frequencia', [RelatorioController::class, 'frequencia'])->name('relatorios.frequencia');
Route::get('/relatorios/matriculas', [RelatorioController::class, 'matriculas'])->name('relatorios.matriculas');
Route::get('/relatorios/responsaveis', [RelatorioController::class, 'responsaveis'])->name('relatorios.responsaveis');
Route::get('/relatorios/turmas', [RelatorioController::class, 'turmas'])->name('relatorios.turmas');
Route::post('/relatorios/gerar', [RelatorioController::class, 'gerar'])->name('relatorios.gerar');
Route::get('/relatorios/exportar', [RelatorioController::class, 'exportarDados'])->name('relatorios.exportar');

    // Rotas do Sistema de Creche
    Route::prefix('admin')->middleware(['auth'])->group(function () {});
});

