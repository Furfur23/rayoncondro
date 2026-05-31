<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasTagihan extends Model
{
    protected $table = 'kas_tagihan'; // ← tambah ini

    protected $fillable = [
        'judul', 'nominal', 'tahun', 'bulan',
        'jatuh_tempo', 'keterangan', 'dibuat_oleh',
    ];

    protected $casts = [
        'jatuh_tempo' => 'date',
    ];

    public function pembayaran()
    {
        return $this->hasMany(KasPembayaran::class);
    }

    public function pembuatTagihan()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}