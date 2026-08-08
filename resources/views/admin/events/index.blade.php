<x-admin-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Community Events CRUD</h2>
                <p class="text-xs text-gray-500">Manage upcoming workshops, gigs, open mics, and seat quotas.</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="px-5 py-2.5 rounded-xl bg-kanca-teal text-white font-bold text-xs hover:bg-kanca-tealHover transition-all shadow-md">
                + Create Event
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Event Poster & Title</th>
                            <th class="p-4">Date & Time</th>
                            <th class="p-4">Speaker</th>
                            <th class="p-4">Quota (Registered/Total)</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($events as $ev)
                            <tr>
                                <td class="p-4 flex items-center gap-3">
                                    <img src="{{ $ev->poster }}" class="w-12 h-12 rounded-xl object-cover" />
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $ev->title }}</h4>
<span class="text-[10px] text-kanca-orange font-bold inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $ev->location }}</span>
                                    </div>
                                </td>
                                <td class="p-4 font-bold">{{ $ev->date ? $ev->date->format('d M Y') : '' }} <span class="block text-gray-400 font-normal">{{ $ev->start_time }} WIB</span></td>
                                <td class="p-4 font-semibold text-gray-700 dark:text-gray-300">{{ $ev->speaker_name ?? 'N/A' }}</td>
                                <td class="p-4 font-bold"><span class="text-kanca-teal">{{ $ev->registered_count }}</span> / {{ $ev->capacity }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $ev->status === 'upcoming' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $ev->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <a href="{{ route('admin.events.participants', $ev->id) }}" class="px-3 py-1.5 rounded-lg bg-kanca-teal/10 text-kanca-teal font-bold">Participants</a>
                                    <a href="{{ route('admin.events.edit', $ev->id) }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 font-bold">Edit</a>
                                    <form action="{{ route('admin.events.destroy', $ev->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this event?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-700 font-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-400">No events found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
