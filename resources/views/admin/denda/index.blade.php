@extends('layouts.admin')
@section('title', 'Data Denda')
@section('page-title', 'Data Denda')

@push('styles')
@include('admin.partials.index-styles')
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div>
        <div class="idx-count">{{ $dendas->total() }} data denda</div>
    </div>
</div>

<div class="idx-card">
    <div class="table-responsive">
        <table class="idx-table">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th style="width:110px">Terlambat</th>
                    <th style="width:140px">Total Denda</th>
                    <th style="width:120px">Status</th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dendas as $denda)
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($dendas->currentPage() - 1) * $dendas->perPage() }}</td>
                    <td class="fw-semibold">{{ $denda->peminjaman->user->name }}</td>
                    <td class="text-muted">{{ $denda->peminjaman->buku->judul }}</td>
                    <td>
                        <span class="idx-badge badge-warning">
                            {{ $denda->terlambat_hari }} hari
                        </span>
                    </td>
                    <td class="fw-semibold">Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</td>
                    <td>
                        <span class="idx-badge {{ $denda->status === 'sudah bayar' ? 'badge-success' : 'badge-danger' }}">
                            {{ $denda->status === 'sudah bayar' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </td>
                    <td>
                        <div class="idx-actions">
                            <a href="{{ route('admin.denda.show', $denda) }}" class="ia-btn ia-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if ($denda->status === 'belum bayar')
                            <form action="{{ route('admin.denda.bayar', $denda) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="ia-btn ia-pay" title="Tandai Lunas">
                                    <i class="bi bi-cash-coin"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.denda.destroy', $denda) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus data denda ini?')">
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
                        Tidak ada data denda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($dendas->hasPages())
    <div class="idx-pagination">{{ $dendas->links() }}</div>
    @endif
</div>

@endsection
