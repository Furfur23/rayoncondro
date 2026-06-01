@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

    {{-- Greeting --}}
    <div class="mb-5">
        <p class="text-gray-400 dark:text-gray-500 text-sm">
            Selamat {{ \Carbon\Carbon::now()->format('H') < 12 ? 'Pagi' : (\Carbon\Carbon::now()->format('H') < 15 ? 'Siang' : (\Carbon\Carbon::now()->format('H') < 18 ? 'Sore' : 'Malam')) }},
        </p>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-xs text-gray-400 mt-0.5">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 gap-3 mb-5">
        <div class="bg-gray-900 dark:bg-gray-900 border border-gold-700/40 rounded-2xl p-4 shadow">
            <p class="text-xs text-gray-400 mb-1">Siswa Aktif</p>
            <p class="text-3xl font-bold text-gold-400">{{ $total_siswa_aktif }}</p>
            <p class="text-xs text-gray-500 mt-1">orang</p>
        </div>
        <div class="bg-gray-900 dark:bg-gray-900 border border-gold-700/40 rounded-2xl p-4 shadow">
            <p class="text-xs text-gray-400 mb-1">Total Warga</p>
            <p class="text-3xl font-bold text-gold-400">{{ $total_warga }}</p>
            <p class="text-xs text-gray-500 mt-1">orang</p>
        </div>
    </div>

    {{-- Jadwal & Status Hari Ini --}}
    <div class="bg-gray-900 dark:bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-5 shadow">
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Hari Ini</p>
        @if($jadwal_hari_ini)
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="font-semibold text-white">{{ $jadwal_hari_ini->nama_sesi }}</p>
                    <p class="text-xs text-gray-400">
                        Pukul {{ \Carbon\Carbon::parse($jadwal_hari_ini->jam_mulai)->format('H.i') }} WIB
                    </p>
                </div>
                <span class="text-xs bg-gold-500/20 text-gold-400 border border-gold-600/40 px-3 py-1 rounded-full font-medium">
                    Ada Latihan
                </span>
            </div>
            {{-- Progress presensi --}}
            <div class="bg-gray-800 rounded-xl p-3">
                <div class="flex justify-between text-xs text-gray-400 mb-2">
                    <span>Presensi terisi</span>
                    <span class="text-gold-400 font-semibold">
                        {{ $presensi_hari_ini['sudah'] }}/{{ $presensi_hari_ini['total'] }} siswa
                    </span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-gold-500 h-2 rounded-full transition-all"
                        style="width: {{ $presensi_hari_ini['total'] > 0 ? ($presensi_hari_ini['sudah'] / $presensi_hari_ini['total'] * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-3">
                <p class="text-gray-500 text-sm">😴 Tidak ada latihan hari ini</p>
                <p class="text-xs text-gray-600 mt-1">Jadwal: Senin · Rabu · Jumat</p>
            </div>
        @endif
    </div>

    {{-- Aksi Cepat --}}
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Aksi Cepat</p>
    <div class="grid grid-cols-2 gap-3 mb-5">
        <a href="{{ route('admin.presensi.index') }}"
            class="bg-gray-900 border border-gray-800 hover:border-gold-600 rounded-2xl p-4 text-center shadow transition group">
            <span class="text-3xl block mb-2">📝</span>
            <span class="text-sm font-semibold text-gray-200 group-hover:text-gold-400 transition">
                Presensi Hari Ini
            </span>
            @if($presensi_hari_ini['belum'] > 0)
                <span class="mt-2 inline-block bg-red-500/20 text-red-400 text-xs px-2 py-0.5 rounded-full">
                    {{ $presensi_hari_ini['belum'] }} belum
                </span>
            @endif
        </a>

        <a href="{{ route('admin.kas.index') }}"
            class="bg-gray-900 border border-gray-800 hover:border-gold-600 rounded-2xl p-4 text-center shadow transition group">
            <span class="text-3xl block mb-2">💰</span>
            <span class="text-sm font-semibold text-gray-200 group-hover:text-gold-400 transition">
                Kas Belum Lunas
            </span>
            @if($kas_belum_lunas > 0)
                <span class="mt-2 inline-block bg-yellow-500/20 text-yellow-400 text-xs px-2 py-0.5 rounded-full">
                    {{ $kas_belum_lunas }} siswa
                </span>
            @endif
        </a>

        <a href="{{ route('admin.presensi.rekap') }}"
            class="bg-gray-900 border border-gray-800 hover:border-gold-600 rounded-2xl p-4 text-center shadow transition group">
            <span class="text-3xl block mb-2">📊</span>
            <span class="text-sm font-semibold text-gray-200 group-hover:text-gold-400 transition">
                Rekap Presensi
            </span>
        </a>

        <a href="{{ route('admin.anggota.siswa.create') }}"
            class="bg-gray-900 border border-gray-800 hover:border-gold-600 rounded-2xl p-4 text-center shadow transition group">
            <span class="text-3xl block mb-2">➕</span>
            <span class="text-sm font-semibold text-gray-200 group-hover:text-gold-400 transition">
                Tambah Siswa dan Warga
            </span>
        </a>

        
    </div>

@endsection