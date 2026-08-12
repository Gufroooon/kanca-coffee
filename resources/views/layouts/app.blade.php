<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kanca Coffee') }} - Teman yang kamu cari ada di seberang meja</title>
    <meta name="description" content="Kanca Coffee adalah coffee shop interaktif dan platform komunitas pertama di Indonesia. Temukan kopi, ikuti event, dan terhubung dengan komunitas.">
    
    <!-- Open Graph / SEO -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Kanca Coffee - Teman yang kamu cari ada di seberang meja">
    <meta property="og:description" content="Situs coffee shop yang juga merupakan platform komunitas tempat pengunjung menemukan menu, mengikuti event, dan terhubung dengan sesama.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=1200&q=80">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body x-data="globalCartApp()" class="bg-kanca-bg dark:bg-[#1a1a1a] text-kanca-dark dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col justify-between selection:bg-kanca-orange selection:text-white">

    <!-- Notification / Announcement Banner -->
    <div x-data="{ open: true }" x-show="open" class="bg-gradient-to-r from-kanca-orange to-kanca-amber text-white text-xs md:text-sm py-2 px-4 text-center font-medium shadow-sm relative flex justify-between items-center z-50">
        <div class="flex-1 flex justify-center items-center gap-2">
            <i data-lucide="coffee" class="w-4 h-4 inline-block"></i>
<span>{{ \App\Models\Setting::getByKey('announcement_banner', 'Selamat datang di Kanca Coffee! Teman yang kamu cari ada di seberang meja.') }}</span>
        </div>
        <button @click="open = false" class="text-white/80 hover:text-white p-1 rounded-full text-xs" title="Dismiss">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Main Navigation Bar -->
    <header x-data="{ mobileMenuOpen: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled ? 'bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md shadow-md py-3' : 'bg-transparent py-5'"
            class="sticky top-0 z-40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            
<!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <x-logo class="w-10 h-10" rounded="rounded-2xl" />
                <div class="flex flex-col">
                    <span class="font-extrabold text-xl tracking-tight text-kanca-dark dark:text-white">KANCA<span class="text-kanca-orange">.</span></span>
<span class="text-[10px] tracking-widest uppercase font-semibold text-kanca-amber">COFFEE</span>
                </div>
            </a>

            <!-- Language Switcher (Desktop) -->
            <div class="hidden lg:flex items-center mr-2">
                <x-language-switcher />
            </div>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
                <a href="{{ route('home') }}" class="hover:text-kanca-orange transition-colors {{ request()->routeIs('home') ? 'text-kanca-orange font-bold' : '' }}">{{ __('Home') }}</a>
                <a href="{{ route('about') }}" class="hover:text-kanca-orange transition-colors {{ request()->routeIs('about') ? 'text-kanca-orange font-bold' : '' }}">{{ __('About') }}</a>
                <a href="{{ route('community.index') }}" class="hover:text-kanca-orange transition-colors {{ request()->routeIs('community.*') ? 'text-kanca-orange font-bold' : '' }}">{{ __('Community') }}</a>
                <a href="{{ route('menu.index') }}" class="hover:text-kanca-orange transition-colors {{ request()->routeIs('menu.index') ? 'text-kanca-orange font-bold' : '' }}">{{ __('Menu') }}</a>
                <a href="{{ route('contact') }}" class="hover:text-kanca-orange transition-colors {{ request()->routeIs('contact') ? 'text-kanca-orange font-bold' : '' }}">{{ __('Contact') }}</a>
<a href="{{ route('menu.qr') }}" class="text-xs px-2.5 py-1 rounded-full bg-kanca-amber/10 text-kanca-amber font-semibold hover:bg-kanca-amber hover:text-white transition-colors inline-flex items-center gap-1.5"><i data-lucide="smartphone" class="w-3.5 h-3.5"></i> {{ __('Menu QR') }}</a>
            </nav>

            <!-- Action Buttons -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Dark Mode Toggle -->
<button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-zinc-800 transition-colors text-gray-700 dark:text-gray-200" title="Toggle theme">
                    <i data-lucide="moon" x-show="!darkMode" class="w-5 h-5"></i>
                    <i data-lucide="sun" x-show="darkMode" class="w-5 h-5"></i>
                </button>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-kanca-dark text-white hover:bg-black transition-all shadow-md">{{ __('Portal Admin') }}</a>
                    @elseif(auth()->user()->isStaff())
<a href="{{ route('staff.dashboard') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-kanca-amber text-white hover:bg-kanca-amberHover transition-all shadow-md">{{ __('Portal Staff') }}</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-xs font-bold rounded-xl border-2 border-kanca-orange text-kanca-orange hover:bg-kanca-orange hover:text-white transition-all shadow-md">{{ __('My Account') }}</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl border-2 border-rose-300 text-rose-500 hover:bg-rose-500 hover:border-rose-500 hover:text-white transition-all shadow-md">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-kanca-dark dark:text-gray-200 hover:text-kanca-orange transition-colors">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-kanca-orange text-white text-xs font-bold hover:bg-kanca-orangeHover transition-all shadow-lg shadow-kanca-orange/25 hover:shadow-xl hover:-translate-y-0.5">{{ __('Register') }}</a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-2 md:hidden">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 text-sm">
                    <i data-lucide="moon" x-show="!darkMode" class="w-5 h-5"></i>
                    <i data-lucide="sun" x-show="darkMode" class="w-5 h-5"></i>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg bg-gray-100 dark:bg-zinc-800 text-kanca-dark dark:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 px-6 py-6 space-y-4">
            <div class="flex items-center justify-between">
                <x-language-switcher />
            </div>
            <a href="{{ route('home') }}" class="block font-semibold hover:text-kanca-orange">{{ __('Home') }}</a>
            <a href="{{ route('about') }}" class="block font-semibold hover:text-kanca-orange">{{ __('About') }}</a>
            <a href="{{ route('community.index') }}" class="block font-semibold hover:text-kanca-orange">{{ __('Community') }}</a>
            <a href="{{ route('menu.index') }}" class="block font-semibold hover:text-kanca-orange">{{ __('Menu') }}</a>
            <a href="{{ route('contact') }}" class="block font-semibold hover:text-kanca-orange">{{ __('Contact') }}</a>
            <a href="{{ route('menu.qr') }}" class="block font-semibold text-kanca-amber inline-flex items-center gap-2"><i data-lucide="smartphone" class="w-4 h-4"></i> {{ __('Menu QR') }}</a>
            <div class="pt-4 border-t border-gray-200 dark:border-zinc-800 flex flex-col gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-kanca-orange text-white font-bold text-sm">{{ __('Dashboard') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center py-2.5 rounded-xl border-2 border-rose-300 text-rose-500 font-bold text-sm hover:bg-rose-500 hover:border-rose-500 hover:text-white transition-colors">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 font-semibold text-sm">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-kanca-orange text-white font-bold text-sm">{{ __('Register') }}</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Global Toast Alert Banner -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 bg-gradient-to-r from-kanca-orange to-kanca-amber text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-bounce">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-xs opacity-75 hover:opacity-100"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 bg-rose-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
            <button @click="show = false" class="ml-4 text-xs opacity-75 hover:opacity-100"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    <!-- Page Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Floating WhatsApp CTA Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20Kanca%20Coffee,%20saya%20ingin%20bertanya%20mengenai%20menu/event!"
       target="_blank"
       class="fixed bottom-6 left-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white p-3.5 rounded-full shadow-2xl hover:scale-110 transition-all flex items-center gap-2 group"
       title="Chat with Kanca Coffee on WhatsApp">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.147 4.192 4.267-1.118z"/></svg>
        <span class="hidden group-hover:inline text-xs font-bold pr-1">Chat Kanca</span>
    </a>

    <!-- Footer -->
    <footer class="bg-kanca-dark text-gray-300 pt-16 pb-12 mt-20 border-t border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-zinc-800">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
<x-logo class="w-10 h-10" rounded="rounded-2xl" />
                        <span class="font-extrabold text-2xl tracking-tight text-white">KANCA<span class="text-kanca-orange">.</span></span>
                    </div>
<p class="text-xs text-gray-400 leading-relaxed">
                        "Teman yang kamu cari ada di seberang meja." Coffee shop interaktif & lounge komunitas pertama di Indonesia.
                    </p>
                    <div class="flex items-center gap-2">
                        <x-language-switcher />
                    </div>
<div class="text-xs text-gray-400 inline-flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-kanca-amber"></i> Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                    <h4 class="text-white text-sm font-bold tracking-wider uppercase mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-kanca-orange transition-colors">Lounge Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-kanca-orange transition-colors">Kisah Kami</a></li>
                        <li><a href="{{ route('community.index') }}" class="hover:text-kanca-orange transition-colors">Komunitas & Event</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-kanca-orange transition-colors">Katalog Menu</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-kanca-orange transition-colors">Kontak & Umpan Balik</a></li>
                    </ul>
                </div>

                <!-- Operating Hours -->
                <div>
                    <h4 class="text-white text-sm font-bold tracking-wider uppercase mb-4">Jam Operasional</h4>
                    <ul class="space-y-2 text-xs text-gray-400">
                        <li class="flex justify-between"><span>Senin - Jumat:</span> <span class="font-semibold text-gray-200">07:00 - 23:00 WIB</span></li>
                        <li class="flex justify-between"><span>Sabtu - Minggu:</span> <span class="font-semibold text-gray-200">07:00 - 24:00 WIB</span></li>
                        <li class="pt-2 text-[11px] text-kanca-amber font-medium inline-flex items-center gap-1.5"><i data-lucide="zap" class="w-3 h-3"></i> Buka untuk kerja jarak jauh & meetup komunitas.</li>
                    </ul>
                </div>

                <!-- Newsletter Subscription -->
                <div>
                    <h4 class="text-white text-sm font-bold tracking-wider uppercase mb-4">Berlangganan Newsletter</h4>
                    <p class="text-xs text-gray-400 mb-3">Dapatkan info bean drop eksklusif & prioritas tiket event.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                        @csrf
                        <input type="email" name="email" required placeholder="Masukkan email Anda" class="w-full px-4 py-2.5 text-xs rounded-xl bg-zinc-800 border border-zinc-700 text-white focus:outline-none focus:border-kanca-orange">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-kanca-orange text-white text-xs font-bold hover:bg-kanca-orangeHover transition-all">Berlangganan Sekarang</button>
                    </form>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
<p>&copy; {{ date('Y') }} Kanca Coffee Indonesia. Hak cipta dilindungi.</p>
                <div class="flex gap-6">
                    <a href="{{ route('menu.qr') }}" class="hover:text-white">Pindai Menu QR</a>
                    <a href="{{ route('contact') }}" class="hover:text-white">Privasi & Ketentuan</a>
                    <a href="{{ route('login') }}" class="hover:text-white">Masuk Staff</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Floating Cart Button -->
    <div class="fixed bottom-6 right-6 z-40" x-show="totalItems > 0" x-transition x-cloak>
        <button @click="cartOpen = true" class="bg-gradient-to-r from-kanca-orange to-kanca-amber hover:scale-105 transition-all text-white p-4 rounded-full shadow-2xl flex items-center justify-center relative group animate-bounce" title="{{ __('Lihat Keranjang') }}">
            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            <span class="absolute -top-2 -right-2 bg-rose-600 text-white text-xs font-black w-6 h-6 rounded-full flex items-center justify-center" x-text="totalItems">0</span>
        </button>
    </div>

    <!-- Cart Drawer Backdrop -->
    <div x-show="cartOpen" x-transition.opacity @click="cartOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50" x-cloak></div>

    <!-- Cart Drawer Panel -->
    <div x-show="cartOpen" 
         x-transition:enter="transition ease-out duration-300 transform" 
         x-transition:enter-start="translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in duration-200 transform" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="translate-x-full" 
         class="fixed right-0 top-0 bottom-0 w-full max-w-md bg-white dark:bg-zinc-950 shadow-2xl z-50 border-l border-gray-100 dark:border-zinc-800 flex flex-col justify-between overflow-hidden" 
         x-cloak>
        
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 dark:border-zinc-800 flex justify-between items-center bg-gray-50 dark:bg-zinc-900">
            <div class="flex items-center gap-2">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-kanca-orange"></i>
                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">{{ __('Keranjang Pesanan') }}</h3>
            </div>
            <button @click="cartOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-white p-1 rounded-full hover:bg-gray-100 dark:hover:bg-zinc-800 transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Body (Scrollable items) -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
            <!-- Empty state -->
            <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-center space-y-3 py-10">
                <div class="w-16 h-16 rounded-full bg-orange-50 dark:bg-zinc-900 flex items-center justify-center text-kanca-orange">
                    <i data-lucide="coffee" class="w-8 h-8"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{ __('Keranjang belanja kosong') }}</h4>
                    <p class="text-xs text-gray-400 mt-1">{{ __('Mulai tambahkan menu favorit kamu ke keranjang.') }}</p>
                </div>
            </div>

            <!-- Cart Items List -->
            <div x-show="cart.length > 0" class="space-y-4 divide-y divide-gray-100 dark:divide-zinc-800">
                <template x-for="(item, index) in cart" :key="item.menu_id">
                    <div class="flex gap-4 pt-4 first:pt-0 items-center">
                        <img :src="item.image" :alt="item.name" class="w-16 h-16 rounded-xl object-cover border border-gray-100 dark:border-zinc-850 shrink-0">
                        <div class="flex-1 min-w-0">
                            <span class="text-xs font-extrabold text-gray-900 dark:text-white block truncate" x-text="item.name"></span>
                            <span class="text-xs text-kanca-orange font-bold block mt-0.5" x-text="formatPrice(item.price)"></span>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-2 mt-2">
                                <button type="button" @click="updateQuantity(item.menu_id, -1)" class="w-6 h-6 rounded-full bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700 text-gray-850 dark:text-white transition-colors flex items-center justify-center font-bold text-xs">-</button>
                                <span class="text-xs font-bold w-6 text-center text-gray-900 dark:text-white" x-text="item.quantity">1</span>
                                <button type="button" @click="updateQuantity(item.menu_id, 1)" class="w-6 h-6 rounded-full bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700 text-gray-855 dark:text-white transition-colors flex items-center justify-center font-bold text-xs">+</button>
                            </div>
                        </div>
                        <button type="button" @click="removeFromCart(item.menu_id)" class="text-rose-500 hover:text-rose-700 p-2 rounded-full hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Footer Form & Details -->
        <div x-show="cart.length > 0" class="p-6 border-t border-gray-100 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-900/60 space-y-3">
            
            <!-- Quick Add Dropdown inside Cart -->
            <div class="space-y-1">
                <label class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Tambah Menu Lainnya') }}</label>
                <select @change="if ($event.target.value) { addToCart(menus.find(m => m.id == $event.target.value)); $event.target.value = ''; }" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:ring-1 focus:ring-kanca-orange focus:outline-none transition-all">
                    <option value="">+ {{ __('Pilih item tambahan...') }}</option>
                    <template x-for="menu in menus" :key="menu.id">
                        <option :value="menu.id" x-text="menu.name + ' — ' + formatPrice(menu.price)"></option>
                    </template>
                </select>
            </div>

            <!-- Table Number Dropdown -->
            <div class="space-y-1">
                <label for="cart_table_number" class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Nomor Meja') }}</label>
                <select id="cart_table_number" x-model="tableNumber" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:ring-1 focus:ring-kanca-orange focus:outline-none transition-all">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ __('Meja') }} {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- Customer Name -->
            <div class="space-y-1">
                <label for="cart_customer_name" class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Nama Kamu') }}</label>
                <input type="text" id="cart_customer_name" x-model="customerName" placeholder="{{ __('Nama pemesan...') }}" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:ring-1 focus:ring-kanca-orange focus:outline-none transition-all">
            </div>

            <!-- Customer Note -->
            <div class="space-y-1">
                <label for="cart_customer_note" class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Catatan Pesanan (Opsional)') }}</label>
                <input type="text" id="cart_customer_note" x-model="customerNote" placeholder="{{ __('mis. Less sugar, hot, extra shot...') }}" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:ring-1 focus:ring-kanca-orange focus:outline-none transition-all">
            </div>

            <!-- Total Price -->
            <div class="flex justify-between items-center py-2 border-t border-gray-200/50 dark:border-zinc-800">
                <span class="text-xs font-bold text-gray-500">{{ __('Total Pembayaran') }}</span>
                <span class="text-lg font-black text-kanca-orange" x-text="formatPrice(totalPrice)">Rp 0</span>
            </div>

            <!-- Submit Form -->
            <form action="{{ route('order.store') }}" method="POST" @submit="clearCart()">
                @csrf
                <input type="hidden" name="table_number" :value="tableNumber">
                <input type="hidden" name="customer_name" :value="customerName">
                <input type="hidden" name="customer_note" :value="customerNote">
                <template x-for="(item, index) in cart" :key="item.menu_id">
                    <div>
                        <input type="hidden" :name="'items['+index+'][menu_id]'" :value="item.menu_id">
                        <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.quantity">
                    </div>
                </template>
                <button type="submit" class="w-full py-3 rounded-2xl bg-gradient-brand text-white font-extrabold text-xs hover:opacity-95 transition-all shadow-xl shadow-kanca-orange/30 flex items-center justify-center gap-2">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    {{ __('KIRIM PESANAN KE DAPUR') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        function globalCartApp() {
            return {
                cart: [],
                cartOpen: false,
                tableNumber: 1,
                customerName: '',
                customerNote: '',
                menus: @json($globalMenus ?? []),
                
                init() {
                    // Load cart from localStorage
                    const savedCart = localStorage.getItem('kanca_cart');
                    if (savedCart) {
                        try {
                            this.cart = JSON.parse(savedCart);
                        } catch (e) {
                            console.error('Failed to parse cart', e);
                        }
                    }
                    
                    // Sync cart to localStorage
                    this.$watch('cart', (val) => {
                        localStorage.setItem('kanca_cart', JSON.stringify(val));
                    }, { deep: true });
                },
                
                addToCart(menu) {
                    let item = this.cart.find(i => i.menu_id === menu.id);
                    if (item) {
                        item.quantity++;
                    } else {
                        this.cart.push({
                            menu_id: menu.id,
                            name: menu.name,
                            price: menu.price,
                            image: menu.image || '',
                            quantity: 1
                        });
                    }
                    this.cartOpen = true;
                    
                    // Trigger Lucide icons refresh
                    this.$nextTick(() => {
                        if (window.lucide) {
                            window.lucide.createIcons();
                        }
                    });
                },
                
                removeFromCart(menuId) {
                    this.cart = this.cart.filter(i => i.menu_id !== menuId);
                },
                
                updateQuantity(menuId, amount) {
                    let item = this.cart.find(i => i.menu_id === menuId);
                    if (item) {
                        item.quantity += amount;
                        if (item.quantity <= 0) {
                            this.removeFromCart(menuId);
                        }
                    }
                },
                
                clearCart() {
                    this.cart = [];
                    localStorage.removeItem('kanca_cart');
                },
                
                get totalPrice() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },
                
                get totalItems() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },
                
                formatPrice(value) {
                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                }
            }
        }
    </script>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
