@extends('layouts.admin')
@section('title', 'Detail Denda')
@section('page-title', 'Detail Denda')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-12">

            <div class="mb-4">
                <a href="{{ route('admin.denda.index') }}" class="back-link">
                    <i class="bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="mb-0">Detail Denda #{{ $denda->id }}</h5>
                </div>
                <div class="detail-card-body">
                    <div class="detail-row">
                        <span class="detail-label">Peminjam</span>
                        <span class="detail-value">{{ $denda->peminjaman->user->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Buku</span>
                        <span class="detail-value">{{ $denda->peminjaman->buku->judul }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Terlambat</span>
                        <span class="detail-value">{{ $denda->terlambat_hari }} hari</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Denda</span>
                        <span class="detail-value fw-bold">
                            Rp {{ number_format($denda->total_denda, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="badge-status {{ $denda->status === 'sudah bayar' ? 'badge-disetujui' : 'badge-ditolak' }}">
                            {{ ucfirst($denda->status) }}
                        </span>
                    </div>
                </div>
                @if ($denda->status === 'belum bayar')
                <div class="detail-card-footer">
                    <form action="{{ route('admin.denda.bayar', $denda) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn custom-btn btn-sm">
                            <i class="bi-cash me-1"></i> Tandai Lunas
                        </button>
                    </form>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

