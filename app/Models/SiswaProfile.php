<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaProfile extends Model
{
    protected $fillable = [
        'user_id', 'nomor_induk', 'phone', 'alamat',
        'tanggal_lahir', 'foto', 'tingkat_sabuk',
        'tanggal_naik_sabuk', 'status', 'tanggal_bergabung', 'catatan',
    ];

    protected $casts = [
        'tanggal_lahir'      => 'date',
        'tanggal_naik_sabuk' => 'date',
        'tanggal_bergabung'  => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hitung durasi di sabuk saat ini
    public function getDurasiSabukAttribute(): string
    {
        if (!$this->tanggal_naik_sabuk) return '-';
        return $this->tanggal_naik_sabuk->diffForHumans(now(), true);
    }
}