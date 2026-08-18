<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth >= 1024, darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="window.addEventListener('resize', () => { if (window.innerWidth < 1024) sidebarOpen = false })" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ __('Portal Admin') }} - {{ config('app.name', 'Kanca Coffee') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 dark:bg-zinc-950 text-gray-800 dark:text-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">

        <!-- Admin Sidebar -->
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" aria-hidden="true"></div>
        <aside :class="sidebarOpen ? 'translate-x-0 lg:w-64' : '-translate-x-full lg:translate-x-0 lg:w-20'" class="fixed inset-y-0 left-0 w-64 bg-zinc-900 text-white transition-all duration-300 flex flex-col z-40 shadow-xl lg:static lg:h-screen lg:sticky lg:top-0">
            <!-- Brand Header -->
            <div :class="sidebarOpen ? 'flex-row px-5' : 'flex-col gap-1 px-2 py-2'" class="h-20 flex items-center justify-between border-b border-zinc-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden shrink-0">
                    <x-logo class="w-10 h-10" rounded="rounded-xl" />
                    <span x-show="sidebarOpen" class="font-extrabold text-lg tracking-tight whitespace-nowrap">KANCA <span class="text-kanca-orange">ADMIN</span></span>
                </a>
                    <button @click="sidebarOpen = window.innerWidth < 1024 ? false : !sidebarOpen" class="text-gray-400 hover:text-white p-2 rounded-lg hover:bg-zinc-800 shrink-0" :aria-label="sidebarOpen ? 'Close menu' : 'Open menu'">
                        <i data-lucide="chevron-left" x-show="sidebarOpen" class="w-4 h-4"></i>
                        <i data-lucide="chevron-right" x-show="!sidebarOpen" class="w-4 h-4"></i>
                    </button>
            </div>

            <!-- Sidebar Navigation Items -->
            <nav @click="if (window.innerWidth < 1024 && $event.target.closest('a')) sidebarOpen = false" class="flex-grow py-6 px-3 space-y-1.5 overflow-y-auto">
<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Dashboard') }}</span>
                </a>

                <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.menus.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="coffee" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Katalog Menu') }}</span>
                </a>

                <div class="pt-4 pb-1 px-4 text-[10px] uppercase tracking-widest text-zinc-500 font-bold" x-show="sidebarOpen">Modul Keuangan & Modul Cafe</div>
                <a href="{{ route('admin.finance.income.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.finance.income.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="trending-up" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard Income</span>
                </a>
                <a href="{{ route('admin.finance.expense.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.finance.expense.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="trending-down" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard Expense</span>
                </a>
                <a href="{{ route('admin.income.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.income.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="wallet" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Database Income (6-Ch)</span>
                </a>
                <a href="{{ route('admin.expenses.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.expenses.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="receipt" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Entry & Summary Expense</span>
                </a>
                <a href="{{ route('admin.finance.journal.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.finance.journal.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="book-open" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Jurnal & Cashflow</span>
                </a>
                <a href="{{ route('admin.master-finance.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.master-finance.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="settings-2" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Master Akun Keuangan</span>
                </a>

                <div class="pt-4 pb-1 px-4 text-[10px] uppercase tracking-widest text-zinc-500 font-bold" x-show="sidebarOpen">Manajemen Inventori & Laporan</div>
                <a href="{{ route('admin.ingredients.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.ingredients.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Bahan Baku</span>
                </a>
                <a href="{{ route('admin.mixed.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.mixed.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="blend" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Mixed Ingredients</span>
                </a>
                <a href="{{ route('admin.inventory.logs') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.inventory.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="clipboard-list" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Inventory Harian</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="file-bar-chart" class="w-5 h-5 flex-shrink-0"></i><span x-show="sidebarOpen" class="whitespace-nowrap">Pelaporan & Export</span>
                </a>

                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.events.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="calendar" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Event & Kuota') }}</span>
                </a>

                <a href="{{ route('admin.attendances.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.attendances.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="clock" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Absensi & PDF') }}</span>
                </a>

                <a href="{{ route('admin.staff.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="user-check" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Karyawan / Staff') }}</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Akun Pengguna') }}</span>
                </a>

                <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.feedbacks.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="message-square" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Umpan Balik & Kotak Masuk') }}</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-amber text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Pengaturan & Galeri') }}</span>
                </a>

                <div class="pt-6 mt-6 border-t border-zinc-800">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold text-kanca-amber hover:bg-zinc-800 transition-all">
                        <i data-lucide="external-link" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap">{{ __('Lihat Toko Langsung') }}</span>
                    </a>
                </div>
            </nav>

            <!-- User Footer Profile -->
            <div class="p-4 border-t border-zinc-800 flex items-center gap-3">
                <img src="{{ asset('images/kanca-logo.jpg') }}" class="w-10 h-10 rounded-full object-cover border-2 border-kanca-orange" />
                <div x-show="sidebarOpen" class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
<p class="text-[10px] text-kanca-orange font-semibold uppercase">{{ __('Administrator') }}</p>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="min-h-20 bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center gap-4 sticky top-0 z-20">
                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300" aria-label="Open menu">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white truncate">{{ __('Pusat Kontrol Admin') }}</h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300" aria-label="Toggle theme">
                        <i data-lucide="moon" x-show="!darkMode" class="w-5 h-5"></i>
                        <i data-lucide="sun" x-show="darkMode" class="w-5 h-5"></i>
                    </button>

                    <!-- Quick Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 sm:px-4 py-2 text-xs font-bold rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-100 transition-colors">
                            {{ __('Keluar') }}
                        </button>
                    </form>
                </div>
            </header>

            <!-- Notification Alerts -->
            @if(session('success'))
<div class="mx-4 sm:mx-6 lg:mx-8 mt-4 sm:mt-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-kanca-amber text-sm font-semibold flex items-center justify-between gap-3">
                    <span class="inline-flex items-center gap-2"><i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-xs"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4 sm:mt-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between gap-3">
                    <span class="inline-flex items-center gap-2"><i data-lucide="alert-triangle" class="w-5 h-5"></i> {{ session('error') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-xs"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            <!-- Main Page Content -->
            <main class="admin-content p-4 sm:p-6 lg:p-8 flex-grow min-w-0">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
    <style>
        .admin-content > * { min-width: 0; }
        .admin-content input,
        .admin-content select,
        .admin-content textarea { max-width: 100%; }
        .admin-content table { min-width: 640px; }
        @media (max-width: 639px) {
            .admin-content { padding: 1rem; }
            .admin-content .rounded-3xl { border-radius: 1rem; }
            .admin-content .p-8,
            .admin-content .p-6 { padding: 1rem; }
            .admin-content .space-y-8 > :not([hidden]) ~ :not([hidden]) { margin-top: 1.25rem; }
            .admin-content .space-y-6 > :not([hidden]) ~ :not([hidden]) { margin-top: 1rem; }
            .admin-content h1 { font-size: 1.5rem; line-height: 2rem; }
            .admin-content h2 { font-size: 1.25rem; line-height: 1.75rem; }
            .admin-content .flex.gap-3 { flex-wrap: wrap; }
            .admin-content .flex.gap-3 > button,
            .admin-content .flex.gap-3 > a { flex: 1 1 0%; text-align: center; }
        }
    </style>
</body>
</html>
