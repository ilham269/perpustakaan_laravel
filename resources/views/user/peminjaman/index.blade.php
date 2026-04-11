@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  .riwayat-page { background: #F9F4EA; min-height: 100vh; padding: 2.5rem 0; font-family: 'Lora', serif; }
  .page-label   { font-size: 11px; text-transform: uppercase; letter-spacing: .1em; color: #A0905E; margin-bottom: 6px; }
  .page-title   { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #3A2E1A; }
  .page-divider { width: 44px; height: 2px; background: #D4C490; border-radius: 2px; margin: 10px 0 2rem; }

  .btn-pinjam-baru { display: inline-block; background: #3A2E1A; color: #F5EDD6 !important; font-family: 'Playfair Display', serif;
                     font-size: 13px; font-weight: 500; padding: 10px 22px; border-radius: 10px; text-decoration: none;
                     letter-spacing: .04em; transition: background .2s; }
  .btn-pinjam-baru:hover { background: #4E3D24; }

  .pinjam-card { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 14px; overflow: hidden;
                 margin-bottom: 14px; transition: box-shadow .2s; }
  .pinjam-card:hover { box-shadow: 0 6px 20px rgba(90,60,20,.08); }
  .pinjam-card-body { padding: 16px 20px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
  .book-cover-sm { width: 48px; height: 64px; object-fit: cover; border-radius: 6px; border: 1px solid #D4C49A; flex-shrink: 0; }
  .pinjam-info { flex: 1; min-width: 0; }
  .pinjam-judul { font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 600; color: #3A2E1A; }
  .pinjam-meta  { font-size: 12px; color: #8A7A55; margin-top: 3px; }

  .badge-status { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
  .badge-pending      { background: #FFF3CD; color: #856404; }
  .badge-disetujui    { background: #D1E7DD; color: #0A5C36; }
  .badge-ditolak      { background: #F8D7DA; color: #842029; }
  .badge-dikembalikan { background: #CFE2FF; color: #084298; }

  .denda-pill { background: #FDE8E8; color: #C0522A; border: 1px solid #F5C6C6; border-radius: 20px;
                font-size: 11px; padding: 3px 12px; display: inline-block; margin-top: 4px; }
  .denda-lunas { background: #D1E7DD; color: #0A5C36; border-color: #A3CFBB; }

  .btn-detail { font-size: 12px; color: #8A7040; text-decoration: none; border: 1px solid #D4C490;
                padding: 6px 14px; border-radius: 8px; transition: all .15s; white-space: nowrap; }
  .btn-detail:hover { background: #F0E6C8; color: #3A2E1A; }

  .empty-state { text-align: center; padding: 3rem 1rem; color: #A0905E; font-style: italic; }
  .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; }

  .alert-success-custom { background: #F0E6C8; border: 1px solid #D4C490; color: #5C4220;
                          border-radius: 10px; padding: 12px 16px; margin-bottom: 1.5rem; font-size: 14px; }
</style>

<div class="riwayat-page">
  <div class="container" style="max-width: 720px;">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-1">
      <div>
        <div class="page-label">Akun Saya</div>
        <div class="page-title">Riwayat Peminjaman</div>
      </div>
      <a href="{{ route('user.peminjaman.create') }}" class="btn-pinjam-baru mt-2">
        + &nbsp;Pinjam Buku Baru
      </a>
    </div>
    <div class="page-divider"></div>

    @if (session('success'))
      <div class="alert-success-custom">✅ &nbsp;{{ session('success') }}</div>
    @endif

    @forelse ($peminjaman as $p)
      <div class="pinjam-card">
        <div class="pinjam-card-body">

          <img class="book-cover-sm"
               src="{{ $p->buku->gambar ? asset('storage/'.$p->buku->gambar) : 'https://via.placeholder.com/48x64/EDE0BE/9A8860?text=📖' }}"
               alt="{{ $p->buku->judul }}">

          <div class="pinjam-info">
            <div class="pinjam-judul">{{ $p->buku->judul }}</div>
            <div class="pinjam-meta">
              Diminta: {{ $p->tanggal_request->format('d M Y') }}
              @if ($p->tanggal_pinjam)
                &nbsp;·&nbsp; Dipinjam: {{ $p->tanggal_pinjam->format('d M Y') }}
              @endif
              @if ($p->tanggal_kembali)
                &nbsp;·&nbsp; Dikembalikan: {{ $p->tanggal_kembali->format('d M Y') }}
              @endif
            </div>
            <div class="mt-2">
              <span class="badge-status badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
              @if ($p->denda)
                <span class="denda-pill {{ $p->denda->status === 'sudah bayar' ? 'denda-lunas' : '' }}">
                  Denda Rp {{ number_format($p->denda->total_denda, 0, ',', '.') }}
                  — {{ $p->denda->status === 'sudah bayar' ? 'Lunas' : 'Belum Bayar' }}
                </span>
              @endif
            </div>
          </div>

          <a href="{{ route('user.peminjaman.show', $p) }}" class="btn-detail">Detail</a>

        </div>
      </div>
    @empty
      <div class="empty-state">
        <div class="icon">📚</div>
        <p>Kamu belum pernah meminjam buku.</p>
        <a href="{{ route('user.peminjaman.create') }}" class="btn-pinjam-baru">Pinjam Sekarang</a>
      </div>
    @endforelse

    @if ($peminjaman->hasPages())
      <div class="mt-3">{{ $peminjaman->links() }}</div>
    @endif

  </div>
</div>
@endsection
