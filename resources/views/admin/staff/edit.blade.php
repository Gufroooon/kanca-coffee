<x-admin-layout>
    <div class="max-w-3xl space-y-6">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Edit Staff Account</h2>
            <p class="text-xs text-gray-500">Update employee profile, shift, status, or password.</p>
        </div>

        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold mb-1">Name</label>
                    <input name="name" value="{{ old('name', $staff->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $staff->email) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Phone</label>
                    <input name="phone" value="{{ old('phone', $staff->phone) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">Shift</label>
                    <select name="shift" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                        @foreach(['Morning', 'Afternoon', 'Evening', 'Flexible'] as $shift)
                            <option value="{{ $shift }}" {{ old('shift', $staff->shift) === $shift ? 'selected' : '' }}>{{ $shift }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold mb-1">New Password</label>
                    <input type="password" name="password" placeholder="Leave empty to keep current" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                </div>
                <label class="flex items-center gap-2 text-xs font-bold pt-7">
                    <input type="checkbox" name="is_active" value="1" {{ $staff->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-kanca-teal">
                    Active account
                </label>
            </div>
            <div class="flex gap-3">
                <button class="px-5 py-2.5 rounded-xl bg-kanca-teal text-white text-xs font-bold">Save Changes</button>
                <a href="{{ route('admin.staff.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-zinc-800 text-xs font-bold">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
