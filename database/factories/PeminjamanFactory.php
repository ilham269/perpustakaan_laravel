<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $tanggalRequest = now()->subDays(10);
        $tanggalPinjam = $tanggalRequest->copy()->addDay();

        return [
            'user_id' => User::factory(),
            'buku_id' => Buku::factory(),
            'tanggal_request' => $tanggalRequest,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => null,
            'status' => 'pending',
        ];
    }

    public function disetujui(): static
    {
        return $this->state(['status' => 'disetujui']);
    }

    public function terlambat(int $hariTerlambat = 3): static
    {
        return $this->state(function () use ($hariTerlambat) {
            $tanggalPinjam = now()->subDays(7 + $hariTerlambat + 1);
            $tanggalKembali = now()->subDay(); // dikembalikan kemarin, melebihi batas 7 hari

            return [
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali' => $tanggalKembali,
                'status' => 'dikembalikan',
            ];
        });
    }
}
