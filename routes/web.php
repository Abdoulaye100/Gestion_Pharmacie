<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');

// Routes d'administration
Route::prefix('admin')->group(function () {
                                            
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/medicaments', [\App\Http\Controllers\MedicamentController::class, 'index'])->name('medicaments');

    Route::post('/medicaments', [\App\Http\Controllers\MedicamentController::class, 'store'])->name('medicaments.store');

    // Route::get('/categories', function () {
    //     return view('admin.categories');
    // })->name('categories');
    Route::resource('categories', \App\Http\Controllers\CategorieController::class)->except(['show', 'create', 'edit']);

    Route::get('/ventes', function () {
        return view('admin.ventes');
    })->name('ventes');

    Route::get('/utilisateurs', function () {
        return view('admin.utilisateurs');
    })->name('utilisateurs');

    Route::resource('fournisseurs', \App\Http\Controllers\FournisseurController::class)->except(['show', 'create', 'edit']);
});