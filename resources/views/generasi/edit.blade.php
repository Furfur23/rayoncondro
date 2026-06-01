@extends('layouts.main')
@section('title', 'Edit Generasi')

@section('content')
<div class="mb-4">
    <a href="{{ route('generasi.index') }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">✏️ Edit Generasi {{ $generasi->tahun }}</h1>
</div>

<form method="POST" action="{{ route('admin.generasi.update', $generasi->id) }}"
    enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pengesahan</label>
            <input type="number" name="tahun"
                value="{{ old('tahun', $generasi->tahun) }}"
                min="2000" max="{{ date('Y') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Angkatan</label>
            <input type="text" name="nama_angkatan"
                value="{{ old('nama_angkatan', $generasi->nama_angkatan) }}"
                placeholder="contoh: Angkatan Garuda"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Angkatan</label>
            @if($generasi->foto_angkatan)
                <img src="{{ asset('storage/' . $generasi->foto_angkatan) }}"
                    class="w-full h-32 object-cover rounded-lg mb-2">
                <p class="text-xs text-gray-400 mb-2">Upload foto baru untuk mengganti.</p>
            @endif
            <input type="file" name="foto_angkatan"
                accept="image/jpg,image/jpeg,image/png,image/webp"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('deskripsi', $generasi->deskripsi) }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-xl shadow transition">
        💾 Simpan Perubahan
    </button>
</form>
@endsection