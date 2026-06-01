@extends('layouts.main')
@section('title', 'Riwayat Presensi')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-bold text-white">📋 Riwayat Presensi Saya</h1>
</div>

{{-- Persentase --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-5">
    <div class="flex items-center gap-4">
        <div class="relative w-16 h-16 shrink-0">
            <svg class="w-16 h-16 -rotate-90" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#374151" stroke-width="3"/>
                <circle cx="18" cy="18" r="15.9" fill="none"
                    stroke="{{ $persen >= 75 ? '#f59e0b' : '#ef4444' }}"
                    stroke-width="3"
                    stroke-dasharray="{{ $persen }}, 100"
                    stroke-linecap="round"/>
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-xs font-bold text-white">{{ $persen }}%</span>
            </div>
        </div>
        <div>
            <p class="text-white font-semibold">Total Kehadiran</p>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ $persen >= 75 ? '✅ Layak tes sabuk' : '⚠️ Belum layak (min. 75%)' }}
            </p>
        </div>
    </div>
</div>

{{-- List riwayat --}}
<div class="space-y-2">
    @forelse($riwayat as $r)
        @php
            $config = match($r->status) {
                'hadir' => ['bg-green-500/10 border-green-500/20', 'text-green-400', 'bg-green-500/20'],
                'izin'  => ['bg-blue-500/10 border-blue-500/20',   'text-blue-400',  'bg-blue-500/20'],
                'sakit' => ['bg-yellow-500/10 border-yellow-500/20','text-yellow-400','bg-yellow-500/20'],
                'alpa'  => ['bg-red-500/10 border-red-500/20',     'text-red-400',   'bg-red-500/20'],
                default => ['bg-gray-800 border-gray-700',         'text-gray-400',  'bg-gray-700'],
            };
        @endphp
        <div class="bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-white">
                    {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                </p>
                <p class="text-xs text-gray-500">{{ $r->jadwal?->nama_sesi ?? 'Latihan Rutin' }}</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1 rounded-full capitalize
                {{ $config[2] }} {{ $config[1] }}">
                {{ $r->status }}
            </span>
        </div>
    @empty
        <div class="text-center py-10 text-gray-500">
            <p class="text-4xl mb-2">📋</p>
            <p>Belum ada riwayat presensi.</p>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $riwayat->links() }}</div>
@endsection