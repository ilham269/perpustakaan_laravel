@extends('layouts.app')

@section('content')
<style>
    .hero-section h1,
.hero-section p {
    color: white;
    z-index: 2;
    position: relative;
}
</style>
{{-- hero 1 --}}
<section class="hero-section d-flex justify-content-center align-items-center">

    <div class="section-overlay"></div>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8 col-12 text-center">
                <h1 class="text-white mb-3">
                    Selamat Datang di Perpustakaan Nasional
                </h1>

                <p class="text-white">
                    Pinjam buku jadi lebih mudah & modern
                </p>
            </div>

        </div>
    </div>

</section>


{{-- KATALOG --}}
<section class="section-padding">
    <div class="container">

        <div class="row mb-4">
            <div class="col-lg-12">
                <h2>Buku Terbaru</h2>
            </div>
        </div>

        <div class="row">

            @forelse ($buku as $item)
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="custom-block custom-block-bg">

                    <div class="custom-block-image-wrap">
                        <img src="{{ asset('storage/' . $item->gambar) }}" 
                             class="custom-block-image img-fluid">

                        <div class="custom-btn-wrap">
                            <a href="{{ route('buku.show', $item->id) }}" class="custom-btn">
                                Detail
                            </a>
                        </div>
                    </div>

                    <div class="custom-block-info">
                        <h5>{{ $item->judul }}</h5>
                        <p class="mb-0">
                            {{ Str::limit($item->deskripsi, 50) }}
                        </p>
                    </div>

                </div>
            </div>
            @empty
                <p>Tidak ada buku terbaru.</p>
            @endforelse

        </div>

    </div>
</section>

@endsection