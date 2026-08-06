<x-admin-layout>
    <div class="max-w-3xl space-y-6">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Create Staff Account</h2>
            <p class="text-xs text-gray-500">Register a new employee with staff portal access.</p>
        </div>

        <form action="{{ route('admin.staff.store') }}" method="POST" class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold mb-1">Name</label>
                    <input name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Phone</label>
                    <input name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Shift</label>
                    <select name="shift" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
            </div>
            <div class="flex gap-3">
                <button class="px-5 py-2.5 rounded-xl bg-kanca-teal text-white text-xs font-bold">Create Staff</button>
                <a href="{{ route('admin.staff.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-zinc-800 text-xs font-bold">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
