@php
    $favoriteItemsTitle = __('Item Favorit');
@endphp
<x-app-layout>
    <section class="py-12 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Profile Card -->
            <div class="glass-card dark:glass-dark rounded-3xl p-6 sm:p-8 border border-white/80 dark:border-zinc-800 shadow-xl mb-10 flex flex-col sm:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ $user->avatar ?? 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=200&q=80' }}" class="w-16 h-16 rounded-full object-cover border-4 border-kanca-orange shadow-md" />
                    <div>
                        <h1 class="text-2xl font-extrabold text-kanca-dark dark:text-white">{{ $user->name }}</h1>
                        <p class="text-xs text-gray-500">{{ $user->email }} • {{ $user->phone ?? __('Belum ada nomor telepon') }}</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full bg-kanca-orange/10 text-kanca-orange text-[10px] font-extrabold uppercase tracking-wider">
                            {{ __('Anggota Komunitas') }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('profile.edit') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 text-xs font-bold text-gray-700 dark:text-gray-300 hover:border-kanca-orange">
                        {{ __('Edit Profil') }}
                    </a>
                </div>
            </div>

            <!-- Content Tabs Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Joined Events & Pass QR -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-extrabold text-kanca-dark dark:text-white inline-flex items-center gap-2"><i data-lucide="ticket" class="w-6 h-6 text-kanca-orange"></i> {{ __('Pass Event Saya') }}</h2>
                        <a href="{{ route('community.index') }}" class="text-xs font-bold text-kanca-teal inline-flex items-center gap-1">{{ __('Jelajahi Event') }} <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></a>
                    </div>

                    <div class="space-y-4">
                        @forelse($registeredEvents as $reg)
                            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-5 border border-gray-100 dark:border-zinc-800 shadow-md flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-extrabold text-kanca-orange uppercase">Pass Code: {{ $reg->qr_code }}</span>
                                    <h4 class="font-bold text-base text-kanca-dark dark:text-white">{{ $reg->event ? $reg->event->title : __('Event Komunitas') }}</h4>
                                    <p class="text-xs text-gray-400 inline-flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $reg->event ? ($reg->event->date ? $reg->event->date->format('D, d M Y') : '') : '' }} • {{ $reg->tickets_count }} {{ __('Tiket') }}</p>
                                </div>

                                <div class="bg-kanca-bg dark:bg-zinc-800 p-3 rounded-2xl text-center border border-gray-200 dark:border-zinc-700 font-mono text-xs font-bold text-kanca-dark dark:text-white inline-flex items-center gap-1.5">
                                    <i data-lucide="qrcode" class="w-4 h-4"></i> {{ $reg->qr_code }}
                                </div>
                            </div>
                        @empty
                            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-8 text-center text-xs text-gray-400">
                                {{ __('Anda belum mendaftar untuk event komunitas apa pun.') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Favorite Menus -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-extrabold text-kanca-dark dark:text-white inline-flex items-center gap-2"><i data-lucide="heart" class="w-6 h-6 text-rose-500 fill-current"></i> {{ __('Item Favorit') }}</h2>
                        <a href="{{ route('menu.index') }}" class="text-xs font-bold text-kanca-orange inline-flex items-center gap-1">{{ __('Lihat Menu') }} <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></a>
                    </div>

                    <div class="space-y-3">
                        @forelse($favorites as $fav)
                            @if($fav->menu)
                                <div class="bg-white dark:bg-zinc-900 rounded-2xl p-3 border border-gray-100 dark:border-zinc-800 shadow-sm flex items-center gap-3">
                                    <img src="{{ $fav->menu->image }}" class="w-12 h-12 rounded-xl object-cover" />
                                    <div class="flex-grow">
                                        <h4 class="font-bold text-xs text-kanca-dark dark:text-white">{{ $fav->menu->name }}</h4>
                                        <span class="text-xs font-extrabold text-kanca-orange">IDR {{ number_format($fav->menu->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-8 text-center text-xs text-gray-400">
                                {{ __('Belum ada item kopi favorit yang disimpan.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
