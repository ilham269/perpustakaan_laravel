@extends('layouts.app')

@section('title', 'Home')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  /* ===== BASE ===== */
  body { font-family: 'Lora', serif; background: #F9F4EA; }

  /* ===== HERO ===== */
  .hero-section {
    background: #F9F4EA;
    padding: 3.5rem 0;
    border-bottom: 1px solid #E8DFC8;
  }
  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    font-weight: 600;
    color: #3A2E1A;
    line-height: 1.3;
  }
  .hero-subtitle {
    font-size: 15px;
    color: #8A7A55;
    line-height: 1.8;
    margin: 14px 0 26px;
  }
  .btn-hero {
    display: inline-block;
    background: #3A2E1A;
    color: #F5EDD6 !important;
    font-family: 'Playfair Display', serif;
    font-size: 14px;
    font-weight: 500;
    padding: 12px 28px;
    border-radius: 10px;
    text-decoration: none;
    letter-spacing: 0.04em;
    transition: background 0.2s, transform 0.15s;
  }
  .btn-hero:hover {
    background: #4E3D24;
    transform: translateY(-1px);
  }
  .hero-img {
    width: 220px;
    opacity: 0.88;
  }

  /* ===== SECTION BUKU ===== */
  .books-section {
    background: #F9F4EA;
    padding: 3rem 0;
  }
  .section-heading {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 600;
    color: #3A2E1A;
    margin-bottom: 6px;
  }
  .section-divider {
    width: 44px;
    height: 2px;
    background: #D4C490;
    border-radius: 2px;
    margin-bottom: 1.75rem;
  }
  .see-all-link {
    font-size: 13px;
    color: #8A7040;
    font-style: italic;
    text-decoration: none;
  }
  .see-all-link:hover { color: #3A2E1A; }

  /* ===== BOOK CARD ===== */
  .book-card {
    background: #FEFCF7;
    border: 1px solid #E8DFC8;
    border-radius: 14px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  .book-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(90,60,20,0.1);
  }
  .book-cover-wrap {
    background: #F0E6C8;
    border-bottom: 1px solid #E8DFC8;
  }
  .book-cover-wrap img {
    width: 100%;
    height: 190px;
    object-fit: cover;
  }
  .book-card-body {
    padding: 14px 16px;
    flex: 1;
  }
  .book-badge {
    display: inline-block;
    background: #F0E6C8;
    color: #8A7040;
    font-size: 10px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 2px 10px;
    border-radius: 20px;
    border: 1px solid #D4C490;
    margin-bottom: 8px;
  }
  .book-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    font-weight: 600;
    color: #3A2E1A;
    line-height: 1.35;
    margin-bottom: 4px;
  }
  .book-card-author {
    font-size: 12px;
    color: #8A7A55;
    font-style: italic;
    margin-bottom: 10px;
  }
  .stok-badge {
    display: inline-block;
    font-size: 11px;
    color: #7A6030;
    background: #F5EDD6;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #DDD0A8;
  }
  .book-card-footer {
    padding: 0 16px 16px;
  }
  .btn-detail {
    display: block;
    width: 100%;
    padding: 10px;
    background: #3A2E1A;
    color: #F5EDD6 !important;
    font-family: 'Playfair Display', serif;
    font-size: 13px;
    font-weight: 500;
    border: none;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    letter-spacing: 0.03em;
    transition: background 0.2s, transform 0.15s;
  }
  .btn-detail:hover {
    background: #4E3D24;
    transform: translateY(-1px);
  }
</style>


{{-- ===== HERO ===== --}}
<section class="hero-section">
  <div class="container d-flex align-items-center justify-content-between flex-wrap gap-4">

    <div style="max-width: 480px;">
      <h1 class="hero-title">Temukan Dunia dari Buku</h1>
      <p class="hero-subtitle">
        Jelajahi berbagai koleksi buku dari berbagai macam genre dengan mudah dan cepat.
      </p>
      <a href="{{ route('catalog.index') }}" class="btn-hero">Jelajahi Sekarang</a>
    </div>

    <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png"
         class="hero-img" alt="Ilustrasi Buku">

  </div>
</section>


{{-- ===== BUKU TERBARU ===== --}}
<section class="books-section">
  <div class="container">

    <div class="d-flex align-items-start justify-content-between mb-1">
      <h2 class="section-heading">Buku Terbaru</h2>
      <a href="{{ route('catalog.index') }}" class="see-all-link mt-1">Lihat semua →</a>
    </div>
    <div class="section-divider"></div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      @foreach ($buku as $item)
        <div class="col">
          <div class="book-card">

            {{-- Cover --}}
            <div class="book-cover-wrap">
              <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/300x190/EDE0BE/9A8860?text=No+Cover' }}"
                   alt="Cover {{ $item->judul }}">
            </div>

            {{-- Info --}}
            <div class="book-card-body">
              <span class="book-badge">Koleksi</span>
              <div class="book-card-title">{{ $item->judul }}</div>
              <div class="book-card-author">{{ $item->penulis }}</div>
              <span class="stok-badge">Stok: {{ $item->stok }}</span>
            </div>

            {{-- Footer --}}
            <div class="book-card-footer">
              <a href="{{ route('detailbuku.show', $item->id) }}" class="btn-detail">
                Detail Buku
              </a>
            </div>

          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>

@endsection