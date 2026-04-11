<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // peminjaman → users, bukus
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('buku_id')->references('id')->on('bukus')->cascadeOnDelete();
        });

        // detail_peminjaman → peminjaman, bukus
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->cascadeOnDelete();
            $table->foreign('buku_id')->references('id')->on('bukus')->cascadeOnDelete();
        });

        // denda → peminjaman
        Schema::table('denda', function (Blueprint $table) {
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            $table->dropForeign(['peminjaman_id']);
        });

        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['peminjaman_id']);
            $table->dropForeign(['buku_id']);
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['buku_id']);
        });
    }
};
