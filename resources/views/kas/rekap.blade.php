@extends('layouts.main')
@section('title', 'Rekap Kas')

@section('content')
<div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800">📊 Rekap Kas</h1>
    <p class="text-sm text-gray-500">Semua periode tagihan</p>
</div>

<div class="space-y-3">
    @forelse($tagihan as $t)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="font-semibold text-gray-800">{{ $t->judul }}</p>
                    <p class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::create($t->tahun, $t->bulan)->translatedFormat('F Y') }}
                    </p>
                </div>
                <span class="text-sm font-bold text-green-700">
                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                </span>
            </div>

            {{-- Progress --}}
            <div class="flex items-center gap-2 mb-1">
                <div class="flex-1 bg-gray-100 rounded-full h-2">
                    <div class="h-2 rounded-full bg-green-500"
                        style="width: {{ $t->total_siswa > 0 ? ($t->sudah_lunas / $t->total_siswa * 100) : 0 }}%">
                    </div>
                </div>
                <span class="text-xs text-gray-600 font-medium">
                    {{ $t->sudah_lunas }}/{{ $t->total_siswa }}
                </span>
            </div>
            <p class="text-xs text-gray-500">
                Terkumpul:
                <span class="font-semibold text-green-700">
                    Rp {{ number_format($t->sudah_lunas * $t->nominal, 0, ',', '.') }}
                </span>
                dari
                Rp {{ number_format($t->total_siswa * $t->nominal, 0, ',', '.') }}
            </p>
        </div>
    @empty
        <div class="text-center py-10 text-gray-400">
            Belum ada data tagihan kas.
        </div>
    @endforelse
</div>
@endsection