@extends('layouts.main')
@section('title', 'Data Warga')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800">🎖️ Data Warga</h1>
        <p class="text-sm text-gray-500">{{ $warga->count() }} warga terdaftar</p>
    </div>
    <a href="{{ route('admin.anggota.warga.create') }}"
        class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg font-medium">
        + Tambah
    </a>
</div>

<div class="space-y-3">
    @forelse($warga as $w)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $w->name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Disahkan {{ $w->wargaProfile?->tahun_pengesahan ?? '-' }}
                        @if($w->wargaProfile?->nomor_pengesahan)
                            · No. {{ $w->wargaProfile->nomor_pengesahan }}
                        @endif
                    </p>
                    @if($w->wargaProfile?->phone)
                        <p class="text-xs text-gray-400 mt-0.5">📱 {{ $w->wargaProfile->phone }}</p>
                    @endif
                </div>
                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">Warga</span>
            </div>
        </div>
    @empty
        <div class="text-center py-10 text-gray-400">
            <p class="text-4xl mb-2">👤</p>
            <p>Belum ada warga terdaftar.</p>
        </div>
    @endforelse
</div>
@endsection