<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanRequest;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function __construct(private PeminjamanService $service) {}

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

    public function store(StorePeminjamanRequest $request)
    {
        try {
            $peminjaman = $this->service->buat($request->validated());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat.',
            'data' => $peminjaman->load(['user:id,name', 'buku:id,judul']),
        ], 201);
    }

    public function show(Peminjaman $peminjaman)
    {
        return response()->json(
            $peminjaman->load(['user:id,name,email', 'buku:id,judul,penulis', 'denda'])
        );
    }

    public function update(UpdatePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        try {
            $peminjaman = $this->service->ubah($peminjaman, $request->validated());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Peminjaman berhasil diperbarui.',
            'data' => $peminjaman->load(['user:id,name', 'buku:id,judul', 'denda']),
        ]);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus.']);
    }
}
