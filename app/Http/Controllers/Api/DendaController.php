<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Denda::with([
            'peminjaman.user:id,name,email',
            'peminjaman.buku:id,judul',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json(
            $query->latest()->paginate($request->get('per_page', 10))
        );
    }

    public function show(Denda $denda)
    {
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
            'data'    => $denda,
        ]);
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        return response()->json(['message' => 'Data denda berhasil dihapus.']);
    }
}
