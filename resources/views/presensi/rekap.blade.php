@extends('layouts.main')
@section('title', 'Rekap Presensi')

@section('content')
<div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800">📊 Rekap Presensi</h1>
    <p class="text-sm text-gray-500">Semua siswa aktif</p>
</div>

<div class="space-y-3">
    @forelse($siswa as $s)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-medium text-gray-800">{{ $s['nama'] }}</p>
                    <p class="text-xs text-gray-500 capitalize">
                        Sabuk {{ str_replace('_', ' ', $s['sabuk']) }}
                    </p>
                </div>
                <span class="text-lg font-bold {{ $s['layak'] ? 'text-green-600' : 'text-red-500' }}">
                    {{ $s['persen'] }}%
                </span>
            </div>

            {{-- Progress bar --}}
            <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                <div class="h-2 rounded-full {{ $s['layak'] ? 'bg-green-500' : 'bg-red-400' }}"
                    style="width: {{ $s['persen'] }}%"></div>
            </div>

            <div class="grid grid-cols-4 gap-1 text-center text-xs">
                <div class="bg-green-50 rounded p-1">
                    <p class="font-bold text-green-700">{{ $s['hadir'] }}</p>
                    <p class="text-gray-500">Hadir</p>
                </div>
                <div class="bg-blue-50 rounded p-1">
                    <p class="font-bold text-blue-700">{{ $s['izin'] }}</p>
                    <p class="text-gray-500">Izin</p>
                </div>
                <div class="bg-yellow-50 rounded p-1">
                    <p class="font-bold text-yellow-700">{{ $s['sakit'] }}</p>
                    <p class="text-gray-500">Sakit</p>
                </div>
                <div class="bg-red-50 rounded p-1">
                    <p class="font-bold text-red-700">{{ $s['alpa'] }}</p>
                    <p class="text-gray-500">Alpa</p>
                </div>
            </div>

            @if($s['layak'])
                <p class="text-xs text-green-600 mt-2">✅ Layak tes sabuk</p>
            @else
                <p class="text-xs text-red-500 mt-2">⚠️ Belum layak tes sabuk (min. 75%)</p>
            @endif
        </div>
    @empty
        <div class="text-center py-8 text-gray-400">
            Belum ada data presensi.
        </div>
    @endforelse
</div>
@endsection