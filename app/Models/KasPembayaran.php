<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasPembayaran extends Model
{
    protected $table = 'kas_pembayaran'; // ← tambah ini

    protected $fillable = [
        'kas_tagihan_id', 'user_id', 'status',
        'tanggal_bayar', 'dicatat_oleh', 'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function tagihan()
    {
        return $this->belongsTo(KasTagihan::class, 'kas_tagihan_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}