<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $table = 'catalogs';

    protected $fillable = [
        'nama',
        'genre',
        'deskripsi',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'catalog_id');
    }
}
