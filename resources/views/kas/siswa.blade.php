@extends('layouts.main')
@section('title', 'Kas Saya')

@section('content')
<div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800">💰 Kas Saya</h1>
</div>

{{-- Ringkasan --}}
<div class="grid grid-cols-2 gap-3 mb-6">
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
        <p class="text-3xl font-bold text-green-700">{{ $totalLunas }}</p>
        <p class="text-xs text-gray-500">Sudah Lunas</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
        <p class="text-3xl font-bold text-red-600">{{ $totalBelum }}</p>
        <p class="text-xs text-gray-500">Belum Lunas</p>
    </div>
</div>

{{-- Daftar --}}
<div class="space-y-3">
    @forelse($pembayaran as $p)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $p->tagihan->judul }}</p>
                    <p class="text-xs text-gray-500">
                        Rp {{ number_format($p->tagihan->nominal, 0, ',', '.') }}
                        @if($p->tanggal_bayar)
                            · Dibayar {{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y') }}
                        @endif
                    </p>
                </div>
                @if($p->status === 'lunas')
                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-medium">
                        ✅ Lunas
                    </span>
                @else
                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-medium">
                        ⏳ Belum
                    </span>
                @endif
            </div>
        </div>
    @empty
        <p class="text-center text-gray-400 py-8">Belum ada tagihan kas.</p>
    @endforelse
</div>
@endsection