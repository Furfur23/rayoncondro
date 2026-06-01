@extends('layouts.main')
@section('title', 'Rekap Kas')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-bold text-white">📊 Rekap Kas</h1>
    <p class="text-sm text-gray-400">Semua periode tagihan</p>
</div>

<div class="space-y-3">
    @forelse($tagihan as $t)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <p class="font-semibold text-white">{{ $t->judul }}</p>
                    <p class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::create($t->tahun, $t->bulan)->translatedFormat('F Y') }}
                    </p>
                </div>
                <span class="text-sm font-bold text-gold-400">
                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex items-center gap-2 mb-2">
                <div class="flex-1 bg-gray-800 rounded-full h-2">
                    <div class="h-2 rounded-full bg-gold-500 transition-all"
                        style="width: {{ $t->total_siswa > 0 ? ($t->sudah_lunas / $t->total_siswa * 100) : 0 }}%">
                    </div>
                </div>
                <span class="text-xs text-gray-400 font-medium whitespace-nowrap">
                    {{ $t->sudah_lunas }}/{{ $t->total_siswa }}
                </span>
            </div>

            <p class="text-xs text-gray-500">
                Terkumpul:
                <span class="font-semibold text-gold-400">
                    Rp {{ number_format($t->sudah_lunas * $t->nominal, 0, ',', '.') }}
                </span>
                dari Rp {{ number_format($t->total_siswa * $t->nominal, 0, ',', '.') }}
            </p>
        </div>
    @empty
        <div class="text-center py-14 text-gray-500">
            <p class="text-5xl mb-3">📊</p>
            <p>Belum ada data tagihan.</p>
        </div>
    @endforelse
</div>
@endsection