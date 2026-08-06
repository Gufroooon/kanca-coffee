<x-app-layout>
    <section class="py-12 bg-kanca-bg dark:bg-zinc-950" x-data="menuApp()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-10">
                <span class="px-4 py-1.5 rounded-full bg-kanca-orange/10 text-kanca-orange font-bold text-xs uppercase tracking-widest">Kanca Artisanal Menu</span>
                <h1 class="text-4xl font-extrabold text-kanca-dark dark:text-white">Discover Our House Brews & Kitchen</h1>
                <p class="text-xs text-gray-500">Every cup is freshly ground and handcrafted to order.</p>
            </div>

            <!-- Search & Controls Bar -->
            <div class="glass-card dark:glass-dark rounded-3xl p-6 mb-10 border border-white/80 dark:border-zinc-800 shadow-xl space-y-6">
                <form action="{{ route('menu.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                    <div class="md:col-span-6 relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search Aren Latte, Croissant, Cold Brew..." class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs focus:outline-none focus:border-kanca-orange">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-4 top-3.5"></i>
                    </div>

                    <div class="md:col-span-4">
                        <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-xs focus:outline-none focus:border-kanca-orange">
                            <option value="">Sort By: Default Bestsellers</option>
                            <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Rating: Highest Rated</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit" class="w-full py-3 rounded-2xl bg-kanca-orange text-white font-bold text-xs hover:bg-kanca-orangeHover transition-colors shadow-md">
                            Apply Filter
                        </button>
                    </div>
                </form>

                <!-- Category Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none border-t border-gray-100 dark:border-zinc-800 pt-4">
                    <a href="{{ route('menu.index', ['category' => 'all', 'search' => $search, 'sort' => $sort]) }}" class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $categorySlug === 'all' ? 'bg-kanca-dark text-white shadow-md' : 'bg-white dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100' }}">
                        ✨ All Items
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('menu.index', ['category' => $cat->slug, 'search' => $search, 'sort' => $sort]) }}" class="px-5 py-2.5 rounded-full text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $categorySlug === $cat->slug ? 'bg-kanca-orange text-white shadow-md' : 'bg-white dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100' }}">
                            <span>{{ $cat->icon }}</span>
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Menu Grid Catalog -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($menus as $menu)
                    <div class="glass-card dark:glass-dark rounded-3xl p-4 border border-white/80 dark:border-zinc-800 shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group relative">
                        <!-- Badges -->
                        <div class="absolute top-6 left-6 z-10 flex flex-col gap-1">
                            @if($menu->is_bestseller)
                                <span class="px-2.5 py-0.5 rounded-full bg-kanca-orange text-white text-[9px] font-extrabold uppercase shadow-sm">Best Seller</span>
                            @endif
                            @if($menu->is_new)
                                <span class="px-2.5 py-0.5 rounded-full bg-kanca-teal text-white text-[9px] font-extrabold uppercase shadow-sm">New</span>
                            @endif
                        </div>

                        <!-- Menu Card Body -->
                        <div>
                            <div class="overflow-hidden rounded-2xl mb-3 h-44 bg-gray-100 relative">
                                <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                
                                <!-- Favorite Heart Button -->
                                <button @click.prevent="toggleFavorite({{ $menu->id }})" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md flex items-center justify-center text-rose-500 hover:scale-110 transition-transform shadow-md">
                                    ♥
                                </button>
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex justify-between items-center text-[10px]">
                                    <span class="font-bold text-kanca-teal uppercase">{{ $menu->category->name }}</span>
                                    <span class="font-bold text-amber-500">★ {{ number_format($menu->rating, 2) }}</span>
                                </div>
                                <h3 class="font-bold text-base text-kanca-dark dark:text-white group-hover:text-kanca-orange transition-colors">
                                    {{ $menu->name }}
                                </h3>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2">
                                    {{ $menu->description }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 mt-3 flex justify-between items-center border-t border-gray-100 dark:border-zinc-800">
                            <span class="text-base font-extrabold text-kanca-orange">
                                IDR {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                            <button @click="openModal({{ json_encode($menu) }})" class="px-3 py-1.5 rounded-xl bg-kanca-dark text-white text-[11px] font-bold hover:bg-black transition-colors">
                                Details
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-16 text-gray-400">
                        No menu items found for the selected category or search.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $menus->links() }}
            </div>
        </div>

        <!-- Menu Item Quick Detail Modal -->
        <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="modalOpen = false" class="bg-white dark:bg-zinc-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-gray-200 dark:border-zinc-800 relative space-y-4">
                <button @click="modalOpen = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 text-lg">✕</button>

                <template x-if="selectedMenu">
                    <div class="space-y-4">
                        <img :src="selectedMenu.image" class="w-full h-56 rounded-2xl object-cover shadow-md" />
                        
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[10px] font-bold text-kanca-teal uppercase" x-text="selectedMenu.category ? selectedMenu.category.name : 'Coffee'"></span>
                                <h3 class="text-xl font-extrabold text-kanca-dark dark:text-white" x-text="selectedMenu.name"></h3>
                            </div>
                            <span class="text-lg font-extrabold text-kanca-orange" x-text="'IDR ' + new Intl.NumberFormat('id-ID').format(selectedMenu.price)"></span>
                        </div>

                        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed" x-text="selectedMenu.description"></p>

                        <div class="p-4 rounded-2xl bg-kanca-bg dark:bg-zinc-800 text-xs space-y-1">
                            <p><strong>Ingredients:</strong> <span x-text="selectedMenu.ingredients || 'Standard House Blend Recipes'"></span></p>
                            <p><strong>Estimated Calories:</strong> <span x-text="(selectedMenu.calories || '150') + ' kcal'"></span></p>
                        </div>

                        <div class="pt-2 flex gap-3">
                            <button @click="toggleFavorite(selectedMenu.id)" class="flex-1 py-3 rounded-xl border border-rose-500 text-rose-500 font-bold text-xs hover:bg-rose-50 dark:hover:bg-rose-950 transition-colors">
                                ♥ Add to Favorites
                            </button>
                            <button @click="modalOpen = false" class="py-3 px-6 rounded-xl bg-kanca-dark text-white font-bold text-xs">
                                Close
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <script>
        function menuApp() {
            return {
                modalOpen: false,
                selectedMenu: null,
                openModal(menu) {
                    this.selectedMenu = menu;
                    this.modalOpen = true;
                },
                async toggleFavorite(menuId) {
                    try {
                        const res = await fetch(`/favorites/toggle/${menuId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();
                        if (res.status === 401) {
                            window.location.href = '/login';
                        } else {
                            alert(data.message);
                        }
                    } catch (e) {
                        console.error(e);
                    }
                }
            }
        }
    </script>
</x-app-layout>
