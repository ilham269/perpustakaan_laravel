<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
            ->latest()->take(5)->get();

        // ── Chart: 12 bulan terakhir ──────────────────────────────────────
        $bulan = collect(range(11, 0))->map(fn ($i) => Carbon::now()->subMonths($i));

        $pinjamPerBulan = Peminjaman::select(
                DB::raw('YEAR(tanggal_request) as tahun'),
                DB::raw('MONTH(tanggal_request) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_request', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->get()
            ->keyBy(fn ($r) => $r->tahun . '-' . str_pad($r->bulan, 2, '0', STR_PAD_LEFT));

        $dendaPerBulan = Denda::select(
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(total_denda) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->get()
            ->keyBy(fn ($r) => $r->tahun . '-' . str_pad($r->bulan, 2, '0', STR_PAD_LEFT));

        $chartLabels      = $bulan->map(fn ($b) => $b->translatedFormat('M Y'))->values();
        $chartPinjam      = $bulan->map(fn ($b) => (int) ($pinjamPerBulan[$b->format('Y-m')]->total ?? 0))->values();
        $chartDenda       = $bulan->map(fn ($b) => (int) ($dendaPerBulan[$b->format('Y-m')]->total ?? 0))->values();

        return view('admin.dashboard', compact(
            'stats', 'peminjaman_terbaru',
            'chartLabels', 'chartPinjam', 'chartDenda'
        ));
    }
}
