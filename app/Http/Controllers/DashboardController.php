<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\JadwalLatihan;
use App\Models\KasPembayaran;
use App\Models\KasTagihan;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $data = [
            'total_siswa_aktif'  => User::role('siswa')
                ->whereHas('siswaProfile', fn($q) => $q->where('status', 'aktif'))
                ->count(),
            'total_warga'        => User::role('warga')->count(),
            'jadwal_hari_ini'    => $this->getJadwalHariIni(),
            'presensi_hari_ini'  => $this->getPresensiHariIni(),
            'kas_belum_lunas'    => $this->getKasBelumLunas(),
            'tagihan_aktif'      => KasTagihan::latest()->first(),
        ];

        return view('dashboard.admin', $data);
    }

    public function warga()
    {
        $data = [
            'total_siswa_aktif' => User::role('siswa')
                ->whereHas('siswaProfile', fn($q) => $q->where('status', 'aktif'))
                ->count(),
            'jadwal_hari_ini'   => $this->getJadwalHariIni(),
            'presensi_hari_ini' => $this->getPresensiHariIni(),
            'kas_belum_lunas'   => $this->getKasBelumLunas(),
        ];

        return view('dashboard.warga', $data);
    }

    public function siswa()
    {
        $user = auth()->user();
        $data = [
            'profile'            => $user->siswaProfile,
            'persentase_hadir'   => $user->persentaseKehadiran(),
            'total_hadir'        => $user->attendances()->where('status', 'hadir')->count(),
            'total_latihan'      => $user->attendances()->count(),
            'tagihan_belum_lunas' => KasPembayaran::where('user_id', $user->id)
                ->where('status', 'belum_lunas')
                ->with('tagihan')
                ->get(),
            'jadwal_latihan'     => JadwalLatihan::where('is_aktif', true)->get(),
        ];

        return view('dashboard.siswa', $data);
    }

    // ── Helper Methods ─────────────────────────────

    private function getJadwalHariIni(): ?JadwalLatihan
    {
        $hariIni = Carbon::now()->dayOfWeek; // 0=Minggu, 1=Senin, dst
        return JadwalLatihan::where('hari', $hariIni)
            ->where('is_aktif', true)
            ->first();
    }

    private function getPresensiHariIni(): array
    {
        $jadwal = $this->getJadwalHariIni();
        if (!$jadwal) return ['sudah' => 0, 'belum' => 0, 'total' => 0];

        // Hanya hitung siswa aktif
        $siswaAktif = User::role('siswa')
            ->whereHas('siswaProfile', fn($q) => $q->where('status', 'aktif'))
            ->pluck('id');

        $totalSiswa = $siswaAktif->count();

        // Hanya hitung presensi dari siswa aktif
        $sudahDiisi = Attendance::where('jadwal_latihan_id', $jadwal->id)
            ->whereDate('tanggal', today())
            ->whereIn('user_id', $siswaAktif) // ← filter hanya siswa aktif
            ->count();

        return [
            'sudah' => $sudahDiisi,
            'belum' => $totalSiswa - $sudahDiisi,
            'total' => $totalSiswa,
        ];
    }

    private function getKasBelumLunas(): int
    {
        $tagihan = KasTagihan::latest()->first();
        if (!$tagihan) return 0;

        return KasPembayaran::where('kas_tagihan_id', $tagihan->id)
            ->where('status', 'belum_lunas')
            ->count();
    }
}
