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
    Schema::create('denda', function (Blueprint $table) {
        $table->id();

        $table->foreignId('peminjaman_id')->constrained('peminjaman')->cascadeOnDelete();

        $table->integer('terlambat_hari')->default(0);
        $table->integer('total_denda')->default(0);

        $table->enum('status', ['belum bayar', 'sudah bayar'])->default('belum bayar');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
