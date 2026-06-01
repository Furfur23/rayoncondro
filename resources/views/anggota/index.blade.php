@extends('layouts.main')
@section('title', 'Data Anggota')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-800">👥 Data Anggota</h1>
    <p class="text-sm text-gray-500">Kelola data siswa dan warga rayon</p>
</div>

<div class="grid grid-cols-2 gap-4">
    <a href="{{ route('admin.anggota.siswa') }}"
        class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-center hover:border-green-400 transition">
        <span class="text-4xl block mb-2">🥋</span>
        <p class="font-semibold text-gray-800">Data Siswa</p>
        <p class="text-xs text-gray-400 mt-1">Kelola siswa aktif & nonaktif</p>
    </a>

    <a href="{{ route('admin.anggota.warga') }}"
        class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-center hover:border-blue-400 transition">
        <span class="text-4xl block mb-2">🎖️</span>
        <p class="font-semibold text-gray-800">Data Warga</p>
        <p class="text-xs text-gray-400 mt-1">Kelola data pelatih & warga</p>
    </a>
</div>
@endsection