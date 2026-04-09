<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('catalog_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Foreign key ditambah setelah catalogs table ada
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreign('catalog_id')
                  ->references('id')
                  ->on('catalogs')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
