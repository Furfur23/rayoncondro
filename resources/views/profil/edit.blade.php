@extends('layouts.main')
@section('title', 'Edit Profil Rayon')

@section('content')
<div class="mb-5">
    <a href="{{ route('profil.index') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">✏️ Edit Profil Rayon</h1>
</div>

<form method="POST" action="{{ route('profil.update.rayon') }}"
    enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Rayon</label>
            <input type="text" name="nama_rayon"
                value="{{ old('nama_rayon', $profil->nama_rayon) }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
            @error('nama_rayon')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Sejarah / Deskripsi Rayon
            </label>
            <textarea name="sejarah" rows="5"
                placeholder="Ceritakan sejarah singkat rayon..."
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition resize-none">{{ old('sejarah', $profil->sejarah) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Alamat Tempat Latihan</label>
            <input type="text" name="alamat_latihan"
                value="{{ old('alamat_latihan', $profil->alamat_latihan) }}"
                placeholder="contoh: Lapangan RT 05, Kel. Xxx"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Link Google Maps
                <span class="text-gray-600 font-normal">(URL share dari Google Maps)</span>
            </label>
            <input type="url" name="maps_embed_url"
                value="{{ old('maps_embed_url', $profil->maps_embed_url) }}"
                placeholder="https://maps.app.goo.gl/..."
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
            @error('maps_embed_url')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Foto Rayon <span class="text-gray-600">(opsional)</span>
            </label>
            @if($profil->foto_rayon)
                <img src="{{ asset('storage/' . $profil->foto_rayon) }}"
                    class="w-full h-32 object-cover rounded-xl mb-2 border border-gray-700">
            @endif
            <input type="file" name="foto_rayon"
                accept="image/jpg,image/jpeg,image/png,image/webp"
                class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-xl px-3 py-2.5 text-sm
                focus:outline-none focus:border-gold-500 transition
                file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium
                file:bg-gold-500/20 file:text-gold-400 hover:file:bg-gold-500/30">
            <p class="text-xs text-gray-600 mt-1">JPG, PNG, WEBP · Maks 2MB</p>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition">
        💾 Simpan Profil
    </button>
</form>
@endsection