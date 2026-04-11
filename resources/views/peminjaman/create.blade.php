@extends('layouts.admin')
@section('title', 'Tambah Peminjaman')
@section('page-title', 'Tambah Peminjaman')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12">

            <div class="mb-4">
                <a href="{{ route('admin.peminjaman.index') }}" class="back-link">
                    <i class="bi-arrow-left me-1"></i> Kembali
                </a>
                <h3 class="mt-3" style="color: var(--secondary-color);">Tambah Peminjaman</h3>
            </div>

            <div class="form-card">
                <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                    @csrf
                    @include('peminjaman._form')
                    <button type="submit" class="btn custom-btn w-100 mt-2">Simpan</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

