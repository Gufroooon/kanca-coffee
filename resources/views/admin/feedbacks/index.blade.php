<x-admin-layout>
    <div class="space-y-8">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Feedbacks and Inbox</h2>
            <p class="text-xs text-gray-500">Review customer feedback and incoming contact messages.</p>
        </div>

        <section class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 dark:border-zinc-800 flex justify-between items-center">
                <h3 class="font-extrabold text-gray-900 dark:text-white">Customer Feedback</h3>
                <span class="text-xs text-gray-400">{{ $feedbacks->total() }} records</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Rating</th>
                            <th class="p-4">Message</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($feedbacks as $feedback)
                            <tr>
                                <td class="p-4">
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $feedback->name ?? $feedback->user->name ?? 'Guest' }}</p>
                                    <p class="text-gray-500">{{ $feedback->email ?? $feedback->user->email ?? '-' }}</p>
                                </td>
                                <td class="p-4 font-bold text-kanca-teal">{{ ucfirst($feedback->category) }}</td>
                                <td class="p-4 font-bold text-amber-500">{{ $feedback->rating }} / 5</td>
                                <td class="p-4 max-w-md text-gray-600 dark:text-gray-300">{{ $feedback->message }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $feedback->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">{{ $feedback->status }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('admin.feedbacks.toggle-status', $feedback->id) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-lg bg-kanca-orange text-white font-bold">{{ $feedback->status === 'published' ? 'Hide' : 'Publish' }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-8 text-center text-gray-400">No feedback submitted yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">{{ $feedbacks->links() }}</div>
        </section>

        <section class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 dark:border-zinc-800 flex justify-between items-center">
                <h3 class="font-extrabold text-gray-900 dark:text-white">Contact Messages</h3>
                <span class="text-xs text-gray-400">{{ $contactMessages->total() }} messages</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Sender</th>
                            <th class="p-4">Subject</th>
                            <th class="p-4">Message</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($contactMessages as $message)
                            <tr>
                                <td class="p-4">
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $message->name }}</p>
                                    <p class="text-gray-500">{{ $message->email }}</p>
                                    <p class="text-gray-400">{{ $message->phone ?? '-' }}</p>
                                </td>
                                <td class="p-4 font-bold">{{ $message->subject }}</td>
                                <td class="p-4 max-w-md text-gray-600 dark:text-gray-300">{{ $message->message }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $message->is_read ? 'bg-gray-100 text-gray-800' : 'bg-kanca-orange/10 text-kanca-orange' }}">{{ $message->is_read ? 'Read' : 'Unread' }}</span>
                                </td>
                                <td class="p-4 text-right">
                                    @unless($message->is_read)
                                        <form action="{{ route('admin.messages.mark-read', $message->id) }}" method="POST">
                                            @csrf
                                            <button class="px-3 py-1.5 rounded-lg bg-kanca-teal text-white font-bold">Mark Read</button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-gray-400">No contact messages yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">{{ $contactMessages->links() }}</div>
        </section>
    </div>
</x-admin-layout>
