<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // bukus → catalogs
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreign('catalog_id')
                  ->references('id')->on('catalogs')
                  ->nullOnDelete();
        });

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
        Schema::table('denda', fn($t) => $t->dropForeign(['peminjaman_id']));
        Schema::table('detail_peminjaman', fn($t) => $t->dropForeign(['peminjaman_id', 'buku_id']));
        Schema::table('peminjaman', fn($t) => $t->dropForeign(['user_id', 'buku_id']));
        Schema::table('bukus', fn($t) => $t->dropForeign(['catalog_id']));
    }
};
