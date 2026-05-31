<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalLatihan;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            ['hari' => 1, 'nama_sesi' => 'Latihan Rutin', 'jam_mulai' => '19:22:00'], // Senin
            ['hari' => 3, 'nama_sesi' => 'Latihan Rutin', 'jam_mulai' => '19:22:00'], // Rabu
            ['hari' => 5, 'nama_sesi' => 'Latihan Rutin', 'jam_mulai' => '19:22:00'], // Jumat
        ];

        foreach ($jadwal as $j) {
            JadwalLatihan::firstOrCreate(
                ['hari' => $j['hari'], 'nama_sesi' => $j['nama_sesi']],
                ['jam_mulai' => $j['jam_mulai'], 'is_aktif' => true]
            );
        }
    }
}