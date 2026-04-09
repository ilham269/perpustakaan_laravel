<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();

        // relasi ke users
        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        // relasi ke buku
        $table->foreignId('buku_id')
              ->constrained('buku')
              ->cascadeOnDelete();

        $table->date('tanggal_request');
        $table->date('tanggal_pinjam')->nullable();
        $table->date('tanggal_kembali')->nullable();

        $table->enum('status', [
            'pending',
            'disetujui',
            'ditolak',
            'dikembalikan'
        ])->default('pending');

        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
