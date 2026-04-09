@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- HERO -->
<section class="py-5" style="background: #f9f5f1;">
    <div class="container d-flex align-items-center justify-content-between flex-wrap">
        
        <div style="max-width:500px;">
            <h1 style="color:#5c3d2e; font-weight:700;">
                Temukan Dunia dari Buku 
            </h1>
            <p class="text-muted mt-3">
                Jelajahi berbagai koleksi buku dari berbagai macam buku dengan mudah dan cepat.
            </p>

            <a href="{ route ('catalog.index')}" class="btn mt-3" 
               style="background:#5c3d2e; color:white; border-radius:8px;">
                Jelajahi Sekarang
            </a>
        </div>

        <div>
            <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" width="250">
        </div>

    </div>
</section>

<!-- card buku baru -->
<!-- BUKU BARU -->
<section class="py-5" style="background:#f9f5f1;">
    <div class="container">
        <h2 class="mb-4" style="color:#5c3d2e;">Buku terbaru</h2>

        <div class="row">
            @foreach ($buku as $buku)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm"
                         style="border-radius:12px; overflow:hidden;">

                        <!-- Cover -->
                        <img src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/300x200' }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">

                        <!-- Body -->
                        <div class="card-body">
                            <h5 class="card-title" style="color:#5c3d2e;">
                                {{ $buku->judul }}
                            </h5>

                            <p class="text-muted mb-1">
                            <span>Penulis : </span> {{ $buku->penulis }}
                            </p>

                            <p class="text-muted small">
                                Stok: {{ $buku->stok }}
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn w-100"
                               style="background:#5c3d2e; color:white; border-radius:8px;">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection