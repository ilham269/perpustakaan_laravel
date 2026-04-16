<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart  = session('cart', []);
        $bukus = collect();

        if (!empty($cart)) {
            $bukus = Buku::whereIn('id', array_keys($cart))->get()
                ->map(fn ($b) => tap($b, fn ($b) => $b->qty = $cart[$b->id]));
        }

        return view('user.cart.index', compact('bukus'));
    }

    public function add(Request $request, Buku $buku)
    {
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        $cart = session('cart', []);

        if (isset($cart[$buku->id])) {
            return back()->with('error', 'Buku sudah ada di keranjang.');
        }

        $cart[$buku->id] = 1;
        session(['cart' => $cart]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Buku ditambahkan ke keranjang.', 'count' => count($cart)]);
        }

        return back()->with('success', "\"{$buku->judul}\" ditambahkan ke keranjang.");
    }

    public function remove(Buku $buku)
    {
        $cart = session('cart', []);
        unset($cart[$buku->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Buku dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
