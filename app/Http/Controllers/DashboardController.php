<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{


    public function __construct()
    {
       $this->middleware(['auth', 'admin']);
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

    return view('admin.dashboard',  compact('stats', 'peminjaman_terbaru',));
    }
}
