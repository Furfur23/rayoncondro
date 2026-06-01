@extends('layouts.main')
@section('title', 'Detail Siswa')

@section('content')
<div class="mb-4 flex justify-between items-start">
    <div>
        <a href="{{ route('admin.anggota.siswa') }}" class="text-sm text-gray-500">← Kembali</a>
        <h1 class="text-xl font-bold text-gray-800 mt-1">{{ $user->name }}</h1>
        <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
            {{ $profile?->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ ucfirst($profile?->status ?? 'aktif') }}
        </span>
    </div>
    <a href="{{ route('admin.anggota.siswa.edit', $user->id) }}"
        class="bg-blue-600 text-white text-sm px-3 py-2 rounded-lg">
        ✏️ Edit
    </a>
</div>

{{-- Info Sabuk --}}
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-4">
    <h2 class="font-semibold text-gray-700 mb-3">🥋 Info Pencak Silat</h2>
    <div class="grid grid-cols-2 gap-3 text-sm">
        <div>
            <p class="text-gray-400 text-xs">Tingkat Sabuk</p>
            <p class="font-medium capitalize">{{ str_replace('_', ' ', $profile?->tingkat_sabuk ?? '-') }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs">Naik Sabuk</p>
            <p class="font-medium">
                {{ $profile?->tanggal_naik_sabuk
                    ? \Carbon\Carbon::parse($profile->tanggal_naik_sabuk)->translatedFormat('d F Y')
                    : '-' }}
            </p>
        </div>
        <div>
            <p class="text-gray-400 text-xs">Durasi di Sabuk Ini</p>
            <p class="font-medium">{{ $profile?->durasi_sabuk ?? '-' }}</p>
        </div>
        <div>
            <p class="text-gray-400 text-xs">Bergabung</p>
            <p class="font-medium">
                {{ $profile?->tanggal_bergabung
                    ? \Carbon\Carbon::parse($profile->tanggal_bergabung)->translatedFormat('d F Y')
                    : '-' }}
            </p>
        </div>
    </div>
</div>

{{-- Statistik Kehadiran --}}
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-4">
    <h2 class="font-semibold text-gray-700 mb-3">📊 Kehadiran</h2>
    <div class="flex items-center gap-3">
        <div class="w-full bg-gray-100 rounded-full h-3">
            <div class="h-3 rounded-full {{ $persen >= 75 ? 'bg-green-500' : 'bg-red-400' }}"
                style="width: {{ $persen }}%"></div>
        </div>
        <span class="font-bold text-lg {{ $persen >= 75 ? 'text-green-600' : 'text-red-500' }} whitespace-nowrap">
            {{ $persen }}%
        </span>
    </div>
    <p class="text-xs mt-1 {{ $persen >= 75 ? 'text-green-600' : 'text-red-500' }}">
        {{ $persen >= 75 ? '✅ Layak tes sabuk' : '⚠️ Belum layak tes sabuk (min. 75%)' }}
    </p>
</div>

{{-- Info Kontak --}}
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-4">
    <h2 class="font-semibold text-gray-700 mb-3">📱 Kontak</h2>
    <div class="space-y-2 text-sm">
        <div class="flex justify-between">
            <span class="text-gray-400">Email</span>
            <span class="font-medium">{{ $user->email }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-400">WhatsApp</span>
            <span class="font-medium">{{ $profile?->phone ?? '-' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-400">Alamat</span>
            <span class="font-medium text-right max-w-xs">{{ $profile?->alamat ?? '-' }}</span>
        </div>
    </div>
</div>

{{-- Riwayat Presensi Terakhir --}}
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-4">
    <h2 class="font-semibold text-gray-700 mb-3">🗓️ Presensi Terakhir</h2>
    <div class="space-y-2">
        @forelse($attendances as $a)
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">
                    {{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}
                </span>
                @php
                    $badge = match($a->status) {
                        'hadir' => 'bg-green-100 text-green-700',
                        'izin'  => 'bg-blue-100 text-blue-700',
                        'sakit' => 'bg-yellow-100 text-yellow-700',
                        'alpa'  => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <span class="text-xs px-2 py-0.5 rounded-full capitalize {{ $badge }}">
                    {{ $a->status }}
                </span>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada data presensi.</p>
        @endforelse
    </div>
</div>

{{-- Tombol Nonaktifkan --}}
@if($profile?->status === 'aktif')
    <form method="POST" action="{{ route('admin.anggota.siswa.nonaktif', $user->id) }}"
        onsubmit="return confirm('Yakin nonaktifkan {{ $user->name }}?')">
        @csrf
        <button type="submit"
            class="w-full bg-red-50 border border-red-300 text-red-600 font-medium py-3 rounded-xl text-sm">
            🚫 Nonaktifkan Siswa
        </button>
    </form>
@endif
@endsection