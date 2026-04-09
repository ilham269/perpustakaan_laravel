@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="color: var(--secondary-color);">Data Peminjaman</h3>
            <p class="text-muted mb-0">Kelola semua transaksi peminjaman buku</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn custom-btn">
            <i class="bi-plus-circle me-1"></i> Tambah
        </a>
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
                        <th>Tgl Request</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $p)
                    <tr>
                        <td>{{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}</td>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->buku->judul }}</td>
                        <td>{{ $p->tanggal_request->format('d M Y') }}</td>
                        <td>{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <span class="badge-status badge-{{ $p->status }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.show', $p) }}" class="btn-aksi btn-detail">
                                <i class="bi-eye"></i>
                            </a>
                            <a href="{{ route('peminjaman.edit', $p) }}" class="btn-aksi btn-edit">
                                <i class="bi-pencil"></i>
                            </a>
                            <form action="{{ route('peminjaman.destroy', $p) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">
                                    <i class="bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($peminjaman->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
@push('styles')

@endpush
