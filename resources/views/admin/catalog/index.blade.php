@extends('layouts.admin')
@section('title', 'Data Katalog')
@section('page-title', 'Data Katalog')

@push('styles')
@include('admin.partials.index-styles')
@include('admin.partials.modal-engine')
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div class="idx-count">{{ $catalogs->total() }} katalog terdaftar</div>
    <button class="idx-btn-add" onclick="kOpenModal('modalTambahKatalog')">
        <i class="bi bi-plus-lg me-1"></i> Tambah Katalog
    </button>
</div>

<div class="idx-card">
    <div class="table-responsive">
        <table class="idx-table">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Nama Katalog</th>
                    <th style="width:130px">Jumlah Buku</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($catalogs as $catalog)
                <tr id="catalog-row-{{ $catalog->id }}">
                    <td class="text-muted">{{ $loop->iteration + ($catalogs->currentPage() - 1) * $catalogs->perPage() }}</td>
                    <td class="fw-semibold">{{ $catalog->nama }}</td>
                    <td><span class="idx-badge badge-info">{{ $catalog->bukus_count }} buku</span></td>
                    <td>
                        <div class="idx-actions">
                            <a href="{{ route('admin.catalog.show', $catalog) }}" class="ia-btn ia-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="ia-btn ia-edit" title="Edit"
                                onclick="openEditKatalog({{ $catalog->id }}, '{{ addslashes($catalog->nama) }}')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="ia-btn ia-del" title="Hapus"
                                onclick="kDelete('{{ route('admin.catalog.destroy', $catalog) }}', 'catalog-row-{{ $catalog->id }}', 'Hapus katalog ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="idx-empty">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data katalog.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($catalogs->hasPages())
    <div class="idx-pagination">{{ $catalogs->links() }}</div>
    @endif
</div>

{{-- MODAL TAMBAH --}}
<div class="kmodal-overlay" id="modalTambahKatalog">
    <div class="kmodal">
        <div class="kmodal-header">
            <span class="kmodal-title">➕ Tambah Katalog</span>
            <button class="kmodal-close" onclick="kCloseModal('modalTambahKatalog')">✕</button>
        </div>
        <form id="formTambahKatalog" action="{{ route('admin.catalog.store') }}" method="POST">
            @csrf
            <div class="kmodal-body">
                <div class="kfield">
                    <label>Nama Katalog</label>
                    <input type="text" name="nama" class="kinput" placeholder="Contoh: Novel, Sains, Agama" required>
                    <span class="kerror" data-err="nama"></span>
                </div>
            </div>
            <div class="kmodal-footer">
                <button type="button" class="kbtn kbtn-ghost" onclick="kCloseModal('modalTambahKatalog')">Batal</button>
                <button type="submit" class="kbtn kbtn-primary"><i class="bi bi-check-lg"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="kmodal-overlay" id="modalEditKatalog">
    <div class="kmodal">
        <div class="kmodal-header">
            <span class="kmodal-title">✏️ Edit Katalog</span>
            <button class="kmodal-close" onclick="kCloseModal('modalEditKatalog')">✕</button>
        </div>
        <form id="formEditKatalog" action="" method="POST">
            @csrf
            @method('PUT')
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

kSubmitForm('formTambahKatalog', 'modalTambahKatalog', (data) => {
    // Tambah row baru ke tabel tanpa reload
    const tbody = document.querySelector('#catalog-row-1')?.closest('tbody') || document.querySelector('.idx-table tbody');
    const emptyRow = tbody.querySelector('.idx-empty');
    if (emptyRow) emptyRow.closest('tr').remove();

    const row = document.createElement('tr');
    row.id = `catalog-row-${data.id}`;
    row.innerHTML = `
        <td class="text-muted">—</td>
        <td class="fw-semibold">${data.nama}</td>
        <td><span class="idx-badge badge-info">0 buku</span></td>
        <td>
            <div class="idx-actions">
                <a href="/admin/catalog/${data.id}" class="ia-btn ia-view"><i class="bi bi-eye"></i></a>
                <button class="ia-btn ia-edit" onclick="openEditKatalog(${data.id}, '${data.nama.replace(/'/g,"\\'")}')"><i class="bi bi-pencil"></i></button>
                <button class="ia-btn ia-del" onclick="kDelete('/admin/catalog/${data.id}','catalog-row-${data.id}','Hapus katalog ini?')"><i class="bi bi-trash"></i></button>
            </div>
        </td>`;
    tbody.appendChild(row);
    document.getElementById('formTambahKatalog').reset();
});

kSubmitForm('formEditKatalog', 'modalEditKatalog', (data) => {
    const row = document.getElementById(`catalog-row-${data.id}`);
    if (row) row.querySelector('td:nth-child(2)').textContent = data.nama;
});
</script>
@endpush
