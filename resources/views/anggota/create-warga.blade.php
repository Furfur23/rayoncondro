@extends('layouts.main')
@section('title', 'Tambah Warga')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.anggota.warga') }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">➕ Tambah Warga Baru</h1>
</div>

<form method="POST" action="{{ route('admin.anggota.warga.store') }}" class="space-y-4">
    @csrf

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
        <p class="text-sm font-semibold text-gray-600">Data Akun</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
        <p class="text-sm font-semibold text-gray-600">Data Pengesahan</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Pengesahan</label>
            <input type="number" name="tahun_pengesahan"
                value="{{ old('tahun_pengesahan', date('Y')) }}"
                min="2000" max="{{ date('Y') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('tahun_pengesahan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nomor Pengesahan <span class="text-gray-400">(opsional)</span>
            </label>
            <input type="text" name="nomor_pengesahan" value="{{ old('nomor_pengesahan') }}"
                placeholder="contoh: 001/RAY/2024"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                No. WhatsApp <span class="text-gray-400">(opsional)</span>
            </label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                placeholder="08xx"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
    </div>

    <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-xl shadow transition">
        💾 Simpan Warga
    </button>
</form>
@endsection