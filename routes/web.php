<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rotas de Autenticação
Auth::routes();

// Rotas Protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Rotas do Sistema de Creche
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

        // Rotas de Crianças
        Route::resource('children', App\Http\Controllers\ChildController::class);

        // Rotas de Responsáveis
        Route::resource('guardians', App\Http\Controllers\GuardianController::class);

        // Rotas de Matrículas
        Route::resource('enrollments', App\Http\Controllers\EnrollmentController::class);

        // Rotas de Turmas
        Route::resource('classes', App\Http\Controllers\ClassController::class);
    });
});
