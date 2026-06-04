<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Portal Rayon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-950 flex flex-col items-center justify-center px-4">

    {{-- Logo & Title --}}
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">🥋</div>
        <h1 class="text-2xl font-bold text-white tracking-wide">Portal Rayon</h1>
        <p class="text-gray-500 text-sm mt-1">Sistem Informasi Manajemen Internal</p>
    </div>

    {{-- Card Login --}}
    <div class="w-full max-w-sm bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-2xl">

        {{-- Session Error --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 text-red-400 rounded-xl text-sm">
                ❌ {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Email</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    required autofocus autocomplete="username"
                    placeholder="email@rayon.test"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition
                    placeholder:text-gray-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Password</label>
                <input type="password" name="password"
                    required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 text-sm
                    focus:outline-none focus:border-gold-500 focus:ring-1 focus:ring-gold-500 transition
                    placeholder:text-gray-600">
            </div>

            {{-- Remember me --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember"
                    class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-gold-500 focus:ring-gold-500">
                <label for="remember" class="text-sm text-gray-500">Ingat saya</label>
            </div>

            <button type="submit"
                class="w-full bg-gold-500 hover:bg-gold-600 text-gray-900 font-bold py-3.5 rounded-xl shadow-lg transition text-base mt-2">
                Masuk →
            </button>
        </form>
    </div>

    <p class="text-gray-700 text-xs mt-6">© {{ date('Y') }} Portal Rayon · Internal Only</p>

</body>
</html>