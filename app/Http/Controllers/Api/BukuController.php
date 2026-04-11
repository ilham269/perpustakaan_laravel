<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('catalog:id,nama');

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%'.$request->search.'%')
                ->orWhere('penulis', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('stok')) {
            $query->where('stok', '>', 0);
        }

        if ($request->filled('catalog_id')) {
            $query->where('catalog_id', $request->catalog_id);
        }

        $bukus = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json($bukus);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'catalog_id' => 'nullable|exists:catalogs,id',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string',
        ]);

        $buku = Buku::create($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku->load('catalog:id,nama'),
        ], 201);
    }

    public function show(Buku $buku)
    {
        return response()->json($buku->load(['catalog:id,nama', 'peminjaman.user:id,name']));
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'catalog_id' => 'nullable|exists:catalogs,id',
            'judul' => 'sometimes|required|string|max:255',
            'penulis' => 'sometimes|required|string|max:255',
            'stok' => 'sometimes|required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string',
        ]);

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => $buku->load('catalog:id,nama'),
        ]);
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.']);
    }
}
