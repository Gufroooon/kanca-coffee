<x-app-layout>
    <section class="py-16 bg-kanca-bg dark:bg-zinc-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
                <span class="px-4 py-1.5 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-widest">Connect With Us</span>
                <h1 class="text-4xl font-extrabold text-kanca-dark dark:text-white">We'd Love To Hear From You</h1>
                <p class="text-xs text-gray-500">Visit our lounge in Senopati or send us your feedback & inquiries.</p>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Location -->
                <div class="glass-card dark:glass-dark rounded-3xl p-6 text-center space-y-3 border border-white/80 dark:border-zinc-800 shadow-md">
                    <div class="w-12 h-12 rounded-2xl bg-kanca-orange/10 text-kanca-orange flex items-center justify-center mx-auto text-2xl">📍</div>
                    <h3 class="font-bold text-base text-kanca-dark dark:text-white">Lounge Location</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan</p>
                </div>

                <!-- Hours -->
                <div class="glass-card dark:glass-dark rounded-3xl p-6 text-center space-y-3 border border-white/80 dark:border-zinc-800 shadow-md">
                    <div class="w-12 h-12 rounded-2xl bg-kanca-teal/10 text-kanca-teal flex items-center justify-center mx-auto text-2xl">⏰</div>
                    <h3 class="font-bold text-base text-kanca-dark dark:text-white">Operating Hours</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Mon - Fri: 07:00 - 23:00 WIB<br>Sat - Sun: 07:00 - 24:00 WIB</p>
                </div>

                <!-- Direct Delivery & Social CTAs -->
                <div class="glass-card dark:glass-dark rounded-3xl p-6 text-center space-y-3 border border-white/80 dark:border-zinc-800 shadow-md">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto text-2xl">🛵</div>
                    <h3 class="font-bold text-base text-kanca-dark dark:text-white">Order Delivery & Socials</h3>
                    <div class="flex justify-center gap-2 pt-1">
                        <a href="https://wa.me/6281234567890" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-500 text-white text-[11px] font-bold">WhatsApp</a>
                        <a href="https://gofood.link/kancacoffee" target="_blank" class="px-3 py-1.5 rounded-xl bg-rose-500 text-white text-[11px] font-bold">GoFood</a>
                        <a href="https://shopeefood.link/kancacoffee" target="_blank" class="px-3 py-1.5 rounded-xl bg-orange-500 text-white text-[11px] font-bold">ShopeeFood</a>
                    </div>
                </div>
            </div>

            <!-- Contact Form & Feedback Form Tabs -->
            <div class="max-w-4xl mx-auto glass-card dark:glass-dark rounded-3xl p-8 border border-white/80 dark:border-zinc-800 shadow-2xl" x-data="{ tab: 'contact' }">
                <!-- Form Tabs Navigation -->
                <div class="flex border-b border-gray-200 dark:border-zinc-800 mb-8">
                    <button @click="tab = 'contact'" :class="tab === 'contact' ? 'border-b-2 border-kanca-orange text-kanca-orange font-bold' : 'text-gray-400'" class="pb-3 px-6 text-sm font-semibold transition-colors">
                        ✉️ General Contact & Space Booking
                    </button>
                    <button @click="tab = 'feedback'" :class="tab === 'feedback' ? 'border-b-2 border-kanca-teal text-kanca-teal font-bold' : 'text-gray-400'" class="pb-3 px-6 text-sm font-semibold transition-colors">
                        ⭐ Send Customer Feedback
                    </button>
                </div>

                <!-- Contact Form -->
                <form x-show="tab === 'contact'" action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Your Name</label>
                            <input type="text" name="name" required placeholder="John Doe" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <input type="email" name="email" required placeholder="john@example.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                            <input type="text" name="phone" placeholder="0812xxxx" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                            <input type="text" name="subject" required placeholder="Event Space Reservation / General Query" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Message</label>
                        <textarea name="message" rows="4" required placeholder="Tell us how we can help you..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-orange"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl bg-kanca-orange hover:bg-kanca-orangeHover text-white font-bold text-xs shadow-md transition-all">
                        Send Message
                    </button>
                </form>

                <!-- Feedback Form -->
                <form x-show="tab === 'feedback'" action="{{ route('feedback.submit') }}" method="POST" class="space-y-4" x-cloak>
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Your Name (Optional)</label>
                            <input type="text" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-teal">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Feedback Category</label>
                            <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-teal">
                                <option value="taste">☕ Coffee Taste & Quality</option>
                                <option value="service">😊 Barista Service & Hospitality</option>
                                <option value="ambiance">🛋️ Store Ambiance & Seating</option>
                                <option value="speed">⚡ Order Speed</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Rating (1 to 5 Stars)</label>
                        <select name="rating" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-teal">
                            <option value="5">⭐⭐⭐⭐⭐ 5 - Outstanding Experience</option>
                            <option value="4">⭐⭐⭐⭐ 4 - Very Good</option>
                            <option value="3">⭐⭐⭐ 3 - Average</option>
                            <option value="2">⭐⭐ 2 - Needs Improvement</option>
                            <option value="1">⭐ 1 - Unsatisfactory</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Feedback Message</label>
                        <textarea name="message" rows="4" required placeholder="Share your experience seberang meja..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white focus:border-kanca-teal"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl bg-kanca-teal hover:bg-kanca-tealHover text-white font-bold text-xs shadow-md transition-all">
                        Submit Feedback
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
