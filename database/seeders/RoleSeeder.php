<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\SiswaProfile;
use App\Models\WargaProfile;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat 3 role
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'warga']);
        Role::firstOrCreate(['name' => 'siswa']);

        // ── ADMIN ──────────────────────────────
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@rayon.test'],
            [
                'name'     => 'Admin Rayon',
                'password' => Hash::make('password123'),
            ]
        );
        $adminUser->syncRoles('admin');

        // ── WARGA ──────────────────────────────
        $wargaUser = User::firstOrCreate(
            ['email' => 'warga@rayon.test'],
            [
                'name'     => 'Mas Budi',
                'password' => Hash::make('password123'),
            ]
        );
        $wargaUser->syncRoles('warga');

        WargaProfile::firstOrCreate(
            ['user_id' => $wargaUser->id],
            [
                'tahun_pengesahan' => 2020,
                'phone'            => '081234567890',
            ]
        );

        // ── SISWA ──────────────────────────────
        $siswaUser = User::firstOrCreate(
            ['email' => 'siswa@rayon.test'],
            [
                'name'     => 'Dika Pratama',
                'password' => Hash::make('password123'),
            ]
        );
        $siswaUser->syncRoles('siswa');

        SiswaProfile::firstOrCreate(
            ['user_id' => $siswaUser->id],
            [
                'tingkat_sabuk'      => 'jambon',
                'tanggal_naik_sabuk' => '2025-01-15',
                'status'             => 'aktif',
                'tanggal_bergabung'  => '2024-06-01',
            ]
        );
    }
}