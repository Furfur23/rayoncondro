@extends('layouts.main')
@section('title', 'Buat Tagihan Kas')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kas.index') }}" class="text-sm text-gray-500">← Kembali</a>
    <h1 class="text-xl font-bold text-gray-800 mt-1">📋 Buat Tagihan Kas</h1>
    <p class="text-sm text-gray-500">Tagihan akan otomatis dibuat untuk semua siswa aktif</p>
</div>

<form method="POST" action="{{ route('admin.kas.store') }}" class="space-y-4">
    @csrf

    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Tagihan</label>
            <input type="text" name="judul"
                value="{{ old('judul', 'Kas ' . \Carbon\Carbon::now()->translatedFormat('F Y')) }}"
                placeholder="contoh: Kas Juni 2026"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('judul')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
            <input type="number" name="nominal"
                value="{{ old('nominal', 10000) }}"
                min="1000" step="1000"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            @error('nominal')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="bulan"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ old('bulan', now()->month) == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach(range(now()->year, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ old('tahun', now()->year) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jatuh Tempo <span class="text-gray-400">(opsional)</span>
            </label>
            <input type="date" name="jatuh_tempo"
                value="{{ old('jatuh_tempo') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Keterangan <span class="text-gray-400">(opsional)</span>
            </label>
            <textarea name="keterangan" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-xl shadow transition">
        💾 Buat Tagihan
    </button>
</form>
@endsection