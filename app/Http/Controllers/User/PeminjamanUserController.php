<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanUserController extends Controller
{
    public function __construct(private PeminjamanService $service)
    {
        $this->middleware('auth');
    }

    /** Daftar peminjaman milik user yang login */
    public function index()
    {
        $peminjaman = Peminjaman::with(['buku', 'denda', 'detailPeminjaman.buku'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.peminjaman.index', compact('peminjaman'));
    }

    /** Form pinjam buku */
    public function create(Request $request)
    {
        $user    = Auth::user();
        $profile = $user->profile;

        // Kalau buku_id dikirim dari halaman detail buku, pre-select
        $selectedBukuId = $request->query('buku_id');

        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('user.peminjaman.create', compact('user', 'profile', 'bukus', 'selectedBukuId'));
    }

    /** Simpan permintaan pinjam */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'required|string',
            'buku_id' => 'required|exists:bukus,id',
        ]);

        // Update nama & alamat di profile sekalian
        $user->update(['name' => $request->nama]);
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['alamat' => $request->alamat]
        );

        try {
            $this->service->buat([
                'user_id'         => $user->id,
                'buku_id'         => $request->buku_id,
                'tanggal_request' => now()->toDateString(),
                'status'          => 'pending',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['buku_id' => $e->getMessage()])->withInput();
        }

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Permintaan pinjam berhasil dikirim. Tunggu persetujuan admin.');
    }

    /** Detail peminjaman milik user */
    public function show(Peminjaman $peminjaman)
    {
        // Pastikan hanya pemilik yang bisa lihat
        abort_if($peminjaman->user_id !== Auth::id(), 403);

        $peminjaman->load(['buku', 'denda']);

        return view('user.peminjaman.show', compact('peminjaman'));
    }
}
