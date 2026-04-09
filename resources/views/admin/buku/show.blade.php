@extends('layouts.app')
@section('title', $buku->judul)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12">

            <div class="mb-4">
                <a href="{{ route('buku.index') }}" class="back-link">
                    <i class="bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="detail-card mb-4">
                <div class="detail-card-header d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="mb-1">{{ $buku->judul }}</h4>
                        <p class="mb-0 text-muted">{{ $buku->penulis }}</p>
                    </div>
                    <span class="badge-stok {{ $buku->stok > 0 ? 'stok-ada' : 'stok-habis' }}">
                        Stok: {{ $buku->stok }}
                    </span>
                </div>
                <div class="detail-card-body">
                    <p class="mb-0">{{ $buku->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                </div>
                <div class="detail-card-footer">
                    <a href="{{ route('buku.edit', $buku) }}" class="btn custom-btn btn-sm me-2">
                        <i class="bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus buku ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn custom-border-btn custom-btn btn-sm">
                            <i class="bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Riwayat Peminjaman --}}
            <div class="table-card">
                <div class="table-card-header">
                    <h5 class="mb-0">Riwayat Peminjaman</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($buku->peminjaman as $p)
                            <tr>
                                <td>{{ $p->user->name }}</td>
                                <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                                <td>{{ $p->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="badge-status badge-{{ $p->status }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada riwayat peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

