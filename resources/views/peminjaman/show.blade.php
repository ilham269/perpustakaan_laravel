@extends('layouts.admin')
@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@push('styles')
@include('admin.partials.show-styles')
@include('admin.partials.modal-engine')
@endpush

@section('content')

<a href="{{ route('admin.peminjaman.index') }}" class="show-back">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Peminjaman
</a>

{{-- Main card --}}
<div class="show-card">
    <div class="show-card-head">
        <div>
            <div class="show-card-title">Peminjaman #{{ $peminjaman->id }}</div>
            <div class="show-card-sub">{{ $peminjaman->user->name }} · {{ $peminjaman->buku->judul }}</div>
        </div>
        <span class="show-badge sb-{{ $peminjaman->status }}">{{ ucfirst($peminjaman->status) }}</span>
    </div>

    <div class="show-card-body">
        <div class="info-row">
            <span class="info-label">Peminjam</span>
            <span class="info-value">{{ $peminjaman->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value muted">{{ $peminjaman->user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Buku</span>
            <span class="info-value">{{ $peminjaman->buku->judul }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tgl Request</span>
            <span class="info-value">{{ $peminjaman->tanggal_request->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tgl Dipinjam</span>
            <span class="info-value {{ $peminjaman->tanggal_pinjam ? '' : 'muted' }}">
                {{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '—' }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Batas Kembali</span>
            <span class="info-value {{ $peminjaman->tanggal_pinjam ? '' : 'muted' }}">
                @if ($peminjaman->tanggal_pinjam)
                    {{ $peminjaman->tanggal_pinjam->copy()->addDays(7)->format('d M Y') }}
                @else
                    —
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Tgl Dikembalikan</span>
            <span class="info-value {{ $peminjaman->tanggal_kembali ? '' : 'muted' }}">
                {{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '—' }}
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
                <span class="show-badge sb-{{ $peminjaman->status }}">{{ ucfirst($peminjaman->status) }}</span>
            </span>
        </div>
    </div>

    <div class="show-card-foot">
        <button class="sa-btn sa-edit"
            onclick="openEditPeminjaman(
                {{ $peminjaman->id }},
                {{ $peminjaman->user_id }},
                {{ $peminjaman->buku_id }},
                '{{ $peminjaman->tanggal_request->format('Y-m-d') }}',
                '{{ $peminjaman->tanggal_pinjam?->format('Y-m-d') ?? '' }}',
                '{{ $peminjaman->tanggal_kembali?->format('Y-m-d') ?? '' }}',
                '{{ $peminjaman->status }}'
            )">
            <i class="bi bi-pencil"></i> Edit
        </button>
        <button class="sa-btn sa-del"
            onclick="kDeleteRedirect('{{ route('admin.peminjaman.destroy', $peminjaman) }}', '{{ route('admin.peminjaman.index') }}', 'Hapus data peminjaman ini?')">
            <i class="bi bi-trash"></i> Hapus
        </button>
    </div>
</div>

{{-- Denda card --}}
@if ($peminjaman->denda)
<div class="denda-card {{ $peminjaman->denda->status === 'sudah bayar' ? 'lunas' : '' }}">
    <div class="denda-card-body">
        <div>
            <div class="denda-label">
                {{ $peminjaman->denda->status === 'sudah bayar' ? '✅ Denda Lunas' : '⚠️ Denda Keterlambatan' }}
            </div>
            <div class="denda-amount">Rp {{ number_format($peminjaman->denda->total_denda, 0, ',', '.') }}</div>
            <div class="denda-meta">
                Terlambat {{ $peminjaman->denda->terlambat_hari }} hari · Rp 1.000/hari
            </div>
        </div>
        @if ($peminjaman->denda->status === 'belum bayar')
        <form id="formBayarDenda" action="{{ route('admin.denda.bayar', $peminjaman->denda) }}" method="POST">
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
@endif

{{-- Modal Edit Peminjaman --}}
<div class="kmodal-overlay" id="modalEditPeminjaman">
    <div class="kmodal wide">
        <div class="kmodal-header">
            <span class="kmodal-title">✏️ Edit Peminjaman</span>
            <button class="kmodal-close" onclick="kCloseModal('modalEditPeminjaman')">✕</button>
        </div>
        <form id="formEditPeminjaman" action="" method="POST">
            @csrf @method('PUT')
            <div class="kmodal-body">
                <div class="ksection">Peminjam &amp; Buku</div>
                <div class="kfield-row">
                    <div class="kfield" style="margin-bottom:0">
                        <label>Peminjam</label>
                        <select name="user_id" id="e_user_id" class="kselect" required>
                            <option value="">— Pilih User —</option>
                            @foreach(\App\Models\User::orderBy('name')->get() as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        <span class="kerror" data-err="user_id"></span>
                    </div>
                    <div class="kfield" style="margin-bottom:0">
                        <label>Buku</label>
                        <select name="buku_id" id="e_buku_id" class="kselect" required>
                            <option value="">— Pilih Buku —</option>
                            @foreach(\App\Models\Buku::orderBy('judul')->get() as $b)
                                <option value="{{ $b->id }}">{{ $b->judul }}</option>
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

document.getElementById('formBayarDenda')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const res = await fetch(this.action, {
        method: 'PATCH',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
    });
    const json = await res.json();
    if (res.ok) { kToast(json.message, 'success'); setTimeout(() => window.location.reload(), 800); }
    else kToast(json.message || 'Gagal.', 'error');
});

kSubmitForm('formEditPeminjaman', 'modalEditPeminjaman', () => window.location.reload());
</script>
@endpush
