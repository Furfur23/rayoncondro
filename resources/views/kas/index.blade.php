@extends('layouts.main')
@section('title', 'Buku Kas')

@section('content')
<div class="flex justify-between items-center mb-5">
    <div>
        <h1 class="text-xl font-bold text-white">💰 Buku Kas</h1>
        <p class="text-sm text-gray-400">Iuran rayon</p>
    </div>
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('admin.kas.create') }}"
            class="bg-gold-500 hover:bg-gold-600 text-gray-900 text-sm px-4 py-2 rounded-xl font-bold transition">
            + Buat Tagihan
        </a>
    @endif
</div>

<div class="space-y-3">
    @forelse($tagihan as $t)
        @php
            $route = auth()->user()->hasRole('admin')
                ? route('admin.kas.show', $t->id)
                : route('warga.kas.show', $t->id);
        @endphp
        <a href="{{ $route }}"
            class="block bg-gray-900 border border-gray-800 hover:border-gold-600/50 rounded-2xl p-4 transition">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold text-white">{{ $t->judul }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ \Carbon\Carbon::create($t->tahun, $t->bulan)->translatedFormat('F Y') }}
                    </p>
                </div>
                <span class="text-sm font-bold text-gold-400">
                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                </span>
            </div>
            @if($t->jatuh_tempo)
                <p class="text-xs text-gray-600">
                    Jatuh tempo: {{ \Carbon\Carbon::parse($t->jatuh_tempo)->translatedFormat('d F Y') }}
                </p>
            @endif
            <div class="flex justify-end mt-2">
                <span class="text-xs text-gray-600">Lihat detail →</span>
            </div>
        </a>
    @empty
        <div class="text-center py-14 text-gray-500">
            <p class="text-5xl mb-3">💸</p>
            <p class="font-medium text-gray-400">Belum ada tagihan kas.</p>
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.kas.create') }}"
                    class="mt-3 inline-block text-gold-400 text-sm font-medium">
                    Buat tagihan pertama →
                </a>
            @endif
        </div>
    @endforelse
</div>
@endsection