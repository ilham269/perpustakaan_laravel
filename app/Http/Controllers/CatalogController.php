<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Catalog;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $databuku = Buku::all();
        return view('admin.catalog.index', compact('databuku'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.catalog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|max:100',
                'genre' => 'required|',
                'deskripsi' => 'required|max:100',
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'genre.required' => 'Genre tidak boleh kosong',
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            ],
        );

        $databuku = new Catalog;
        $databuku->nama = $request->nama;
        $databuku->genre = $request->genre;
        $databuku->deskripsi = $request->deskripsi;
        $databuku->save();

        session()->flash('success', 'Data berhasil di tambahkan !');

        return redirect()->route('admin.catalog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $databuku = Catalog::findOrFail($id);
        $buku = Buku::all();
        return view('admin.catalog.show', compact('databuku', 'buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $databuku = Catalog::findOrFail($id);
        $buku = Buku::all();
        return view('admin.catalog.edit', compact('uangkeluar', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nama' => 'required|max:100',
                'genre' => 'required|',
                'deskripsi' => 'required|max:100',
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'genre.required' => 'Genre tidak boleh kosong',
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            ],
        );

        $databuku = Catalog::findOrFail($id);
        $databuku->nama = $request->nama;
        $databuku->genre = $request->genre;
        $databuku->deskripsi = $request->deskripsi;
        $databuku->save();

        session()->flash('success', 'Data berhasil di edit !');

        return redirect()->route('admin.catalog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $databuku = Catalog::findOrFail($id);
        $databuku->delete();
        return redirect()->route('admin.catalog.index')->with('success', 'Data Berhasil Di Hapus !');
    }
}
