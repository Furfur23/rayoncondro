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
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('warga'))
                <a href="{{ dashboard_route() }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs
                    {{ request()->routeIs('*.dashboard') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">🏠</span>
                    Dashboard
                </a>
                <a href="{{ auth()->user()->hasRole('admin') ? route('admin.presensi.index') : route('warga.presensi.index') }}" 
                    class="flex-1 flex flex-col items-center py-3 text-xs
                    {{ request()->routeIs('*.presensi*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">📝</span>
                    Presensi
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs
                    {{ request()->routeIs('*.kas*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">💰</span>
                    Kas
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs
                    {{ request()->routeIs('*.anggota*') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">👥</span>
                    Anggota
                </a>
            @else
                <a href="{{ dashboard_route() }}"
                    class="flex-1 flex flex-col items-center py-3 text-xs
                    {{ request()->routeIs('*.dashboard') ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                    <span class="text-xl">🏠</span>
                    Dashboard
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs text-gray-500">
                    <span class="text-xl">📋</span>
                    Presensi
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs text-gray-500">
                    <span class="text-xl">💰</span>
                    Kas Saya
                </a>
                <a href="#"
                    class="flex-1 flex flex-col items-center py-3 text-xs text-gray-500">
                    <span class="text-xl">👤</span>
                    Profil
                </a>
            @endif
        </div>
    </nav>

    {{-- Spacer biar konten tidak ketutup bottom nav --}}
    <div class="h-20"></div>

</body>
</html>