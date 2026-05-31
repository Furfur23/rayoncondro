@extends('layouts.main')
@section('title', 'Dashboard Siswa')

@section('content')
    {{-- Greeting + Info Sabuk --}}
    <div class="mb-6">
        <p class="text-gray-500 text-sm">Selamat {{ \Carbon\Carbon::now()->format('H') < 12 ? 'Pagi' : (\Carbon\Carbon::now()->format('H') < 15 ? 'Siang' : (\Carbon\Carbon::now()->format('H') < 18 ? 'Sore' : 'Malam')) }},</p>
        <h1 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }} 👋</h1>
        @if($profile)
            <span class="inline-block mt-1 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium capitalize">
                🥋 Sabuk {{ str_replace('_', ' ', $profile->tingkat_sabuk) }}
            </span>
        @endif
    </div>

    {{-- Statistik Kehadiran --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6">
        <h2 class="font-semibold text-gray-700 mb-3">📊 Kehadiran Saya</h2>
        <div class="flex items-center gap-4">
            <div class="relative w-20 h-20">
                <svg class="w-20 h-20 -rotate-90" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#16a34a" stroke-width="3"
                        stroke-dasharray="{{ $persentase_hadir }}, 100"
                        stroke-linecap="round"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-sm font-bold text-gray-800">{{ $persentase_hadir }}%</span>
                </div>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-600">
                    Hadir <span class="font-bold text-green-600">{{ $total_hadir }}x</span>
                    dari <span class="font-bold">{{ $total_latihan }}x</span> latihan
                </p>
                @if($persentase_hadir >= 75)
                    <p class="text-xs text-green-600 mt-1">✅ Memenuhi syarat tes sabuk</p>
                @else
                    <p class="text-xs text-red-500 mt-1">⚠️ Kehadiran belum cukup (min. 75%)</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Tagihan Kas --}}
    @if($tagihan_belum_lunas->count() > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
        <h2 class="font-semibold text-yellow-800 mb-2">💰 Tagihan Belum Lunas</h2>
        @foreach($tagihan_belum_lunas as $bayar)
            <div class="flex justify-between items-center py-2 border-b border-yellow-100 last:border-0">
                <span class="text-sm text-gray-700">{{ $bayar->tagihan->judul }}</span>
                <span class="text-sm font-bold text-yellow-700">
                    Rp {{ number_format($bayar->tagihan->nominal, 0, ',', '.') }}
                </span>
            </div>
        @endforeach
    </div>
    @else
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
        <p class="text-sm text-green-700">✅ Semua tagihan kas sudah lunas!</p>
    </div>
    @endif

    {{-- Jadwal Latihan --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6">
        <h2 class="font-semibold text-gray-700 mb-3">🗓️ Jadwal Latihan</h2>
        @php
            $namaHari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        @endphp
        @foreach($jadwal_latihan as $jadwal)
            <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                <span class="text-sm font-medium text-gray-700">
                    {{ $namaHari[$jadwal->hari] }}
                </span>
                <span class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} WIB
                </span>
            </div>
        @endforeach
    </div>
@endsection