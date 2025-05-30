<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\UserController;
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

    Route::resource('medicaments', \App\Http\Controllers\MedicamentController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::resource('categories', \App\Http\Controllers\CategorieController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('/ventes', function () {
        return view('admin.ventes');
    })->name('ventes');

    Route::resource('fournisseurs', \App\Http\Controllers\FournisseurController::class)->except(['show', 'create', 'edit']);

    Route::resource('utilisateurs', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'store', 'update', 'destroy']);
});