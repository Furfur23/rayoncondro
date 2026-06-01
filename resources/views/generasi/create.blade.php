@extends('layouts.main')
@section('title', 'Tambah Generasi')

@section('content')
<div class="mb-5">
    <a href="{{ route('generasi.index') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">➕ Tambah Generasi</h1>
    <p class="text-xs text-gray-500 mt-0.5">Warga otomatis masuk sesuai tahun pengesahan</p>
</div>

<form method="POST" action="{{ route('admin.generasi.store') }}"
    enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tahun Pengesahan</label>
            <input type="number" name="tahun"
                value="{{ old('tahun', date('Y')) }}"
                min="2000" max="{{ date('Y') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
            @error('tahun')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Nama Angkatan <span class="text-gray-600">(opsional)</span>
            </label>
            <input type="text" name="nama_angkatan"
                value="{{ old('nama_angkatan') }}"
                placeholder="contoh: Angkatan Garuda"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Foto Angkatan <span class="text-gray-600">(opsional)</span>
            </label>
            <input type="file" name="foto_angkatan"
                accept="image/jpg,image/jpeg,image/png,image/webp"
                class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition
                file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium
                file:bg-gold-500/20 file:text-gold-400 hover:file:bg-gold-500/30">
            <p class="text-xs text-gray-600 mt-1">JPG, PNG, WEBP · Maks 2MB</p>
            @error('foto_angkatan')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Deskripsi <span class="text-gray-600">(opsional)</span>
            </label>
            <textarea name="deskripsi" rows="3"
                placeholder="Cerita singkat angkatan ini..."
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition resize-none">{{ old('deskripsi') }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition">
        💾 Simpan Generasi
    </button>
</form>
@endsection