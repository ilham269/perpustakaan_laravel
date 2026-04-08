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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();

        // relasi ke user
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->string('foto')->nullable(); // simpan path foto
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
