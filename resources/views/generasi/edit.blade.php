@extends('layouts.main')
@section('title', 'Edit Generasi')

@section('content')
<div class="mb-5">
    <a href="{{ route('generasi.index') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">✏️ Edit Generasi {{ $generasi->tahun }}</h1>
</div>

<form method="POST" action="{{ route('admin.generasi.update', $generasi->id) }}"
    enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tahun Pengesahan</label>
            <input type="number" name="tahun"
                value="{{ old('tahun', $generasi->tahun) }}"
                min="2000" max="{{ date('Y') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Angkatan</label>
            <input type="text" name="nama_angkatan"
                value="{{ old('nama_angkatan', $generasi->nama_angkatan) }}"
                placeholder="contoh: Angkatan Garuda"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Foto Angkatan</label>
            @if($generasi->foto_angkatan)
                <img src="{{ asset('storage/' . $generasi->foto_angkatan) }}"
                    class="w-full h-36 object-cover rounded-xl mb-2 border border-gray-700">
                <p class="text-xs text-gray-600 mb-2">Upload foto baru untuk mengganti foto di atas.</p>
            @endif
            <input type="file" name="foto_angkatan"
                accept="image/jpg,image/jpeg,image/png,image/webp"
                class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition
                file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium
                file:bg-gold-500/20 file:text-gold-400 hover:file:bg-gold-500/30">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition resize-none">{{ old('deskripsi', $generasi->deskripsi) }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition">
        💾 Simpan Perubahan
    </button>
</form>
@endsection