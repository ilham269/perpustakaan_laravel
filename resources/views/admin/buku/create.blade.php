@extends('layouts.admin')
@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-12">

            <div class="mb-4">
                <a href="{{ route('admin.buku.index') }}" class="back-link">
                    <i class="bi-arrow-left me-1"></i> Kembali
                </a>
                <h3 class="mt-3" style="color: var(--secondary-color);">Tambah Buku</h3>
            </div>

            <div class="form-card">
                <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.buku._form')
                    <button type="submit" class="btn custom-btn w-100 mt-2">Simpan</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

