<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

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
        return view('denda.index', compact('dendas'));
    }

    public function show(Denda $denda)
    {
        $denda->load(['peminjaman.user', 'peminjaman.buku']);
        return view('denda.show', compact('denda'));
    }

    public function bayar(Denda $denda)
    {
        $denda->update(['status' => 'sudah bayar']);

        return redirect()->route('denda.index')
                         ->with('success', 'Denda berhasil ditandai lunas.');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();

        return redirect()->route('denda.index')
                         ->with('success', 'Data denda berhasil dihapus.');
    }
}
