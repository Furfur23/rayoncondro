<?php

namespace App\Http\Controllers;

use App\Models\Generasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GenerasiController extends Controller
{
    // ── Tampilkan semua generasi (semua role bisa lihat) ──
    public function index()
    {
        $generasi = Generasi::orderByDesc('tahun')->get();

        // Attach warga per tahun pengesahan
        $generasi = $generasi->map(function ($g) {
            $g->warga = User::role('warga')
                ->whereHas('wargaProfile', fn($q) => $q->where('tahun_pengesahan', $g->tahun))
                ->with('wargaProfile')
                ->orderBy('name')
                ->get();
            return $g;
        });

        return view('generasi.index', compact('generasi'));
    }

    // ── Form tambah generasi (admin only) ────────────────
    public function create()
    {
        return view('generasi.create');
    }

    // ── Simpan generasi baru ─────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'tahun'          => 'required|integer|min:2000|max:' . date('Y'),
            'nama_angkatan'  => 'nullable|string|max:100',
            'foto_angkatan'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi'      => 'nullable|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_angkatan')) {
            $fotoPath = $request->file('foto_angkatan')
                ->store('generasi', 'public');
        }

        Generasi::create([
            'tahun'         => $request->tahun,
            'nama_angkatan' => $request->nama_angkatan,
            'foto_angkatan' => $fotoPath,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('generasi.index')
            ->with('success', "Generasi {$request->tahun} berhasil ditambahkan!");
    }

    // ── Form edit generasi (admin only) ──────────────────
    public function edit(Generasi $generasi)
    {
        return view('generasi.edit', compact('generasi'));
    }

    // ── Update generasi ───────────────────────────────────
    public function update(Request $request, Generasi $generasi)
    {
        $request->validate([
            'tahun'         => 'required|integer|min:2000|max:' . date('Y'),
            'nama_angkatan' => 'nullable|string|max:100',
            'foto_angkatan' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi'     => 'nullable|string',
        ]);

        $fotoPath = $generasi->foto_angkatan;
        if ($request->hasFile('foto_angkatan')) {
            // Hapus foto lama
            if ($fotoPath) Storage::disk('public')->delete($fotoPath);
            $fotoPath = $request->file('foto_angkatan')->store('generasi', 'public');
        }

        $generasi->update([
            'tahun'         => $request->tahun,
            'nama_angkatan' => $request->nama_angkatan,
            'foto_angkatan' => $fotoPath,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->route('generasi.index')
            ->with('success', "Generasi {$generasi->tahun} berhasil diperbarui!");
    }

    // ── Hapus generasi (admin only) ───────────────────────
    public function destroy(Generasi $generasi)
    {
        if ($generasi->foto_angkatan) {
            Storage::disk('public')->delete($generasi->foto_angkatan);
        }
        $generasi->delete();

        return redirect()->route('generasi.index')
            ->with('success', "Generasi berhasil dihapus.");
    }
}