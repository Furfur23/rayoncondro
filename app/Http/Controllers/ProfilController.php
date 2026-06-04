<?php

namespace App\Http\Controllers;

use App\Models\ProfilRayon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // ── Halaman profil (semua role bisa lihat) ───────────
    public function index()
    {
        $profil = ProfilRayon::first();

        // Ambil daftar kontak warga (yang punya no. WA)
        $kontak = User::role('warga')
            ->whereHas('wargaProfile', fn($q) => $q->whereNotNull('phone'))
            ->with('wargaProfile')
            ->orderBy('name')
            ->get();

        // Ambil pengurus (admin)
        $pengurus = User::role('admin')
            ->orderBy('name')
            ->get();

        return view('profil.index', compact('profil', 'kontak', 'pengurus'));
    }

    // ── Form edit profil (admin only) ────────────────────
    public function edit()
    {
        $profil = ProfilRayon::firstOrCreate(
            ['id' => 1],
            ['nama_rayon' => 'Rayon']
        );

        return view('profil.edit', compact('profil'));
    }

    // ── Update profil (admin only) ────────────────────────
    public function update(Request $request)
    {
        $request->validate([
            'nama_rayon'     => 'required|string|max:100',
            'sejarah'        => 'nullable|string',
            'alamat_latihan' => 'nullable|string',
            'maps_embed_url' => 'nullable|url',
            'foto_rayon'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $profil = ProfilRayon::firstOrCreate(['id' => 1]);

        $fotoPath = $profil->foto_rayon;
        if ($request->hasFile('foto_rayon')) {
            if ($fotoPath) Storage::disk('public')->delete($fotoPath);
            $fotoPath = $request->file('foto_rayon')->store('profil', 'public');
        }

        $profil->update([
            'nama_rayon'     => $request->nama_rayon,
            'sejarah'        => $request->sejarah,
            'alamat_latihan' => $request->alamat_latihan,
            'maps_embed_url' => $request->maps_embed_url,
            'foto_rayon'     => $fotoPath,
        ]);

        return redirect()->route('profil.index')
            ->with('success', 'Profil rayon berhasil diperbarui!');
    }
}