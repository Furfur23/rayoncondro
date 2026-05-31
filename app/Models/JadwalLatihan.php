<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    protected $table = 'jadwal_latihan'; // ← tambah ini, paksa nama tabel

    protected $fillable = [
        'hari', 'nama_sesi', 'jam_mulai', 'jam_selesai',
        'is_aktif', 'keterangan',
    ];

    public function getNamaHariAttribute(): string
    {
        $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        return $hari[$this->hari] ?? '-';
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}