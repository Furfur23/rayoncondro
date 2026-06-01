@extends('layouts.main')
@section('title', 'Buat Tagihan')

@section('content')
<div class="mb-5">
    <a href="{{ route('admin.kas.index') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
    <h1 class="text-xl font-bold text-white mt-1">📋 Buat Tagihan Kas</h1>
    <p class="text-xs text-gray-500 mt-0.5">Otomatis dibuat untuk semua siswa aktif</p>
</div>

<form method="POST" action="{{ route('admin.kas.store') }}" class="space-y-4">
    @csrf

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Judul Tagihan</label>
            <input type="text" name="judul"
                value="{{ old('judul', 'Kas ' . \Carbon\Carbon::now()->translatedFormat('F Y')) }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
            @error('judul')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nominal (Rp)</label>
            <input type="number" name="nominal"
                value="{{ old('nominal', 10000) }}"
                min="1000" step="1000"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition">
            @error('nominal')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Bulan</label>
                <select name="bulan"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
                    @foreach(range(1,12) as $b)
                        <option value="{{ $b }}" {{ old('bulan', now()->month) == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Tahun</label>
                <select name="tahun"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
                    @foreach(range(now()->year - 1, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ old('tahun', now()->year) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Jatuh Tempo <span class="text-gray-600">(opsional)</span>
            </label>
            <input type="date" name="jatuh_tempo"
                value="{{ old('jatuh_tempo') }}"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1.5">
                Keterangan <span class="text-gray-600">(opsional)</span>
            </label>
            <textarea name="keterangan" rows="2"
                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-gold-500 transition"
                placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
        </div>
    </div>

    <button type="submit"
        class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-4 rounded-2xl shadow-lg transition">
        💾 Buat Tagihan
    </button>
</form>
@endsection