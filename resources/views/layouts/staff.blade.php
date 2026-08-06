<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Staff Attendance Portal - {{ config('app.name', 'Kanca Coffee') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 dark:bg-zinc-950 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-between">

    <!-- Top Staff Navbar -->
    <header class="bg-zinc-900 text-white py-4 px-6 shadow-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-kanca-orange to-kanca-teal flex items-center justify-center font-bold text-white text-lg">
                    K
                </div>
                <div>
                    <h1 class="font-extrabold text-base tracking-tight">KANCA <span class="text-kanca-teal">STAFF PORTAL</span></h1>
                    <p class="text-[10px] text-gray-400">Shift & Attendance Station</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 text-sm text-gray-300 hover:text-white">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white transition-colors">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <span>✅ {{ session('success') }}</span>
                <button @click="$el.parentElement.remove()" class="text-xs">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <span>⚠️ {{ session('error') }}</span>
                <button @click="$el.parentElement.remove()" class="text-xs">✕</button>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 py-4 text-center text-xs text-gray-500">
        <p>&copy; {{ date('Y') }} Kanca Coffee Barista & Shift System</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
