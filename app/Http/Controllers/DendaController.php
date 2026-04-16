<?php

namespace App\Http\Controllers;

use App\Models\Denda;

class DendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dendas = Denda::with(['peminjaman.user', 'peminjaman.buku'])
            ->latest()
            ->paginate(10);

        return view('admin.denda.index', compact('dendas'));
    }

    public function show(Denda $denda)
    {
        $denda->load(['peminjaman.user', 'peminjaman.buku']);

        return view('admin.denda.show', compact('denda'));
    }

    public function bayar(Denda $denda)
    {
        if ($denda->status === 'sudah bayar') {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Denda sudah lunas.'], 422);
            }
        }

        $denda->update(['status' => 'sudah bayar']);

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Denda berhasil ditandai lunas.', 'data' => $denda]);
        }

        return redirect()->route('admin.denda.index')
            ->with('success', 'Denda berhasil ditandai lunas.');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Data denda berhasil dihapus.']);
        }

        return redirect()->route('admin.denda.index')
            ->with('success', 'Data denda berhasil dihapus.');
    }
}
