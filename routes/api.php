<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\DendaController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes — Perpustakaan
|--------------------------------------------------------------------------
| Base URL  : /api
| Auth      : Laravel Sanctum (Bearer Token)
| Header    : Authorization: Bearer {token}, Accept: application/json
*/

// ── PUBLIC ───────────────────────────────────────────────────────────────
Route::post('login', [AuthController::class, 'login']);

// ── PROTECTED ────────────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me',      [AuthController::class, 'me']);

    // Profile
    Route::get('profile',  [ProfileController::class, 'show']);
    Route::post('profile', [ProfileController::class, 'update']); // POST biar support multipart

    // Catalog
    Route::apiResource('catalog', CatalogController::class);

    // Buku
    Route::apiResource('buku', BukuController::class);

    // Peminjaman
    Route::apiResource('peminjaman', PeminjamanController::class);

    // Denda
    Route::get('denda',                 [DendaController::class, 'index']);
    Route::get('denda/{denda}',         [DendaController::class, 'show']);
    Route::patch('denda/{denda}/bayar', [DendaController::class, 'bayar']);
    Route::delete('denda/{denda}',      [DendaController::class, 'destroy']);

});
