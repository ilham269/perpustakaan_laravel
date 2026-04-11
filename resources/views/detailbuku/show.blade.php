{{-- resources/views/buku/show.blade.php --}}
@extends('layouts.app')

@section('title', 'detail buku')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  .book-page {
    font-family: 'Lora', serif;
    display: flex;
    justify-content: center;
    padding: 2.5rem 1rem;
    min-height: 100vh;
    background: #F9F4EA;
  }

  .book-card {
    background: #FEFCF7;
    border: 1px solid #E8DFC8;
    border-radius: 16px;
    width: 100%;
    max-width: 440px;
    overflow: hidden;
  }

  .book-banner {
    background: linear-gradient(135deg, #F5EDD6 0%, #EDE0BE 100%);
    padding: 2rem;
    display: flex;
    justify-content: center;
    border-bottom: 1px solid #E0D2B0;
  }

  .book-cover {
    width: 140px;
    height: 195px;
    border-radius: 6px;
    border: 3px solid #D4C49A;
    box-shadow: 7px 7px 0px #C9B882;
    object-fit: cover;
  }

  .book-body {
    padding: 1.75rem 2rem 2rem;
  }

  .book-badge {
    display: inline-block;
    background: #F0E6C8;
    color: #8A7040;
    font-size: 11px;
    letter-spacing: 0.08em;
    padding: 3px 12px;
    border-radius: 20px;
    border: 1px solid #D4C490;
    margin-bottom: 12px;
    text-transform: uppercase;
  }

  .book-title {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 600;
    color: #3A2E1A;
    line-height: 1.3;
    margin: 0 0 6px;
  }

  .book-author {
    font-size: 14px;
    color: #8A7A55;
    font-style: italic;
    margin: 0 0 20px;
  }

  .divider {
    width: 40px;
    height: 2px;
    background: #D4C490;
    border-radius: 2px;
    margin-bottom: 20px;
  }

  .book-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 24px;
  }

  .meta-item {
    background: #FAF6EC;
    border: 1px solid #E8DFC8;
    border-radius: 8px;
    padding: 10px 14px;
  }

  .meta-label {
    font-size: 10px;
    color: #A0905E;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 4px;
  }

  .meta-value {
    font-size: 13px;
    font-weight: 500;
    color: #4A3C20;
  }

  .btn-pinjam {
    display: block;
    width: 100%;
    padding: 14px;
    background: #3A2E1A;
    color: #F5EDD6;
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    font-weight: 500;
    letter-spacing: 0.04em;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
  }

  .btn-pinjam:hover {
    background: #4E3D24;
    transform: translateY(-1px);
  }
</style>

<div class="book-page">
  <div class="book-card">

    {{-- Cover Buku --}}
    <div class="book-banner">
      <img class="book-cover"
           src="{{ $buku->gambar ? asset('storage/' . $buku->gambar) : 'https://via.placeholder.com/140x195/EDE0BE/9A8860?text=No+Cover' }}"
           alt="Cover {{ $buku->judul }}">
    </div>

    <div class="book-body">
      <span class="book-badge">Koleksi Perpustakaan</span>

      <h2 class="book-title">{{ $buku->judul }}</h2>
      <p class="book-author">{{ $buku->penulis }}</p>

      <div class="divider"></div>

      <div class="book-meta">
        <div class="meta-item">
          <div class="meta-label">Katalog</div>
          <div class="meta-value">{{ $buku->catalog->nama ?? '-' }}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Status</div>
          <div class="meta-value">{{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}</div>
        </div>
        <div class="meta-item" style="grid-column: 1 / -1;">
          <div class="meta-label">Deskripsi</div>
          <div class="meta-value">{{ $buku->deskripsi ?? 'Tidak ada deskripsi.' }}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Stok</div>
          <div class="meta-value">{{ $buku->stok }} buku</div>
        </div>
      </div>

      {{-- Tombol Pinjam --}}
      @auth
        @if ($buku->stok > 0)
          <a class="btn-pinjam" href="{{ route('user.peminjaman.create', ['buku_id' => $buku->id]) }}">
            📖 &nbsp;Pinjam Buku
          </a>
        @else
          <button class="btn-pinjam" disabled style="opacity:0.5;cursor:not-allowed;">
            Stok Habis
          </button>
        @endif
      @else
        <a class="btn-pinjam" href="{{ route('login') }}">
          Login untuk Meminjam
        </a>
      @endauth
    </div>

  </div>
</div>
@endsection