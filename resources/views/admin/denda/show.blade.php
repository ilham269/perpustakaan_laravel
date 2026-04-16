@extends('layouts.admin')
@section('title', 'Detail Denda')
@section('page-title', 'Detail Denda')

@push('styles')
@include('admin.partials.show-styles')
@include('admin.partials.modal-engine')
@endpush

@section('content')

<a href="{{ route('admin.denda.index') }}" class="show-back">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Denda
</a>

{{-- Denda highlight card --}}
<div class="denda-card {{ $denda->status === 'sudah bayar' ? 'lunas' : '' }} mb-4">
    <div class="denda-card-body">
        <div>
            <div class="denda-label">
                {{ $denda->status === 'sudah bayar' ? '✅ Denda Lunas' : '⚠️ Denda Belum Dibayar' }}
            </div>
            <div class="denda-amount">Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</div>
            <div class="denda-meta">Terlambat {{ $denda->terlambat_hari }} hari · Rp 1.000/hari</div>
        </div>
        @if ($denda->status === 'belum bayar')
        <form id="formBayar" action="{{ route('admin.denda.bayar', $denda) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="sa-btn sa-pay" style="font-size:14px;padding:10px 22px;">
                <i class="bi bi-cash-coin"></i> Tandai Lunas
            </button>
        </form>
        @else
        <div style="display:flex;align-items:center;gap:8px;color:#16a34a;font-weight:700;font-size:15px;">
            <i class="bi bi-check-circle-fill fs-4"></i> LUNAS
        </div>
        @endif
    </div>
</div>

{{-- Detail info --}}
<div class="show-card">
    <div class="show-card-head">
        <div class="show-card-title">Detail Denda #{{ $denda->id }}</div>
        <span class="show-badge {{ $denda->status === 'sudah bayar' ? 'sb-success' : 'sb-danger' }}">
            {{ $denda->status === 'sudah bayar' ? 'Lunas' : 'Belum Bayar' }}
        </span>
    </div>
    <div class="show-card-body">
        <div class="info-row">
            <span class="info-label">Peminjam</span>
            <span class="info-value">{{ $denda->peminjaman->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value muted">{{ $denda->peminjaman->user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Buku</span>
            <span class="info-value">{{ $denda->peminjaman->buku->judul }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Terlambat</span>
            <span class="info-value">
                <span class="show-badge sb-warning">{{ $denda->terlambat_hari }} hari</span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Denda</span>
            <span class="info-value" style="font-size:16px;font-weight:800;color:#dc2626;">
                Rp {{ number_format($denda->total_denda, 0, ',', '.') }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
                <span class="show-badge {{ $denda->status === 'sudah bayar' ? 'sb-success' : 'sb-danger' }}">
                    {{ $denda->status === 'sudah bayar' ? 'Lunas' : 'Belum Bayar' }}
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Dibuat</span>
            <span class="info-value muted">{{ $denda->created_at->format('d M Y, H:i') }}</span>
        </div>
    </div>
    <div class="show-card-foot">
        <a href="{{ route('admin.peminjaman.show', $denda->peminjaman) }}" class="sa-btn sa-edit" style="text-decoration:none;">
            <i class="bi bi-eye"></i> Lihat Peminjaman
        </a>
        <button class="sa-btn sa-del"
            onclick="kDeleteRedirect('{{ route('admin.denda.destroy', $denda) }}', '{{ route('admin.denda.index') }}', 'Hapus data denda ini?')">
            <i class="bi bi-trash"></i> Hapus
        </button>
    </div>
</div>

@endsection

@push('scripts')
<script>
async function kDeleteRedirect(url, redirectUrl, msg) {
    if (!confirm(msg)) return;
    const res = await fetch(url, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
    });
    const json = await res.json();
    if (res.ok) { kToast(json.message, 'success'); setTimeout(() => window.location = redirectUrl, 800); }
    else kToast(json.message || 'Gagal menghapus.', 'error');
}

// AJAX bayar denda
document.getElementById('formBayar')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const res = await fetch(this.action, {
        method: 'PATCH',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
    });
    const json = await res.json();
    if (res.ok) { kToast(json.message, 'success'); setTimeout(() => window.location.reload(), 800); }
    else kToast(json.message || 'Gagal.', 'error');
});
</script>
@endpush
