<x-admin-layout>
    <div class="max-w-3xl mx-auto bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-gray-100 dark:border-zinc-800 shadow-xl space-y-6">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Create Community Event</h2>
            <p class="text-xs text-gray-500">Host a workshop, acoustic gig, or coffee class.</p>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Event Title</label>
                <input type="text" name="title" required placeholder="Artisan Brew Masterclass" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Start Time</label>
                    <input type="text" name="start_time" value="15:00" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">End Time</label>
                    <input type="text" name="end_time" value="18:00" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Location</label>
                    <input type="text" name="location" value="Kanca Coffee Main Lounge" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Capacity Quota</label>
                    <input type="number" name="capacity" value="30" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Price (0 for Free)</label>
                    <input type="number" name="price" value="0" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Speaker Name</label>
                    <input type="text" name="speaker_name" placeholder="Fajar Nugraha" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Speaker Title</label>
                    <input type="text" name="speaker_title" placeholder="Head Roaster & Barista" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Poster Image URL or Upload</label>
                <input type="url" name="poster_url" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white mb-2">
                <input type="file" name="poster" class="w-full text-xs text-gray-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Event Description</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white"></textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="is_featured" value="1"> Feature on Home & Community Header
                </label>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="py-3 px-6 rounded-xl bg-kanca-teal text-white font-bold text-xs hover:bg-kanca-tealHover">
                    Save Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="py-3 px-6 rounded-xl border border-gray-300 text-xs font-bold">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
