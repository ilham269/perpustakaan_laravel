@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">

    <div class="mb-4">
        <h3 style="color: var(--secondary-color);">Dashboard</h3>
        <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-5">
        <div class="col-lg-3 col-md-6 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-icon" style="background: rgba(129,178,154,0.15);">
                    <i class="bi-book" style="color: var(--primary-color);"></i>
                </div>
                <div>
                    <div class="dashboard-card-value">{{ $stats['total_buku'] }}</div>
                    <div class="dashboard-card-label">Total Buku</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-icon" style="background: rgba(61,64,91,0.1);">
                    <i class="bi-arrow-left-right" style="color: var(--secondary-color);"></i>
                </div>
                <div>
                    <div class="dashboard-card-value">{{ $stats['total_peminjaman'] }}</div>
                    <div class="dashboard-card-label">Total Peminjaman</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-icon" style="background: rgba(242,204,143,0.2);">
                    <i class="bi-hourglass-split" style="color: #c9a227;"></i>
                </div>
                <div>
                    <div class="dashboard-card-value">{{ $stats['pending'] }}</div>
                    <div class="dashboard-card-label">Menunggu Persetujuan</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="dashboard-card">
                <div class="dashboard-card-icon" style="background: rgba(224,122,95,0.15);">
                    <i class="bi-exclamation-triangle" style="color: var(--custom-btn-bg-hover-color);"></i>
                </div>
                <div>
                    <div class="dashboard-card-value">{{ $stats['denda_belum_bayar'] }}</div>
                    <div class="dashboard-card-label">Denda Belum Lunas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3 mb-5">
        <div class="col-12">
            <h5 style="color: var(--secondary-color);">Aksi Cepat</h5>
        </div>
        
        <div class="col-auto">
            <a href="{{ route('peminjaman.create') }}" class="btn custom-btn">
                <i class="bi-plus-circle me-1"></i> Tambah Peminjaman
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('denda.index') }}" class="btn custom-border-btn custom-btn">
                <i class="bi-cash me-1"></i> Kelola Denda
            </a>
        </div>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="row">
        <div class="col-12">
            <div class="table-card">
                <div class="table-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Peminjaman Terbaru</h5>
                    <a href="{{ route('peminjaman.index') }}" class="btn custom-border-btn custom-btn btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tgl Request</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman_terbaru as $p)
                            <tr>
                                <td>{{ $p->user->name }}</td>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tanggal_request->format('d M Y') }}</td>
                                <td>
                                    <span class="badge-status badge-{{ $p->status }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('peminjaman.show', $p) }}" class="btn btn-sm custom-border-btn custom-btn">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .dashboard-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .dashboard-card-icon {
        width: 52px; height: 52px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .dashboard-card-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--secondary-color);
        line-height: 1;
    }
    .dashboard-card-label {
        font-size: 0.82rem;
        color: var(--p-color);
        margin-top: 4px;
    }
    .table-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .table-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f0f0;
    }
    .table-card .table thead tr {
        background-color: var(--secondary-color);
        color: #fff;
    }
    .table-card .table thead th {
        padding: 14px 16px;
        font-weight: 500;
        font-size: 0.88rem;
        border: 0;
    }
    .table-card .table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.9rem;
        border-color: #f5f5f5;
    }
    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .badge-pending      { background: #fff3cd; color: #856404; }
    .badge-disetujui    { background: #d1e7dd; color: #0a5c36; }
    .badge-ditolak      { background: #f8d7da; color: #842029; }
    .badge-dikembalikan { background: #cfe2ff; color: #084298; }
</style>
@endpush
