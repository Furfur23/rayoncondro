@extends('layouts.main')
@section('title', 'Galeri Generasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-bold text-white">🏛️ Galeri Generasi</h1>
        <p class="text-sm text-gray-400">Arsip angkatan rayon</p>
    </div>
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('admin.generasi.create') }}"
            class="bg-gold-500 hover:bg-gold-600 text-gray-900 text-sm px-4 py-2 rounded-xl font-bold transition">
            + Tambah
        </a>
    @endif
</div>

@forelse($generasi as $g)
    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden mb-4">

        {{-- Foto --}}
        @if($g->foto_angkatan)
            <img src="{{ asset('storage/' . $g->foto_angkatan) }}"
                alt="Foto Generasi {{ $g->tahun }}"
                class="w-full h-48 object-cover">
        @else
            <div class="w-full h-32 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center border-b border-gray-800">
                <span class="text-5xl opacity-30">🥋</span>
            </div>
        @endif

        <div class="p-4">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h2 class="font-bold text-white text-lg">
                        {{ $g->nama_angkatan ?? 'Generasi ' . $g->tahun }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Disahkan tahun {{ $g->tahun }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="bg-gold-500/20 text-gold-400 border border-gold-500/30 text-xs px-3 py-1 rounded-full font-medium">
                        {{ $g->warga->count() }} Warga
                    </span>
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.generasi.edit', $g->id) }}"
                            class="text-gray-500 hover:text-gold-400 transition text-sm">✏️</a>
                        <form method="POST" action="{{ route('admin.generasi.destroy', $g->id) }}"
                            onsubmit="return confirm('Hapus generasi {{ $g->tahun }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="text-gray-600 hover:text-red-400 transition text-sm">🗑️</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Deskripsi --}}
            @if($g->deskripsi)
                <p class="text-sm text-gray-400 mb-3 italic border-l-2 border-gold-600/40 pl-3">
                    {{ $g->deskripsi }}
                </p>
            @endif

            {{-- Daftar warga --}}
            @if($g->warga->count() > 0)
                <div class="border-t border-gray-800 pt-3">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-2 font-medium">
                        Daftar Warga
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($g->warga as $w)
                            <span class="bg-gray-800 border border-gray-700 text-gray-300 text-xs px-3 py-1 rounded-full">
                                {{ $w->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="border-t border-gray-800 pt-3">
                    <p class="text-xs text-gray-600 italic">
                        Belum ada warga di angkatan ini.
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.anggota.warga.create') }}"
                                class="text-gold-500 hover:text-gold-400 transition">Tambah warga →</a>
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@empty
    <div class="text-center py-16 text-gray-500">
        <p class="text-6xl mb-4">🏛️</p>
        <p class="font-medium text-gray-400 text-lg">Belum ada data generasi</p>
        <p class="text-sm text-gray-600 mt-1">Arsip angkatan akan tampil di sini</p>
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.generasi.create') }}"
                class="mt-4 inline-block bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold px-5 py-2.5 rounded-xl transition text-sm">
                + Tambah Generasi Pertama
            </a>
        @endif
    </div>
@endforelse
@endsection