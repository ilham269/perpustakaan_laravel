<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Denda::with([
            'peminjaman.user:id,name,email',
            'peminjaman.buku:id,judul',
        ]);

        // Non-admin hanya bisa lihat denda milik sendiri
        if (strtolower($user->role) !== 'admin') {
            $query->whereHas('peminjaman', fn ($q) => $q->where('user_id', $user->id));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json(
            $query->latest()->paginate($request->get('per_page', 10))
        );
    }

    public function show(Request $request, Denda $denda)
    {
        $user = $request->user();

        if (strtolower($user->role) !== 'admin' && $denda->peminjaman->user_id !== $user->id) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        return response()->json(
            $denda->load(['peminjaman.user:id,name,email', 'peminjaman.buku:id,judul'])
        );
    }

    public function bayar(Denda $denda)
    {
        if ($denda->status === 'sudah bayar') {
            return response()->json(['message' => 'Denda sudah lunas.'], 422);
        }

        $denda->update(['status' => 'sudah bayar']);

        return response()->json([
            'message' => 'Denda berhasil ditandai lunas.',
            'data' => $denda,
        ]);
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        return response()->json(['message' => 'Data denda berhasil dihapus.']);
    }
}
