<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanRequest;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Services\PeminjamanService;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function __construct(private PeminjamanService $service)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->paginate(10)->withQueryString();

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('peminjaman.create', compact('users', 'bukus'));
    }

    public function store(StorePeminjamanRequest $request)
    {
        try {
            $this->service->buat($request->validated());
        } catch (\Exception $e) {
            return back()->withErrors(['buku_id' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku', 'denda']);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $users = User::orderBy('name')->get();
        $bukus = Buku::orderBy('judul')->get();

        return view('peminjaman.edit', compact('peminjaman', 'users', 'bukus'));
    }

    public function update(UpdatePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        try {
            $this->service->ubah($peminjaman, $request->validated());
        } catch (\Exception $e) {
            return back()->withErrors(['buku_id' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
