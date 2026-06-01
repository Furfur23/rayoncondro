@extends('layouts.main')
@section('title', 'Kas Saya')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-bold text-white">💰 Kas Saya</h1>
</div>

{{-- Ringkasan --}}
<div class="grid grid-cols-2 gap-3 mb-5">
    <div class="bg-green-500/10 border border-green-500/20 rounded-2xl p-4 text-center">
        <p class="text-3xl font-bold text-green-400">{{ $totalLunas }}</p>
        <p class="text-xs text-gray-500 mt-1">Sudah Lunas</p>
    </div>
    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4 text-center">
        <p class="text-3xl font-bold text-red-400">{{ $totalBelum }}</p>
        <p class="text-xs text-gray-500 mt-1">Belum Lunas</p>
    </div>
</div>

{{-- Daftar --}}
<div class="space-y-3">
    @forelse($pembayaran as $p)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 flex justify-between items-center">
            <div>
                <p class="font-medium text-white">{{ $p->tagihan->judul }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Rp {{ number_format($p->tagihan->nominal, 0, ',', '.') }}
                    @if($p->tanggal_bayar)
                        · {{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y') }}
                    @endif
                </p>
            </div>
            @if($p->status === 'lunas')
                <span class="text-xs bg-green-500/20 text-green-400 border border-green-500/30 px-3 py-1 rounded-full font-medium">
                    ✅ Lunas
                </span>
            @else
                <span class="text-xs bg-red-500/20 text-red-400 border border-red-500/30 px-3 py-1 rounded-full font-medium">
                    ⏳ Belum
                </span>
            @endif
        </div>
    @empty
        <div class="text-center py-10 text-gray-500">
            <p class="text-4xl mb-2">💸</p>
            <p>Belum ada tagihan kas.</p>
        </div>
    @endforelse
</div>
@endsection