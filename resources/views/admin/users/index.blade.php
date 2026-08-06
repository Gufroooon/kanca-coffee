<x-admin-layout>
    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">User Accounts</h2>
            <p class="text-xs text-gray-500">Manage roles, activation status, and password resets.</p>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-gray-100 dark:border-zinc-800">
            <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search user name or email..." class="sm:col-span-7 px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <select name="role_id" class="sm:col-span-3 px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                <button class="sm:col-span-2 px-5 py-2 rounded-xl bg-kanca-dark text-white text-xs font-bold">Filter</button>
            </form>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">User</th>
                            <th class="p-4">Role</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Change Role</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($users as $user)
                            <tr>
                                <td class="p-4">
                                    <p class="font-bold text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-gray-500">{{ $user->email }}</p>
                                </td>
                                <td class="p-4 font-bold text-kanca-teal">{{ $user->role->name ?? 'No role' }}</td>
                                <td class="p-4">
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $user->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</button>
                                    </form>
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="role_id" class="px-3 py-1.5 rounded-lg border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="px-3 py-1.5 rounded-lg bg-kanca-teal text-white font-bold">Save</button>
                                    </form>
                                </td>
                                <td class="p-4 text-right">
                                    <details class="inline-block text-left">
                                        <summary class="cursor-pointer px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 font-bold list-none">Reset Password</summary>
                                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="absolute right-8 mt-2 w-72 bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-2xl p-4 shadow-xl space-y-3 z-10">
                                            @csrf
                                            <input type="password" name="password" placeholder="New password" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                                            <input type="password" name="password_confirmation" placeholder="Confirm password" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                                            <button class="w-full py-2 rounded-lg bg-kanca-orange text-white font-bold">Update Password</button>
                                        </form>
                                    </details>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-lg bg-rose-100 text-rose-700 font-bold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-8 text-center text-gray-400">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">{{ $users->links() }}</div>
        </div>
    </div>
</x-admin-layout>
