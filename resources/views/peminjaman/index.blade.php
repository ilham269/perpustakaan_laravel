@extends('layouts.admin')
@section('title', 'Data Peminjaman')
@section('page-title', 'Data Peminjaman')

@push('styles')
@include('admin.partials.index-styles')
<style>
.filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
.filter-bar select, .filter-bar input {
    font-size: 13px; padding: 7px 12px; border: 1px solid #e5e7eb;
    border-radius: 8px; background: #fff; color: #374151; outline: none;
}
.filter-bar select:focus, .filter-bar input:focus { border-color: #0d6efd; }
.filter-bar button {
    font-size: 13px; padding: 7px 16px; background: #f1f5f9; border: 1px solid #e5e7eb;
    border-radius: 8px; cursor: pointer; color: #374151; transition: background .15s;
}
.filter-bar button:hover { background: #e2e8f0; }
</style>
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div>
        <div class="idx-count">{{ $peminjaman->total() }} data peminjaman</div>
    </div>
    <a href="{{ route('admin.peminjaman.create') }}" class="idx-btn-add">
        <i class="bi bi-plus-lg me-1"></i> Tambah
    </a>
</div>

{{-- Filter status --}}
<form method="GET" class="filter-bar">
    <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach (['pending','disetujui','ditolak','dikembalikan'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
        @endforeach
    </select>
    @if (request('status'))
        <a href="{{ route('admin.peminjaman.index') }}" class="ia-btn ia-del" title="Reset filter" style="width:auto;padding:0 12px;font-size:12px;text-decoration:none;">
            <i class="bi bi-x me-1"></i> Reset
        </a>
    @endif
</form>

<div class="idx-card">
    <div class="table-responsive">
        <table class="idx-table">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th style="width:120px">Tgl Request</th>
                    <th style="width:120px">Tgl Kembali</th>
                    <th style="width:120px">Status</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $p)
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}</td>
                    <td>
                        <div class="fw-semibold">{{ $p->user->name }}</div>
                        <div style="font-size:12px;color:#9ca3af;">{{ $p->user->email }}</div>
                    </td>
                    <td class="text-muted">{{ $p->buku->judul }}</td>
                    <td style="font-size:13px;">{{ $p->tanggal_request->format('d M Y') }}</td>
                    <td style="font-size:13px;">{{ $p->tanggal_kembali?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <span class="idx-badge badge-{{ $p->status }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="idx-actions">
                            <a href="{{ route('admin.peminjaman.show', $p) }}" class="ia-btn ia-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.peminjaman.edit', $p) }}" class="ia-btn ia-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.peminjaman.destroy', $p) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="ia-btn ia-del" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="idx-empty">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($peminjaman->hasPages())
    <div class="idx-pagination">{{ $peminjaman->links()->withQueryString() }}</div>
    @endif
</div>

@endsection
