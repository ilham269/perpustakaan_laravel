<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user:id,name,email', 'buku:id,judul,penulis']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json(
            $query->latest()->paginate($request->get('per_page', 10))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'buku_id'         => 'required|exists:bukus,id',
            'tanggal_request' => 'required|date',
            'tanggal_pinjam'  => 'nullable|date|after_or_equal:tanggal_request',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status'          => 'required|in:pending,disetujui,ditolak,dikembalikan',
        ]);

        $peminjaman = Peminjaman::create($data);

        if ($data['status'] === 'disetujui') {
            $buku = Buku::find($data['buku_id']);
            if ($buku && $buku->stok > 0) {
                $buku->decrement('stok');
            }
        }

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat.',
            'data'    => $peminjaman->load(['user:id,name', 'buku:id,judul']),
        ], 201);
    }

    public function show(Peminjaman $peminjaman)
    {
        return response()->json(
            $peminjaman->load(['user:id,name,email', 'buku:id,judul,penulis', 'denda'])
        );
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $data = $request->validate([
            'user_id'         => 'sometimes|required|exists:users,id',
            'buku_id'         => 'sometimes|required|exists:bukus,id',
            'tanggal_request' => 'sometimes|required|date',
            'tanggal_pinjam'  => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'status'          => 'sometimes|required|in:pending,disetujui,ditolak,dikembalikan',
        ]);

        $statusLama = $peminjaman->status;
        $peminjaman->update($data);

        if (isset($data['status'])) {
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
        }

        return response()->json([
            'message' => 'Peminjaman berhasil diperbarui.',
            'data'    => $peminjaman->load(['user:id,name', 'buku:id,judul', 'denda']),
        ]);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus.']);
    }
}
