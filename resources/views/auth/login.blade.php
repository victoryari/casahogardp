<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión – La Divina Providencia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 font-inter flex items-center justify-center p-4">

<div class="w-full max-w-sm">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-teal-500/30">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <h1 class="text-white font-bold text-2xl">La Divina Providencia</h1>
        <p class="text-slate-400 text-sm mt-1">Sistema de Gestión Administrativa</p>
    </div>

    {{-- Card --}}
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-8 shadow-2xl">

        <h2 class="text-white font-semibold text-lg mb-6">Iniciar sesión</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="nombre_usuario" class="block text-slate-300 text-sm font-medium mb-1.5">Usuario</label>
                <input
                    id="nombre_usuario"
                    type="text"
                    name="nombre_usuario"
                    value="{{ old('nombre_usuario') }}"
                    required autofocus autocomplete="username"
                    placeholder="Ingresa tu usuario"
                    class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 text-sm
                           focus:outline-none focus:ring-2 focus:ring-teal-400 focus:border-transparent transition-all
                           @error('nombre_usuario') border-red-400 @enderror"
                >
                @error('nombre_usuario')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-slate-300 text-sm font-medium mb-1.5">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-400 text-sm
                           focus:outline-none focus:ring-2 focus:ring-teal-400 focus:border-transparent transition-all
                           @error('password') border-red-400 @enderror"
                >
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-white/30 bg-white/10 text-teal-500 focus:ring-teal-400">
                <label for="remember" class="text-slate-300 text-sm">Recordarme</label>
            </div>

            <button type="submit"
                class="w-full py-3 bg-teal-500 hover:bg-teal-400 text-white font-semibold rounded-xl
                       transition-all duration-200 text-sm mt-2 shadow-lg shadow-teal-500/25 active:scale-95">
                Ingresar al sistema
            </button>
        </form>
    </div>

    <p class="text-center text-slate-500 text-xs mt-6">© {{ date('Y') }} CasaHogar — Todos los derechos reservados</p>
</div>

</body>
</html>
