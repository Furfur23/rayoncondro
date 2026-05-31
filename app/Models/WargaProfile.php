<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WargaProfile extends Model
{
    protected $fillable = [
        'user_id', 'phone', 'alamat', 'tanggal_lahir',
        'foto', 'tahun_pengesahan', 'nomor_pengesahan', 'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}