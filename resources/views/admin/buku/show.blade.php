@extends('layouts.admin')
@section('title', $buku->judul)
@section('page-title', 'Detail Buku')

@push('styles')
@include('admin.partials.show-styles')
@include('admin.partials.index-styles')
@include('admin.partials.modal-engine')
@endpush

@section('content')

<a href="{{ route('admin.buku.index') }}" class="show-back">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
</a>

{{-- ── Main Card ── --}}
<div class="show-card">
    <div class="show-card-head">
        <div class="d-flex align-items-center gap-3">
            @if ($buku->gambar)
                <img src="{{ asset('storage/'.$buku->gambar) }}" class="show-cover" alt="{{ $buku->judul }}">
            @else
                <div class="show-cover-placeholder"><i class="bi bi-book"></i></div>
            @endif
            <div>
                <div class="show-card-title">{{ $buku->judul }}</div>
                <div class="show-card-sub">{{ $buku->penulis }}</div>
                <div class="mt-2 d-flex gap-2 flex-wrap">
                    <span class="show-badge {{ $buku->stok > 0 ? 'sb-success' : 'sb-danger' }}">
                        Stok: {{ $buku->stok }}
                    </span>
                    @if ($buku->catalog)
                        <span class="show-badge sb-info">{{ $buku->catalog->nama }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="show-card-body">
        <div class="info-row">
            <span class="info-label">Judul</span>
            <span class="info-value">{{ $buku->judul }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Penulis</span>
            <span class="info-value">{{ $buku->penulis }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Katalog</span>
            <span class="info-value">{{ $buku->catalog->nama ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Stok</span>
            <span class="info-value">{{ $buku->stok }} eksemplar</span>
        </div>
        <div class="info-row">
            <span class="info-label">Deskripsi</span>
            <span class="info-value muted">{{ $buku->deskripsi ?? 'Tidak ada deskripsi.' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Ditambahkan</span>
            <span class="info-value muted">{{ $buku->created_at->format('d M Y, H:i') }}</span>
        </div>
    </div>

    <div class="show-card-foot">
        <button class="sa-btn sa-edit"
            onclick="openEditBuku(
                {{ $buku->id }},
                '{{ addslashes($buku->judul) }}',
                '{{ addslashes($buku->penulis) }}',
                {{ $buku->catalog_id ?? 'null' }},
                {{ $buku->stok }},
                '{{ addslashes($buku->deskripsi ?? '') }}',
                '{{ $buku->gambar ? asset('storage/'.$buku->gambar) : '' }}'
            )">
            <i class="bi bi-pencil"></i> Edit
        </button>
        <button class="sa-btn sa-del"
            onclick="kDeleteRedirect('{{ route('admin.buku.destroy', $buku) }}', '{{ route('admin.buku.index') }}', 'Hapus buku ini?')">
            <i class="bi bi-trash"></i> Hapus
        </button>
    </div>
</div>

{{-- ── Riwayat Peminjaman ── --}}
<div class="sub-table-card">
    <div class="sub-table-head">Riwayat Peminjaman</div>
    <div class="table-responsive">
        <table class="sub-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku->peminjaman as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->user->name }}</td>
                    <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '—' }}</td>
                    <td>{{ $p->tanggal_kembali?->format('d M Y') ?? '—' }}</td>
                    <td><span class="show-badge sb-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" class="sub-empty"><i class="bi bi-inbox d-block fs-3 mb-2"></i>Belum ada riwayat peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Modal Edit (reuse dari index) ── --}}
<div class="kmodal-overlay" id="modalEditBuku">
    <div class="kmodal wide">
        <div class="kmodal-header">
            <span class="kmodal-title">✏️ Edit Buku</span>
            <button class="kmodal-close" onclick="kCloseModal('modalEditBuku')">✕</button>
        </div>
        <form id="formEditBuku" action="" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="kmodal-body">
                <div class="ksection">Informasi Buku</div>
                <div class="kfield">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" id="edit-judul" class="kinput" required>
                    <span class="kerror" data-err="judul"></span>
                </div>
                <div class="kfield">
                    <label>Penulis</label>
                    <input type="text" name="penulis" id="edit-penulis" class="kinput" required>
                    <span class="kerror" data-err="penulis"></span>
                </div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Katalog <span class="opt">(opsional)</span></label>
                        <select name="catalog_id" id="edit-catalog" class="kselect">
                            <option value="">— Pilih Katalog —</option>
                            @foreach(\App\Models\Catalog::orderBy('nama')->get() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="catalog_id"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Stok</label>
                        <input type="number" name="stok" id="edit-stok" class="kinput" min="0" required>
                        <span class="kerror" data-err="stok"></span>
                    </div>
                </div>
                <div class="kfield" style="margin-top:14px">
                    <label>Deskripsi <span class="opt">(opsional)</span></label>
                    <textarea name="deskripsi" id="edit-deskripsi" class="ktextarea"></textarea>
                    <span class="kerror" data-err="deskripsi"></span>
                </div>
                <div class="ksection">Cover Buku</div>
                <div class="kfield">
                    <label>Ganti Cover <span class="opt">(kosongkan jika tidak diganti)</span></label>
                    <div class="kcover-wrap">
                        <img id="edit-preview" class="kcover-img" src="" alt="Cover">
                    </div>
                    <input type="file" name="gambar" class="kfile-input" accept="image/*"
                           onchange="previewCover(this,'edit-preview',null)">
                    <span class="kerror" data-err="gambar"></span>
                </div>
            </div>
            <div class="kmodal-footer">
                <button type="button" class="kbtn kbtn-ghost" onclick="kCloseModal('modalEditBuku')">Batal</button>
                <button type="submit" class="kbtn kbtn-primary"><i class="bi bi-check-lg"></i> Perbarui</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewCover(input, previewId, placeholderId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.style.display = 'block';
        if (placeholderId) { const ph = document.getElementById(placeholderId); if (ph) ph.style.display = 'none'; }
    };
    reader.readAsDataURL(file);
}

function openEditBuku(id, judul, penulis, catalogId, stok, deskripsi, gambarUrl) {
    document.getElementById('edit-judul').value     = judul;
    document.getElementById('edit-penulis').value   = penulis;
    document.getElementById('edit-stok').value      = stok;
    document.getElementById('edit-deskripsi').value = deskripsi;
    document.getElementById('edit-catalog').value   = catalogId || '';
    const preview = document.getElementById('edit-preview');
    preview.src = gambarUrl || 'https://via.placeholder.com/64x88/f1f5f9/94a3b8?text=📖';
    document.getElementById('formEditBuku').action = `/admin/buku/${id}`;
    kOpenModal('modalEditBuku');
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

kSubmitForm('formEditBuku', 'modalEditBuku', () => window.location.reload());
</script>
@endpush
