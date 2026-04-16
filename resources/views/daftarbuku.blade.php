@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')

<div class="container py-5">

    <h2 class="mb-4" style="color:#5c3d2e;">📚 Daftar Buku</h2>

    <!-- FILTER -->
    <form method="GET" action="" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="catalog" class="form-control">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($catalogs as $c)
                        <option value="{{ $c->id }}" 
                            {{ request('catalog') == $c->id ? 'selected' : '' }}>
                            {{ $c->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn w-100" 
                        style="background:#5c3d2e; color:white;">
                    Filter
                </button>
            </div>
        </div>
    </form>

    <!-- LIST BUKU -->
    <div class="row">
        @forelse ($bukus as $buku)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0" 
                     style="border-radius:12px;">

                    <img src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/300x200' }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">

                    <div class="card-body">
                        <h5 style="color:#5c3d2e;">
                            {{ $buku->judul }}
                        </h5>

                        <p class="text-muted mb-1">
                            Penulis : {{ $buku->penulis }}
                        </p>

                        <p class="small text-muted">
                            Jenis buku : {{ $buku->catalog->nama ?? '-' }}
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex gap-2">
                        <a href="{{ route('detailbuku.show', $buku->id) }}" class="btn flex-fill"
                           style="background:#5c3d2e; color:white;">
                            Detail
                        </a>
                        @auth
                        @if($buku->stok > 0)
                        <form action="{{ route('cart.add', $buku) }}" method="POST" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn w-100"
                                    style="background:#F0E6C8;color:#3A2E1A;border:1px solid #D4C490;">
                                🛒
                            </button>
                        </form>
                        @endif
                        @endauth
                    </div>

                </div>
            </div>
        @empty
            <p class="text-center">Buku tidak ditemukan 😢</p>
        @endforelse
    </div>

</div>

@endsection