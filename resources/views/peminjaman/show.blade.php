@extends('layouts.app')
@section('title', 'Detail Peminjaman')

@section('content')
<style>
    /* Card Styling */
.card {
    border-radius: 12px;
    transition: transform 0.2s ease;
}

/* Badge Custom */
.badge {
    padding: 8px 16px;
    font-weight: 500;
}

/* Table styling for details */
.table td {
    border-color: #3A2E1A;
    vertical-align: middle;
}

/* Custom Backgrounds */
body {
    background-color: #f4f7f6; /* Warna background abu-abu sangat muda */
}

/* Button Styling */
.btn-sm {
    border-radius: 8px;
    padding: 6px 12px;
}

/* Border Danger untuk Card Denda */
.border-danger {
    border-left-width: 5px !important;
}

/* Icon colors */
.bi-arrow-left-short {
    vertical-align: middle;
    line-height: 0;
}
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12">

            <div class="mb-4">
                <a href="{{ route('peminjaman.index') }}" class="btn btn-link text-decoration-none text-muted p-0">
                    <i class="bi bi-arrow-left-short fs-4"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">Detail Peminjaman <span class="text-primary">#{{ $peminjaman->id }}</span></h5>
                    <span class="badge rounded-pill bg-{{ $peminjaman->status == 'disetujui' ? 'success' : ($peminjaman->status == 'pending' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($peminjaman->status) }}
                    </span>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                                <tr>
                                    <td class="ps-4 text-muted py-3" width="30%">Nama Peminjam</td>
                                    <td class="fw-semibold py-3">{{ $peminjaman->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-muted py-3">Judul Buku</td>
                                    <td class="fw-semibold py-3 text-primary">{{ $peminjaman->buku->judul }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-muted py-3">Tanggal Request</td>
                                    <td class="py-3">{{ $peminjaman->tanggal_request->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-muted py-3">Estimasi Pinjam</td>
                                    <td class="py-3 text-success fw-medium">{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? 'Belum Diambil' }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-muted py-3">Batas Kembali</td>
                                    <td class="py-3 text-danger fw-medium">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-light border-top py-3 px-4 d-flex">
                    <a href="{{ route('peminjaman.edit', $peminjaman) }}" class="btn btn-warning btn-sm me-2 text-white px-3">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                    <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST" onsubmit="return confirm('Hapus data peminjaman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Card Denda --}}
            @if ($peminjaman->denda)
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body d-flex align-items-center justify-content-between py-4">
                    <div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Informasi Denda</h6>
                        <h3 class="mb-0 fw-bold text-danger">Rp {{ number_format($peminjaman->denda->total_denda, 0, ',', '.') }}</h3>
                        <p class="mb-0 text-muted small">Terlambat: {{ $peminjaman->denda->terlambat_hari }} Hari</p>
                    </div>
                    
                    <div class="text-end">
                        @if ($peminjaman->denda->status === 'belum bayar')
                            <form action="{{ route('denda.bayar', $peminjaman->denda) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger px-4 shadow-sm">
                                    <i class="bi bi-cash-coin me-2"></i> Bayar Sekarang
                                </button>
                            </form>
                        @else
                            <div class="d-flex align-items-center text-success fw-bold">
                                <i class="bi bi-check-circle-fill me-2 fs-4"></i> LUNAS
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection