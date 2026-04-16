@extends('layouts.app')
@section('title', 'Home')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  body { font-family: 'Lora', serif; background: #F9F4EA; }

  /* ── HERO ── */
  .hero-section { background: #F9F4EA; padding: 1.5rem 0; margin-bottom: 20px; border-bottom: 1px solid #E8DFC8; }
  .hero-title   { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 600; color: #3A2E1A; line-height: 1.2; }
  .hero-sub     { font-size: 15px; color: #8A7A55; line-height: 1.6; margin: 8px 0 16px; }
  .btn-hero     { display: inline-block; background: #3A2E1A; color: #F5EDD6 !important; font-family: 'Playfair Display', serif;
                  font-size: 14px; font-weight: 500; padding: 12px 28px; border-radius: 10px; text-decoration: none;
                  letter-spacing: .04em; transition: background .2s, transform .15s; margin-right: 10px; }
  .btn-hero:hover { background: #4E3D24; transform: translateY(-1px); }
  .btn-hero-outline { display: inline-block; border: 1.5px solid #3A2E1A; color: #3A2E1A !important; font-family: 'Playfair Display', serif;
                      font-size: 14px; font-weight: 500; padding: 11px 24px; border-radius: 10px; text-decoration: none;
                      letter-spacing: .04em; transition: all .2s; }
  .btn-hero-outline:hover { background: #3A2E1A; color: #F5EDD6 !important; }
  .hero-img { width: 200px; opacity: .88; }

  /* ── STATS ── */
  .stats-section { padding: 2rem 0; }
  .stat-card { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 14px; padding: 18px 20px;
               display: flex; align-items: center; gap: 14px; }
  .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center;
               justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
  .stat-val  { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 600; color: #3A2E1A; line-height: 1; }
  .stat-lbl  { font-size: 12px; color: #8A7A55; margin-top: 3px; }

  /* ── RIWAYAT ── */
  .section-heading { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 600; color: #3A2E1A; margin-bottom: 6px; }
  .section-divider { width: 40px; height: 2px; background: #D4C490; border-radius: 2px; margin-bottom: 1.25rem; }
  .see-all { font-size: 13px; color: #8A7040; font-style: italic; text-decoration: none; }
  .see-all:hover { color: #3A2E1A; }

  .pinjam-row { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 12px; padding: 14px 18px;
                display: flex; align-items: center; gap: 14px; margin-bottom: 10px; flex-wrap: wrap; }
  .book-cover-sm { width: 40px; height: 54px; object-fit: cover; border-radius: 5px; border: 1px solid #D4C49A; flex-shrink: 0; }
  .pinjam-judul  { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 600; color: #3A2E1A; }
  .pinjam-meta   { font-size: 12px; color: #8A7A55; margin-top: 2px; }

  .badge-status { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
  .badge-pending      { background: #FFF3CD; color: #856404; }
  .badge-disetujui    { background: #D1E7DD; color: #0A5C36; }
  .badge-ditolak      { background: #F8D7DA; color: #842029; }
  .badge-dikembalikan { background: #CFE2FF; color: #084298; }

  .denda-pill { background: #FDE8E8; color: #C0522A; border: 1px solid #F5C6C6; border-radius: 20px;
                font-size: 11px; padding: 2px 10px; display: inline-block; margin-left: 6px; }

  .btn-row-detail { font-size: 12px; color: #8A7040; text-decoration: none; border: 1px solid #D4C490;
                    padding: 5px 12px; border-radius: 8px; white-space: nowrap; margin-left: auto; }
  .btn-row-detail:hover { background: #F0E6C8; color: #3A2E1A; }

  /* ── BUKU ── */
  .books-section { background: #F9F4EA; padding: 2.5rem 0 3rem; }
  .book-card { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 14px; overflow: hidden;
               display: flex; flex-direction: column; height: 100%; transition: transform .2s, box-shadow .2s; }
  .book-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(90,60,20,.1); }
  .book-cover-wrap img { width: 100%; height: 180px; object-fit: cover; }
  .book-card-body { padding: 12px 14px; flex: 1; }
  .book-badge { display: inline-block; background: #F0E6C8; color: #8A7040; font-size: 10px; letter-spacing: .06em;
                text-transform: uppercase; padding: 2px 10px; border-radius: 20px; border: 1px solid #D4C490; margin-bottom: 7px; }
  .book-card-title  { font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 600; color: #3A2E1A; line-height: 1.3; margin-bottom: 3px; }
  .book-card-author { font-size: 12px; color: #8A7A55; font-style: italic; margin-bottom: 8px; }
  .stok-badge { font-size: 11px; color: #7A6030; background: #F5EDD6; padding: 2px 10px; border-radius: 20px; border: 1px solid #DDD0A8; }
  .book-card-footer { padding: 0 14px 14px; display: flex; gap: 8px; }
  .btn-detail-sm { flex: 1; padding: 9px; background: #F0E6C8; color: #3A2E1A !important; font-family: 'Playfair Display', serif;
                   font-size: 12px; font-weight: 500; border: 1px solid #D4C490; border-radius: 8px; text-align: center;
                   text-decoration: none; transition: background .2s; }
  .btn-detail-sm:hover { background: #E8D8B0; }
  .btn-pinjam-sm { flex: 1; padding: 9px; background: #3A2E1A; color: #F5EDD6 !important; font-family: 'Playfair Display', serif;
                   font-size: 12px; font-weight: 500; border: none; border-radius: 8px; text-align: center;
                   text-decoration: none; transition: background .2s; }
  .btn-pinjam-sm:hover { background: #4E3D24; }
  .btn-pinjam-sm.disabled { opacity: .45; pointer-events: none; }

  .alert-success-custom { background: #F0E6C8; border: 1px solid #D4C490; color: #5C4220;
                          border-radius: 10px; padding: 12px 16px; margin-bottom: 1.5rem; font-size: 14px; }
</style>

{{-- Flash --}}
@if (session('success'))
  <div class="container mt-3">
    <div class="alert-success-custom"> &nbsp;{{ session('success') }}</div>
  </div>
@endif

{{-- ===== HERO ===== --}}
<section class="hero-section">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-4">
    <div style="max-width: 420px;">
      <h1 class="hero-title">Halo, Selamat datang {{ Auth::user()->name }}</h1>
      <p class="hero-sub">Selamat datang di Perpustakaan. Temukan buku favoritmu dan pinjam dengan mudah.</p>
      <a href="{{ route('user.peminjaman.create') }}" class="btn-hero"> Pinjam Buku</a>
      <a href="{{ route('daftarbuku') }}" class="btn-hero-outline">Jelajahi Koleksi</a>
    </div>
    <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" class="hero-img" alt="Buku">
  </div>
</section>

{{-- ===== STATS ===== --}}
<section class="stats-section">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#F0E6C8;">📚</div>
          <div>
            <div class="stat-val">{{ $stats['total_pinjam'] }}</div>
            <div class="stat-lbl">Total Pinjam</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#D1E7DD;">✅</div>
          <div>
            <div class="stat-val">{{ $stats['sedang_pinjam'] }}</div>
            <div class="stat-lbl">Sedang Dipinjam</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#FFF3CD;">⏳</div>
          <div>
            <div class="stat-val">{{ $stats['pending'] }}</div>
            <div class="stat-lbl">Menunggu Approve</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#F8D7DA;">⚠️</div>
          <div>
            <div class="stat-val">{{ $stats['denda_aktif'] }}</div>
            <div class="stat-lbl">Denda Belum Bayar</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== RIWAYAT TERAKHIR ===== --}}
@if ($peminjaman_saya->isNotEmpty())
<section style="padding: 0 0 2rem;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-1">
      <h2 class="section-heading">Peminjaman Terakhir</h2>
      <a href="{{ route('user.peminjaman.index') }}" class="see-all">Lihat semua →</a>
    </div>
    <div class="section-divider"></div>

    @foreach ($peminjaman_saya as $p)
      <div class="pinjam-row">
        <img class="book-cover-sm"
             src="{{ $p->buku->gambar ? asset('storage/'.$p->buku->gambar) : 'https://via.placeholder.com/40x54/EDE0BE/9A8860?text=📖' }}"
             alt="{{ $p->buku->judul }}">
        <div style="flex:1;min-width:0;">
          <div class="pinjam-judul">{{ $p->buku->judul }}</div>
          <div class="pinjam-meta">
            {{ $p->tanggal_request->format('d M Y') }}
            <span class="badge-status badge-{{ $p->status }} ms-2">{{ ucfirst($p->status) }}</span>
            @if ($p->denda && $p->denda->status === 'belum bayar')
              <span class="denda-pill">Denda Rp {{ number_format($p->denda->total_denda, 0, ',', '.') }}</span>
            @endif
          </div>
        </div>
        <a href="{{ route('user.peminjaman.show', $p) }}" class="btn-row-detail">Detail</a>
      </div>
    @endforeach
  </div>
</section>
@endif

{{-- ===== BUKU TERBARU ===== --}}
<section class="books-section">
  <div class="container">
    <div class="d-flex align-items-start justify-content-between mb-1">
      <h2 class="section-heading">Buku Terbaru</h2>
      <a href="{{ route('daftarbuku') }}" class="see-all mt-1">Lihat semua →</a>
    </div>
    <div class="section-divider"></div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
      @foreach ($buku as $item)
        <div class="col">
          <div class="book-card">
            <div class="book-cover-wrap">
              <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/300x180/EDE0BE/9A8860?text=No+Cover' }}"
                   alt="{{ $item->judul }}">
            </div>
            <div class="book-card-body">
              <span class="book-badge">Koleksi</span>
              <div class="book-card-title">{{ $item->judul }}</div>
              <div class="book-card-author">{{ $item->penulis }}</div>
              <span class="stok-badge">Stok: {{ $item->stok }}</span>
            </div>
            <div class="book-card-footer">
              <a href="{{ route('detailbuku.show', $item->id) }}" class="btn-detail-sm">Detail</a>
              @if ($item->stok > 0)
                <a href="{{ route('user.peminjaman.create', ['buku_id' => $item->id]) }}" class="btn-pinjam-sm">Pinjam</a>
              @else
                <span class="btn-pinjam-sm disabled">Habis</span>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
