@extends('layouts.app')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-12">

            <div class="mb-4">
                <a href="{{ route('peminjaman.index') }}" class="back-link">
                    <i class="bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="detail-card mb-4">
                <div class="detail-card-header">
                    <h5 class="mb-0">Detail Peminjaman #{{ $peminjaman->id }}</h5>
                </div>
                <div class="detail-card-body">
                    <div class="detail-row">
                        <span class="detail-label">Peminjam</span>
                        <span class="detail-value">{{ $peminjaman->user->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Buku</span>
                        <span class="detail-value">{{ $peminjaman->buku->judul }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tgl Request</span>
                        <span class="detail-value">{{ $peminjaman->tanggal_request->format('d M Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tgl Pinjam</span>
                        <span class="detail-value">{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tgl Kembali</span>
                        <span class="detail-value">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="badge-status badge-{{ $peminjaman->status }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                </div>
                <div class="detail-card-footer">
                    <a href="{{ route('peminjaman.edit', $peminjaman) }}" class="btn custom-btn btn-sm me-2">
                        <i class="bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn custom-border-btn custom-btn btn-sm">
                            <i class="bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info Denda --}}
            @if ($peminjaman->denda)
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="mb-0">Informasi Denda</h5>
                </div>
                <div class="detail-card-body">
                    <div class="detail-row">
                        <span class="detail-label">Terlambat</span>
                        <span class="detail-value">{{ $peminjaman->denda->terlambat_hari }} hari</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Denda</span>
                        <span class="detail-value">Rp {{ number_format($peminjaman->denda->total_denda, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status Denda</span>
                        <span class="badge-status {{ $peminjaman->denda->status === 'sudah bayar' ? 'badge-disetujui' : 'badge-ditolak' }}">
                            {{ ucfirst($peminjaman->denda->status) }}
                        </span>
                    </div>
                </div>
                @if ($peminjaman->denda->status === 'belum bayar')
                <div class="detail-card-footer">
                    <form action="{{ route('denda.bayar', $peminjaman->denda) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn custom-btn btn-sm">
                            <i class="bi-cash me-1"></i> Tandai Lunas
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

