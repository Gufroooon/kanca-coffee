<x-app-layout>
    <!-- Community Hero & Featured Event Countdown -->
    <section class="py-16 bg-gradient-to-b from-kanca-teal/10 via-kanca-bg to-kanca-bg dark:from-zinc-900 dark:to-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                <span class="px-4 py-1.5 rounded-full bg-kanca-teal/10 text-kanca-teal font-bold text-xs uppercase tracking-widest">Kanca Community Lounge</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-kanca-dark dark:text-white tracking-tight">
                    Connect, Learn, and Create Seberang Meja.
                </h1>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    Explore coffee workshops, acoustic mini gigs, youth creative markets, and open mic sessions. Register your ticket online in seconds.
                </p>
            </div>

            <!-- Next Event Live Countdown Timer Card -->
            @if($featuredEvents->count() > 0)
                @php $nextEvent = $featuredEvents->first(); @endphp
                <div x-data="countdownTimer('{{ $nextEvent->date ? $nextEvent->date->format('Y-m-d') : '' }} {{ $nextEvent->start_time }}')" class="glass-card dark:glass-dark rounded-3xl p-6 sm:p-8 max-w-4xl mx-auto border border-white/80 dark:border-zinc-800 shadow-2xl relative overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        <div class="md:col-span-7 space-y-3">
                            <span class="px-3 py-1 rounded-full bg-kanca-orange text-white text-[10px] font-extrabold uppercase">Next Featured Event</span>
                            <h3 class="text-2xl font-bold text-kanca-dark dark:text-white">{{ $nextEvent->title }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">🎙️ Speaker: <strong>{{ $nextEvent->speaker_name }}</strong> ({{ $nextEvent->speaker_title }})</p>
                            <p class="text-xs text-kanca-teal font-semibold">📍 {{ $nextEvent->location }} • {{ $nextEvent->date ? $nextEvent->date->format('d M Y') : '' }} ({{ $nextEvent->start_time }} WIB)</p>
                        </div>
                        <div class="md:col-span-5 text-center bg-white/80 dark:bg-zinc-800/80 p-5 rounded-2xl border border-gray-100 dark:border-zinc-700">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Countdown To Event</p>
                            <div class="grid grid-cols-4 gap-2 text-kanca-dark dark:text-white">
                                <div><span class="text-xl font-extrabold text-kanca-orange" x-text="days">0</span><span class="block text-[9px] text-gray-400 uppercase">Days</span></div>
                                <div><span class="text-xl font-extrabold text-kanca-orange" x-text="hours">0</span><span class="block text-[9px] text-gray-400 uppercase">Hours</span></div>
                                <div><span class="text-xl font-extrabold text-kanca-orange" x-text="minutes">0</span><span class="block text-[9px] text-gray-400 uppercase">Mins</span></div>
                                <div><span class="text-xl font-extrabold text-kanca-orange" x-text="seconds">0</span><span class="block text-[9px] text-gray-400 uppercase">Secs</span></div>
                            </div>
                            <a href="{{ route('community.show', $nextEvent->slug) }}" class="mt-4 w-full block py-2.5 rounded-xl bg-kanca-orange text-white text-xs font-bold hover:bg-kanca-orangeHover transition-all shadow-md">
                                Reserve Pass Now
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Search & Events Catalog Grid -->
    <section class="py-20 bg-white dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="max-w-xl mx-auto mb-12">
                <form action="{{ route('community.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search workshops, acoustic gigs, classes..." class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-kanca-bg dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-sm focus:outline-none focus:border-kanca-teal">
                    <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-4 top-4"></i>
                </form>
            </div>

            <!-- Events List -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div class="glass-card dark:glass-dark rounded-3xl overflow-hidden border border-gray-100 dark:border-zinc-800 shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative h-52">
                                <img src="{{ $event->poster }}" class="w-full h-full object-cover" />
                                <div class="absolute top-4 left-4 bg-kanca-dark/90 backdrop-blur-md text-white text-[11px] font-bold px-3 py-1 rounded-full">
                                    {{ $event->price > 0 ? 'IDR ' . number_format($event->price, 0, ',', '.') : 'FREE ADMISSION' }}
                                </div>
                            </div>
                            <div class="p-6 space-y-3">
                                <span class="text-[11px] font-bold text-kanca-orange uppercase">📅 {{ $event->date ? $event->date->format('D, d M Y') : '' }}</span>
                                <h3 class="font-bold text-lg text-kanca-dark dark:text-white leading-snug">{{ $event->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">{{ $event->description }}</p>
                                <div class="pt-2 text-xs text-gray-400">
                                    <strong>Speaker:</strong> {{ $event->speaker_name ?? 'Kanca Host' }}
                                </div>
                            </div>
                        </div>

                        <div class="p-6 pt-0 border-t border-gray-100 dark:border-zinc-800 mt-4 flex justify-between items-center">
                            <span class="text-xs font-semibold text-gray-500">Seats: <strong class="text-kanca-teal">{{ $event->available_seats }} left</strong></span>
                            <a href="{{ route('community.show', $event->slug) }}" class="px-5 py-2.5 rounded-xl bg-kanca-orange text-white text-xs font-bold hover:bg-kanca-orangeHover transition-colors shadow-md">
                                Event Detail & Ticket
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-400">
                        No community events match your search criteria.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $events->links() }}
            </div>
        </div>
    </section>

    <script>
        function countdownTimer(eventDateStr) {
            return {
                days: 0, hours: 0, minutes: 0, seconds: 0,
                init() {
                    const target = new Date(eventDateStr).getTime();
                    const update = () => {
                        const now = new Date().getTime();
                        const diff = target - now;
                        if (diff > 0) {
                            this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        }
                    };
                    update();
                    setInterval(update, 1000);
                }
            }
        }
    </script>
</x-app-layout>
