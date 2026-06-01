<?php

namespace App\Http\Controllers;

use App\Models\KasPembayaran;
use App\Models\KasTagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KasController extends Controller
{
    // ── Daftar semua tagihan ─────────────────────────────
    public function index()
    {
        $tagihan = KasTagihan::with('pembuatTagihan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('kas.index', compact('tagihan'));
    }

    // ── Form buat tagihan baru ───────────────────────────
    public function create()
    {
        return view('kas.create');
    }

    // ── Simpan tagihan baru + buat record pembayaran semua siswa ──
    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:100',
            'nominal'      => 'required|integer|min:1000',
            'bulan'        => 'required|integer|min:1|max:12',
            'tahun'        => 'required|integer|min:2020',
            'jatuh_tempo'  => 'nullable|date',
            'keterangan'   => 'nullable|string',
        ]);

        // Buat tagihan
        $tagihan = KasTagihan::create([
            'judul'       => $request->judul,
            'nominal'     => $request->nominal,
            'bulan'       => $request->bulan,
            'tahun'       => $request->tahun,
            'jatuh_tempo' => $request->jatuh_tempo,
            'keterangan'  => $request->keterangan,
            'dibuat_oleh' => auth()->id(),
        ]);

        // Auto-generate record pembayaran untuk semua siswa aktif
        $siswaAktif = User::role('siswa')
            ->whereHas('siswaProfile', fn($q) => $q->where('status', 'aktif'))
            ->get();

        foreach ($siswaAktif as $siswa) {
            KasPembayaran::create([
                'kas_tagihan_id' => $tagihan->id,
                'user_id'        => $siswa->id,
                'status'         => 'belum_lunas',
            ]);
        }

        return redirect()->route('admin.kas.show', $tagihan->id)
            ->with('success', "Tagihan \"{$tagihan->judul}\" berhasil dibuat untuk {$siswaAktif->count()} siswa!");
    }

    // ── Detail tagihan + daftar pembayaran siswa ─────────
    public function show(KasTagihan $kas)
    {
        $pembayaran = KasPembayaran::where('kas_tagihan_id', $kas->id)
            ->with('siswa.siswaProfile')
            ->orderBy('status') // belum_lunas dulu
            ->get();

        $totalLunas     = $pembayaran->where('status', 'lunas')->count();
        $totalBelum     = $pembayaran->where('status', 'belum_lunas')->count();
        $totalTerkumpul = $totalLunas * $kas->nominal;

        return view('kas.show', compact(
            'kas', 'pembayaran', 'totalLunas', 'totalBelum', 'totalTerkumpul'
        ));
    }

    // ── Tandai lunas (satu siswa) ────────────────────────
    public function tandaiLunas(Request $request, KasPembayaran $pembayaran)
    {
        $pembayaran->update([
            'status'       => 'lunas',
            'tanggal_bayar'=> now(),
            'dicatat_oleh' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Pembayaran {$pembayaran->siswa->name} berhasil ditandai lunas!");
    }

    // ── Batalkan lunas ───────────────────────────────────
    public function batalLunas(KasPembayaran $pembayaran)
    {
        $pembayaran->update([
            'status'        => 'belum_lunas',
            'tanggal_bayar' => null,
            'dicatat_oleh'  => null,
        ]);

        return redirect()->back()->with('success', "Status pembayaran {$pembayaran->siswa->name} dikembalikan ke belum lunas.");
    }

    // ── Rekap kas semua tagihan (warga bisa lihat) ───────
    public function rekap()
    {
        $tagihan = KasTagihan::withCount([
            'pembayaran as total_siswa',
            'pembayaran as sudah_lunas' => fn($q) => $q->where('status', 'lunas'),
        ])->orderByDesc('tahun')->orderByDesc('bulan')->get();

        return view('kas.rekap', compact('tagihan'));
    }

    // ── Kas saya (untuk siswa) ───────────────────────────
    public function kasSiswa()
    {
        $user = auth()->user();

        $pembayaran = KasPembayaran::where('user_id', $user->id)
            ->with('tagihan')
            ->orderByDesc('created_at')
            ->get();

        $totalLunas = $pembayaran->where('status', 'lunas')->count();
        $totalBelum = $pembayaran->where('status', 'belum_lunas')->count();

        return view('kas.siswa', compact('pembayaran', 'totalLunas', 'totalBelum'));
    }
}