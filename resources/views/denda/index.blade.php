@extends('layouts.app')
@section('title', 'Data Denda')

@section('content')
<div class="container py-5">

    <div class="mb-4">
        <h3 style="color: var(--secondary-color);">Data Denda</h3>
        <p class="text-muted mb-0">Kelola denda keterlambatan pengembalian buku</p>
    </div>

    @if (session('success'))
        <div class="alert-success-custom mb-4">
            <i class="bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Terlambat</th>
                        <th>Total Denda</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dendas as $denda)
                    <tr>
                        <td>{{ $loop->iteration + ($dendas->currentPage() - 1) * $dendas->perPage() }}</td>
                        <td>{{ $denda->peminjaman->user->name }}</td>
                        <td>{{ $denda->peminjaman->buku->judul }}</td>
                        <td>{{ $denda->terlambat_hari }} hari</td>
                        <td>Rp {{ number_format($denda->total_denda, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-status {{ $denda->status === 'sudah bayar' ? 'badge-disetujui' : 'badge-ditolak' }}">
                                {{ ucfirst($denda->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('denda.show', $denda) }}" class="btn-aksi btn-detail">
                                <i class="bi-eye"></i>
                            </a>
                            @if ($denda->status === 'belum bayar')
                            <form action="{{ route('denda.bayar', $denda) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-aksi btn-edit" title="Tandai Lunas">
                                    <i class="bi-cash"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('denda.destroy', $denda) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus data denda ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">
                                    <i class="bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data denda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($dendas->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $dendas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

