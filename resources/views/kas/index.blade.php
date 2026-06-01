@extends('layouts.main')
@section('title', 'Buku Kas')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800">💰 Buku Kas</h1>
        <p class="text-sm text-gray-500">Daftar tagihan iuran rayon</p>
    </div>
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('admin.kas.create') }}"
            class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg font-medium">
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
            class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-gray-800">{{ $t->judul }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ \Carbon\Carbon::create($t->tahun, $t->bulan)->translatedFormat('F Y') }}
                    </p>
                </div>
                <span class="text-sm font-bold text-green-700">
                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                </span>
            </div>
            @if($t->jatuh_tempo)
                <p class="text-xs text-gray-400 mt-2">
                    Jatuh tempo: {{ \Carbon\Carbon::parse($t->jatuh_tempo)->translatedFormat('d F Y') }}
                </p>
            @endif
        </a>
    @empty
        <div class="text-center py-10 text-gray-400">
            <p class="text-4xl mb-2">💸</p>
            <p>Belum ada tagihan kas.</p>
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.kas.create') }}"
                    class="mt-3 inline-block text-green-600 font-medium text-sm">
                    Buat tagihan pertama →
                </a>
            @endif
        </div>
    @endforelse
</div>
@endsection