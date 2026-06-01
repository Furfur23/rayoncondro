@extends('layouts.main')
@section('title', 'Rekap Presensi')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-bold text-white">📊 Rekap Presensi</h1>
    <p class="text-sm text-gray-400">Semua siswa aktif</p>
</div>

<div class="space-y-3">
    @forelse($siswa as $s)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold text-white">{{ $s['nama'] }}</p>
                    <p class="text-xs text-gray-500 capitalize">
                        🥋 Sabuk {{ str_replace('_', ' ', $s['sabuk']) }}
                    </p>
                </div>
                <span class="text-xl font-bold {{ $s['layak'] ? 'text-gold-400' : 'text-red-400' }}">
                    {{ $s['persen'] }}%
                </span>
            </div>

            {{-- Progress bar --}}
            <div class="w-full bg-gray-800 rounded-full h-2 mb-3">
                <div class="h-2 rounded-full transition-all {{ $s['layak'] ? 'bg-gold-500' : 'bg-red-500' }}"
                    style="width: {{ $s['persen'] }}%"></div>
            </div>

            {{-- Stat boxes --}}
            <div class="grid grid-cols-4 gap-2 text-center text-xs">
                <div class="bg-green-500/10 border border-green-500/20 rounded-xl py-2">
                    <p class="font-bold text-green-400 text-base">{{ $s['hadir'] }}</p>
                    <p class="text-gray-500">Hadir</p>
                </div>
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl py-2">
                    <p class="font-bold text-blue-400 text-base">{{ $s['izin'] }}</p>
                    <p class="text-gray-500">Izin</p>
                </div>
                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl py-2">
                    <p class="font-bold text-yellow-400 text-base">{{ $s['sakit'] }}</p>
                    <p class="text-gray-500">Sakit</p>
                </div>
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl py-2">
                    <p class="font-bold text-red-400 text-base">{{ $s['alpa'] }}</p>
                    <p class="text-gray-500">Alpa</p>
                </div>
            </div>

            <p class="text-xs mt-2 {{ $s['layak'] ? 'text-gold-400' : 'text-red-400' }}">
                {{ $s['layak'] ? '✅ Layak tes sabuk' : '⚠️ Belum layak (min. 75%)' }}
            </p>
        </div>
    @empty
        <div class="text-center py-10 text-gray-500">
            <p class="text-4xl mb-2">📋</p>
            <p>Belum ada data presensi.</p>
        </div>
    @endforelse
</div>
@endsection