<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        return response()->json(Catalog::withCount('bukus')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:catalogs,nama',
        ]);

        $catalog = Catalog::create($data);

        return response()->json([
            'message' => 'Catalog berhasil ditambahkan.',
            'data'    => $catalog,
        ], 201);
    }

    public function show(Catalog $catalog)
    {
        return response()->json($catalog->load('bukus'));
    }

    public function update(Request $request, Catalog $catalog)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100|unique:catalogs,nama,' . $catalog->id,
        ]);

        $catalog->update($data);

        return response()->json([
            'message' => 'Catalog berhasil diperbarui.',
            'data'    => $catalog,
        ]);
    }

    public function destroy(Catalog $catalog)
    {
        $catalog->delete();

        return response()->json(['message' => 'Catalog berhasil dihapus.']);
    }
}
