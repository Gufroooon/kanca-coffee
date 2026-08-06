<x-admin-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Attendance Reports</h2>
                <p class="text-xs text-gray-500">Filter staff attendance and export PDF or CSV reports.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.attendances.export.pdf', request()->query()) }}" class="px-4 py-2.5 rounded-xl bg-kanca-orange text-white text-xs font-bold">Export PDF</a>
                <a href="{{ route('admin.attendances.export.excel', request()->query()) }}" class="px-4 py-2.5 rounded-xl bg-kanca-teal text-white text-xs font-bold">Export CSV</a>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-gray-100 dark:border-zinc-800">
            <form action="{{ route('admin.attendances.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <input type="date" name="date" value="{{ request('date') }}" class="sm:col-span-3 px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                <select name="user_id" class="sm:col-span-4 px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                    <option value="">All Staff</option>
                    @foreach($staffList as $staff)
                        <option value="{{ $staff->id }}" {{ request('user_id') == $staff->id ? 'selected' : '' }}>{{ $staff->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="sm:col-span-3 px-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-700 text-xs dark:bg-zinc-800 dark:text-white">
                    <option value="">All Status</option>
                    @foreach(['present', 'late', 'leave', 'permission'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="sm:col-span-2 px-5 py-2 rounded-xl bg-kanca-dark text-white text-xs font-bold">Apply</button>
            </form>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                        <tr>
                            <th class="p-4">Date</th>
                            <th class="p-4">Employee</th>
                            <th class="p-4">Clock In</th>
                            <th class="p-4">Clock Out</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($attendances as $attendance)
                            <tr>
                                <td class="p-4 font-bold">{{ $attendance->date ? $attendance->date->format('d M Y') : '-' }}</td>
                                <td class="p-4">{{ $attendance->user->name ?? 'Deleted user' }}</td>
                                <td class="p-4 text-kanca-teal font-bold">{{ $attendance->clock_in ?? '-' }}</td>
                                <td class="p-4 text-kanca-orange font-bold">{{ $attendance->clock_out ?? '-' }}</td>
                                <td class="p-4"><span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-zinc-800 text-[10px] font-bold uppercase">{{ $attendance->status }}</span></td>
                                <td class="p-4 text-gray-500">{{ $attendance->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-8 text-center text-gray-400">No attendance records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-100 dark:border-zinc-800">{{ $attendances->links() }}</div>
        </div>
    </div>
</x-admin-layout>
