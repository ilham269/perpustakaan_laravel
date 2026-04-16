@extends('layouts.admin')
@section('title', 'Data Peminjaman')
@section('page-title', 'Data Peminjaman')

@push('styles')
@include('admin.partials.index-styles')
@include('admin.partials.modal-engine')
<style>
.filter-bar { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px; }
.filter-bar select { font-size:13px; padding:7px 12px; border:1px solid #e5e7eb; border-radius:8px; background:#fff; color:#374151; outline:none; }
.filter-bar select:focus { border-color:#0d6efd; }
.filter-reset { font-size:12px; color:#6b7280; text-decoration:none; padding:7px 12px; border:1px solid #e5e7eb; border-radius:8px; background:#fff; }
.filter-reset:hover { background:#f8fafc; }
</style>
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div class="idx-count">{{ $peminjaman->total() }} data peminjaman</div>
    <button class="idx-btn-add" onclick="kOpenModal('modalTambahPeminjaman')">
        <i class="bi bi-plus-lg me-1"></i> Tambah
    </button>
</div>

<form method="GET" class="filter-bar">
    <select name="status" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach (['pending','disetujui','ditolak','dikembalikan'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    @if (request('status'))
        <a href="{{ route('admin.peminjaman.index') }}" class="filter-reset">✕ Reset</a>
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
                <tr id="peminjaman-row-{{ $p->id }}">
                    <td class="text-muted">{{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}</td>
                    <td>
                        <div class="fw-semibold">{{ $p->user->name }}</div>
                        <div style="font-size:11px;color:#9ca3af;">{{ $p->user->email }}</div>
                    </td>
                    <td class="text-muted">{{ $p->buku->judul }}</td>
                    <td style="font-size:13px;">{{ $p->tanggal_request->format('d M Y') }}</td>
                    <td style="font-size:13px;">{{ $p->tanggal_kembali?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <span class="idx-badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                    </td>
                    <td>
                        <div class="idx-actions">
                            <a href="{{ route('admin.peminjaman.show', $p) }}" class="ia-btn ia-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="ia-btn ia-edit" title="Edit"
                                onclick="openEditPeminjaman(
                                    {{ $p->id }},
                                    {{ $p->user_id }},
                                    {{ $p->buku_id }},
                                    '{{ $p->tanggal_request->format('Y-m-d') }}',
                                    '{{ $p->tanggal_pinjam?->format('Y-m-d') ?? '' }}',
                                    '{{ $p->tanggal_kembali?->format('Y-m-d') ?? '' }}',
                                    '{{ $p->status }}'
                                )">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="ia-btn ia-del" title="Hapus"
                                onclick="kDelete('{{ route('admin.peminjaman.destroy', $p) }}', 'peminjaman-row-{{ $p->id }}', 'Hapus data peminjaman ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="idx-empty">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data peminjaman.
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

{{-- ══ MODAL TAMBAH ══ --}}
<div class="kmodal-overlay" id="modalTambahPeminjaman">
    <div class="kmodal wide">
        <div class="kmodal-header">
            <span class="kmodal-title">➕ Tambah Peminjaman</span>
            <button class="kmodal-close" onclick="kCloseModal('modalTambahPeminjaman')">✕</button>
        </div>
        <form id="formTambahPeminjaman" action="{{ route('admin.peminjaman.store') }}" method="POST">
            @csrf
            <div class="kmodal-body">
                <div class="ksection">Peminjam &amp; Buku</div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Peminjam</label>
                        <select name="user_id" class="kselect" required>
                            <option value="">— Pilih User —</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="user_id"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Buku</label>
                        <select name="buku_id" class="kselect" required>
                            <option value="">— Pilih Buku —</option>
                            @foreach($bukus as $b)
                                <option value="{{ $b->id }}">{{ $b->judul }} (Stok: {{ $b->stok }})</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="buku_id"></span>
                    </div>
                </div>
                <div class="ksection">Tanggal</div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Tanggal Request</label>
                        <input type="date" name="tanggal_request" class="kinput" value="{{ date('Y-m-d') }}" required>
                        <span class="kerror" data-err="tanggal_request"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Tanggal Pinjam <span class="opt">(opsional)</span></label>
                        <input type="date" name="tanggal_pinjam" class="kinput">
                        <span class="kerror" data-err="tanggal_pinjam"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Tanggal Kembali <span class="opt">(opsional)</span></label>
                        <input type="date" name="tanggal_kembali" class="kinput">
                        <span class="kerror" data-err="tanggal_kembali"></span>
                    </div>
                </div>
                <div class="ksection">Status</div>
                <div class="kstatus-grid">
                    @foreach(['pending','disetujui','ditolak','dikembalikan'] as $s)
                    <div class="kstatus-opt">
                        <input type="radio" id="t_status_{{ $s }}" name="status" value="{{ $s }}" {{ $s === 'pending' ? 'checked' : '' }}>
                        <label for="t_status_{{ $s }}">{{ ucfirst($s) }}</label>
                    </div>
                    @endforeach
                </div>
                <span class="kerror" data-err="status"></span>
            </div>
            <div class="kmodal-footer">
                <button type="button" class="kbtn kbtn-ghost" onclick="kCloseModal('modalTambahPeminjaman')">Batal</button>
                <button type="submit" class="kbtn kbtn-primary"><i class="bi bi-check-lg"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ MODAL EDIT ══ --}}
<div class="kmodal-overlay" id="modalEditPeminjaman">
    <div class="kmodal wide">
        <div class="kmodal-header">
            <span class="kmodal-title">✏️ Edit Peminjaman</span>
            <button class="kmodal-close" onclick="kCloseModal('modalEditPeminjaman')">✕</button>
        </div>
        <form id="formEditPeminjaman" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="kmodal-body">
                <div class="ksection">Peminjam &amp; Buku</div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Peminjam</label>
                        <select name="user_id" id="e_user_id" class="kselect" required>
                            <option value="">— Pilih User —</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="user_id"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Buku</label>
                        <select name="buku_id" id="e_buku_id" class="kselect" required>
                            <option value="">— Pilih Buku —</option>
                            @foreach($bukus as $b)
                                <option value="{{ $b->id }}">{{ $b->judul }} (Stok: {{ $b->stok }})</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="buku_id"></span>
                    </div>
                </div>
                <div class="ksection">Tanggal</div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Tanggal Request</label>
                        <input type="date" name="tanggal_request" id="e_tanggal_request" class="kinput" required>
                        <span class="kerror" data-err="tanggal_request"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Tanggal Pinjam <span class="opt">(opsional)</span></label>
                        <input type="date" name="tanggal_pinjam" id="e_tanggal_pinjam" class="kinput">
                        <span class="kerror" data-err="tanggal_pinjam"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Tanggal Kembali <span class="opt">(opsional)</span></label>
                        <input type="date" name="tanggal_kembali" id="e_tanggal_kembali" class="kinput">
                        <span class="kerror" data-err="tanggal_kembali"></span>
                    </div>
                </div>
                <div class="ksection">Status</div>
                <div class="kstatus-grid">
                    @foreach(['pending','disetujui','ditolak','dikembalikan'] as $s)
                    <div class="kstatus-opt">
                        <input type="radio" id="e_status_{{ $s }}" name="status" value="{{ $s }}">
                        <label for="e_status_{{ $s }}">{{ ucfirst($s) }}</label>
                    </div>
                    @endforeach
                </div>
                <span class="kerror" data-err="status"></span>
            </div>
            <div class="kmodal-footer">
                <button type="button" class="kbtn kbtn-ghost" onclick="kCloseModal('modalEditPeminjaman')">Batal</button>
                <button type="submit" class="kbtn kbtn-primary"><i class="bi bi-check-lg"></i> Perbarui</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEditPeminjaman(id, userId, bukuId, tglReq, tglPinjam, tglKembali, status) {
    document.getElementById('e_user_id').value           = userId;
    document.getElementById('e_buku_id').value           = bukuId;
    document.getElementById('e_tanggal_request').value   = tglReq;
    document.getElementById('e_tanggal_pinjam').value    = tglPinjam;
    document.getElementById('e_tanggal_kembali').value   = tglKembali;

    const radio = document.getElementById(`e_status_${status}`);
    if (radio) radio.checked = true;

    document.getElementById('formEditPeminjaman').action = `/admin/peminjaman/${id}`;
    kOpenModal('modalEditPeminjaman');
}

kSubmitForm('formTambahPeminjaman', 'modalTambahPeminjaman', () => window.location.reload());
kSubmitForm('formEditPeminjaman',   'modalEditPeminjaman',   () => window.location.reload());
</script>
@endpush
