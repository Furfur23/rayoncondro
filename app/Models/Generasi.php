<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generasi extends Model
{
    protected $table = 'generasi'; // ← tambah ini

    protected $fillable = [
        'tahun', 'nama_angkatan', 'foto_angkatan', 'deskripsi',
    ];
}