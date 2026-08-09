<x-app-layout>
    <section class="relative overflow-hidden py-20 lg:py-28 bg-gradient-to-b from-kanca-bg via-orange-50/50 to-kanca-bg dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[44rem] h-[44rem] rounded-full bg-gradient-to-tr from-kanca-orange/20 to-kanca-teal/20 blur-3xl"></div>
        <div class="absolute top-16 left-6 px-3 py-1 rounded-full bg-white/70 dark:bg-zinc-800/70 text-xs font-semibold animate-float-slow">Coffee</div>
        <div class="absolute top-24 right-10 px-3 py-1 rounded-full bg-white/70 dark:bg-zinc-800/70 text-xs font-semibold animate-float-reverse">Community</div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 text-center lg:text-left space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kanca-orange/10 border border-kanca-orange/20 text-kanca-orange text-xs font-bold uppercase tracking-[0.2em]">
                    <span class="w-2 h-2 rounded-full bg-kanca-orange animate-pulse"></span>
                    {{ __('Coffee shop interaktif dan platform komunitas pertama') }}
                </div>

                <div class="space-y-5">
                    <h1 class="text-4xl sm:text-6xl xl:text-7xl font-extrabold leading-[1.05] text-kanca-dark dark:text-white">
                        {{ __('Teman yang kamu cari ada di') }} <span class="text-gradient-primary">{{ __('seberang meja') }}.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto lg:mx-0 text-base sm:text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ __('Lebih dari sekadar coffee shop, Kanca Coffee adalah tempat untuk menemukan menu, ikut event, bertemu orang baru, dan membangun komunitas nyata di sekitar kopi specialty.') }}
                    </p>
                </div>

                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="{{ route('menu.index') }}" class="px-7 py-4 rounded-2xl bg-kanca-orange text-white font-bold shadow-xl shadow-kanca-orange/20 hover:-translate-y-1 transition-all">
                        {{ __('Jelajahi Menu') }}
                    </a>
                    <a href="{{ route('community.index') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-zinc-800 text-kanca-dark dark:text-white font-bold border border-gray-200 dark:border-zinc-700 hover:-translate-y-1 transition-all">
                        {{ __('Gabung Komunitas') }}
                    </a>
                    <a href="{{ route('contact') }}" class="px-7 py-4 rounded-2xl bg-kanca-orange text-white font-bold shadow-xl shadow-kanca-orange/20 hover:-translate-y-1 transition-all">
                        {{ __('Pesan Ruang Event') }}
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-6 max-w-xl mx-auto lg:mx-0 pt-4 border-t border-gray-200/80 dark:border-zinc-800">
                    <div>
                        <span class="block text-2xl sm:text-3xl font-extrabold">{{ $stats['menus'] }}</span>
                        <span class="text-[11px] text-gray-500 uppercase tracking-wide">{{ __('Menu Tersedia') }}</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-extrabold text-kanca-orange">{{ $stats['events'] }}</span>
                        <span class="text-[11px] text-gray-500 uppercase tracking-wide">{{ __('Event Mendatang') }}</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-extrabold text-kanca-teal">{{ $stats['testimonials'] }}</span>
                        <span class="text-[11px] text-gray-500 uppercase tracking-wide">{{ __('Ulasan Unggulan') }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="absolute inset-0 bg-gradient-to-tr from-kanca-orange to-kanca-teal rounded-3xl rotate-3 scale-105 opacity-30 blur-lg"></div>
                    <div class="glass-card dark:glass-dark rounded-3xl p-4 shadow-2xl relative border border-white/60">
                        <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=1200&q=80" alt="Kanca Coffee signature drink" class="rounded-2xl w-full h-80 object-cover">
                        <div class="absolute -bottom-6 -left-6 bg-white dark:bg-zinc-800 p-4 rounded-2xl shadow-xl border border-gray-100 dark:border-zinc-700 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-kanca-orange/10 flex items-center justify-center text-kanca-orange font-bold">Cup</div>
                            <div>
                                <h4 class="font-bold text-sm text-kanca-dark dark:text-white">{{ __('Sorotan Hari Ini') }}</h4>
                                <p class="text-xs text-kanca-teal font-semibold">{{ __('Minuman signature hari ini') }}</p>
                            </div>
                        </div>
                        <div class="absolute -top-5 -right-5 bg-kanca-dark text-white px-4 py-2 rounded-2xl shadow-xl text-xs font-bold">
                            {{ __('Menu QR Meja Cepat') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white dark:bg-zinc-900 border-y border-gray-100 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1200&q=80" alt="Kanca Coffee lounge" class="rounded-3xl shadow-2xl w-full h-[28rem] object-cover">
                <div class="absolute -bottom-6 -right-6 bg-kanca-teal text-white p-6 rounded-3xl shadow-xl max-w-xs">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] opacity-80">{{ __('Filosofi Kami') }}</p>
                    <p class="font-extrabold mt-1">{{ __('Kopi menghubungkan percakapan di setiap meja.') }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-[0.2em]">{{ __('Kenapa Kanca Coffee') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">{{ __('Dirancang untuk koneksi, kualitas, dan komunitas.') }}</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ __('Kami menggabungkan biji kopi specialty, ruang yang nyaman untuk bekerja, event yang terkurasi, dan keramahan hangat dalam satu pengalaman kopi premium.') }}
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-kanca-bg dark:bg-zinc-800 border border-orange-100 dark:border-zinc-700">
                        <h4 class="font-bold text-kanca-orange text-sm mb-1">{{ __('Kopi Langsung dari Petani') }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Kopi specialty segar dan dapat ditelusuri asalnya dari petani lokal.') }}</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-kanca-bg dark:bg-zinc-800 border border-teal-100 dark:border-zinc-700">
                        <h4 class="font-bold text-kanca-teal text-sm mb-1">{{ __('Tempat Work from Anywhere') }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Kursi nyaman, Wi-Fi kuat, dan banyak akses listrik.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-[0.2em]">{{ __('Menu Pilihan') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">{{ __('Minuman dan Makanan Terlaris Hari Ini') }}</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($bestsellers as $menu)
                    <div class="glass-card dark:glass-dark rounded-3xl p-5 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-white/80 dark:border-zinc-800 relative">
                        <div class="absolute top-8 left-8 flex gap-2 z-10">
                            <span class="px-3 py-1 rounded-full bg-kanca-orange text-white text-[10px] font-extrabold uppercase">{{ __('Best Seller') }}</span>
                            @if($menu->is_new)
                                <span class="px-3 py-1 rounded-full bg-kanca-teal text-white text-[10px] font-extrabold uppercase">{{ __('New') }}</span>
                            @endif
                        </div>
                        <div class="overflow-hidden rounded-2xl mb-4 h-52 bg-gray-100">
                            <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-start">
                                <span class="text-[11px] font-bold text-kanca-teal uppercase tracking-wider">{{ $menu->category->name }}</span>
                                <span class="text-xs font-bold text-amber-500">Star {{ number_format($menu->rating, 2) }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-kanca-dark dark:text-white">{{ $menu->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $menu->description }}</p>
                            <div class="pt-4 flex justify-between items-center border-t border-gray-100 dark:border-zinc-800">
                                <span class="text-lg font-extrabold text-kanca-orange">IDR {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <button type="button" @click="addToCart({ id: {{ $menu->id }}, name: '{{ addslashes($menu->name) }}', price: {{ $menu->price }}, image: '{{ $menu->image }}' })" class="p-2.5 rounded-xl bg-kanca-orange/10 text-kanca-orange hover:bg-kanca-orange hover:text-white transition-colors flex items-center justify-center font-bold" title="{{ __('Tambah ke Keranjang') }}">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-14 text-gray-500 dark:text-gray-400">
                        {{ __('Data menu belum tersedia saat ini.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-white dark:bg-zinc-900 border-t border-gray-100 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-[0.2em] mb-3">{{ __('Lounge Komunitas') }}</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">{{ __('Event Komunitas Mendatang') }}</h2>
                </div>
                <a href="{{ route('community.index') }}" class="font-bold text-sm text-kanca-teal hover:text-kanca-tealHover">{{ __('Lihat semua event') }}</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($upcomingEvents as $event)
                    <div class="bg-kanca-bg dark:bg-zinc-800 rounded-3xl overflow-hidden border border-gray-200/80 dark:border-zinc-700 hover:shadow-2xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $event->poster }}" alt="{{ $event->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 right-4 bg-kanca-dark/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                    {{ $event->date ? $event->date->format('d M Y') : '' }}
                                </div>
                            </div>
                            <div class="p-6 space-y-3">
                                <div class="text-xs font-bold text-kanca-orange uppercase tracking-wider">{{ __('Lokasi') }}: {{ $event->location }}</div>
                                <h3 class="font-bold text-lg text-kanca-dark dark:text-white leading-snug">{{ $event->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $event->description }}</p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-gray-200/60 dark:border-zinc-700/60 mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500 font-semibold">{{ __('Kuota') }}: <strong class="text-kanca-dark dark:text-white">{{ $event->available_seats }} {{ __('kursi tersisa') }}</strong></span>
                            <a href="{{ route('community.show', $event->slug) }}" class="px-4 py-2 rounded-xl bg-kanca-orange text-white text-xs font-bold hover:bg-kanca-orangeHover transition-colors">{{ __('Ikut Event') }}</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-14 text-gray-500 dark:text-gray-400">
                        {{ __('Belum ada event mendatang yang dijadwalkan.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-[0.2em]">{{ __('Ulasan Komunitas') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">{{ __('Apa Kata Pengunjung tentang Kanca') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($testimonials as $t)
                    <div class="glass-card dark:glass-dark rounded-3xl p-6 border border-white/80 dark:border-zinc-800 space-y-4">
                        <div class="flex text-amber-400 text-sm">
                            @for($i = 0; $i < $t->rating; $i++)
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-300 italic leading-relaxed">"{{ $t->message }}"</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-zinc-800">
                            <img src="{{ $t->avatar }}" class="w-10 h-10 rounded-full object-cover border-2 border-kanca-orange" alt="{{ $t->name }}">
                            <div>
                                <h4 class="font-bold text-xs text-kanca-dark dark:text-white">{{ $t->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-semibold">{{ $t->role }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-14 text-gray-500 dark:text-gray-400">
                        {{ __('Ulasan pelanggan akan muncul di sini setelah dipublikasikan.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-20 bg-white dark:bg-zinc-900 border-y border-gray-100 dark:border-zinc-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-12">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-[0.2em]">{{ __('FAQ') }}</span>
                <h2 class="text-3xl font-extrabold text-kanca-dark dark:text-white">{{ __('Pertanyaan yang Sering Diajukan') }}</h2>
            </div>
            <div class="space-y-4" x-data="{ active: null }">
                <div class="border border-gray-200 dark:border-zinc-800 rounded-2xl p-4 bg-kanca-bg dark:bg-zinc-800">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full flex justify-between items-center font-bold text-sm text-left text-kanca-dark dark:text-white">
                        <span>{{ __('Apakah ada Wi-Fi yang stabil untuk kerja jarak jauh?') }}</span>
                        <span class="text-kanca-orange">+</span>
                    </button>
                    <div x-show="active === 1" x-collapse class="mt-3 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ __('Ya. Kanca Coffee dirancang untuk kerja jarak jauh dengan internet stabil, colokan listrik, dan kursi yang nyaman.') }}
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-zinc-800 rounded-2xl p-4 bg-kanca-bg dark:bg-zinc-800">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full flex justify-between items-center font-bold text-sm text-left text-kanca-dark dark:text-white">
                        <span>{{ __('Bagaimana cara ikut event komunitas?') }}</span>
                        <span class="text-kanca-orange">+</span>
                    </button>
                    <div x-show="active === 2" x-collapse class="mt-3 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ __('Buka halaman Komunitas, pilih event, lalu daftarkan diri dengan data Anda untuk memesan kursi.') }}
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-zinc-800 rounded-2xl p-4 bg-kanca-bg dark:bg-zinc-800">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full flex justify-between items-center font-bold text-sm text-left text-kanca-dark dark:text-white">
                        <span>{{ __('Apakah saya bisa memesan ruang event pribadi?') }}</span>
                        <span class="text-kanca-orange">+</span>
                    </button>
                    <div x-show="active === 3" x-collapse class="mt-3 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ __('Ya. Gunakan halaman Kontak dan tim kami akan membantu mengatur workshop, mini gig, dan gathering pribadi.') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-5 space-y-4">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-[0.2em]">{{ __('Galeri') }}</span>
                <h2 class="text-3xl font-extrabold text-kanca-dark dark:text-white">{{ __('Ruang hangat yang dibangun untuk manusia dan ide.') }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('Sedikit gambaran suasana, detail, dan energi yang membuat Kanca terasa hidup.') }}</p>
            </div>
            <div class="lg:col-span-7 grid grid-cols-2 gap-4">
                @forelse($galleries as $gallery)
                    <img src="{{ $gallery->image }}" alt="{{ $gallery->title ?? 'Kanca gallery photo' }}" class="rounded-3xl h-52 w-full object-cover shadow-lg">
                @empty
                    <div class="col-span-2 text-center py-12 text-gray-500 dark:text-gray-400">{{ __('Gallery items will appear here once uploaded.') }}</div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>
