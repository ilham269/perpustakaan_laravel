@extends('layouts.app')
@section('title', 'Data Buku')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 style="color: var(--secondary-color);">Data Buku</h3>
            <p class="text-muted mb-0">Kelola koleksi buku perpustakaan</p>
        </div>
        <a href="{{ route('buku.create') }}" class="btn custom-btn">
            <i class="bi-plus-circle me-1"></i> Tambah Buku
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
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bukus as $buku)
                    <tr>
                        <td>{{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>
                            <span class="badge-stok {{ $buku->stok > 0 ? 'stok-ada' : 'stok-habis' }}">
                                {{ $buku->stok }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('buku.show', $buku) }}" class="btn-aksi btn-detail">
                                <i class="bi-eye"></i>
                            </a>
                            <a href="{{ route('buku.edit', $buku) }}" class="btn-aksi btn-edit">
                                <i class="bi-pencil"></i>
                            </a>
                            <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">
                                    <i class="bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data buku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($bukus->hasPages())
        <div class="px-4 py-3 border-top">
            {{ $bukus->links() }}
        </div>
        @endif
    </div>

</div>
@endsection


