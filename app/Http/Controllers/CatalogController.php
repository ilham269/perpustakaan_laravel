<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::withCount('bukus')->latest()->paginate(10);

        return view('admin.catalog.index', compact('catalogs'));
    }

    public function create()
    {
        return view('admin.catalog.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|max:100|unique:catalogs,nama']);
        $catalog = Catalog::create(['nama' => $request->nama]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Katalog berhasil ditambahkan.', 'data' => $catalog]);
        }

        return redirect()->route('admin.catalog.index')->with('success', 'Katalog berhasil ditambahkan.');
    }

    public function show(Catalog $catalog)
    {
        $catalog->load('bukus');
        return view('admin.catalog.show', compact('catalog'));
    }

    public function edit(Catalog $catalog)
    {
        return view('admin.catalog.edit', compact('catalog'));
    }

    public function update(Request $request, Catalog $catalog)
    {
        $request->validate(['nama' => 'required|max:100|unique:catalogs,nama,' . $catalog->id]);
        $catalog->update(['nama' => $request->nama]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Katalog berhasil diperbarui.', 'data' => $catalog]);
        }

        return redirect()->route('admin.catalog.index')->with('success', 'Katalog berhasil diperbarui.');
    }

    public function destroy(Catalog $catalog)
    {
        $catalog->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Katalog berhasil dihapus.']);
        }

        return redirect()->route('admin.catalog.index')->with('success', 'Katalog berhasil dihapus.');
    }
}
