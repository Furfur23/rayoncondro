@extends('layouts.main')
@section('title', 'Tambah Generasi')

@section('content')
<div class="mb-4">
    <a href="{{ route('generasi.index') }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">➕ Tambah Generasi</h1>
    <p class="text-sm text-gray-500">Warga akan otomatis masuk berdasarkan tahun pengesahan</p>
</div>

<form method="POST" action="{{ route('admin.generasi.store') }}"
    enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pengesahan</label>
            <input type="number" name="tahun"
                value="{{ old('tahun', date('Y')) }}"
                min="2000" max="{{ date('Y') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('tahun')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Angkatan <span class="text-gray-400">(opsional)</span>
            </label>
            <input type="text" name="nama_angkatan"
                value="{{ old('nama_angkatan') }}"
                placeholder="contoh: Angkatan Garuda"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Foto Angkatan <span class="text-gray-400">(opsional)</span>
            </label>
            <input type="file" name="foto_angkatan"
                accept="image/jpg,image/jpeg,image/png,image/webp"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
            @error('foto_angkatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Deskripsi <span class="text-gray-400">(opsional)</span>
            </label>
            <textarea name="deskripsi" rows="3"
                placeholder="Cerita singkat angkatan ini..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('deskripsi') }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-xl shadow transition">
        💾 Simpan Generasi
    </button>
</form>
@endsection