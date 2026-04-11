@extends('layouts.admin')
@section('title', 'Detail Katalog')
@section('page-title', 'Detail Katalog')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>

        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $catalog->nama }}</h5>
                    <small class="text-muted">{{ $catalog->bukus->count() }} buku dalam katalog ini</small>
                </div>
                <div>
                    <a href="{{ route('admin.catalog.edit', $catalog) }}" class="btn btn-warning btn-sm me-1">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.catalog.destroy', $catalog) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus katalog ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header fw-semibold">Daftar Buku</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($catalog->bukus as $buku)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>
                                <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $buku->stok }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Belum ada buku di katalog ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
