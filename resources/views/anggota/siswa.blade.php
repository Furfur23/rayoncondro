@extends('layouts.main')
@section('title', 'Data Siswa')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div>
        <h1 class="text-xl font-bold text-gray-800">👥 Data Siswa</h1>
        <p class="text-sm text-gray-500">{{ $siswa->count() }} siswa terdaftar</p>
    </div>
    <a href="{{ route('admin.anggota.siswa.create') }}"
        class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg font-medium">
        + Tambah
    </a>
</div>

{{-- Filter status --}}
<div class="flex gap-2 mb-4">
    <button onclick="filterSiswa('aktif')" id="tab-aktif"
        class="px-3 py-1.5 rounded-lg text-sm font-medium bg-green-600 text-white">
        Aktif ({{ $siswa->where('siswaProfile.status', 'aktif')->count() }})
    </button>
    <button onclick="filterSiswa('berhenti')" id="tab-berhenti"
        class="px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-600">
        Berhenti ({{ $siswa->where('siswaProfile.status', 'berhenti')->count() }})
    </button>
</div>

{{-- List Aktif --}}
<div id="list-aktif" class="space-y-3">
    @foreach($siswa->where('siswaProfile.status', 'aktif') as $s)
        <a href="{{ route('admin.anggota.siswa.show', $s->id) }}"
            class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $s->name }}</p>
                    <p class="text-xs text-gray-500 capitalize mt-0.5">
                        🥋 Sabuk {{ str_replace('_', ' ', $s->siswaProfile?->tingkat_sabuk ?? '-') }}
                        @if($s->siswaProfile?->tanggal_naik_sabuk)
                            · {{ \Carbon\Carbon::parse($s->siswaProfile->tanggal_naik_sabuk)->diffForHumans(now(), true) }}
                        @endif
                    </p>
                </div>
                <span class="text-green-500 text-lg">›</span>
            </div>
        </a>
    @endforeach
    @if($siswa->where('siswaProfile.status', 'aktif')->isEmpty())
        <p class="text-center text-gray-400 py-6">Belum ada siswa aktif.</p>
    @endif
</div>

{{-- List Berhenti --}}
<div id="list-berhenti" class="space-y-3 hidden">
    @foreach($siswa->where('siswaProfile.status', 'berhenti') as $s)
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 opacity-60">
            <p class="font-medium text-gray-800">{{ $s->name }}</p>
            <p class="text-xs text-gray-500 capitalize">
                Sabuk {{ str_replace('_', ' ', $s->siswaProfile?->tingkat_sabuk ?? '-') }}
            </p>
        </div>
    @endforeach
    @if($siswa->where('siswaProfile.status', 'berhenti')->isEmpty())
        <p class="text-center text-gray-400 py-6">Tidak ada siswa berhenti.</p>
    @endif
</div>

<script>
function filterSiswa(tab) {
    document.getElementById('list-aktif').classList.toggle('hidden', tab !== 'aktif');
    document.getElementById('list-berhenti').classList.toggle('hidden', tab !== 'berhenti');
    document.getElementById('tab-aktif').className = 'px-3 py-1.5 rounded-lg text-sm font-medium ' +
        (tab === 'aktif' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600');
    document.getElementById('tab-berhenti').className = 'px-3 py-1.5 rounded-lg text-sm font-medium ' +
        (tab === 'berhenti' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600');
}
</script>
@endsection