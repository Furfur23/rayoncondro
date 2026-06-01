@extends('layouts.main')
@section('title', 'Edit Siswa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.anggota.siswa.show', $user->id) }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">✏️ Edit: {{ $user->name }}</h1>
</div>

<form method="POST" action="{{ route('admin.anggota.siswa.update', $user->id) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
        <p class="text-sm font-semibold text-gray-600">Data Akun</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
        <p class="text-sm font-semibold text-gray-600">Data Pencak Silat</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Sabuk</label>
            <select name="tingkat_sabuk"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @foreach(['polos','jambon','hijau','putih','kuning','merah','merah_putih'] as $sabuk)
                    <option value="{{ $sabuk }}"
                        {{ old('tingkat_sabuk', $profile?->tingkat_sabuk) === $sabuk ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $sabuk)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Naik Sabuk</label>
            <input type="date" name="tanggal_naik_sabuk"
                value="{{ old('tanggal_naik_sabuk', $profile?->tanggal_naik_sabuk?->toDateString()) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Keanggotaan</label>
            <select name="status"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="aktif" {{ old('status', $profile?->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="berhenti" {{ old('status', $profile?->status) === 'berhenti' ? 'selected' : '' }}>Berhenti</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
        <p class="text-sm font-semibold text-gray-600">Data Pribadi</p>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
            <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir"
                value="{{ old('tanggal_lahir', $profile?->tanggal_lahir?->toDateString()) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="alamat" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('alamat', $profile?->alamat) }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-xl shadow transition">
        💾 Simpan Perubahan
    </button>
</form>
@endsection