@extends('layouts.main')
@section('title', 'Detail Kas')

@section('content')
@php
    $backRoute  = auth()->user()->hasRole('admin') ? route('admin.kas.index') : route('warga.kas.index');
    $lunasRoute = auth()->user()->hasRole('admin') ? 'admin.kas.lunas' : 'warga.kas.lunas';
    $batalRoute = auth()->user()->hasRole('admin') ? 'admin.kas.batal' : 'warga.kas.batal';
@endphp

<div class="mb-5">
    <a href="{{ $backRoute }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">{{ $kas->judul }}</h1>
    <p class="text-sm text-gray-400">
        Rp {{ number_format($kas->nominal, 0, ',', '.') }} / siswa
    </p>
</div>

{{-- Ringkasan --}}
<div class="grid grid-cols-3 gap-3 mb-5">
    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-3 text-center">
        <p class="text-2xl font-bold text-red-400">{{ $totalBelum }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Belum</p>
    </div>
    <div class="bg-green-500/10 border border-green-500/20 rounded-2xl p-3 text-center">
        <p class="text-2xl font-bold text-green-400">{{ $totalLunas }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Lunas</p>
    </div>
    <div class="bg-gold-500/10 border border-gold-500/20 rounded-2xl p-3 text-center">
        <p class="text-base font-bold text-gold-400">
            {{ number_format($totalTerkumpul / 1000, 0) }}rb
        </p>
        <p class="text-xs text-gray-500 mt-0.5">Terkumpul</p>
    </div>
</div>

{{-- Tab --}}
<div class="flex gap-2 mb-4">
    <button onclick="filterKas('belum')" id="tab-belum"
        class="flex-1 py-2.5 rounded-xl text-sm font-bold bg-red-500 text-white transition">
        Belum ({{ $totalBelum }})
    </button>
    <button onclick="filterKas('lunas')" id="tab-lunas"
        class="flex-1 py-2.5 rounded-xl text-sm font-bold bg-gray-800 text-gray-400 transition">
        Lunas ({{ $totalLunas }})
    </button>
</div>

{{-- List Belum Lunas --}}
<div id="list-belum" class="space-y-3">
    @foreach($pembayaran->where('status', 'belum_lunas') as $p)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 flex justify-between items-center">
            <div>
                <p class="font-medium text-white">{{ $p->siswa->name }}</p>
                <p class="text-xs text-gray-500 capitalize">
                    🥋 {{ str_replace('_', ' ', $p->siswa->siswaProfile?->tingkat_sabuk ?? '-') }}
                </p>
            </div>
            <form method="POST" action="{{ route($lunasRoute, $p->id) }}">
                @csrf
                <button type="submit"
                    class="bg-gold-500 hover:bg-gold-600 text-gray-900 text-sm px-4 py-2 rounded-xl font-bold transition">
                    ✅ Lunas
                </button>
            </form>
        </div>
    @endforeach
    @if($pembayaran->where('status', 'belum_lunas')->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <p class="text-3xl mb-2">🎉</p>
            <p>Semua siswa sudah lunas!</p>
        </div>
    @endif
</div>

{{-- List Sudah Lunas --}}
<div id="list-lunas" class="space-y-3 hidden">
    @foreach($pembayaran->where('status', 'lunas') as $p)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 flex justify-between items-center">
            <div>
                <p class="font-medium text-white">{{ $p->siswa->name }}</p>
                <p class="text-xs text-gray-500">
                    {{ $p->tanggal_bayar
                        ? \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y')
                        : '-' }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs bg-green-500/20 text-green-400 border border-green-500/30 px-3 py-1 rounded-full font-medium">
                    ✅ Lunas
                </span>
                @if(auth()->user()->hasRole('admin'))
                    <form method="POST" action="{{ route($batalRoute, $p->id) }}">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 hover:text-red-400 transition">
                            Batal
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
    @if($pembayaran->where('status', 'lunas')->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <p>Belum ada yang lunas.</p>
        </div>
    @endif
</div>

<script>
function filterKas(tab) {
    const belum    = document.getElementById('list-belum');
    const lunas    = document.getElementById('list-lunas');
    const tabBelum = document.getElementById('tab-belum');
    const tabLunas = document.getElementById('tab-lunas');

    if (tab === 'belum') {
        belum.classList.remove('hidden');
        lunas.classList.add('hidden');
        tabBelum.className = 'flex-1 py-2.5 rounded-xl text-sm font-bold bg-red-500 text-white transition';
        tabLunas.className = 'flex-1 py-2.5 rounded-xl text-sm font-bold bg-gray-800 text-gray-400 transition';
    } else {
        lunas.classList.remove('hidden');
        belum.classList.add('hidden');
        tabLunas.className = 'flex-1 py-2.5 rounded-xl text-sm font-bold bg-green-500 text-white transition';
        tabBelum.className = 'flex-1 py-2.5 rounded-xl text-sm font-bold bg-gray-800 text-gray-400 transition';
    }
}
</script>
@endsection