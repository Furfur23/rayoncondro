@extends('layouts.main')
@section('title', 'Detail Kas')

@section('content')
@php
    $backRoute = auth()->user()->hasRole('admin')
        ? route('admin.kas.index')
        : route('warga.kas.index');
    $lunasRoute = auth()->user()->hasRole('admin') ? 'admin.kas.lunas' : 'warga.kas.lunas';
    $batalRoute = auth()->user()->hasRole('admin') ? 'admin.kas.batal' : 'warga.kas.batal';
@endphp

<div class="mb-4">
    <a href="{{ $backRoute }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">{{ $kas->judul }}</h1>
    <p class="text-sm text-gray-500">
        Rp {{ number_format($kas->nominal, 0, ',', '.') }} /siswa
    </p>
</div>

{{-- Ringkasan --}}
<div class="grid grid-cols-3 gap-3 mb-4">
    <div class="bg-green-50 border border-green-200 rounded-xl p-3 text-center">
        <p class="text-2xl font-bold text-green-700">{{ $totalLunas }}</p>
        <p class="text-xs text-gray-500">Lunas</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-xl p-3 text-center">
        <p class="text-2xl font-bold text-red-600">{{ $totalBelum }}</p>
        <p class="text-xs text-gray-500">Belum Lunas</p>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-center">
        <p class="text-lg font-bold text-blue-700">
            {{ number_format($totalTerkumpul / 1000, 0) }}rb
        </p>
        <p class="text-xs text-gray-500">Terkumpul</p>
    </div>
</div>

{{-- Tab Filter --}}
<div class="flex gap-2 mb-4">
    <button onclick="filterKas('belum')"
        id="tab-belum"
        class="flex-1 py-2 rounded-lg text-sm font-medium bg-red-500 text-white transition">
        Belum Lunas ({{ $totalBelum }})
    </button>
    <button onclick="filterKas('lunas')"
        id="tab-lunas"
        class="flex-1 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 transition">
        Sudah Lunas ({{ $totalLunas }})
    </button>
</div>

{{-- Daftar Belum Lunas --}}
<div id="list-belum" class="space-y-3">
    @foreach($pembayaran->where('status', 'belum_lunas') as $p)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $p->siswa->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">
                        Sabuk {{ str_replace('_', ' ', $p->siswa->siswaProfile?->tingkat_sabuk ?? '-') }}
                    </p>
                </div>
                <form method="POST" action="{{ route($lunasRoute, $p->id) }}">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition">
                        ✅ Tandai Lunas
                    </button>
                </form>
            </div>
        </div>
    @endforeach
    @if($pembayaran->where('status', 'belum_lunas')->isEmpty())
        <p class="text-center text-gray-400 py-6">🎉 Semua siswa sudah lunas!</p>
    @endif
</div>

{{-- Daftar Sudah Lunas --}}
<div id="list-lunas" class="space-y-3 hidden">
    @foreach($pembayaran->where('status', 'lunas') as $p)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $p->siswa->name }}</p>
                    <p class="text-xs text-gray-500">
                        Dibayar: {{ $p->tanggal_bayar
                            ? \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y')
                            : '-' }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">✅ Lunas</span>
                    @if(auth()->user()->hasRole('admin'))
                        <form method="POST" action="{{ route($batalRoute, $p->id) }}">
                            @csrf
                            <button type="submit"
                                class="text-xs text-red-500 hover:text-red-700">
                                Batal
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    @if($pembayaran->where('status', 'lunas')->isEmpty())
        <p class="text-center text-gray-400 py-6">Belum ada yang lunas.</p>
    @endif
</div>

<script>
function filterKas(tab) {
    const belum = document.getElementById('list-belum');
    const lunas = document.getElementById('list-lunas');
    const tabBelum = document.getElementById('tab-belum');
    const tabLunas = document.getElementById('tab-lunas');

    if (tab === 'belum') {
        belum.classList.remove('hidden');
        lunas.classList.add('hidden');
        tabBelum.className = 'flex-1 py-2 rounded-lg text-sm font-medium bg-red-500 text-white transition';
        tabLunas.className = 'flex-1 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 transition';
    } else {
        lunas.classList.remove('hidden');
        belum.classList.add('hidden');
        tabLunas.className = 'flex-1 py-2 rounded-lg text-sm font-medium bg-green-500 text-white transition';
        tabBelum.className = 'flex-1 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-600 transition';
    }
}
</script>
@endsection