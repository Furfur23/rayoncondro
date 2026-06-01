<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-2xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-lg font-bold text-green-700">🥋 Portal Rayon</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm text-red-500 hover:text-red-700 font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="max-w-2xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Bottom Navigation --}}
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
        <div class="max-w-2xl mx-auto flex">

            @if(auth()->user()->hasRole('admin'))
            {{-- ── ADMIN ── --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('admin.dashboard') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">🏠</span>Dashboard
                </a>
                <a href="{{ route('admin.presensi.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('admin.presensi*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">📝</span>Presensi
                </a>
                <a href="{{ route('admin.kas.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('admin.kas*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">💰</span>Kas
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('admin.anggota*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">👥</span>Anggota
                </a>

            @elseif(auth()->user()->hasRole('warga'))
            {{-- ── WARGA ── --}}
                <a href="{{ route('warga.dashboard') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('warga.dashboard') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">🏠</span>Dashboard
                </a>
                <a href="{{ route('warga.presensi.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('warga.presensi*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">📝</span>Presensi
                </a>
                <a href="{{ route('warga.kas.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('warga.kas*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">💰</span>Kas
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs text-gray-500">
                    <span class="text-xl">👥</span>Anggota
                </a>

            @else
            {{-- ── SISWA ── --}}
                <a href="{{ route('siswa.dashboard') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('siswa.dashboard') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">🏠</span>Dashboard
                </a>
                <a href="{{ route('siswa.presensi.riwayat') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('siswa.presensi*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">📋</span>Presensi
                </a>
                <a href="{{ route('siswa.kas.index') }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs {{ request()->routeIs('siswa.kas*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">💰</span>Kas Saya
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs text-gray-500">
                    <span class="text-xl">👤</span>Profil
                </a>
            @endif

        </div>
    </nav>

    <div class="h-20"></div>

</body>
</html>