<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ __('Portal Kehadiran Staff') }} - {{ config('app.name', 'Kanca Coffee') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 dark:bg-zinc-950 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col justify-between">

    <!-- Top Staff Navbar -->
    <header class="bg-zinc-900 text-white py-4 px-6 shadow-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
<div class="flex items-center gap-3">
                <x-logo class="w-10 h-10" rounded="rounded-xl" />
                <div>
<h1 class="font-extrabold text-base tracking-tight">KANCA <span class="text-kanca-amber">{{ __('PORTAL STAFF') }}</span></h1>
                    <p class="text-[10px] text-gray-400">{{ __('Stasiun Shift & Absensi') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 text-sm text-gray-300 hover:text-white">
                    <i data-lucide="moon" x-show="!darkMode" class="w-5 h-5"></i>
                    <i data-lucide="sun" x-show="darkMode" class="w-5 h-5"></i>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
<button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-rose-600 hover:bg-rose-700 text-white transition-colors">
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full">
        @if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-kanca-amber text-sm font-semibold flex items-center justify-between shadow-sm">
                <span class="inline-flex items-center gap-2"><i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}</span>
                <button @click="$el.parentElement.remove()" class="text-xs"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        @endif

        @if(session('error'))
<div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <span class="inline-flex items-center gap-2"><i data-lucide="alert-triangle" class="w-5 h-5"></i> {{ session('error') }}</span>
                <button @click="$el.parentElement.remove()" class="text-xs"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 py-4 text-center text-xs text-gray-500">
<p>&copy; {{ date('Y') }} Kanca Coffee Barista & Sistem Shift</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
