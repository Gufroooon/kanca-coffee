<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Kanca Coffee') }} - Teman yang kamu cari ada di seberang meja</title>
        <meta name="description" content="Kanca Coffee adalah coffee shop interaktif dan platform komunitas pertama di Indonesia. Temukan kopi, ikuti event, dan terhubung dengan komunitas.">

        @fonts

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body { font-family: ui-sans-serif, system-ui, sans-serif; }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col items-center justify-center min-h-screen p-6">
        <header class="w-full max-w-4xl flex items-center justify-between mb-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/kanca-logo.jpg') }}" alt="Kanca Coffee" class="w-11 h-11 rounded-2xl object-cover shadow-lg" />
                <span class="font-extrabold text-2xl tracking-tight">KANCA<span class="text-kanca-orange">.</span></span>
            </a>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-2 rounded-xl bg-kanca-dark dark:bg-white text-white dark:text-black text-sm font-bold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-2 rounded-xl border border-gray-300 dark:border-zinc-700 text-sm font-semibold hover:border-kanca-orange">
                            Masuk
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-2 rounded-xl bg-kanca-orange text-white text-sm font-bold hover:bg-kanca-orangeHover">
                                Bergabung
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-1 w-full max-w-4xl flex flex-col items-center justify-center text-center space-y-6">
            <img src="{{ asset('images/kanca-logo.jpg') }}" alt="Kanca Coffee" class="w-28 h-28 rounded-3xl object-cover shadow-2xl shadow-kanca-orange/20" />

            <div class="space-y-3">
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                    Teman yang kamu cari ada di <span class="text-kanca-orange">seberang meja.</span>
                </h1>
                <p class="max-w-xl mx-auto text-gray-600 dark:text-gray-300 text-sm sm:text-base leading-relaxed">
                    Kanca Coffee adalah coffee shop interaktif dan platform komunitas pertama di Indonesia. Temukan kopi, ikuti event, dan terhubung dengan komunitas.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('menu.index') }}" class="px-7 py-3.5 rounded-2xl bg-kanca-orange text-white font-bold shadow-xl shadow-kanca-orange/20 hover:-translate-y-1 transition-all">
                    Jelajahi Menu
                </a>
                <a href="{{ route('community.index') }}" class="px-7 py-3.5 rounded-2xl bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 font-bold hover:-translate-y-1 transition-all">
                    Gabung Komunitas
                </a>
            </div>
        </main>

        <footer class="w-full max-w-4xl mt-8 pt-6 border-t border-gray-200 dark:border-zinc-800 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Kanca Coffee Indonesia. Hak cipta dilindungi.
        </footer>
    </body>
</html>
