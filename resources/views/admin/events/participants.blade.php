<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.index') }}" class="text-xs font-bold text-gray-500 hover:text-kanca-orange">← Back to Events</a>
        </div>

        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Participants List: {{ $event->title }}</h2>
            <p class="text-xs text-gray-500">Registered community members and guest ticket passes.</p>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Phone</th>
                            <th class="p-4">Tickets Count</th>
                            <th class="p-4">QR Pass Code</th>
                            <th class="p-4">Registered Date</th>
                            <th class="p-4">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($registrations as $reg)
                            <tr>
                                <td class="p-4 font-bold">{{ $reg->name }}</td>
                                <td class="p-4 text-gray-600 dark:text-gray-300">{{ $reg->email }}</td>
                                <td class="p-4">{{ $reg->phone }}</td>
                                <td class="p-4 font-bold text-kanca-teal">{{ $reg->tickets_count }}</td>
                                <td class="p-4 font-mono font-bold text-kanca-orange">{{ $reg->qr_code }}</td>
                                <td class="p-4">{{ $reg->registered_at ? $reg->registered_at->format('d M Y H:i') : '' }}</td>
                                <td class="p-4 text-gray-500">{{ $reg->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-400">No participants registered for this event yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
