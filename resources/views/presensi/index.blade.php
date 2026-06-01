@extends('layouts.main')
@section('title', 'Presensi Hari Ini')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-bold text-white">📝 Presensi Hari Ini</h1>
    <p class="text-sm text-gray-400 mt-0.5">
        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
    </p>
</div>

@if(!$jadwal)
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-center">
        <p class="text-4xl mb-3">😴</p>
        <p class="text-gray-300 font-medium">Tidak ada jadwal latihan hari ini</p>
        <p class="text-sm text-gray-500 mt-1">Jadwal rutin: Senin · Rabu · Jumat</p>
        <p class="text-sm text-gray-500">Pukul 19.22 WIB</p>
    </div>
@else
    {{-- Info jadwal --}}
    <div class="bg-gold-500/10 border border-gold-600/30 rounded-2xl px-4 py-3 mb-5 flex justify-between items-center">
        <div>
            <p class="text-sm font-semibold text-gold-400">{{ $jadwal->nama_sesi }}</p>
            <p class="text-xs text-gray-400">
                Pukul {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} WIB
            </p>
        </div>
        <span class="text-xs bg-gold-500/20 text-gold-400 px-3 py-1 rounded-full border border-gold-600/40">
            {{ $siswa->count() }} Siswa
        </span>
    </div>

    @if($siswa->isEmpty())
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-center">
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
                    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="font-medium text-white">{{ $s->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">
                                    🥋 Sabuk {{ str_replace('_', ' ', $s->siswaProfile?->tingkat_sabuk ?? '-') }}
                                </p>
                            </div>
                            {{-- Status badge realtime --}}
                            <span class="text-xs px-2 py-1 rounded-full capitalize font-medium
                                {{ $statusSaatIni === 'hadir' ? 'bg-green-500/20 text-green-400' : '' }}
                                {{ $statusSaatIni === 'izin'  ? 'bg-blue-500/20 text-blue-400'  : '' }}
                                {{ $statusSaatIni === 'sakit' ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                {{ $statusSaatIni === 'alpa'  ? 'bg-red-500/20 text-red-400'   : '' }}">
                                {{ $statusSaatIni }}
                            </span>
                        </div>

                        {{-- Radio buttons --}}
                        <div class="grid grid-cols-4 gap-2">
                            @foreach([
                                'hadir' => ['border-green-500', 'bg-green-500/20', 'text-green-400', '✅'],
                                'izin'  => ['border-blue-500',  'bg-blue-500/20',  'text-blue-400',  '📋'],
                                'sakit' => ['border-yellow-500','bg-yellow-500/20','text-yellow-400','🤒'],
                                'alpa'  => ['border-red-500',   'bg-red-500/20',   'text-red-400',   '❌'],
                            ] as $status => [$border, $bg, $text, $icon])
                                <label class="cursor-pointer">
                                    <input type="radio"
                                        name="presensi[{{ $s->id }}]"
                                        value="{{ $status }}"
                                        class="sr-only peer"
                                        {{ $statusSaatIni === $status ? 'checked' : '' }}>
                                    <div class="text-center py-2 rounded-xl border border-gray-700
                                        peer-checked:{{ $border }} peer-checked:{{ $bg }}
                                        text-xs text-gray-500 peer-checked:{{ $text }}
                                        peer-checked:font-semibold transition-all">
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
                class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition text-base">
                💾 Simpan Presensi
            </button>
        </form>
    @endif
@endif
@endsection