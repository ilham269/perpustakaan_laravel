<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $buku = Buku::latest()->take(8)->get();

        if ($user->role === 'admin') {
            // Admin: redirect ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        // User biasa: tampilkan peminjaman milik sendiri + denda
        $peminjaman_saya = Peminjaman::with(['buku', 'denda'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_pinjam'   => Peminjaman::where('user_id', $user->id)->count(),
            'sedang_pinjam'  => Peminjaman::where('user_id', $user->id)->where('status', 'disetujui')->count(),
            'pending'        => Peminjaman::where('user_id', $user->id)->where('status', 'pending')->count(),
            'denda_aktif'    => Denda::whereHas('peminjaman', fn ($q) => $q->where('user_id', $user->id))
                                     ->where('status', 'belum bayar')->count(),
        ];

        return view('home', compact('buku', 'peminjaman_saya', 'stats'));
    }
}
