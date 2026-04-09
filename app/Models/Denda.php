<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denda extends Model
{
    use SoftDeletes;

    protected $table = 'denda';

    protected $fillable = [
        'peminjaman_id',
        'terlambat_hari',
        'total_denda',
        'status',
    ];

    const DENDA_PER_HARI = 1000; // Rp 1.000/hari

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    /** Hitung total denda otomatis */
    public static function hitung(int $hariTerlambat): int
    {
        return $hariTerlambat * self::DENDA_PER_HARI;
    }
}
