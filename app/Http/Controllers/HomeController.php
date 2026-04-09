<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = [
            'total_buku'       => Buku::count(),
            'total_peminjaman' => Peminjaman::count(),
            'pending'          => Peminjaman::where('status', 'pending')->count(),
            'denda_belum_bayar'=> Denda::where('status', 'belum bayar')->count(),
        ];

        $peminjaman_terbaru = Peminjaman::with(['user', 'buku'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
    $buku = Buku::latest()->take(8)->get(); 
    
    // latest() = order by created_at DESC


        return view('home', compact('stats', 'peminjaman_terbaru', 'buku'));
    }
}
