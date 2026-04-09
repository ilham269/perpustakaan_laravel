<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::insert([
            [
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'stok' => 10,
                'deskripsi' => 'Kisah perjuangan dan kehilangan.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'stok' => 8,
                'deskripsi' => 'Petualangan dunia paralel.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'stok' => 12,
                'deskripsi' => 'Kisah santri dengan mimpi besar.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Dilan 1990',
                'penulis' => 'Pidi Baiq',
                'stok' => 15,
                'deskripsi' => 'Cerita cinta remaja.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Ayat-Ayat Cinta',
                'penulis' => 'Habiburrahman',
                'stok' => 7,
                'deskripsi' => 'Kisah cinta religi.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Perahu Kertas',
                'penulis' => 'Dee Lestari',
                'stok' => 9,
                'deskripsi' => 'Cinta dan mimpi.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Hujan',
                'penulis' => 'Tere Liye',
                'stok' => 11,
                'deskripsi' => 'Cerita kehilangan.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'stok' => 6,
                'deskripsi' => 'Belajar stoikisme.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Rich Dad Poor Dad',
                'penulis' => 'Robert Kiyosaki',
                'stok' => 5,
                'deskripsi' => 'Edukasi finansial.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'stok' => 13,
                'deskripsi' => 'Kebiasaan kecil berdampak besar.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}