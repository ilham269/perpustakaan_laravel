<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $bukus = Buku::with('catalog')->latest()->paginate(10);

        return view('admin.buku.index', compact('bukus'));
    }

    public function create()
    {
        $catalogs = Catalog::orderBy('nama')->get();

        return view('admin.buku.create', compact('catalogs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'penulis'    => 'required|string|max:255',
            'catalog_id' => 'nullable|exists:catalogs,id',
            'stok'       => 'required|integer|min:0',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $ext           = $request->file('gambar')->extension();
            $data['gambar'] = $request->file('gambar')
                ->storeAs('buku', Str::uuid().'.'.$ext, 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        $buku->load(['catalog', 'peminjaman.user']);

        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $catalogs = Catalog::orderBy('nama')->get();

        return view('admin.buku.edit', compact('buku', 'catalogs'));
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'penulis'    => 'required|string|max:255',
            'catalog_id' => 'nullable|exists:catalogs,id',
            'stok'       => 'required|integer|min:0',
            'deskripsi'  => 'nullable|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }

            $ext           = $request->file('gambar')->extension();
            $data['gambar'] = $request->file('gambar')
                ->storeAs('buku', Str::uuid().'.'.$ext, 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}