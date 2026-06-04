<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilRayon extends Model
{
    protected $table = 'profil_rayon';

    protected $fillable = [
        'nama_rayon',
        'sejarah',
        'alamat_latihan',
        'maps_embed_url',
        'foto_rayon',
    ];
}