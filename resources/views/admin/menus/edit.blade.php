<x-admin-layout>
    <div class="max-w-3xl mx-auto bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-gray-100 dark:border-zinc-800 shadow-xl space-y-6">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Edit Menu Item: {{ $menu->name }}</h2>
            <p class="text-xs text-gray-500">Update pricing, description, or ingredients.</p>
        </div>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Item Name</label>
                    <input type="text" name="name" value="{{ $menu->name }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Category</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $menu->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Price (IDR)</label>
                    <input type="number" name="price" value="{{ $menu->price }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Estimated Calories (kcal)</label>
                    <input type="number" name="calories" value="{{ $menu->calories }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Image URL or File Upload</label>
                <input type="url" name="image_url" value="{{ $menu->image }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white mb-2">
                <input type="file" name="image" class="w-full text-xs text-gray-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">{{ $menu->description }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Ingredients</label>
                <input type="text" name="ingredients" value="{{ $menu->ingredients }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
            </div>

            <div class="flex gap-6 pt-2">
                <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_bestseller" value="1" {{ $menu->is_bestseller ? 'checked' : '' }}> Best Seller Badge
                </label>
                <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_new" value="1" {{ $menu->is_new ? 'checked' : '' }}> New Badge
                </label>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="py-3 px-6 rounded-xl bg-kanca-orange text-white font-bold text-xs hover:bg-kanca-orangeHover">
                    Update Menu Item
                </button>
                <a href="{{ route('admin.menus.index') }}" class="py-3 px-6 rounded-xl border border-gray-300 text-xs font-bold">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
