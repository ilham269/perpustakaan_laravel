<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
                                ->latest()
                                ->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        return view('peminjaman.create', compact('users', 'bukus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'buku_id'          => 'required|exists:bukus,id',
            'tanggal_request'  => 'required|date',
            'tanggal_pinjam'   => 'nullable|date|after_or_equal:tanggal_request',
            'tanggal_kembali'  => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status'           => 'required|in:pending,disetujui,ditolak,dikembalikan',
        ]);

        Peminjaman::create($data);

        if ($data['status'] === 'disetujui') {
            $buku = Buku::find($data['buku_id']);
            if ($buku && $buku->stok > 0) {
                $buku->decrement('stok');
            }
        }

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku', 'denda']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $users = User::orderBy('name')->get();
        $bukus = Buku::orderBy('judul')->get();
        return view('peminjaman.edit', compact('peminjaman', 'users', 'bukus'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $data = $request->validate([
            'user_id'          => 'required|exists:users,id',
            'buku_id'          => 'required|exists:bukus,id',
            'tanggal_request'  => 'required|date',
            'tanggal_pinjam'   => 'nullable|date',
            'tanggal_kembali'  => 'nullable|date',
            'status'           => 'required|in:pending,disetujui,ditolak,dikembalikan',
        ]);

        $statusLama = $peminjaman->status;
        $peminjaman->update($data);

        if ($data['status'] === 'dikembalikan' && $statusLama !== 'dikembalikan') {
            $peminjaman->buku->increment('stok');

            $hari = $peminjaman->hariTerlambat();
            if ($hari > 0 && !$peminjaman->denda) {
                Denda::create([
                    'peminjaman_id'  => $peminjaman->id,
                    'terlambat_hari' => $hari,
                    'total_denda'    => Denda::hitung($hari),
                    'status'         => 'belum bayar',
                ]);
            }
        }

        if ($data['status'] === 'disetujui' && $statusLama === 'pending') {
            $peminjaman->buku->decrement('stok');
        }

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
