@extends('layouts.main')
@section('title', 'Tambah Warga')

@section('content')
<div class="mb-5">
    <a href="{{ route('admin.anggota.warga') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">➕ Tambah Warga Baru</h1>
</div>

<form method="POST" action="{{ route('admin.anggota.warga.store') }}" class="space-y-4">
    @csrf

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-medium">Data Akun</p>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
            <input type="password" name="password"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-medium">Data Pengesahan</p>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tahun Pengesahan</label>
            <input type="number" name="tahun_pengesahan"
                value="{{ old('tahun_pengesahan', date('Y')) }}"
                min="2000" max="{{ date('Y') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
            @error('tahun_pengesahan')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Nomor Pengesahan <span class="text-gray-600">(opsional)</span>
            </label>
            <input type="text" name="nomor_pengesahan" value="{{ old('nomor_pengesahan') }}"
                placeholder="contoh: 001/RAY/2024"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                No. WhatsApp <span class="text-gray-600">(opsional)</span>
            </label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xx"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>
    </div>

    <button type="submit"
        class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition">
        💾 Simpan Warga
    </button>
</form>
@endsectionx