@extends('layouts.app')
@section('title', 'Keranjang Pinjam')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
.cart-page{background:#F9F4EA;min-height:100vh;padding:2.5rem 0;font-family:'Lora',serif}
.page-title{font-family:'Playfair Display',serif;font-size:26px;font-weight:600;color:#3A2E1A}
.page-divider{width:44px;height:2px;background:#D4C490;border-radius:2px;margin:10px 0 2rem}
.cart-card{background:#FEFCF7;border:1px solid #E8DFC8;border-radius:14px;overflow:hidden;margin-bottom:12px}
.cart-row{display:flex;align-items:center;gap:16px;padding:16px 20px;flex-wrap:wrap}
.book-cover{width:52px;height:70px;object-fit:cover;border-radius:7px;border:1px solid #D4C49A;flex-shrink:0}
.book-title{font-family:'Playfair Display',serif;font-size:15px;font-weight:600;color:#3A2E1A}
.book-author{font-size:12px;color:#8A7A55;font-style:italic;margin-top:2px}
.stok-pill{font-size:11px;background:#F5EDD6;color:#7A6030;padding:2px 10px;border-radius:20px;border:1px solid #DDD0A8;display:inline-block;margin-top:5px}
.btn-remove{font-size:12px;color:#C0522A;border:1px solid #F5C6C6;background:#FDE8E8;padding:5px 12px;border-radius:8px;cursor:pointer;transition:all .15s;text-decoration:none;white-space:nowrap}
.btn-remove:hover{background:#fee2e2}
.btn-checkout{display:block;width:100%;padding:14px;background:#3A2E1A;color:#F5EDD6;font-family:'Playfair Display',serif;font-size:15px;font-weight:500;border:none;border-radius:10px;cursor:pointer;text-align:center;text-decoration:none;transition:background .2s}
.btn-checkout:hover{background:#4E3D24;color:#F5EDD6}
.btn-clear{font-size:12px;color:#8A7040;text-decoration:none;border:1px solid #D4C490;padding:6px 14px;border-radius:8px;transition:all .15s}
.btn-clear:hover{background:#F0E6C8}
.empty-state{text-align:center;padding:4rem 1rem;color:#A0905E}
.alert-ok{background:#F0E6C8;border:1px solid #D4C490;color:#5C4220;border-radius:10px;padding:12px 16px;margin-bottom:1.5rem;font-size:14px}
.alert-err{background:#FDE8E8;border:1px solid #F5C6C6;color:#C0522A;border-radius:10px;padding:12px 16px;margin-bottom:1.5rem;font-size:14px}
.summary-box{background:#FEFCF7;border:1px solid #E8DFC8;border-radius:14px;padding:20px}
.summary-row{display:flex;justify-content:space-between;font-size:14px;color:#6B5B3E;padding:6px 0;border-bottom:1px solid #F0E6C8}
.summary-row:last-child{border-bottom:none;font-weight:600;color:#3A2E1A;font-size:15px}
</style>

<div class="cart-page">
  <div class="container" style="max-width:760px">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-1">
      <div>
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.1em;color:#A0905E;margin-bottom:6px">Peminjaman</div>
        <div class="page-title">Keranjang Pinjam</div>
      </div>
      @if($bukus->isNotEmpty())
      <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
        @csrf @method('DELETE')
        <button type="submit" class="btn-clear" onclick="return confirm('Kosongkan keranjang?')">🗑 Kosongkan</button>
      </form>
      @endif
    </div>
    <div class="page-divider"></div>

    @if(session('success'))<div class="alert-ok">✅ {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert-err">⚠️ {{ session('error') }}</div>@endif

    @if($bukus->isEmpty())
      <div class="empty-state">
        <div style="font-size:3.5rem;margin-bottom:1rem">🛒</div>
        <p style="font-size:15px">Keranjang kamu masih kosong.</p>
        <a href="{{ route('daftarbuku') }}" class="btn-checkout" style="display:inline-block;width:auto;padding:12px 28px;margin-top:12px">
          Jelajahi Buku
        </a>
      </div>
    @else
      <div class="row g-4">
        <div class="col-lg-8">
          @foreach($bukus as $buku)
          <div class="cart-card">
            <div class="cart-row">
              <img class="book-cover"
                   src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/52x70/EDE0BE/9A8860?text=📖' }}"
                   alt="{{ $buku->judul }}">
              <div style="flex:1;min-width:0">
                <div class="book-title">{{ $buku->judul }}</div>
                <div class="book-author">{{ $buku->penulis }}</div>
                <span class="stok-pill">Stok: {{ $buku->stok }}</span>
              </div>
              <form action="{{ route('cart.remove', $buku) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn-remove">✕ Hapus</button>
              </form>
            </div>
          </div>
          @endforeach
        </div>

        <div class="col-lg-4">
          <div class="summary-box">
            <div style="font-family:'Playfair Display',serif;font-size:15px;font-weight:600;color:#3A2E1A;margin-bottom:14px">Ringkasan</div>
            <div class="summary-row">
              <span>Jumlah Buku</span>
              <span>{{ $bukus->count() }} buku</span>
            </div>
            <div class="summary-row">
              <span>Batas Pinjam</span>
              <span>7 hari</span>
            </div>
            <div class="summary-row">
              <span>Denda Terlambat</span>
              <span>Rp 1.000/hari</span>
            </div>
            <div class="summary-row" style="margin-top:8px">
              <span>Total Item</span>
              <span>{{ $bukus->count() }} buku</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn-checkout mt-3">
              Lanjut Checkout →
            </a>
            <a href="{{ route('daftarbuku') }}" style="display:block;text-align:center;font-size:12px;color:#8A7040;margin-top:12px;text-decoration:none">
              + Tambah buku lagi
            </a>
          </div>
        </div>
      </div>
    @endif

  </div>
</div>
@endsection
