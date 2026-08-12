<x-admin-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Staff Management</h2>
                <p class="text-xs text-gray-500">Manage employee accounts, shifts, and staff access.</p>
            </div>
            <a href="{{ route('admin.staff.create') }}" class="px-5 py-2.5 rounded-xl bg-kanca-teal text-white font-bold text-xs hover:bg-kanca-tealHover transition-all shadow-md">+ Add Staff</a>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-gray-100 dark:border-zinc-800">
            <form action="{{ route('admin.staff.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search staff name, email, or phone..." class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <button class="px-5 py-2 rounded-xl bg-kanca-dark text-white text-xs font-bold">Search</button>
            </form>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Staff</th>
                            <th class="p-4">Phone</th>
                            <th class="p-4">Shift</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($staffMembers as $staff)
                            <tr>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/kanca-logo.jpg') }}" alt="{{ $staff->name }}" class="w-11 h-11 rounded-xl object-cover">
                                        <div>
                                            <p class="font-bold text-sm text-gray-900 dark:text-white">{{ $staff->name }}</p>
                                            <p class="text-gray-500">{{ $staff->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 font-semibold">{{ $staff->phone }}</td>
                                <td class="p-4 text-kanca-teal font-bold">{{ $staff->shift ?? 'Flexible' }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $staff->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ $staff->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <a href="{{ route('admin.staff.edit', $staff->id) }}" class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 font-bold">Edit</a>
                                    <form action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this staff account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-700 font-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-gray-400">No staff accounts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">{{ $staffMembers->links() }}</div>
        </div>
    </div>
</x-admin-layout>
