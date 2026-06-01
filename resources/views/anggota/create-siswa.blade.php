@extends('layouts.main')
@section('title', 'Tambah Siswa')

@section('content')
<div class="mb-5">
    <a href="{{ route('admin.anggota.siswa') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">➕ Tambah Siswa Baru</h1>
</div>

<form method="POST" action="{{ route('admin.anggota.siswa.store') }}" class="space-y-4">
    @csrf

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-medium">Data Akun</p>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
            <input type="password" name="password"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-medium">Data Pencak Silat</p>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tingkat Sabuk</label>
            <select name="tingkat_sabuk"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
                @foreach(['polos','jambon','hijau','putih','kuning','merah','merah_putih'] as $sabuk)
                    <option value="{{ $sabuk }}" {{ old('tingkat_sabuk') === $sabuk ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $sabuk)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tanggal Naik Sabuk</label>
            <input type="date" name="tanggal_naik_sabuk" value="{{ old('tanggal_naik_sabuk') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tanggal Bergabung</label>
            <input type="date" name="tanggal_bergabung"
                value="{{ old('tanggal_bergabung', today()->toDateString()) }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-medium">Data Pribadi (opsional)</p>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">No. WhatsApp</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xx"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Alamat</label>
            <textarea name="alamat" rows="2"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">{{ old('alamat') }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition">
        💾 Simpan Siswa
    </button>
</form>
@endsection