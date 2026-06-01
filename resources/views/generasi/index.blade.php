@extends('layouts.main')
@section('title', 'Galeri Generasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-bold text-gray-800">🏛️ Galeri Generasi</h1>
        <p class="text-sm text-gray-500">Arsip angkatan rayon</p>
    </div>
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('admin.generasi.create') }}"
            class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg font-medium">
            + Tambah
        </a>
    @endif
</div>

@forelse($generasi as $g)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-4 overflow-hidden">

        {{-- Foto Angkatan --}}
        @if($g->foto_angkatan)
            <img src="{{ asset('storage/' . $g->foto_angkatan) }}"
                alt="Foto Generasi {{ $g->tahun }}"
                class="w-full h-48 object-cover">
        @else
            <div class="w-full h-32 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                <span class="text-5xl">🥋</span>
            </div>
        @endif

        <div class="p-4">
            {{-- Header generasi --}}
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">
                        {{ $g->nama_angkatan ?? 'Generasi ' . $g->tahun }}
                    </h2>
                    <p class="text-sm text-gray-500">Disahkan {{ $g->tahun }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">
                        {{ $g->warga->count() }} Warga
                    </span>
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.generasi.edit', $g->id) }}"
                            class="text-xs text-blue-500 hover:text-blue-700">✏️</a>
                        <form method="POST" action="{{ route('admin.generasi.destroy', $g->id) }}"
                            onsubmit="return confirm('Hapus generasi {{ $g->tahun }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">🗑️</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Deskripsi --}}
            @if($g->deskripsi)
                <p class="text-sm text-gray-600 mb-3 italic">{{ $g->deskripsi }}</p>
            @endif

            {{-- Daftar nama warga --}}
            @if($g->warga->count() > 0)
                <div class="border-t border-gray-50 pt-3">
                    <p class="text-xs text-gray-400 mb-2 font-medium uppercase tracking-wide">
                        Daftar Warga
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($g->warga as $w)
                            <span class="bg-gray-50 border border-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full">
                                {{ $w->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="border-t border-gray-50 pt-3">
                    <p class="text-xs text-gray-400 italic">
                        Belum ada warga di angkatan ini.
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.anggota.warga.create') }}"
                                class="text-green-600 underline">Tambah warga</a>
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@empty
    <div class="text-center py-16 text-gray-400">
        <p class="text-5xl mb-3">🏛️</p>
        <p class="font-medium">Belum ada data generasi.</p>
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.generasi.create') }}"
                class="mt-3 inline-block text-green-600 font-medium text-sm">
                Tambah generasi pertama →
            </a>
        @endif
    </div>
@endforelse
@endsection