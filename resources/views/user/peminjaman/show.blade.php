@extends('layouts.app')
@section('title', 'Detail Peminjaman')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  .detail-page  { background: #F9F4EA; min-height: 100vh; padding: 2.5rem 0; font-family: 'Lora', serif; }
  .back-link    { font-size: 13px; color: #8A7040; text-decoration: none; }
  .back-link:hover { color: #3A2E1A; }

  .detail-card  { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 16px; overflow: hidden; margin-bottom: 16px; }
  .detail-head  { background: #F0E6C8; padding: 1.25rem 1.75rem; border-bottom: 1px solid #E8DFC8;
                  display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
  .book-cover   { width: 60px; height: 82px; object-fit: cover; border-radius: 6px; border: 2px solid #D4C49A; flex-shrink: 0; }
  .detail-judul { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: #3A2E1A; }
  .detail-penulis { font-size: 13px; color: #8A7A55; font-style: italic; }

  .detail-body  { padding: 1.5rem 1.75rem; }
  .row-info     { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #F0E6C8; font-size: 14px; }
  .row-info:last-child { border-bottom: none; }
  .row-label    { color: #A0905E; }
  .row-value    { color: #3A2E1A; font-weight: 500; text-align: right; }

  .badge-status { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
  .badge-pending      { background: #FFF3CD; color: #856404; }
  .badge-disetujui    { background: #D1E7DD; color: #0A5C36; }
  .badge-ditolak      { background: #F8D7DA; color: #842029; }
  .badge-dikembalikan { background: #CFE2FF; color: #084298; }

  /* Denda card */
  .denda-card   { background: #FFF5F5; border: 1px solid #F5C6C6; border-left: 4px solid #D4654A;
                  border-radius: 12px; padding: 1.25rem 1.5rem; }
  .denda-card.lunas { background: #F0FFF4; border-color: #A3CFBB; border-left-color: #2E7D52; }
  .denda-title  { font-family: 'Playfair Display', serif; font-size: 13px; text-transform: uppercase;
                  letter-spacing: .08em; color: #C0522A; margin-bottom: 6px; }
  .denda-card.lunas .denda-title { color: #2E7D52; }
  .denda-amount { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 600; color: #C0522A; }
  .denda-card.lunas .denda-amount { color: #2E7D52; }
  .denda-meta   { font-size: 12px; color: #8A7A55; margin-top: 4px; }

  /* Timeline status */
  .timeline     { padding: 1rem 0; }
  .tl-step      { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 16px; }
  .tl-dot       { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center;
                  justify-content: center; font-size: 13px; flex-shrink: 0; margin-top: 2px; }
  .tl-dot.done  { background: #D1E7DD; color: #0A5C36; }
  .tl-dot.active{ background: #3A2E1A; color: #F5EDD6; }
  .tl-dot.wait  { background: #F0E6C8; color: #A0905E; }
  .tl-label     { font-size: 14px; color: #3A2E1A; font-weight: 500; }
  .tl-sub       { font-size: 12px; color: #8A7A55; font-style: italic; }
</style>

<div class="detail-page">
  <div class="container" style="max-width: 620px;">

    <a href="{{ route('user.peminjaman.index') }}" class="back-link">
      ← Kembali ke Riwayat
    </a>

    {{-- Header buku --}}
    <div class="detail-card mt-3">
      <div class="detail-head">
        <img class="book-cover"
             src="{{ $peminjaman->buku->gambar ? asset('storage/'.$peminjaman->buku->gambar) : 'https://via.placeholder.com/60x82/EDE0BE/9A8860?text=📖' }}"
             alt="{{ $peminjaman->buku->judul }}">
        <div>
          <div class="detail-judul">{{ $peminjaman->buku->judul }}</div>
          <div class="detail-penulis">{{ $peminjaman->buku->penulis }}</div>
          <span class="badge-status badge-{{ $peminjaman->status }} mt-2 d-inline-block">
            {{ ucfirst($peminjaman->status) }}
          </span>
        </div>
      </div>
      <div class="detail-body">
        <div class="row-info">
          <span class="row-label">Tanggal Request</span>
          <span class="row-value">{{ $peminjaman->tanggal_request->format('d M Y') }}</span>
        </div>
        <div class="row-info">
          <span class="row-label">Tanggal Dipinjam</span>
          <span class="row-value">{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '—' }}</span>
        </div>
        <div class="row-info">
          <span class="row-label">Batas Kembali</span>
          <span class="row-value">
            @if ($peminjaman->tanggal_pinjam)
              {{ $peminjaman->tanggal_pinjam->addDays(7)->format('d M Y') }}
            @else
              —
            @endif
          </span>
        </div>
        <div class="row-info">
          <span class="row-label">Tanggal Dikembalikan</span>
          <span class="row-value">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '—' }}</span>
        </div>
      </div>
    </div>

    {{-- Timeline status --}}
    <div class="detail-card">
      <div class="detail-body">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:.09em;color:#A0905E;margin-bottom:14px;">
          Status Peminjaman
        </div>
        <div class="timeline">
          @php
            $steps = [
              'pending'      => ['label' => 'Permintaan Dikirim',    'sub' => 'Menunggu persetujuan admin'],
              'disetujui'    => ['label' => 'Disetujui Admin',       'sub' => 'Buku siap diambil'],
              'dikembalikan' => ['label' => 'Buku Dikembalikan',     'sub' => 'Proses selesai'],
            ];
            $order  = array_keys($steps);
            $current = $peminjaman->status === 'ditolak' ? 'ditolak' : $peminjaman->status;
          @endphp

          @if ($peminjaman->status === 'ditolak')
            <div class="tl-step">
              <div class="tl-dot" style="background:#F8D7DA;color:#842029;">✕</div>
              <div>
                <div class="tl-label" style="color:#842029;">Permintaan Ditolak</div>
                <div class="tl-sub">Hubungi admin untuk informasi lebih lanjut</div>
              </div>
            </div>
          @else
            @foreach ($steps as $key => $step)
              @php
                $idx     = array_search($key, $order);
                $curIdx  = array_search($current, $order);
                $isDone  = $idx < $curIdx;
                $isActive= $idx === $curIdx;
              @endphp
              <div class="tl-step">
                <div class="tl-dot {{ $isDone ? 'done' : ($isActive ? 'active' : 'wait') }}">
                  {{ $isDone ? '✓' : ($isActive ? '●' : '○') }}
                </div>
                <div>
                  <div class="tl-label">{{ $step['label'] }}</div>
                  <div class="tl-sub">{{ $step['sub'] }}</div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>

    {{-- Denda (kalau ada) --}}
    @if ($peminjaman->denda)
      <div class="denda-card {{ $peminjaman->denda->status === 'sudah bayar' ? 'lunas' : '' }}">
        <div class="denda-title">
          {{ $peminjaman->denda->status === 'sudah bayar' ? '✅ Denda Lunas' : '⚠️ Denda Keterlambatan' }}
        </div>
        <div class="denda-amount">
          Rp {{ number_format($peminjaman->denda->total_denda, 0, ',', '.') }}
        </div>
        <div class="denda-meta">
          Terlambat {{ $peminjaman->denda->terlambat_hari }} hari
          · Rp 1.000/hari
          @if ($peminjaman->denda->status === 'belum bayar')
            · <strong>Harap segera bayar ke petugas perpustakaan</strong>
          @endif
        </div>
      </div>
    @endif

  </div>
</div>
@endsection
