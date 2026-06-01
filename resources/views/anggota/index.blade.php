@extends('layouts.main')
@section('title', 'Data Anggota')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-white">👥 Data Anggota</h1>
    <p class="text-sm text-gray-400">Kelola siswa dan warga rayon</p>
</div>

<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('admin.anggota.siswa') }}"
        class="bg-gray-900 border border-gray-800 hover:border-gold-600/50 rounded-2xl p-5 text-center transition group">
        <span class="text-4xl block mb-3">🥋</span>
        <p class="font-semibold text-white group-hover:text-gold-400 transition">Data Siswa</p>
        <p class="text-xs text-gray-500 mt-1">Kelola siswa aktif & nonaktif</p>
    </a>
    <a href="{{ route('admin.anggota.warga') }}"
        class="bg-gray-900 border border-gray-800 hover:border-gold-600/50 rounded-2xl p-5 text-center transition group">
        <span class="text-4xl block mb-3">🎖️</span>
        <p class="font-semibold text-white group-hover:text-gold-400 transition">Data Warga</p>
        <p class="text-xs text-gray-500 mt-1">Kelola pelatih & warga</p>
    </a>
</div>
@endsection