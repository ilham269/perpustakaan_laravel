<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth', 'admin']);
    }

    
    public function index()
    {
        $bukus = Buku::latest()->paginate(10);
        return view('admin.buku.index', compact('bukus'));
    }

    // ➕ FORM CREATE
    public function create()
    {
        return view('admin.buku.create');
    }

    // 💾 STORE DATA + UPLOAD GAMBAR
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'stok'      => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            // rename biar rapi
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            $data['gambar'] = $file->storeAs('buku', $filename, 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    // 👁️ DETAIL
    public function show(Buku $buku)
    {
        $buku->load('peminjaman.user');
        return view('admin.buku.show', compact('buku'));
    }

    // ✏️ FORM EDIT
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    // 🔄 UPDATE + GANTI GAMBAR
    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'penulis'   => 'required|string|max:255',
            'stok'      => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // kalau upload gambar baru
        if ($request->hasFile('gambar')) {

            // 🔥 hapus gambar lama
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            $data['gambar'] = $file->storeAs('buku', $filename, 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')
                         ->with('success', 'Buku berhasil diperbarui.');
    }

    // 🗑️ DELETE + HAPUS FILE
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