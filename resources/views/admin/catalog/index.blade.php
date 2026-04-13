@extends('layouts.admin')
@section('title', 'Data Katalog')
@section('page-title', 'Data Katalog')

@push('styles')
@include('admin.partials.index-styles')
@endpush

@section('content')

@include('admin.partials.flash')

<div class="idx-toolbar">
    <div>
        <div class="idx-count">{{ $catalogs->total() }} katalog terdaftar</div>
    </div>
    <a href="{{ route('admin.catalog.create') }}" class="idx-btn-add">
        <i class="bi bi-plus-lg me-1"></i> Tambah Katalog
    </a>
</div>

<div class="idx-card">
    <div class="table-responsive">
        <table class="idx-table">
            <thead>
                <tr>
                    <th style="width:48px">No</th>
                    <th>Nama Katalog</th>
                    <th style="width:120px">Jumlah Buku</th>
                    <th style="width:110px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($catalogs as $catalog)
                <tr>
                    <td class="text-muted">{{ $loop->iteration + ($catalogs->currentPage() - 1) * $catalogs->perPage() }}</td>
                    <td class="fw-semibold">{{ $catalog->nama }}</td>
                    <td>
                        <span class="idx-badge badge-info">{{ $catalog->bukus_count }} buku</span>
                    </td>
                    <td>
                        <div class="idx-actions">
                            <a href="{{ route('admin.catalog.show', $catalog) }}" class="ia-btn ia-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.catalog.edit', $catalog) }}" class="ia-btn ia-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.catalog.destroy', $catalog) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus katalog ini?')">
                                @csrf @method('DELETE')
                                <button class="ia-btn ia-del" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="idx-empty">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada data katalog.
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

@endsection
