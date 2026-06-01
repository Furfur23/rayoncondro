@extends('layouts.main')
@section('title', 'Data Siswa')

@section('content')
<div class="flex justify-between items-center mb-5">
    <div>
        <a href="{{ route('admin.anggota.index') }}" class="text-sm text-gray-500 hover:text-gold-400 transition">← Kembali</a>
        <h1 class="text-xl font-bold text-white mt-1">🥋 Data Siswa</h1>
        <p class="text-sm text-gray-400">{{ $siswa->count() }} siswa terdaftar</p>
    </div>
    <a href="{{ route('admin.anggota.siswa.create') }}"
        class="bg-gold-500 hover:bg-gold-600 text-gray-900 text-sm px-4 py-2 rounded-xl font-bold transition">
        + Tambah
    </a>
</div>

{{-- Tab filter --}}
<div class="flex gap-2 mb-4">
    <button onclick="filterSiswa('aktif')" id="tab-aktif"
        class="px-4 py-2 rounded-xl text-sm font-bold bg-gold-500 text-gray-900 transition">
        Aktif ({{ $siswa->where('siswaProfile.status', 'aktif')->count() }})
    </button>
    <button onclick="filterSiswa('berhenti')" id="tab-berhenti"
        class="px-4 py-2 rounded-xl text-sm font-bold bg-gray-800 text-gray-400 transition">
        Berhenti ({{ $siswa->where('siswaProfile.status', 'berhenti')->count() }})
    </button>
</div>

{{-- List Aktif --}}
<div id="list-aktif" class="space-y-3">
    @foreach($siswa->where('siswaProfile.status', 'aktif') as $s)
        <a href="{{ route('admin.anggota.siswa.show', $s->id) }}"
            class="block bg-gray-900 border border-gray-800 hover:border-gold-600/50 rounded-2xl p-4 transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-white">{{ $s->name }}</p>
                    <p class="text-xs text-gray-500 capitalize mt-0.5">
                        🥋 Sabuk {{ str_replace('_', ' ', $s->siswaProfile?->tingkat_sabuk ?? '-') }}
                        @if($s->siswaProfile?->tanggal_naik_sabuk)
                            <span class="text-gray-600">
                                · {{ \Carbon\Carbon::parse($s->siswaProfile->tanggal_naik_sabuk)->diffForHumans(now(), true) }}
                            </span>
                        @endif
                    </p>
                </div>
                <span class="text-gold-600 text-lg">›</span>
            </div>
        </a>
    @endforeach
    @if($siswa->where('siswaProfile.status', 'aktif')->isEmpty())
        <div class="text-center py-10 text-gray-500">
            <p class="text-4xl mb-2">🥋</p>
            <p>Belum ada siswa aktif.</p>
        </div>
    @endif
</div>

{{-- List Berhenti --}}
<div id="list-berhenti" class="space-y-3 hidden">
    @foreach($siswa->where('siswaProfile.status', 'berhenti') as $s)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 opacity-50">
            <p class="font-medium text-white">{{ $s->name }}</p>
            <p class="text-xs text-gray-500 capitalize mt-0.5">
                🥋 Sabuk {{ str_replace('_', ' ', $s->siswaProfile?->tingkat_sabuk ?? '-') }}
            </p>
        </div>
    @endforeach
    @if($siswa->where('siswaProfile.status', 'berhenti')->isEmpty())
        <div class="text-center py-10 text-gray-500">
            <p>Tidak ada siswa berhenti.</p>
        </div>
    @endif
</div>

<script>
function filterSiswa(tab) {
    document.getElementById('list-aktif').classList.toggle('hidden', tab !== 'aktif');
    document.getElementById('list-berhenti').classList.toggle('hidden', tab !== 'berhenti');
    document.getElementById('tab-aktif').className = 'px-4 py-2 rounded-xl text-sm font-bold transition ' +
        (tab === 'aktif' ? 'bg-gold-500 text-gray-900' : 'bg-gray-800 text-gray-400');
    document.getElementById('tab-berhenti').className = 'px-4 py-2 rounded-xl text-sm font-bold transition ' +
        (tab === 'berhenti' ? 'bg-red-500 text-white' : 'bg-gray-800 text-gray-400');
}
</script>
@endsection