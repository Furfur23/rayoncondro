<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relasi
    public function siswaProfile()
    {
        return $this->hasOne(SiswaProfile::class);
    }

    public function wargaProfile()
    {
        return $this->hasOne(WargaProfile::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function kasPembayaran()
    {
        return $this->hasMany(KasPembayaran::class);
    }

    // Hitung persentase kehadiran
    public function persentaseKehadiran(): float
    {
        $total  = $this->attendances()->count();
        $hadir  = $this->attendances()->where('status', 'hadir')->count();
        if ($total === 0) return 0;
        return round(($hadir / $total) * 100, 1);
    }
}