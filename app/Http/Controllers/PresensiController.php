<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\JadwalLatihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PresensiController extends Controller
{
    // ── Tampilkan form presensi hari ini ─────────────────
    public function index()
    {
        $hariIni  = Carbon::now()->dayOfWeek;
        $tanggal  = Carbon::today();

        $jadwal = JadwalLatihan::where('hari', $hariIni)
            ->where('is_aktif', true)
            ->first();

        // Ambil semua siswa aktif
        $siswa = User::role('siswa')
            ->whereHas('siswaProfile', fn($q) => $q->where('status', 'aktif'))
            ->with('siswaProfile')
            ->orderBy('name')
            ->get();

        // Ambil presensi hari ini jika sudah ada
        $presensiHariIni = collect();
        if ($jadwal) {
            $presensiHariIni = Attendance::where('jadwal_latihan_id', $jadwal->id)
                ->whereDate('tanggal', $tanggal)
                ->get()
                ->keyBy('user_id'); // index by user_id biar mudah dicek di view
        }

        return view('presensi.index', compact(
            'jadwal', 'siswa', 'presensiHariIni', 'tanggal'
        ));
    }

    // ── Simpan presensi ──────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_latihan_id' => 'required|exists:jadwal_latihan,id',
            'tanggal'           => 'required|date',
            'presensi'          => 'required|array',
            'presensi.*'        => 'in:hadir,izin,sakit,alpa',
        ]);

        $tanggal   = $request->tanggal;
        $jadwalId  = $request->jadwal_latihan_id;
        $pencatat  = auth()->id();

        foreach ($request->presensi as $userId => $status) {
            Attendance::updateOrCreate(
                [
                    'user_id'           => $userId,
                    'jadwal_latihan_id' => $jadwalId,
                    'tanggal'           => $tanggal,
                ],
                [
                    'status'      => $status,
                    'dicatat_oleh'=> $pencatat,
                ]
            );
        }

        return redirect()->back()->with('success', 'Presensi berhasil disimpan!');
    }

    // ── Rekap presensi per siswa ─────────────────────────
    public function rekap()
    {
        $siswa = User::role('siswa')
            ->whereHas('siswaProfile', fn($q) => $q->where('status', 'aktif'))
            ->with(['siswaProfile', 'attendances'])
            ->orderBy('name')
            ->get()
            ->map(function ($s) {
                $total = $s->attendances->count();
                $hadir = $s->attendances->where('status', 'hadir')->count();
                $izin  = $s->attendances->where('status', 'izin')->count();
                $sakit = $s->attendances->where('status', 'sakit')->count();
                $alpa  = $s->attendances->where('status', 'alpa')->count();
                $persen = $total > 0 ? round($hadir / $total * 100, 1) : 0;

                return [
                    'id'      => $s->id,
                    'nama'    => $s->name,
                    'sabuk'   => $s->siswaProfile?->tingkat_sabuk ?? '-',
                    'total'   => $total,
                    'hadir'   => $hadir,
                    'izin'    => $izin,
                    'sakit'   => $sakit,
                    'alpa'    => $alpa,
                    'persen'  => $persen,
                    'layak'   => $persen >= 75,
                ];
            });

        return view('presensi.rekap', compact('siswa'));
    }

    // ── Riwayat presensi satu siswa (untuk siswa login) ──
    public function riwayat()
    {
        $user = auth()->user();

        $riwayat = Attendance::where('user_id', $user->id)
            ->with('jadwal')
            ->orderByDesc('tanggal')
            ->paginate(20);

        $persen = $user->persentaseKehadiran();

        return view('presensi.riwayat', compact('riwayat', 'persen'));
    }
}