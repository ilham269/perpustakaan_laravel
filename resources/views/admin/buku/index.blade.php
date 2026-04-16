@extends('layouts.admin')
@section('title', 'Data Buku')
@section('page-title', 'Data Buku')

@push('styles')
@include('admin.partials.index-styles')
@include('admin.partials.modal-engine')
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div class="idx-count">{{ $bukus->total() }} buku terdaftar</div>
    <button class="idx-btn-add" onclick="kOpenModal('modalTambahBuku')">
        <i class="bi bi-plus-lg me-1"></i> Tambah Buku
    </button>
</div>

<div class="idx-card">
    <div class="table-responsive">
        <table class="idx-table">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th style="width:72px">Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Katalog</th>
                    <th style="width:80px">Stok</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody id="bukuTableBody">
                @forelse ($bukus as $buku)
                <tr id="buku-row-{{ $buku->id }}">
                    <td class="text-muted">{{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}</td>
                    <td>
                        <img src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/48x64/f1f5f9/94a3b8?text=📖' }}"
                             class="idx-cover" alt="{{ $buku->judul }}">
                    </td>
                    <td class="fw-semibold">{{ $buku->judul }}</td>
                    <td class="text-muted">{{ $buku->penulis }}</td>
                    <td><span class="idx-badge badge-secondary">{{ $buku->catalog->nama ?? '—' }}</span></td>
                    <td>
                        <span class="idx-badge {{ $buku->stok > 0 ? 'badge-success' : 'badge-danger' }}">
                            {{ $buku->stok }}
                        </span>
                    </td>
                    <td>
                        <div class="idx-actions">
                            <a href="{{ route('admin.buku.show', $buku) }}" class="ia-btn ia-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="ia-btn ia-edit" title="Edit"
                                onclick="openEditBuku({{ $buku->id }}, '{{ addslashes($buku->judul) }}', '{{ addslashes($buku->penulis) }}', {{ $buku->catalog_id ?? 'null' }}, {{ $buku->stok }}, '{{ addslashes($buku->deskripsi ?? '') }}', '{{ $buku->gambar ? asset('storage/'.$buku->gambar) : '' }}')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="ia-btn ia-del" title="Hapus"
                                onclick="kDelete('{{ route('admin.buku.destroy', $buku) }}', 'buku-row-{{ $buku->id }}', 'Hapus buku ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="idx-empty">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data buku.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($bukus->hasPages())
    <div class="idx-pagination">{{ $bukus->links() }}</div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════════════
     MODAL TAMBAH BUKU
══════════════════════════════════════════════════════════════ --}}
<div class="kmodal-overlay" id="modalTambahBuku">
    <div class="kmodal wide">
        <div class="kmodal-header">
            <span class="kmodal-title">➕ Tambah Buku</span>
            <button class="kmodal-close" onclick="kCloseModal('modalTambahBuku')">✕</button>
        </div>
        <form id="formTambahBuku" action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="kmodal-body">
                <div class="ksection">Informasi Buku</div>
                <div class="kfield">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="kinput" placeholder="Contoh: Laskar Pelangi" required>
                    <span class="kerror" data-err="judul"></span>
                </div>
                <div class="kfield">
                    <label>Penulis</label>
                    <input type="text" name="penulis" class="kinput" placeholder="Contoh: Andrea Hirata" required>
                    <span class="kerror" data-err="penulis"></span>
                </div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Katalog <span class="opt">(opsional)</span></label>
                        <select name="catalog_id" class="kselect">
                            <option value="">— Pilih Katalog —</option>
                            @foreach($catalogs as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="catalog_id"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Stok</label>
                        <input type="number" name="stok" class="kinput" value="0" min="0" required>
                        <span class="kerror" data-err="stok"></span>
                    </div>
                </div>
                <div class="kfield" style="margin-top:14px">
                    <label>Deskripsi <span class="opt">(opsional)</span></label>
                    <textarea name="deskripsi" class="ktextarea" placeholder="Sinopsis singkat..."></textarea>
                    <span class="kerror" data-err="deskripsi"></span>
                </div>
                <div class="ksection">Cover Buku</div>
                <div class="kfield">
                    <label>Upload Cover <span class="opt">(opsional, maks 2MB)</span></label>
                    <div class="kcover-wrap">
                        <div class="kcover-placeholder" id="tambah-placeholder"><i class="bi bi-image"></i></div>
                        <img id="tambah-preview" class="kcover-img" style="display:none" alt="Preview">
                        <span style="font-size:12px;color:#6b7280;">JPG, JPEG, PNG · Rasio 2:3</span>
                    </div>
                    <input type="file" name="gambar" class="kfile-input" accept="image/*"
                           onchange="previewCover(this,'tambah-preview','tambah-placeholder')">
                    <span class="kerror" data-err="gambar"></span>
                </div>
            </div>
            <div class="kmodal-footer">
                <button type="button" class="kbtn kbtn-ghost" onclick="kCloseModal('modalTambahBuku')">Batal</button>
                <button type="submit" class="kbtn kbtn-primary"><i class="bi bi-check-lg"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════
     MODAL EDIT BUKU
══════════════════════════════════════════════════════════════ --}}
<div class="kmodal-overlay" id="modalEditBuku">
    <div class="kmodal wide">
        <div class="kmodal-header">
            <span class="kmodal-title">✏️ Edit Buku</span>
            <button class="kmodal-close" onclick="kCloseModal('modalEditBuku')">✕</button>
        </div>
        <form id="formEditBuku" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                            @foreach($catalogs as $cat)
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
// Preview cover
function previewCover(input, previewId, placeholderId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.style.display = 'block';
        if (placeholderId) {
            const ph = document.getElementById(placeholderId);
            if (ph) ph.style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
}

// Open edit modal & populate fields
function openEditBuku(id, judul, penulis, catalogId, stok, deskripsi, gambarUrl) {
    document.getElementById('edit-judul').value    = judul;
    document.getElementById('edit-penulis').value  = penulis;
    document.getElementById('edit-stok').value     = stok;
    document.getElementById('edit-deskripsi').value= deskripsi;
    document.getElementById('edit-catalog').value  = catalogId || '';

    const preview = document.getElementById('edit-preview');
    preview.src = gambarUrl || 'https://via.placeholder.com/64x88/f1f5f9/94a3b8?text=📖';

    const form = document.getElementById('formEditBuku');
    form.action = `/admin/buku/${id}`;

    kOpenModal('modalEditBuku');
}

// Wire up forms
kSubmitForm('formTambahBuku', 'modalTambahBuku', (data) => {
    // Reload page to show new row with pagination intact
    window.location.reload();
});

kSubmitForm('formEditBuku', 'modalEditBuku', (data) => {
    window.location.reload();
});
</script>
@endpush
