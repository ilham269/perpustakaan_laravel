<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_request',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    protected $casts = [
        'tanggal_request' => 'date',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(Detailpeminjaman::class, 'peminjaman_id');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'peminjaman_id');
    }

    /** Hitung keterlambatan dalam hari */
    public function hariTerlambat(): int
    {
        if ($this->status !== 'dikembalikan' || ! $this->tanggal_kembali || ! $this->tanggal_pinjam) {
            return 0;
        }
        // batas = tanggal_pinjam + 7 hari
        // diffInDays(false) = signed: positif kalau $batas < $tanggal_kembali (terlambat)
        $batas = $this->tanggal_pinjam->copy()->addDays(7);

        return max(0, (int) $batas->diffInDays($this->tanggal_kembali, false));
    }
}
