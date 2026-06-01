@extends('layouts.main')
@section('title', 'Tambah Siswa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.anggota.siswa') }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">➕ Tambah Siswa Baru</h1>
</div>

<form method="POST" action="{{ route('admin.anggota.siswa.store') }}" class="space-y-4">
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
        <p class="text-sm font-semibold text-gray-600">Data Pencak Silat</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Sabuk</label>
            <select name="tingkat_sabuk"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @foreach(['polos','jambon','hijau','putih','kuning','merah','merah_putih'] as $sabuk)
                    <option value="{{ $sabuk }}" {{ old('tingkat_sabuk') === $sabuk ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $sabuk)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Naik Sabuk</label>
            <input type="date" name="tanggal_naik_sabuk" value="{{ old('tanggal_naik_sabuk') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bergabung</label>
            <input type="date" name="tanggal_bergabung" value="{{ old('tanggal_bergabung', today()->toDateString()) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
        <p class="text-sm font-semibold text-gray-600">Data Pribadi (opsional)</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                placeholder="08xx"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="alamat" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('alamat') }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-xl shadow transition">
        💾 Simpan Siswa
    </button>
</form>
@endsection