<x-app-layout>
    <section class="py-12 bg-kanca-bg dark:bg-zinc-950" x-data="publicOrderApp({{ json_encode($menus) }})">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="text-center space-y-3 mb-10">
                <span class="px-4 py-1.5 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-widest">
                    Kanca Coffee
                </span>
                <h1 class="text-4xl font-extrabold text-kanca-dark dark:text-white">Pesan Sekarang</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pilih menu favorit kamu & kami siapkan langsung.</p>
            </div>

            {{-- Success / Error Alerts --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3 shadow-sm">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3 shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Order Card --}}
            <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-gray-100 dark:border-zinc-800 overflow-hidden">

                {{-- Decorative Top Bar --}}
                <div class="h-2 bg-gradient-brand w-full"></div>

                <form action="{{ route('order.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    {{-- Menu Selection --}}
                    <div class="space-y-2">
                        <label class="text-sm font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                            <i data-lucide="coffee" class="w-4 h-4 text-kanca-orange"></i>
                            Ingin Beli Apa?
                        </label>
                        <select name="menu_id" id="menu_id" x-model="selectedMenuId" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-zinc-700 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-kanca-orange focus:border-transparent transition-all">
                            <option value="">-- Pilih Makanan / Minuman --</option>
                            <template x-for="menu in menus" :key="menu.id">
                                <option :value="menu.id" x-text="menu.name + ' — ' + formatPrice(menu.price)"></option>
                            </template>
                        </select>
                    </div>

                    {{-- Dynamic Menu Preview Card --}}
                    <div x-show="selectedMenu" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="rounded-2xl bg-gradient-to-br from-kanca-cream to-white dark:from-zinc-800 dark:to-zinc-900 border border-kanca-orange/20 dark:border-zinc-700 overflow-hidden shadow-sm">
                        <div class="flex gap-5 p-5">
                            <img :src="selectedMenu ? selectedMenu.image : ''"
                                 :alt="selectedMenu ? selectedMenu.name : ''"
                                 class="w-24 h-24 rounded-2xl object-cover shadow-lg border-2 border-white dark:border-zinc-700 shrink-0">
                            <div class="space-y-1.5 min-w-0 flex-1">
                                <p class="font-extrabold text-base text-gray-900 dark:text-white truncate" x-text="selectedMenu ? selectedMenu.name : ''"></p>
                                <p class="text-kanca-orange font-bold text-lg" x-text="selectedMenu ? formatPrice(selectedMenu.price) : ''"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2" x-text="selectedMenu ? selectedMenu.description : ''"></p>
                            </div>
                        </div>

                        {{-- Quantity Selector --}}
                        <div class="flex items-center justify-between px-5 py-4 bg-gray-50 dark:bg-zinc-800/50 border-t border-kanca-orange/10 dark:border-zinc-700">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Jumlah Pesanan</span>
                            <div class="flex items-center gap-4">
                                <button type="button" @click="decrement"
                                    class="w-9 h-9 rounded-full bg-white dark:bg-zinc-700 shadow-md border border-gray-200 dark:border-zinc-600 text-gray-800 dark:text-white hover:bg-kanca-orange hover:text-white hover:border-kanca-orange transition-all font-extrabold text-lg flex items-center justify-center">
                                    −
                                </button>
                                <span class="text-xl font-extrabold text-gray-900 dark:text-white w-8 text-center" x-text="quantity"></span>
                                <button type="button" @click="increment"
                                    class="w-9 h-9 rounded-full bg-white dark:bg-zinc-700 shadow-md border border-gray-200 dark:border-zinc-600 text-gray-800 dark:text-white hover:bg-kanca-orange hover:text-white hover:border-kanca-orange transition-all font-extrabold text-lg flex items-center justify-center">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="quantity" :value="quantity">

                    {{-- Table Number --}}
                    <div class="space-y-2">
                        <label class="text-sm font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-kanca-orange"></i>
                            Nomor Meja
                        </label>
                        <select name="table_number" required
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-zinc-700 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-kanca-orange focus:border-transparent transition-all">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">Meja {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Customer Name (Optional) --}}
                    <div class="space-y-2">
                        <label class="text-sm font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-kanca-orange"></i>
                            Nama Kamu
                            <span class="text-xs font-normal text-gray-400">(opsional)</span>
                        </label>
                        <input type="text" name="customer_name" placeholder="mis. Budi, Rini, atau nomor antrian..."
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-zinc-700 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-kanca-orange focus:border-transparent transition-all">
                    </div>

                    {{-- Customer Note (Optional) --}}
                    <div class="space-y-2">
                        <label class="text-sm font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                            <i data-lucide="message-square" class="w-4 h-4 text-kanca-orange"></i>
                            Catatan Pesanan
                            <span class="text-xs font-normal text-gray-400">(opsional)</span>
                        </label>
                        <textarea name="customer_note" rows="2" placeholder="mis. Less ice, no sugar, extra shot..."
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-zinc-700 text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-kanca-orange focus:border-transparent transition-all resize-none"></textarea>
                    </div>

                    {{-- Total Price + Submit --}}
                    <div class="pt-4 border-t border-gray-100 dark:border-zinc-800 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-500">Total Harga</span>
                            <span class="text-2xl font-extrabold text-kanca-orange" x-text="formatPrice(totalPrice)">Rp 0</span>
                        </div>
                        <button type="submit" :disabled="!selectedMenuId"
                            class="w-full py-4 rounded-2xl bg-gradient-brand hover:opacity-90 disabled:opacity-40 disabled:cursor-not-allowed text-white font-extrabold text-base transition-all shadow-xl shadow-kanca-orange/30 flex items-center justify-center gap-2">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                            KIRIM PESANAN
                        </button>
                        <p class="text-center text-xs text-gray-400">Pesanan kamu akan langsung diproses oleh staff kami ☕</p>
                    </div>
                </form>
            </div>

            {{-- Link to menu --}}
            <div class="text-center mt-6">
                <a href="{{ route('menu.index') }}" class="text-sm text-gray-500 hover:text-kanca-orange transition-colors font-medium">
                    ← Lihat menu lengkap
                </a>
            </div>
        </div>
    </section>

    <script>
        function publicOrderApp(menus) {
            return {
                menus: menus,
                selectedMenuId: '',
                quantity: 1,
                get selectedMenu() {
                    return this.menus.find(m => m.id == this.selectedMenuId) || null;
                },
                get totalPrice() {
                    if (!this.selectedMenu) return 0;
                    return this.selectedMenu.price * this.quantity;
                },
                increment() { this.quantity++; },
                decrement() { if (this.quantity > 1) this.quantity--; },
                formatPrice(value) {
                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                },
                init() {
                    this.$watch('selectedMenuId', () => { this.quantity = 1; });
                }
            }
        }
    </script>
</x-app-layout>
