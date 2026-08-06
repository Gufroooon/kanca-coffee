<x-app-layout>
    <!-- Header Banner -->
    <section class="py-20 bg-gradient-to-b from-kanca-orange/10 via-kanca-bg to-kanca-bg dark:from-zinc-900 dark:to-zinc-950 text-center">
        <div class="max-w-4xl mx-auto px-4">
            <span class="px-4 py-1.5 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-widest">About Our Lounge</span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-kanca-dark dark:text-white mt-4 tracking-tight">
                "Teman yang kamu cari ada di seberang meja."
            </h1>
            <p class="mt-4 text-gray-600 dark:text-gray-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
                Discover the story behind Kanca Coffee — how a small specialty coffee bar grew into Indonesia's first interactive community coffee house.
            </p>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-16 bg-white dark:bg-zinc-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-8 rounded-3xl bg-gradient-to-br from-kanca-orange/10 to-orange-50 dark:from-zinc-800 dark:to-zinc-800/50 border border-kanca-orange/20 space-y-3">
                    <div class="text-3xl">🎯</div>
                    <h3 class="text-xl font-bold text-kanca-dark dark:text-white">Our Mission</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                        To serve world-class Indonesian specialty coffee while cultivating an open, inclusive physical & digital space where creators, professionals, and coffee lovers collide and collaborate.
                    </p>
                </div>

                <div class="p-8 rounded-3xl bg-gradient-to-br from-kanca-teal/10 to-teal-50 dark:from-zinc-800 dark:to-zinc-800/50 border border-kanca-teal/20 space-y-3">
                    <div class="text-3xl">🌟</div>
                    <h3 class="text-xl font-bold text-kanca-dark dark:text-white">Our Vision</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                        To become Southeast Asia's leading community-driven coffee house chain, empowering local coffee farmers and transforming neighborhood coffee shops into vibrant tech-enabled hubs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Story Timeline -->
    <section class="py-20 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-kanca-dark dark:text-white">Our Coffee & Community Journey</h2>
                <p class="text-xs text-gray-500 mt-2">Milestones that shaped Kanca Coffee over the years</p>
            </div>

            <div class="relative border-l-2 border-kanca-orange/40 ml-4 md:ml-32 space-y-12">
                <!-- 2023 -->
                <div class="relative pl-8 group">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-kanca-orange border-4 border-white dark:border-zinc-950 shadow-md"></div>
                    <span class="text-xs font-bold text-kanca-orange uppercase tracking-wider">Year 2023</span>
                    <h4 class="font-bold text-lg text-kanca-dark dark:text-white mt-1">The First Table in Senopati</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                        Kanca Coffee opened its doors with a single 3-group Synesso machine and 12 communal wooden seats, introducing direct-trade Aceh Gayo beans.
                    </p>
                </div>

                <!-- 2024 -->
                <div class="relative pl-8 group">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-kanca-teal border-4 border-white dark:border-zinc-950 shadow-md"></div>
                    <span class="text-xs font-bold text-kanca-teal uppercase tracking-wider">Year 2024</span>
                    <h4 class="font-bold text-lg text-kanca-dark dark:text-white mt-1">Launch of Community Workshops</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                        We hosted our first manual brew cupping classes, acoustic sunset gigs, and open mic poetry nights, surpassing 5,000 active community attendees.
                    </p>
                </div>

                <!-- 2026 -->
                <div class="relative pl-8 group">
                    <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-kanca-orange border-4 border-white dark:border-zinc-950 shadow-md"></div>
                    <span class="text-xs font-bold text-kanca-orange uppercase tracking-wider">Year 2026</span>
                    <h4 class="font-bold text-lg text-kanca-dark dark:text-white mt-1">Interactive Digital Platform</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                        Pioneering Indonesia's first interactive web platform integrating real-time menu discovery, table QR ordering, event passes, and staff shift transparency.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Showcase -->
    <section class="py-20 bg-white dark:bg-zinc-900 border-t border-gray-100 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-2">
                <span class="text-xs font-bold text-kanca-orange uppercase tracking-wider">Behind The Bar</span>
                <h2 class="text-3xl font-extrabold text-kanca-dark dark:text-white">Meet Our Passionate Baristas & Team</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($team as $member)
                    <div class="glass-card dark:glass-dark rounded-3xl p-5 text-center space-y-3 border border-gray-100 dark:border-zinc-800">
                        <img src="{{ $member->avatar }}" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-kanca-orange shadow-md" />
                        <h4 class="font-bold text-sm text-kanca-dark dark:text-white">{{ $member->name }}</h4>
                        <p class="text-xs font-semibold text-kanca-teal">{{ $member->shift }}</p>
                        <p class="text-[11px] text-gray-500">Dedicated to brewing perfection and welcoming every customer.</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
