<x-app-layout>
    <section class="py-12 bg-kanca-bg dark:bg-zinc-950" x-data="{ modalOpen: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('community.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-kanca-orange mb-8">
                ← Back to Community Events
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Poster -->
                <div class="lg:col-span-5">
                    <img src="{{ $event->poster }}" alt="{{ $event->title }}" class="rounded-3xl shadow-2xl w-full object-cover h-[420px]" />
                </div>

                <!-- Event Info & Registration Box -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full bg-kanca-teal/10 text-kanca-teal text-xs font-extrabold uppercase">
                            {{ $event->status }}
                        </span>
                        <span class="text-xs text-gray-400 font-semibold">Quota Available: {{ $event->available_seats }} / {{ $event->capacity }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-extrabold text-kanca-dark dark:text-white leading-tight">
                        {{ $event->title }}
                    </h1>

                    <!-- Speaker Card -->
                    @if($event->speaker_name)
                        <div class="p-4 rounded-2xl bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-kanca-orange/10 flex items-center justify-center text-kanca-orange font-bold text-xl">
                                🎙️
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-kanca-dark dark:text-white">{{ $event->speaker_name }}</h4>
                                <p class="text-xs text-gray-400 font-medium">{{ $event->speaker_title }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Event Metadata -->
                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-gray-200 dark:border-zinc-800 text-xs">
                        <div>
                            <span class="text-gray-400 block font-semibold">Date & Time</span>
                            <span class="font-bold text-kanca-dark dark:text-white text-sm">{{ $event->date ? $event->date->format('l, d F Y') : '' }}</span>
                            <span class="block text-gray-500">{{ $event->start_time }} - {{ $event->end_time }} WIB</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block font-semibold">Location & Price</span>
                            <span class="font-bold text-kanca-dark dark:text-white text-sm">📍 {{ $event->location }}</span>
                            <span class="block text-kanca-orange font-extrabold">{{ $event->price > 0 ? 'IDR ' . number_format($event->price, 0, ',', '.') : 'FREE ADMISSION' }}</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h3 class="font-bold text-sm uppercase text-gray-400 tracking-wider">About This Event</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                            {{ $event->description }}
                        </p>
                    </div>

                    <!-- Register CTA -->
                    <div>
                        @if($event->is_full)
                            <button disabled class="w-full py-4 rounded-2xl bg-gray-300 dark:bg-zinc-800 text-gray-500 font-bold text-base cursor-not-allowed">
                                Registration Closed (Quota Full)
                            </button>
                        @else
                            <button @click="modalOpen = true" class="w-full py-4 rounded-2xl bg-kanca-orange hover:bg-kanca-orangeHover text-white font-bold text-base transition-all shadow-xl shadow-kanca-orange/30 flex items-center justify-center gap-3">
                                <span>Register Ticket Pass Now</span>
                                <i data-lucide="ticket" class="w-5 h-5"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Registration Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="modalOpen = false" class="bg-white dark:bg-zinc-900 rounded-3xl p-8 max-w-lg w-full shadow-2xl border border-gray-200 dark:border-zinc-800 relative space-y-6">
                <button @click="modalOpen = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 text-lg">✕</button>

                <div class="space-y-1">
                    <h3 class="text-xl font-extrabold text-kanca-dark dark:text-white">Register Event Pass</h3>
                    <p class="text-xs text-gray-500">{{ $event->title }}</p>
                </div>

                <form action="{{ route('community.register', $event->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                        <input type="text" name="name" required value="{{ auth()->check() ? auth()->user()->name : '' }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                        <input type="email" name="email" required value="{{ auth()->check() ? auth()->user()->email : '' }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">WhatsApp / Phone Number</label>
                        <input type="text" name="phone" required value="{{ auth()->check() ? auth()->user()->phone : '' }}" placeholder="0812xxxx" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Number of Tickets</label>
                        <select name="tickets_count" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                            <option value="1">1 Ticket Pass</option>
                            <option value="2">2 Ticket Passes</option>
                            <option value="3">3 Ticket Passes</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl bg-kanca-orange hover:bg-kanca-orangeHover text-white text-xs font-bold transition-all shadow-md">
                        Confirm Registration & Generate QR Ticket
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
