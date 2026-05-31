@extends('layouts.main')
@section('title', 'Dashboard Warga')

@section('content')
    {{-- Greeting --}}
    <div class="mb-6">
        <p class="text-gray-500 text-sm">Selamat {{ \Carbon\Carbon::now()->format('H') < 12 ? 'Pagi' : (\Carbon\Carbon::now()->format('H') < 15 ? 'Siang' : (\Carbon\Carbon::now()->format('H') < 18 ? 'Sore' : 'Malam')) }},</p>
        <h1 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Ringkasan --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6">
        <p class="text-xs text-gray-500">Siswa Aktif</p>
        <p class="text-3xl font-bold text-green-600">{{ $total_siswa_aktif }}</p>
    </div>

    {{-- Status Hari Ini --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6">
        <h2 class="font-semibold text-gray-700 mb-3">📅 Hari Ini</h2>
        @if($jadwal_hari_ini)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $jadwal_hari_ini->nama_sesi }}</p>
                    <p class="text-xs text-gray-500">Pukul {{ \Carbon\Carbon::parse($jadwal_hari_ini->jam_mulai)->format('H.i') }} WIB</p>
                </div>
                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Ada Latihan</span>
            </div>
            <div class="mt-3 bg-gray-50 rounded-lg p-3">
                <p class="text-xs text-gray-500 mb-1">Presensi terisi</p>
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full"
                            style="width: {{ $presensi_hari_ini['total'] > 0 ? ($presensi_hari_ini['sudah'] / $presensi_hari_ini['total'] * 100) : 0 }}%">
                        </div>
                    </div>
                    <span class="text-xs font-medium text-gray-700">
                        {{ $presensi_hari_ini['sudah'] }}/{{ $presensi_hari_ini['total'] }}
                    </span>
                </div>
            </div>
        @else
            <p class="text-sm text-gray-400 italic">Tidak ada jadwal latihan hari ini.</p>
        @endif
    </div>

    {{-- Aksi Cepat --}}
    <h2 class="font-semibold text-gray-700 mb-3">⚡ Aksi Cepat</h2>
    <div class="grid grid-cols-2 gap-3 mb-6">
        <a href="{{ auth()->user()->hasRole('admin') ? route('admin.presensi.index') : route('warga.presensi.index') }}"
            class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-4 text-center shadow-sm transition">
            <span class="text-3xl block mb-1">📝</span>
            <span class="text-sm font-semibold">Presensi Hari Ini</span>
        </a>
        <a href="#"
            class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl p-4 text-center shadow-sm transition">
            <span class="text-3xl block mb-1">💰</span>
            <span class="text-sm font-semibold">Kas Belum Lunas</span>
            @if($kas_belum_lunas > 0)
                <span class="mt-1 inline-block bg-white text-yellow-600 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $kas_belum_lunas }} siswa
                </span>
            @endif
        </a>
    </div>
@endsection