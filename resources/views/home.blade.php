<x-app-layout>
    <section class="relative overflow-hidden py-20 lg:py-28 bg-gradient-to-b from-kanca-bg via-orange-50/50 to-kanca-bg dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[44rem] h-[44rem] rounded-full bg-gradient-to-tr from-kanca-orange/20 to-kanca-teal/20 blur-3xl"></div>
        <div class="absolute top-16 left-6 px-3 py-1 rounded-full bg-white/70 dark:bg-zinc-800/70 text-xs font-semibold animate-float-slow">Coffee</div>
        <div class="absolute top-24 right-10 px-3 py-1 rounded-full bg-white/70 dark:bg-zinc-800/70 text-xs font-semibold animate-float-reverse">Community</div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 text-center lg:text-left space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-kanca-orange/10 border border-kanca-orange/20 text-kanca-orange text-xs font-bold uppercase tracking-[0.2em]">
                    <span class="w-2 h-2 rounded-full bg-kanca-orange animate-pulse"></span>
                    First interactive coffee shop and community platform
                </div>

                <div class="space-y-5">
                    <h1 class="text-4xl sm:text-6xl xl:text-7xl font-extrabold leading-[1.05] text-kanca-dark dark:text-white">
                        Teman yang kamu cari ada di <span class="text-gradient-primary">seberang meja.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto lg:mx-0 text-base sm:text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                        More than a coffee shop, Kanca Coffee is a place to discover menus, join events, meet people, and build a real community around specialty coffee.
                    </p>
                </div>

                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="{{ route('menu.index') }}" class="px-7 py-4 rounded-2xl bg-kanca-orange text-white font-bold shadow-xl shadow-kanca-orange/20 hover:-translate-y-1 transition-all">
                        Explore Menu
                    </a>
                    <a href="{{ route('community.index') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-zinc-800 text-kanca-dark dark:text-white font-bold border border-gray-200 dark:border-zinc-700 hover:-translate-y-1 transition-all">
                        Join Community
                    </a>
                    <a href="{{ route('contact') }}" class="px-7 py-4 rounded-2xl bg-kanca-teal text-white font-bold shadow-xl shadow-kanca-teal/20 hover:-translate-y-1 transition-all">
                        Book Event Space
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-6 max-w-xl mx-auto lg:mx-0 pt-4 border-t border-gray-200/80 dark:border-zinc-800">
                    <div>
                        <span class="block text-2xl sm:text-3xl font-extrabold">{{ $stats['menus'] }}</span>
                        <span class="text-[11px] text-gray-500 uppercase tracking-wide">Available Menus</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-extrabold text-kanca-orange">{{ $stats['events'] }}</span>
                        <span class="text-[11px] text-gray-500 uppercase tracking-wide">Upcoming Events</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-extrabold text-kanca-teal">{{ $stats['testimonials'] }}</span>
                        <span class="text-[11px] text-gray-500 uppercase tracking-wide">Featured Reviews</span>
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
                                <h4 class="font-bold text-sm text-kanca-dark dark:text-white">Today's Highlight</h4>
                                <p class="text-xs text-kanca-teal font-semibold">Signature drink of the day</p>
                            </div>
                        </div>
                        <div class="absolute -top-5 -right-5 bg-kanca-dark text-white px-4 py-2 rounded-2xl shadow-xl text-xs font-bold">
                            Quick Table QR Menu
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
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] opacity-80">Our Philosophy</p>
                    <p class="font-extrabold mt-1">Coffee connects conversations across every single table.</p>
                </div>
            </div>

            <div class="space-y-6">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-[0.2em]">Why Kanca Coffee</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">Designed for connection, craft, and community.</h2>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    We blend specialty beans, flexible work-friendly spaces, curated events, and warm hospitality into one premium coffee experience.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-kanca-bg dark:bg-zinc-800 border border-orange-100 dark:border-zinc-700">
                        <h4 class="font-bold text-kanca-orange text-sm mb-1">Direct Trade Beans</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Fresh and traceable specialty coffee from local farmers.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-kanca-bg dark:bg-zinc-800 border border-teal-100 dark:border-zinc-700">
                        <h4 class="font-bold text-kanca-teal text-sm mb-1">Remote Work Haven</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Comfortable seating, strong Wi-Fi, and plenty of power access.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-[0.2em]">Curated Menu</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">Today's Best Selling Brews and Bites</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($bestsellers as $menu)
                    <div class="glass-card dark:glass-dark rounded-3xl p-5 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-white/80 dark:border-zinc-800 relative">
                        <div class="absolute top-8 left-8 flex gap-2 z-10">
                            <span class="px-3 py-1 rounded-full bg-kanca-orange text-white text-[10px] font-extrabold uppercase">Best Seller</span>
                            @if($menu->is_new)
                                <span class="px-3 py-1 rounded-full bg-kanca-teal text-white text-[10px] font-extrabold uppercase">New</span>
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
                                <a href="{{ route('menu.index') }}" class="p-2.5 rounded-xl bg-kanca-orange/10 text-kanca-orange hover:bg-kanca-orange hover:text-white transition-colors">+</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-14 text-gray-500 dark:text-gray-400">
                        Menu data is not available yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-white dark:bg-zinc-900 border-t border-gray-100 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-[0.2em] mb-3">Community Lounge</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">Upcoming Community Events</h2>
                </div>
                <a href="{{ route('community.index') }}" class="font-bold text-sm text-kanca-teal hover:text-kanca-tealHover">View all events</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($upcomingEvents as $event)
                    <div class="bg-kanca-bg dark:bg-zinc-800 rounded-3xl overflow-hidden border border-gray-200/80 dark:border-zinc-700 hover:shadow-2xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $event->poster }}" alt="{{ $event->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 right-4 bg-kanca-dark/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                    {{ $event->date ? $event->date->format('M d, Y') : '' }}
                                </div>
                            </div>
                            <div class="p-6 space-y-3">
                                <div class="text-xs font-bold text-kanca-orange uppercase tracking-wider">Location: {{ $event->location }}</div>
                                <h3 class="font-bold text-lg text-kanca-dark dark:text-white leading-snug">{{ $event->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $event->description }}</p>
                            </div>
                        </div>
                        <div class="p-6 pt-0 border-t border-gray-200/60 dark:border-zinc-700/60 mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500 font-semibold">Quota: <strong class="text-kanca-dark dark:text-white">{{ $event->available_seats }} seats left</strong></span>
                            <a href="{{ route('community.show', $event->slug) }}" class="px-4 py-2 rounded-xl bg-kanca-orange text-white text-xs font-bold hover:bg-kanca-orangeHover transition-colors">Join Event</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-14 text-gray-500 dark:text-gray-400">
                        No upcoming events scheduled yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-16">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-[0.2em]">Community Reviews</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white">What Visitors Say About Kanca</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($testimonials as $t)
                    <div class="glass-card dark:glass-dark rounded-3xl p-6 border border-white/80 dark:border-zinc-800 space-y-4">
                        <div class="flex text-amber-400 text-sm">
                            @for($i = 0; $i < $t->rating; $i++)
                                <span>★</span>
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
                        Customer reviews will appear here once they are published.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-20 bg-white dark:bg-zinc-900 border-y border-gray-100 dark:border-zinc-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-12">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-[0.2em]">FAQ</span>
                <h2 class="text-3xl font-extrabold text-kanca-dark dark:text-white">Frequently Asked Questions</h2>
            </div>
            <div class="space-y-4" x-data="{ active: null }">
                <div class="border border-gray-200 dark:border-zinc-800 rounded-2xl p-4 bg-kanca-bg dark:bg-zinc-800">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full flex justify-between items-center font-bold text-sm text-left text-kanca-dark dark:text-white">
                        <span>Is there reliable Wi-Fi for remote work?</span>
                        <span class="text-kanca-orange">+</span>
                    </button>
                    <div x-show="active === 1" x-collapse class="mt-3 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        Yes. Kanca Coffee is designed for remote work with stable internet, plug points, and comfortable seating.
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-zinc-800 rounded-2xl p-4 bg-kanca-bg dark:bg-zinc-800">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full flex justify-between items-center font-bold text-sm text-left text-kanca-dark dark:text-white">
                        <span>How do I join community events?</span>
                        <span class="text-kanca-orange">+</span>
                    </button>
                    <div x-show="active === 2" x-collapse class="mt-3 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        Open the Community page, pick an event, and register with your details to reserve a seat.
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-zinc-800 rounded-2xl p-4 bg-kanca-bg dark:bg-zinc-800">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full flex justify-between items-center font-bold text-sm text-left text-kanca-dark dark:text-white">
                        <span>Can I book a private event space?</span>
                        <span class="text-kanca-orange">+</span>
                    </button>
                    <div x-show="active === 3" x-collapse class="mt-3 text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        Yes. Use the Contact page and our team will help you arrange workshops, mini gigs, and private gatherings.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-5 space-y-4">
                <span class="inline-block px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-[0.2em]">Gallery</span>
                <h2 class="text-3xl font-extrabold text-kanca-dark dark:text-white">A warm space built for people and ideas.</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300">A small glimpse of the atmosphere, details, and energy that make Kanca feel alive.</p>
            </div>
            <div class="lg:col-span-7 grid grid-cols-2 gap-4">
                @forelse($galleries as $gallery)
                    <img src="{{ $gallery->image }}" alt="{{ $gallery->title ?? 'Kanca gallery photo' }}" class="rounded-3xl h-52 w-full object-cover shadow-lg">
                @empty
                    <div class="col-span-2 text-center py-12 text-gray-500 dark:text-gray-400">Gallery items will appear here once uploaded.</div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>
