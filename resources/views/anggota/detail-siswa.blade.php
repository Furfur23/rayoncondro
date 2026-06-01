@extends('layouts.main')
@section('title', 'Detail Siswa')

@section('content')
<div class="flex justify-between items-start mb-5">
    <div>
        <a href="{{ route('admin.anggota.siswa') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
        <h1 class="text-xl font-bold text-white mt-1">{{ $user->name }}</h1>
        <span class="inline-block mt-1 text-xs px-3 py-1 rounded-full font-medium
            {{ $profile?->status === 'aktif' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
            {{ ucfirst($profile?->status ?? 'aktif') }}
        </span>
    </div>
    <a href="{{ route('admin.anggota.siswa.edit', $user->id) }}"
        class="bg-gray-800 hover:bg-gray-700 text-white text-sm px-3 py-2 rounded-xl transition">
        ✏️ Edit
    </a>
</div>

{{-- Info Sabuk --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Info Pencak Silat</p>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-500 text-xs mb-0.5">Tingkat Sabuk</p>
            <p class="font-semibold text-gold-400 capitalize">
                🥋 {{ str_replace('_', ' ', $profile?->tingkat_sabuk ?? '-') }}
            </p>
        </div>
        <div>
            <p class="text-gray-500 text-xs mb-0.5">Naik Sabuk</p>
            <p class="font-medium text-white">
                {{ $profile?->tanggal_naik_sabuk
                    ? \Carbon\Carbon::parse($profile->tanggal_naik_sabuk)->translatedFormat('d F Y')
                    : '-' }}
            </p>
        </div>
        <div>
            <p class="text-gray-500 text-xs mb-0.5">Durasi Sabuk Ini</p>
            <p class="font-medium text-white">{{ $profile?->durasi_sabuk ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-xs mb-0.5">Bergabung</p>
            <p class="font-medium text-white">
                {{ $profile?->tanggal_bergabung
                    ? \Carbon\Carbon::parse($profile->tanggal_bergabung)->translatedFormat('d F Y')
                    : '-' }}
            </p>
        </div>
    </div>
</div>

{{-- Kehadiran --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Kehadiran</p>
    <div class="flex items-center gap-3 mb-2">
        <div class="flex-1 bg-gray-800 rounded-full h-3">
            <div class="h-3 rounded-full transition-all {{ $persen >= 75 ? 'bg-gold-500' : 'bg-red-500' }}"
                style="width: {{ $persen }}%"></div>
        </div>
        <span class="font-bold text-lg {{ $persen >= 75 ? 'text-gold-400' : 'text-red-400' }} whitespace-nowrap">
            {{ $persen }}%
        </span>
    </div>
    <p class="text-xs {{ $persen >= 75 ? 'text-gold-400' : 'text-red-400' }}">
        {{ $persen >= 75 ? '✅ Layak tes sabuk' : '⚠️ Belum layak tes sabuk (min. 75%)' }}
    </p>
</div>

{{-- Kontak --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Kontak</p>
    <div class="space-y-2 text-sm">
        <div class="flex justify-between">
            <span class="text-gray-500">Email</span>
            <span class="text-white">{{ $user->email }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">WhatsApp</span>
            <span class="text-white">{{ $profile?->phone ?? '-' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Alamat</span>
            <span class="text-white text-right max-w-xs">{{ $profile?->alamat ?? '-' }}</span>
        </div>
    </div>
</div>

{{-- Presensi Terakhir --}}
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 mb-4">
    <p class="text-xs text-gray-400 uppercase tracking-widest mb-3 font-medium">Presensi Terakhir</p>
    <div class="space-y-2">
        @forelse($attendances as $a)
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-300">
                    {{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}
                </span>
                @php
                    $badge = match($a->status) {
                        'hadir' => 'bg-green-500/20 text-green-400',
                        'izin'  => 'bg-blue-500/20 text-blue-400',
                        'sakit' => 'bg-yellow-500/20 text-yellow-400',
                        'alpa'  => 'bg-red-500/20 text-red-400',
                        default => 'bg-gray-700 text-gray-400',
                    };
                @endphp
                <span class="text-xs px-2 py-0.5 rounded-full capitalize {{ $badge }}">
                    {{ $a->status }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Belum ada data presensi.</p>
        @endforelse
    </div>
</div>

{{-- Tombol Nonaktifkan --}}
@if($profile?->status === 'aktif')
    <form method="POST" action="{{ route('admin.anggota.siswa.nonaktif', $user->id) }}"
        onsubmit="return confirm('Yakin nonaktifkan {{ $user->name }}?')">
        @csrf
        <button type="submit"
            class="w-full bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500/20 font-medium py-3 rounded-2xl text-sm transition">
            🚫 Nonaktifkan Siswa
        </button>
    </form>
@endif
@endsection