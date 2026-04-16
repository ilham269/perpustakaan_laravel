@extends('layouts.app')
@section('title', 'Checkout Peminjaman')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
.co-page{background:#F9F4EA;min-height:100vh;padding:2.5rem 0;font-family:'Lora',serif}
.page-title{font-family:'Playfair Display',serif;font-size:26px;font-weight:600;color:#3A2E1A}
.page-divider{width:44px;height:2px;background:#D4C490;border-radius:2px;margin:10px 0 2rem}
.co-card{background:#FEFCF7;border:1px solid #E8DFC8;border-radius:16px;overflow:hidden;margin-bottom:20px}
.co-card-head{background:#F0E6C8;padding:14px 20px;border-bottom:1px solid #E8DFC8;font-family:'Playfair Display',serif;font-size:14px;font-weight:600;color:#3A2E1A}
.co-card-body{padding:20px}
.flabel{display:block;font-size:11px;text-transform:uppercase;letter-spacing:.07em;color:#6B5B3E;margin-bottom:7px;font-weight:600}
.finput{width:100%;background:#FAF6EC;border:1px solid #E0D2B0;border-radius:10px;padding:11px 14px;font-size:14px;font-family:'Lora',serif;color:#3A2E1A;outline:none;transition:border .2s}
.finput:focus{border-color:#C4AA70;box-shadow:0 0 0 3px rgba(196,170,112,.15)}
.finput.is-invalid{border-color:#D4654A}
.ferror{font-size:12px;color:#C0522A;font-style:italic;margin-top:5px;display:block}
.divider-line{border:none;border-top:1px solid #E8DFC8;margin:1.25rem 0}
.book-row{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid #F0E6C8}
.book-row:last-child{border-bottom:none}
.book-cover-sm{width:40px;height:54px;object-fit:cover;border-radius:6px;border:1px solid #D4C49A;flex-shrink:0}
.book-row-title{font-family:'Playfair Display',serif;font-size:13px;font-weight:600;color:#3A2E1A}
.book-row-author{font-size:11px;color:#8A7A55;font-style:italic}
.info-box{background:#FFF8E7;border:1px solid #F0D080;border-radius:10px;padding:12px 16px;font-size:13px;color:#7A5C10;margin-bottom:1.5rem}
.btn-submit{display:block;width:100%;padding:14px;background:#3A2E1A;color:#F5EDD6;font-family:'Playfair Display',serif;font-size:15px;font-weight:500;border:none;border-radius:10px;cursor:pointer;text-align:center;transition:background .2s}
.btn-submit:hover{background:#4E3D24}
.btn-back{font-size:13px;color:#8A7040;text-decoration:none;display:block;text-align:center;margin-top:12px}
.btn-back:hover{color:#3A2E1A}
.alert-err{background:#FDE8E8;border:1px solid #F5C6C6;color:#C0522A;border-radius:10px;padding:12px 16px;margin-bottom:1.5rem;font-size:14px}
</style>

<div class="co-page">
  <div class="container" style="max-width:680px">

    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.1em;color:#A0905E;margin-bottom:6px">Peminjaman</div>
    <div class="page-title">Checkout</div>
    <div class="page-divider"></div>

    @if(session('error'))<div class="alert-err">⚠️ {{ session('error') }}</div>@endif

    <div class="info-box">
      📋 Periksa data diri dan daftar buku sebelum mengirim permintaan. Batas pinjam <strong>7 hari</strong>, denda <strong>Rp 1.000/hari</strong>.
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
      @csrf

      {{-- Data Diri --}}
      <div class="co-card">
        <div class="co-card-head">👤 Data Diri</div>
        <div class="co-card-body">
          <div class="mb-3">
            <label class="flabel" for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama"
                   class="finput {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                   value="{{ old('nama', $user->name) }}" required>
            @error('nama')<span class="ferror">{{ $message }}</span>@enderror
          </div>
          <div>
            <label class="flabel" for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"
                      class="finput {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                      required>{{ old('alamat', $user->profile->alamat ?? '') }}</textarea>
            @error('alamat')<span class="ferror">{{ $message }}</span>@enderror
          </div>
        </div>
      </div>

      {{-- Daftar Buku --}}
      <div class="co-card">
        <div class="co-card-head">📚 Buku yang Dipinjam ({{ $bukus->count() }} buku)</div>
        <div class="co-card-body">
          @foreach($bukus as $buku)
          <div class="book-row">
            <img class="book-cover-sm"
                 src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/40x54/EDE0BE/9A8860?text=📖' }}"
                 alt="{{ $buku->judul }}">
            <div>
              <div class="book-row-title">{{ $buku->judul }}</div>
              <div class="book-row-author">{{ $buku->penulis }}</div>
            </div>
            @if($buku->stok <= 0)
              <span style="margin-left:auto;font-size:11px;color:#C0522A;font-weight:600">Stok Habis!</span>
            @endif
          </div>
          @endforeach
        </div>
      </div>

      <button type="submit" class="btn-submit">
        📨 Kirim Permintaan Pinjam
      </button>
      <a href="{{ route('cart.index') }}" class="btn-back">← Kembali ke Keranjang</a>
    </form>

  </div>
</div>
@endsection
