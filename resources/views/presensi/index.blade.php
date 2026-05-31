@extends('layouts.main')
@section('title', 'Presensi Hari Ini')

@section('content')
<div class="mb-4">
    <h1 class="text-xl font-bold text-gray-800">📝 Presensi Hari Ini</h1>
    <p class="text-sm text-gray-500">
        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
    </p>
</div>

@if(!$jadwal)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
        <p class="text-yellow-700 font-medium">😴 Tidak ada jadwal latihan hari ini.</p>
        <p class="text-sm text-yellow-600 mt-1">Jadwal latihan: Senin, Rabu, Jumat</p>
    </div>
@else
    <div class="bg-green-50 border border-green-200 rounded-xl p-3 mb-4">
        <p class="text-sm text-green-700 font-medium">
            {{ $jadwal->nama_sesi }} —
            Pukul {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} WIB
        </p>
    </div>

    @if($siswa->isEmpty())
        <div class="bg-gray-50 rounded-xl p-4 text-center">
            <p class="text-gray-500">Belum ada siswa aktif terdaftar.</p>
        </div>
    @else
        <form method="POST"
            action="{{ auth()->user()->hasRole('admin') ? route('admin.presensi.store') : route('warga.presensi.store') }}">
            @csrf

            <input type="hidden" name="jadwal_latihan_id" value="{{ $jadwal->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">

            <div class="space-y-3 mb-6">
                @foreach($siswa as $s)
                    @php
                        $statusSaatIni = $presensiHariIni->get($s->id)?->status ?? 'hadir';
                    @endphp
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $s->name }}</p>
                                <span class="text-xs text-gray-500 capitalize">
                                    Sabuk {{ str_replace('_', ' ', $s->siswaProfile?->tingkat_sabuk ?? '-') }}
                                </span>
                            </div>
                        </div>

                        {{-- Radio Button Status --}}
                        <div class="grid grid-cols-4 gap-2">
                            @foreach(['hadir' => ['bg-green-500', '✅'], 'izin' => ['bg-blue-500', '📋'], 'sakit' => ['bg-yellow-500', '🤒'], 'alpa' => ['bg-red-500', '❌']] as $status => [$color, $icon])
                                <label class="cursor-pointer">
                                    <input type="radio"
                                        name="presensi[{{ $s->id }}]"
                                        value="{{ $status }}"
                                        class="sr-only peer"
                                        {{ $statusSaatIni === $status ? 'checked' : '' }}>
                                    <div class="text-center py-2 px-1 rounded-lg border-2 border-gray-200
                                        peer-checked:border-{{ explode('-', $color)[1] }}-500
                                        peer-checked:{{ $color }} peer-checked:text-white
                                        text-xs font-medium text-gray-500 transition">
                                        <span class="block text-base">{{ $icon }}</span>
                                        {{ ucfirst($status) }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-xl shadow transition text-lg">
                💾 Simpan Presensi
            </button>
        </form>
    @endif
@endif
@endsection