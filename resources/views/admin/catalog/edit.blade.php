@extends('layouts.admin')
@section('title', 'Edit Katalog')
@section('page-title', 'Edit Katalog')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.catalog.update', $catalog) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Katalog</label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $catalog->nama) }}"
                               placeholder="Contoh: Novel, Sains, Agama">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
