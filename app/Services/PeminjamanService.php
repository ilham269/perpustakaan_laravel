<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PeminjamanService
{
    /**
     * 
     * 
     *
     * @throws \Exception 
     */
    public function buat(array $data): Peminjaman
    {
        return DB::transaction(function () use ($data) {
            $peminjaman = Peminjaman::create($data);

            if ($data['status'] === 'disetujui') {
                $this->kurangiStok($data['buku_id']);
            }

            return $peminjaman;
        });
    }

    /**
     * 
     *
     * @throws \Exception 
     */
    public function ubah(Peminjaman $peminjaman, array $data): Peminjaman
    {
        return DB::transaction(function () use ($peminjaman, $data) {
            $statusLama = $peminjaman->status;
            $statusBaru = $data['status'] ?? $statusLama;

            $peminjaman->update($data);

            // pending → disetujui: kurangi stok
            if ($statusBaru === 'disetujui' && $statusLama === 'pending') {
                $this->kurangiStok($peminjaman->buku_id);
            }

            // * → dikembalikan (pertama kali): kembalikan stok + buat denda kalau telat
            if ($statusBaru === 'dikembalikan' && $statusLama !== 'dikembalikan') {
                Buku::lockForUpdate()->findOrFail($peminjaman->buku_id)->increment('stok');
                $peminjaman->refresh();
                $this->buatDendaJikaTerlambat($peminjaman);
            }

            return $peminjaman->fresh();
        });
    }

    /**
     * Kurangi stok buku dengan lock agar aman dari race condition.
     *
     * @throws \Exception kalau stok = 0
     */
    private function kurangiStok(int $bukuId): void
    {
        $buku = Buku::lockForUpdate()->findOrFail($bukuId);

        if ($buku->stok <= 0) {
            throw new \Exception("Stok buku \"{$buku->judul}\" habis, tidak bisa disetujui.");
        }

        $buku->decrement('stok');
    }

    /**
     * Buat record denda kalau peminjaman terlambat dan belum ada dendanya.
     */
    private function buatDendaJikaTerlambat(Peminjaman $peminjaman): void
    {
        $hari = $peminjaman->hariTerlambat();

        if ($hari > 0 && ! $peminjaman->denda) {
            Denda::create([
                'peminjaman_id' => $peminjaman->id,
                'terlambat_hari' => $hari,
                'total_denda' => Denda::hitung($hari),
                'status' => 'belum bayar',
            ]);
        }
    }
}
