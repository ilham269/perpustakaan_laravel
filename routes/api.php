<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\DendaController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

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

// ── PROTECTED — semua user yg login ──────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Profile — user hanya bisa akses profil sendiri (logika di controller)
    Route::get('profile', [ProfileController::class, 'show']);
    Route::post('profile', [ProfileController::class, 'update']); // POST biar support multipart

    // Peminjaman — user bisa lihat & buat, admin bisa semua
    Route::apiResource('peminjaman', PeminjamanController::class);

    // Denda — user bisa lihat denda sendiri
    Route::get('denda', [DendaController::class, 'index']);
    Route::get('denda/{denda}', [DendaController::class, 'show']);

    // ── ADMIN ONLY ────────────────────────────────────────────────────────────
    Route::middleware('admin')->group(function () {

        // Catalog — hanya admin yg bisa tambah/edit/hapus
        Route::apiResource('catalog', CatalogController::class);

        // Buku — hanya admin yg bisa tambah/edit/hapus
        Route::apiResource('buku', BukuController::class);

        // Denda — hanya admin yg bisa bayar & hapus
        Route::patch('denda/{denda}/bayar', [DendaController::class, 'bayar']);
        Route::delete('denda/{denda}', [DendaController::class, 'destroy']);
    });
});
