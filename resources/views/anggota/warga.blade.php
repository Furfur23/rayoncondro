@extends('layouts.main')
@section('title', 'Data Warga')

@section('content')
<div class="flex justify-between items-center mb-5">
    <div>
        <a href="{{ route('admin.anggota.index') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
        <h1 class="text-xl font-bold text-white mt-1">🎖️ Data Warga</h1>
        <p class="text-sm text-gray-400">{{ $warga->count() }} warga terdaftar</p>
    </div>
    <a href="{{ route('admin.anggota.warga.create') }}"
        class="bg-gold-500 hover:bg-gold-600 text-gray-900 text-sm px-4 py-2 rounded-xl font-bold transition">
        + Tambah
    </a>
</div>

<div class="space-y-3">
    @forelse($warga as $w)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-white">{{ $w->name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        🎖️ Disahkan {{ $w->wargaProfile?->tahun_pengesahan ?? '-' }}
                        @if($w->wargaProfile?->nomor_pengesahan)
                            · No. {{ $w->wargaProfile->nomor_pengesahan }}
                        @endif
                    </p>
                    @if($w->wargaProfile?->phone)
                        <p class="text-xs text-gray-600 mt-0.5">📱 {{ $w->wargaProfile->phone }}</p>
                    @endif
                </div>
                <span class="text-xs bg-gold-500/20 text-gold-400 border border-gold-500/30 px-3 py-1 rounded-full font-medium">
                    Warga
                </span>
            </div>
        </div>
    @empty
        <div class="text-center py-14 text-gray-500">
            <p class="text-5xl mb-3">🎖️</p>
            <p class="font-medium text-gray-400">Belum ada warga terdaftar.</p>
        </div>
    @endforelse
</div>
@endsection