<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Estudiantil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-200 text-gray-900 font-sans min-h-screen">
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-200 shadow-sm">
        <div class="max-w-[1140px] mx-auto px-6 h-16 flex items-center gap-6">
            <a href="{{ route('portal.home') }}" class="flex items-center shrink-0">
                <img src="{{ asset('images/banner.png') }}" class="h-8 w-auto object-contain" alt="Logo">
            </a>

            <div class="hidden md:block w-px h-6 bg-gray-300"></div>

            <nav class="hidden md:flex items-center gap-1 flex-1">
                <a href="{{ route('portal.home') }}"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('portal.home') ? 'bg-amalfi text-white shadow-sm' : 'text-gray-600 hover:text-amalfi hover:bg-blue-50' }}">
                    Inicio
                </a>

                <a href="{{ route('portal.progress') }}"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('portal.progress') ? 'bg-amalfi text-white shadow-sm' : 'text-gray-600 hover:text-amalfi hover:bg-blue-50' }}">
                    Progreso
                </a>

                <a href="{{ route('portal.practices') }}"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('portal.practices') ? 'bg-amalfi text-white shadow-sm' : 'text-gray-600 hover:text-amalfi hover:bg-blue-50' }}">
                    Prácticas
                </a>

                <a href="{{ route('portal.placement') }}"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 {{ request()->routeIs(['portal.placement*', 'portal.study-plan', 'portal.challenges*']) ? 'bg-amalfi text-white shadow-sm' : 'text-gray-600 hover:text-amalfi hover:bg-blue-50' }}">
                    <span>🤖</span> Inglés con IA
                </a>
            </nav>

            <div class="ml-auto flex items-center gap-3">
                <div class="flex flex-col items-end">
                    <span class="text-sm font-semibold text-gray-700 hidden sm:inline">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="text-xs font-normal text-gray-500 hidden sm:inline">
                        {{ $student->school->name ?? 'Tu carrera' }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-8 py-2 rounded-lg border border-gray-300 text-xs font-bold text-gray-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-[1140px] mx-auto px-6 py-6">
        <div class="h-1 w-full bg-gradient-to-r from-citrus via-breeze to-amalfi rounded-full mb-4"></div>
        @yield('content')
    </main>
</body>

</html>
