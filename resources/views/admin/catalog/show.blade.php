@extends('layouts.admin')
@section('title', 'Detail Katalog')
@section('page-title', 'Detail Katalog')

@push('styles')
@include('admin.partials.show-styles')
@include('admin.partials.modal-engine')
@endpush

@section('content')

<a href="{{ route('admin.catalog.index') }}" class="show-back">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Katalog
</a>

<div class="show-card">
    <div class="show-card-head">
        <div>
            <div class="show-card-title">{{ $catalog->nama }}</div>
            <div class="show-card-sub">{{ $catalog->bukus->count() }} buku dalam katalog ini</div>
        </div>
        <span class="show-badge sb-info">Katalog</span>
    </div>

    <div class="show-card-body">
        <div class="info-row">
            <span class="info-label">Nama</span>
            <span class="info-value">{{ $catalog->nama }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jumlah Buku</span>
            <span class="info-value">{{ $catalog->bukus->count() }} buku</span>
        </div>
        <div class="info-row">
            <span class="info-label">Dibuat</span>
            <span class="info-value muted">{{ $catalog->created_at->format('d M Y, H:i') }}</span>
        </div>
    </div>

    <div class="show-card-foot">
        <button class="sa-btn sa-edit"
            onclick="openEditKatalog({{ $catalog->id }}, '{{ addslashes($catalog->nama) }}')">
            <i class="bi bi-pencil"></i> Edit
        </button>
        <button class="sa-btn sa-del"
            onclick="kDeleteRedirect('{{ route('admin.catalog.destroy', $catalog) }}', '{{ route('admin.catalog.index') }}', 'Hapus katalog ini?')">
            <i class="bi bi-trash"></i> Hapus
        </button>
    </div>
</div>

{{-- Daftar Buku --}}
<div class="sub-table-card">
    <div class="sub-table-head">Daftar Buku dalam Katalog Ini</div>
    <div class="table-responsive">
        <table class="sub-table">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th style="width:80px">Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($catalog->bukus as $buku)
                <tr>
                    <td class="text-muted">{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $buku->judul }}</td>
                    <td class="text-muted">{{ $buku->penulis }}</td>
                    <td>
                        <span class="show-badge {{ $buku->stok > 0 ? 'sb-success' : 'sb-danger' }}">
                            {{ $buku->stok }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="sub-empty"><i class="bi bi-inbox d-block fs-3 mb-2"></i>Belum ada buku di katalog ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit --}}
<div class="kmodal-overlay" id="modalEditKatalog">
    <div class="kmodal">
        <div class="kmodal-header">
            <span class="kmodal-title">✏️ Edit Katalog</span>
            <button class="kmodal-close" onclick="kCloseModal('modalEditKatalog')">✕</button>
        </div>
        <form id="formEditKatalog" action="" method="POST">
            @csrf @method('PUT')
            <div class="kmodal-body">
                <div class="kfield">
                    <label>Nama Katalog</label>
                    <input type="text" name="nama" id="edit-nama-katalog" class="kinput" required>
                    <span class="kerror" data-err="nama"></span>
                </div>
            </div>
            <div class="kmodal-footer">
                <button type="button" class="kbtn kbtn-ghost" onclick="kCloseModal('modalEditKatalog')">Batal</button>
                <button type="submit" class="kbtn kbtn-primary"><i class="bi bi-check-lg"></i> Perbarui</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditKatalog(id, nama) {
    document.getElementById('edit-nama-katalog').value = nama;
    document.getElementById('formEditKatalog').action = `/admin/catalog/${id}`;
    kOpenModal('modalEditKatalog');
}

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

kSubmitForm('formEditKatalog', 'modalEditKatalog', (data) => {
    kToast('Katalog berhasil diperbarui.', 'success');
    document.querySelector('.show-card-title').textContent = data.nama;
    document.querySelector('.info-row .info-value').textContent = data.nama;
});
</script>
@endpush
