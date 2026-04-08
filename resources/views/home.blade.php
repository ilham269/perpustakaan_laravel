@extends('layouts.app')

@section('content')

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">

    <div class="container text-center">
        <h1 class="text-white">Selamat Datang di Perpustakaan Nasional</h1>
        <p class="text-white">Pinjam buku jadi lebih mudah & modern</p>
    </div>
</section>

<section class="container mt-5">
    <h2>Katalog Buku</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <img src="{{ asset('images/sample.jpg') }}" class="card-img-top">
                <div class="card-body">
                    <h5>Judul Buku</h5>
                    <button class="btn btn-primary">Pinjam</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection