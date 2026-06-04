@extends('layouts.main')
@section('title', 'Profil Rayon')

@section('content')

{{-- Header --}}
<div class="flex justify-between items-center mb-5">
    <div>
        <h1 class="text-xl font-bold text-white">🏯 Profil Rayon</h1>
        <p class="text-sm text-gray-400">{{ $profil?->nama_rayon ?? 'Rayon' }}</p>
    </div>
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('profil.edit.rayon') }}"
            class="bg-gray-800 hover:bg-gray-700 text-white text-sm px-3 py-2 rounded-xl transition">
            ✏️ Edit
        </a>
    @endif
</div>

{{-- Foto Rayon --}}
@if($profil?->foto_rayon)
    <img src="{{ asset('storage/' . $profil->foto_rayon) }}"
        alt="Foto Rayon"
        class="w-full h-44 object-cover rounded-2xl border border-gray-800 mb-4">
@endif

{{-- Tentang Kami --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Tentang Kami</p>
    @if($profil?->sejarah)
        <p class="text-sm text-gray-300 leading-relaxed">{{ $profil->sejarah }}</p>
    @else
        <p class="text-sm text-gray-600 italic">Belum ada deskripsi rayon.
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('profil.edit.rayon') }}" class="text-gold-500">Tambah sekarang →</a>
            @endif
        </p>
    @endif
</div>

{{-- Struktur Pengurus --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Pengurus</p>
    @forelse($pengurus as $p)
        <div class="flex items-center gap-3 py-2 border-b border-gray-800 last:border-0">
            <div class="w-8 h-8 rounded-full bg-gold-500/20 border border-gold-500/30 flex items-center justify-center text-sm">
                👤
            </div>
            <div>
                <p class="text-sm font-medium text-white">{{ $p->name }}</p>
                <p class="text-xs text-gray-500">Admin / Pengurus Inti</p>
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-600 italic">Belum ada data pengurus.</p>
    @endforelse
</div>

{{-- Lokasi Latihan --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Lokasi Latihan</p>
    @if($profil?->alamat_latihan)
        <p class="text-sm text-gray-300 mb-3">📍 {{ $profil->alamat_latihan }}</p>
    @endif
    @if($profil?->maps_embed_url)
        <a href="{{ $profil->maps_embed_url }}" target="_blank"
            class="flex items-center justify-center gap-2 w-full bg-gold-500/10 border border-gold-500/30
            text-gold-400 hover:bg-gold-500/20 font-medium py-3 rounded-xl text-sm transition">
            📌 Buka di Google Maps
        </a>
    @else
        <p class="text-sm text-gray-600 italic">Belum ada lokasi.
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('profil.edit.rayon') }}" class="text-gold-500">Tambah →</a>
            @endif
        </p>
    @endif
</div>

{{-- Kontak Warga --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Kontak Pengurus / Pelatih</p>
    @forelse($kontak as $k)
        <div class="flex items-center justify-between py-2.5 border-b border-gray-800 last:border-0">
            <div>
                <p class="text-sm font-medium text-white">{{ $k->name }}</p>
                <p class="text-xs text-gray-500">
                    Warga · {{ $k->wargaProfile?->tahun_pengesahan }}
                </p>
            </div>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $k->wargaProfile->phone) }}"
                target="_blank"
                class="flex items-center gap-1.5 bg-green-500/20 text-green-400 border border-green-500/30
                text-xs px-3 py-1.5 rounded-xl font-medium hover:bg-green-500/30 transition">
                📱 WA
            </a>
        </div>
    @empty
        <p class="text-sm text-gray-600 italic">Belum ada kontak warga.</p>
    @endforelse
</div>

@endsection