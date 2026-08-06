<x-admin-layout>
    <div class="space-y-8">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Website Settings and Gallery</h2>
            <p class="text-xs text-gray-500">Update public site content, announcement banner, contacts, and gallery assets.</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold mb-1">Announcement Banner</label>
                    <input name="announcement_banner" value="{{ old('announcement_banner', $settings['announcement_banner'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">WhatsApp Number</label>
                    <input name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '6281234567890') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Instagram URL</label>
                    <input name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? 'https://instagram.com/kancacoffee') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Weekday Hours</label>
                    <input name="weekday_hours" value="{{ old('weekday_hours', $settings['weekday_hours'] ?? '07:00 - 23:00 WIB') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Weekend Hours</label>
                    <input name="weekend_hours" value="{{ old('weekend_hours', $settings['weekend_hours'] ?? '07:00 - 24:00 WIB') }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
            </div>
            <button class="px-5 py-2.5 rounded-xl bg-kanca-orange text-white text-xs font-bold">Save Settings</button>
        </form>

        <section class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 p-6 space-y-6">
            <div>
                <h3 class="font-extrabold text-gray-900 dark:text-white">Add Gallery Item</h3>
                <p class="text-xs text-gray-500">Upload an image or use a remote image URL.</p>
            </div>
            <form action="{{ route('admin.settings.gallery.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                <input name="title" placeholder="Gallery title" required class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <select name="category" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                    <option value="ambiance">Ambiance</option>
                    <option value="coffee">Coffee</option>
                    <option value="community">Community</option>
                    <option value="event">Event</option>
                </select>
                <input type="file" name="image" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <input type="url" name="image_url" placeholder="https://images.unsplash.com/..." class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <textarea name="caption" rows="3" placeholder="Caption" class="sm:col-span-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white"></textarea>
                <button class="sm:col-span-2 px-5 py-2.5 rounded-xl bg-kanca-teal text-white text-xs font-bold">Add Gallery</button>
            </form>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($galleries as $gallery)
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-100 dark:border-zinc-800 overflow-hidden">
                    <img src="{{ $gallery->image }}" alt="{{ $gallery->title }}" class="w-full h-40 object-cover">
                    <div class="p-4 space-y-3">
                        <div>
                            <p class="font-bold text-sm text-gray-900 dark:text-white">{{ $gallery->title }}</p>
                            <p class="text-[10px] uppercase font-bold text-kanca-teal">{{ $gallery->category }}</p>
                        </div>
                        <form action="{{ route('admin.settings.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Delete this gallery item?')">
                            @csrf
                            @method('DELETE')
                            <button class="w-full py-2 rounded-xl bg-rose-100 text-rose-700 text-xs font-bold">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 rounded-2xl bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 text-center text-gray-400 text-sm">No gallery items yet.</div>
            @endforelse
        </section>
    </div>
</x-admin-layout>
