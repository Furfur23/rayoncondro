<?php

namespace App\Http\Controllers;

use App\Models\SiswaProfile;
use App\Models\User;
use App\Models\WargaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    // ── Daftar semua siswa ───────────────────────────────
    public function siswa()
    {
        $siswa = User::role('siswa')
            ->with('siswaProfile')
            ->orderBy('name')
            ->get();

        return view('anggota.siswa', compact('siswa'));
    }

    // ── Detail siswa ─────────────────────────────────────
    public function detailSiswa(User $user)
    {
        $profile     = $user->siswaProfile;
        $attendances = $user->attendances()
            ->with('jadwal')
            ->orderByDesc('tanggal')
            ->take(10)
            ->get();
        $persen = $user->persentaseKehadiran();

        return view('anggota.detail-siswa', compact('user', 'profile', 'attendances', 'persen'));
    }

    // ── Form tambah siswa baru ───────────────────────────
    public function createSiswa()
    {
        return view('anggota.create-siswa');
    }

    // ── Simpan siswa baru ────────────────────────────────
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6',
            'phone'             => 'nullable|string|max:20',
            'alamat'            => 'nullable|string',
            'tanggal_lahir'     => 'nullable|date',
            'tingkat_sabuk'     => 'required|in:polos,jambon,hijau,putih,kuning,merah,merah_putih',
            'tanggal_naik_sabuk' => 'nullable|date',
            'tanggal_bergabung' => 'nullable|date',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('siswa');

        SiswaProfile::create([
            'user_id'            => $user->id,
            'phone'              => $request->phone,
            'alamat'             => $request->alamat,
            'tanggal_lahir'      => $request->tanggal_lahir,
            'tingkat_sabuk'      => $request->tingkat_sabuk,
            'tanggal_naik_sabuk' => $request->tanggal_naik_sabuk,
            'tanggal_bergabung'  => $request->tanggal_bergabung ?? today(),
            'status'             => 'aktif',
        ]);

        return redirect()->route('admin.anggota.siswa')
            ->with('success', "Siswa {$user->name} berhasil ditambahkan!");
    }

    // ── Form edit siswa ──────────────────────────────────
    public function editSiswa(User $user)
    {
        $profile = $user->siswaProfile;
        return view('anggota.edit-siswa', compact('user', 'profile'));
    }

    // ── Update data siswa ────────────────────────────────
    public function updateSiswa(Request $request, User $user)
    {
        $request->validate([
            'name'              => 'required|string|max:100',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'phone'             => 'nullable|string|max:20',
            'alamat'            => 'nullable|string',
            'tanggal_lahir'     => 'nullable|date',
            'tingkat_sabuk'     => 'required|in:polos,jambon,hijau,putih,kuning,merah,merah_putih',
            'tanggal_naik_sabuk' => 'nullable|date',
            'status'            => 'required|in:aktif,berhenti',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->siswaProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone'              => $request->phone,
                'alamat'             => $request->alamat,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'tingkat_sabuk'      => $request->tingkat_sabuk,
                'tanggal_naik_sabuk' => $request->tanggal_naik_sabuk,
                'status'             => $request->status,
            ]
        );

        return redirect()->route('admin.anggota.siswa')
            ->with('success', "Data {$user->name} berhasil diperbarui!");
    }

    // ── Nonaktifkan siswa (soft delete) ─────────────────
    public function nonaktifkanSiswa(User $user)
    {
        $user->siswaProfile()->update(['status' => 'berhenti']);

        return redirect()->back()
            ->with('success', "{$user->name} berhasil dinonaktifkan.");
    }

    // ── Daftar semua warga ───────────────────────────────
    public function warga()
    {
        $warga = User::role('warga')
            ->with('wargaProfile')
            ->orderBy('name')
            ->get();

        return view('anggota.warga', compact('warga'));
    }

    // ── Form tambah warga ────────────────────────────────
    public function createWarga()
    {
        return view('anggota.create-warga');
    }

    // ── Simpan warga baru ────────────────────────────────
    public function storeWarga(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6',
            'phone'            => 'nullable|string|max:20',
            'tahun_pengesahan' => 'required|integer|min:2000|max:' . date('Y'),
            'nomor_pengesahan' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('warga');

        WargaProfile::create([
            'user_id'          => $user->id,
            'phone'            => $request->phone,
            'tahun_pengesahan' => $request->tahun_pengesahan,
            'nomor_pengesahan' => $request->nomor_pengesahan,
        ]);

        return redirect()->route('admin.anggota.warga')
            ->with('success', "Warga {$user->name} berhasil ditambahkan!");
    }

    // ── Halaman index anggota ────────────────────────────
    public function index()
    {
        return view('anggota.index');
    }
}
