<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Detailpeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $bukus = Buku::whereIn('id', array_keys($cart))->get();
        $user  = Auth::user();

        return view('user.checkout.index', compact('bukus', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $user  = Auth::user();
        $bukus = Buku::whereIn('id', array_keys($cart))->lockForUpdate()->get();

        // Validasi stok semua buku
        foreach ($bukus as $buku) {
            if ($buku->stok <= 0) {
                return back()->with('error', "Stok buku \"{$buku->judul}\" habis. Hapus dari keranjang terlebih dahulu.");
            }
        }

        DB::transaction(function () use ($user, $request, $bukus) {
            // Update profil user
            $user->update(['name' => $request->nama]);
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['alamat'  => $request->alamat]
            );

            // Buat satu peminjaman (buku_id diisi buku pertama untuk kompatibilitas)
            $peminjaman = Peminjaman::create([
                'user_id'         => $user->id,
                'buku_id'         => $bukus->first()->id,
                'tanggal_request' => now()->toDateString(),
                'status'          => 'pending',
            ]);

            // Simpan semua buku ke detail_peminjaman
            foreach ($bukus as $buku) {
                Detailpeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id'       => $buku->id,
                    'jumlah'        => 1,
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Permintaan pinjam ' . $bukus->count() . ' buku berhasil dikirim. Tunggu persetujuan admin.');
    }
}
