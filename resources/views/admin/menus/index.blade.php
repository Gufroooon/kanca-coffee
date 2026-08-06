<x-admin-layout>
    <div class="space-y-6">
        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Menu Catalog CRUD</h2>
                <p class="text-xs text-gray-500">Manage coffee recipes, pricing, ingredients, and availability.</p>
            </div>
            <a href="{{ route('admin.menus.create') }}" class="px-5 py-2.5 rounded-xl bg-kanca-orange text-white font-bold text-xs hover:bg-kanca-orangeHover transition-all shadow-md">
                + Create New Menu
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-gray-100 dark:border-zinc-800 flex flex-col sm:flex-row gap-4">
            <form action="{{ route('admin.menus.index') }}" method="GET" class="flex-grow flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search menu name..." class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <select name="category_id" onchange="this.form.submit()" class="px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl bg-kanca-dark text-white text-xs font-bold">Filter</button>
            </form>
        </div>

        <!-- Menu Items Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Item</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Rating</th>
                            <th class="p-4">Availability</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($menus as $menu)
                            <tr>
                                <td class="p-4 flex items-center gap-3">
                                    <img src="{{ $menu->image }}" class="w-12 h-12 rounded-xl object-cover" />
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $menu->name }}</h4>
                                        <div class="flex gap-1 mt-0.5">
                                            @if($menu->is_bestseller)<span class="text-[9px] px-2 py-0.5 rounded bg-kanca-orange text-white font-bold">BESTSELLER</span>@endif
                                            @if($menu->is_new)<span class="text-[9px] px-2 py-0.5 rounded bg-kanca-teal text-white font-bold">NEW</span>@endif
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold text-kanca-teal">{{ $menu->category->name }}</td>
                                <td class="p-4 font-bold text-gray-900 dark:text-white">IDR {{ number_format($menu->price, 0, ',', '.') }}</td>
                                <td class="p-4 font-bold text-amber-500">★ {{ number_format($menu->rating, 2) }}</td>
                                <td class="p-4">
                                    <form action="{{ route('admin.menus.toggle-availability', $menu->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $menu->is_available ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $menu->is_available ? 'Available' : 'Sold Out' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 font-bold hover:bg-gray-200">Edit</a>
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this menu item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-700 font-bold hover:bg-rose-200">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-400">No menu items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
