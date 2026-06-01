<!DOCTYPE html>
<html lang="id" class="h-full" x-data x-init="$store.theme.init()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-100 dark:bg-gray-950 font-sans transition-colors duration-200">

    {{-- Navbar --}}
    <nav class="bg-gray-900 dark:bg-black border-b border-gold-600 sticky top-0 z-50 shadow-lg">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-xl">🥋</span>
                <span class="font-bold text-gold-400 tracking-wide">Portal Rayon</span>
            </div>
            <div class="flex items-center gap-3">
                {{-- Dark mode toggle --}}
                <button @click="$store.theme.toggle()"
                    class="text-gray-400 hover:text-gold-400 transition text-lg">
                    <span x-show="!$store.theme.dark">🌙</span>
                    <span x-show="$store.theme.dark">☀️</span>
                </button>
                <span class="text-sm text-gray-300 hidden sm:block">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-xs text-red-400 hover:text-red-300 font-medium border border-red-800 px-2 py-1 rounded-lg transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="max-w-2xl mx-auto px-4 py-5 pb-24">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-900/50 border border-green-700 text-green-300 rounded-xl text-sm flex items-center gap-2">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-900/50 border border-red-700 text-red-300 rounded-xl text-sm flex items-center gap-2">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Bottom Navigation --}}
    <nav class="fixed bottom-0 left-0 right-0 bg-gray-900 dark:bg-black border-t border-gray-800 z-50">
        <div class="max-w-2xl mx-auto flex">

            @if(auth()->user()->hasRole('admin'))
            {{-- ── ADMIN ── --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('admin.dashboard') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">🏠</span>Dashboard
                </a>
                <a href="{{ route('admin.presensi.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('admin.presensi*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">📝</span>Presensi
                </a>
                <a href="{{ route('admin.kas.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('admin.kas*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">💰</span>Kas
                </a>
                <a href="{{ route('admin.anggota.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('admin.anggota*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">👥</span>Anggota
                </a>

            @elseif(auth()->user()->hasRole('warga'))
            {{-- ── WARGA ── --}}
                <a href="{{ route('warga.dashboard') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('warga.dashboard') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">🏠</span>Dashboard
                </a>
                <a href="{{ route('warga.presensi.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('warga.presensi*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">📝</span>Presensi
                </a>
                <a href="{{ route('warga.kas.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('warga.kas*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">💰</span>Kas
                </a>
                <a href="{{ route('generasi.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('generasi*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">🏛️</span>Galeri
                </a>

            @else
            {{-- ── SISWA ── --}}
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('siswa.dashboard') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">🏠</span>Dashboard
                </a>
                <a href="{{ route('siswa.presensi.riwayat') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('siswa.presensi*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">📋</span>Presensi
                </a>
                <a href="{{ route('siswa.kas.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('siswa.kas*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">💰</span>Kas Saya
                </a>
                <a href="{{ route('generasi.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs transition
                    {{ request()->routeIs('generasi*') ? 'text-gold-400 font-semibold' : 'text-gray-500 hover:text-gray-300' }}">
                    <span class="text-xl mb-0.5">🏛️</span>Galeri
                </a>
            @endif

        </div>
    </nav>

</body>
</html>