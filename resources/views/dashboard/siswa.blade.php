@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

    <div class="mb-5">
        <p class="text-gray-400 text-sm">
            Selamat {{ \Carbon\Carbon::now()->format('H') < 12 ? 'Pagi' : (\Carbon\Carbon::now()->format('H') < 15 ? 'Siang' : (\Carbon\Carbon::now()->format('H') < 18 ? 'Sore' : 'Malam')) }},
        </p>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ auth()->user()->name }} 👋
        </h1>
        @if($profile)
            <span class="inline-block mt-1 bg-gold-500/20 text-gold-400 border border-gold-600/40 text-xs px-3 py-1 rounded-full font-medium capitalize">
                🥋 Sabuk {{ str_replace('_', ' ', $profile->tingkat_sabuk) }}
            </span>
        @endif
    </div>

    {{-- Kehadiran --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4 shadow">
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Kehadiran Saya</p>
        <div class="flex items-center gap-4">
            {{-- Circle progress --}}
            <div class="relative w-20 h-20 shrink-0">
                <svg class="w-20 h-20 -rotate-90" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#374151" stroke-width="3"/>
                    <circle cx="18" cy="18" r="15.9" fill="none"
                        stroke="{{ $persentase_hadir >= 75 ? '#f59e0b' : '#ef4444' }}"
                        stroke-width="3"
                        stroke-dasharray="{{ $persentase_hadir }}, 100"
                        stroke-linecap="round"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-sm font-bold text-white">{{ $persentase_hadir }}%</span>
                </div>
            </div>
            <div>
                <p class="text-gray-300 text-sm">
                    Hadir <span class="font-bold text-gold-400">{{ $total_hadir }}x</span>
                    dari <span class="font-bold text-white">{{ $total_latihan }}x</span>
                </p>
                @if($persentase_hadir >= 75)
                    <p class="text-xs text-gold-400 mt-1">✅ Layak tes sabuk</p>
                @else
                    <p class="text-xs text-red-400 mt-1">⚠️ Belum layak tes (min. 75%)</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Tagihan --}}
    @if($tagihan_belum_lunas->count() > 0)
        <div class="bg-yellow-900/30 border border-yellow-700/50 rounded-2xl p-4 mb-4">
            <p class="text-xs text-yellow-400 uppercase tracking-widest mb-2 font-medium">
                ⚠️ Tagihan Belum Lunas
            </p>
            @foreach($tagihan_belum_lunas as $bayar)
                <div class="flex justify-between items-center py-2 border-b border-yellow-800/30 last:border-0">
                    <span class="text-sm text-gray-300">{{ $bayar->tagihan->judul }}</span>
                    <span class="text-sm font-bold text-yellow-400">
                        Rp {{ number_format($bayar->tagihan->nominal, 0, ',', '.') }}
                    </span>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-green-900/20 border border-green-800/40 rounded-2xl p-3 mb-4">
            <p class="text-sm text-green-400 text-center">✅ Semua tagihan kas sudah lunas!</p>
        </div>
    @endif

    {{-- Jadwal --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4">
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Jadwal Latihan</p>
        @php $namaHari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; @endphp
        @foreach($jadwal_latihan as $jadwal)
            <div class="flex justify-between items-center py-2 border-b border-gray-800 last:border-0">
                <span class="text-sm text-gray-300">{{ $namaHari[$jadwal->hari] }}</span>
                <span class="text-sm text-gold-400 font-medium">
                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} WIB
                </span>
            </div>
        @endforeach
    </div>

@endsection