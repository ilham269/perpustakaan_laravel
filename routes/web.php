<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Auth::routes();

// Dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Buku
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('buku', BukuController::class);
});

// Peminjaman
Route::resource('peminjaman', PeminjamanController::class);

//Catalog
Route::resource('catalog', CatalogController::class);

// Denda
Route::resource('denda', DendaController::class)->only(['index', 'show', 'destroy']);
Route::patch('denda/{denda}/bayar', [DendaController::class, 'bayar'])->name('denda.bayar');

// Profile
Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
