<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DaftarBukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\DetailBukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PeminjamanUserController;
use Illuminate\Support\Facades\Route;

// ── PUBLIC ───────────────────────────────────────────────────────────────────

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Auth::routes();

// Halaman publik katalog buku (tanpa login)
Route::get('/daftarbuku', [DaftarBukuController::class, 'index'])->name('daftarbuku');
Route::get('/detailbuku/{buku}', [DetailBukuController::class, 'show'])->name('detailbuku.show');

// ── USER (butuh login) ────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Dashboard user
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile — user hanya bisa lihat & edit profil sendiri
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Peminjaman user — riwayat & detail
    Route::get('riwayat-pinjam', [PeminjamanUserController::class, 'index'])->name('user.peminjaman.index');
    Route::get('riwayat-pinjam/{peminjaman}', [PeminjamanUserController::class, 'show'])->name('user.peminjaman.show');

    // Cart
    Route::get('keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('keranjang/{buku}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('keranjang/{buku}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('keranjang', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

// ── ADMIN ONLY ────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Buku
    Route::resource('buku', BukuController::class);

    // CRUD Catalog
    Route::resource('catalog', CatalogController::class);

    // CRUD Peminjaman — hanya admin yg boleh approve/tolak/kelola
    Route::resource('peminjaman', PeminjamanController::class);

    // Denda — hanya admin yg boleh lihat semua & hapus
    Route::resource('denda', DendaController::class)->only(['index', 'show', 'destroy']);
    Route::patch('denda/{denda}/bayar', [DendaController::class, 'bayar'])->name('denda.bayar');
});
