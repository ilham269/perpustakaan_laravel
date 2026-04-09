<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use SoftDeletes;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'penulis',
        'stok',
        'deskripsi',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(Detailpeminjaman::class, 'buku_id');
    }

    public function denda()
    {
        return $this->hasMany(Denda::class, 'buku_id');
    }
}
