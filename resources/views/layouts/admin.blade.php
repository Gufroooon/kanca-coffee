<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: true, darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Portal - {{ config('app.name', 'Kanca Coffee') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 dark:bg-zinc-950 text-gray-800 dark:text-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">

        <!-- Admin Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-zinc-900 text-white transition-all duration-300 flex flex-col z-30 shadow-xl sticky top-0 h-screen">
            <!-- Brand Header -->
            <div class="h-20 flex items-center justify-between px-5 border-b border-zinc-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-kanca-orange to-kanca-teal flex-shrink-0 flex items-center justify-center font-bold text-white text-lg">
                        K
                    </div>
                    <span x-show="sidebarOpen" class="font-extrabold text-lg tracking-tight whitespace-nowrap">KANCA <span class="text-kanca-orange">ADMIN</span></span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white p-1.5 rounded-lg hover:bg-zinc-800">
                    <span x-show="sidebarOpen">◀</span>
                    <span x-show="!sidebarOpen">▶</span>
                </button>
            </div>

            <!-- Sidebar Navigation Items -->
            <nav class="flex-grow py-6 px-3 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
                </a>

                <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.menus.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="coffee" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Menu Catalog</span>
                </a>

                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.events.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="calendar" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Events & Quota</span>
                </a>

                <a href="{{ route('admin.attendances.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.attendances.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="clock" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Attendance & PDF</span>
                </a>

                <a href="{{ route('admin.staff.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="user-check" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Employees / Staff</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">User Accounts</span>
                </a>

                <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.feedbacks.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="message-square" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Feedbacks & Inbox</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-kanca-orange to-kanca-teal text-white shadow-lg' : 'text-gray-400 hover:bg-zinc-800 hover:text-white' }}">
                    <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Settings & Gallery</span>
                </a>

                <div class="pt-6 mt-6 border-t border-zinc-800">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-semibold text-kanca-teal hover:bg-zinc-800 transition-all">
                        <i data-lucide="external-link" class="w-5 h-5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen" class="whitespace-nowrap">View Live Store</span>
                    </a>
                </div>
            </nav>

            <!-- User Footer Profile -->
            <div class="p-4 border-t border-zinc-800 flex items-center gap-3">
                <img src="{{ auth()->user()->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80' }}" class="w-10 h-10 rounded-full object-cover border-2 border-kanca-orange" />
                <div x-show="sidebarOpen" class="overflow-hidden">
                    <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-kanca-orange font-semibold uppercase">Administrator</p>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="h-20 bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 px-8 flex justify-between items-center sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Admin Control Center</h1>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300">
                        <span x-show="!darkMode">🌙</span>
                        <span x-show="darkMode">☀️</span>
                    </button>

                    <!-- Quick Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-100 transition-colors">
                            Sign Out
                        </button>
                    </form>
                </div>
            </header>

            <!-- Notification Alerts -->
            @if(session('success'))
                <div class="mx-8 mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between">
                    <span>✅ {{ session('success') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-xs">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-8 mt-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between">
                    <span>⚠️ {{ session('error') }}</span>
                    <button @click="$el.parentElement.remove()" class="text-xs">✕</button>
                </div>
            @endif

            <!-- Main Page Content -->
            <main class="p-8 flex-grow">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
