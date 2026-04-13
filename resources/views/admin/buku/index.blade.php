@extends('layouts.admin')
@section('title', 'Data Buku')
@section('page-title', 'Data Buku')

@push('styles')
@include('admin.partials.index-styles')
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div>
        <div class="idx-count">{{ $bukus->total() }} buku terdaftar</div>
    </div>
    <a href="{{ route('admin.buku.create') }}" class="idx-btn-add">
        <i class="bi bi-plus-lg me-1"></i> Tambah Buku
    </a>
</div>

<div class="idx-card">
    <div class="table-responsive">
        <table class="idx-table">
            <thead>
                <tr>
                    <th style="width:48px">No</th>
                    <th style="width:72px">Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th style="width:80px">Stok</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukus as $buku)
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}</td>
                    <td>
                        <img src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/48x64/f1f5f9/94a3b8?text=📖' }}"
                             class="idx-cover" alt="{{ $buku->judul }}">
                    </td>
                    <td class="fw-semibold">{{ $buku->judul }}</td>
                    <td class="text-muted">{{ $buku->penulis }}</td>
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
                            <a href="{{ route('admin.buku.edit', $buku) }}" class="ia-btn ia-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button class="ia-btn ia-del" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="idx-empty">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada data buku.
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

@endsection
