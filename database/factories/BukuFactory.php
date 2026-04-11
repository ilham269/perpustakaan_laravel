<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'stok' => fake()->numberBetween(1, 20),
            'deskripsi' => fake()->paragraph(),
            'gambar' => null,
            'catalog_id' => null,
        ];
    }

    /** State: buku tanpa stok */
    public function habis(): static
    {
        return $this->state(['stok' => 0]);
    }
}
