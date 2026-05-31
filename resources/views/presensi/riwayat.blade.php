@extends('layouts.main')
@section('title', 'Riwayat Presensi')

@section('content')
<div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800">📋 Riwayat Presensi Saya</h1>
</div>

{{-- Persentase --}}
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-4">
    <p class="text-sm text-gray-500 mb-1">Total Kehadiran</p>
    <div class="flex items-center gap-3">
        <div class="w-full bg-gray-100 rounded-full h-3">
            <div class="h-3 rounded-full {{ $persen >= 75 ? 'bg-green-500' : 'bg-red-400' }}"
                style="width: {{ $persen }}%"></div>
        </div>
        <span class="font-bold text-lg {{ $persen >= 75 ? 'text-green-600' : 'text-red-500' }}">
            {{ $persen }}%
        </span>
    </div>
    @if($persen >= 75)
        <p class="text-xs text-green-600 mt-1">✅ Layak tes sabuk</p>
    @else
        <p class="text-xs text-red-500 mt-1">⚠️ Belum layak tes sabuk (min. 75%)</p>
    @endif
</div>

{{-- Tabel Riwayat --}}
<div class="space-y-2">
    @forelse($riwayat as $r)
        <div class="bg-white rounded-xl px-4 py-3 shadow-sm border border-gray-100 flex justify-between items-center">
            <div>
                <p class="text-sm font-medium text-gray-800">
                    {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l, d F Y') }}
                </p>
                <p class="text-xs text-gray-500">{{ $r->jadwal?->nama_sesi ?? 'Latihan Rutin' }}</p>
            </div>
            @php
                $badge = match($r->status) {
                    'hadir' => 'bg-green-100 text-green-700',
                    'izin'  => 'bg-blue-100 text-blue-700',
                    'sakit' => 'bg-yellow-100 text-yellow-700',
                    'alpa'  => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp
            <span class="text-xs font-semibold px-3 py-1 rounded-full capitalize {{ $badge }}">
                {{ $r->status }}
            </span>
        </div>
    @empty
        <div class="text-center py-8 text-gray-400">
            Belum ada riwayat presensi.
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $riwayat->links() }}
</div>
@endsection