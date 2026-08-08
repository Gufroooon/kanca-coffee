<x-admin-layout>
    <div class="space-y-8">
        <!-- Top Quick Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Metric 1: Total Menus -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm flex items-center gap-4">
<div class="w-14 h-14 rounded-2xl bg-kanca-orange/10 text-kanca-orange flex items-center justify-center"><i data-lucide="coffee" class="w-7 h-7"></i></div>
                <div>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Active Menus</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalMenus }}</h3>
                </div>
            </div>

            <!-- Metric 2: Events -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm flex items-center gap-4">
<div class="w-14 h-14 rounded-2xl bg-kanca-teal/10 text-kanca-teal flex items-center justify-center"><i data-lucide="calendar" class="w-7 h-7"></i></div>
                <div>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Community Events</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalEvents }}</h3>
                </div>
            </div>

            <!-- Metric 3: Today's Staff Attendance -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm flex items-center gap-4">
<div class="w-14 h-14 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center"><i data-lucide="clock" class="w-7 h-7"></i></div>
                <div>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Today Attendances</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $todayAttendances }}</h3>
                </div>
            </div>

            <!-- Metric 4: Registered Users -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm flex items-center gap-4">
<div class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center"><i data-lucide="users" class="w-7 h-7"></i></div>
                <div>
                    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Total Accounts</span>
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>

        <!-- Attendance Chart & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Chart Container -->
            <div class="lg:col-span-8 bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-base text-gray-900 dark:text-white">Attendance Activity Trends</h3>
                        <p class="text-xs text-gray-400">Staff clock-in count over past 7 days</p>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <!-- Quick Action Cards -->
            <div class="lg:col-span-4 bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm space-y-4 flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-base text-gray-900 dark:text-white mb-2">Management Shortcuts</h3>
                    <p class="text-xs text-gray-400 mb-6">Perform quick updates or generate reports.</p>
                </div>

                <div class="space-y-3">
<a href="{{ route('admin.menus.create') }}" class="w-full py-3 px-4 rounded-2xl bg-kanca-orange text-white font-bold text-xs hover:bg-kanca-orangeHover transition-all flex items-center justify-between">
                        <span>+ Create New Menu Item</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="w-full py-3 px-4 rounded-2xl bg-kanca-teal text-white font-bold text-xs hover:bg-kanca-tealHover transition-all flex items-center justify-between">
                        <span>+ Host Community Event</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('admin.attendances.export.pdf') }}" class="w-full py-3 px-4 rounded-2xl bg-zinc-900 text-white font-bold text-xs hover:bg-black transition-all flex items-center justify-between">
                        <span class="inline-flex items-center gap-2"><i data-lucide="file-text" class="w-4 h-4"></i> Export Attendance PDF</span>
                        <i data-lucide="download" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Registrations & Recent Attendances Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Event Registrations -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">Recent Event Passes</h3>
                    <a href="{{ route('admin.events.index') }}" class="text-xs font-bold text-kanca-orange">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                            <tr>
                                <th class="p-3">Attendee</th>
                                <th class="p-3">Event</th>
                                <th class="p-3">QR Code</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($recentRegistrations as $reg)
                                <tr>
                                    <td class="p-3 font-bold">{{ $reg->name }}</td>
                                    <td class="p-3 text-gray-600 dark:text-gray-300">{{ $reg->event ? $reg->event->title : 'N/A' }}</td>
                                    <td class="p-3 font-mono font-bold text-kanca-teal">{{ $reg->qr_code }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-400">No registrations yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Today Staff Clock-Ins -->
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">Today Staff Clock-Ins</h3>
                    <a href="{{ route('admin.attendances.index') }}" class="text-xs font-bold text-kanca-teal">View Logs</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 uppercase font-bold">
                            <tr>
                                <th class="p-3">Staff Name</th>
                                <th class="p-3">Clock In</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($recentAttendances as $att)
                                <tr>
                                    <td class="p-3 font-bold">{{ $att->user ? $att->user->name : 'N/A' }}</td>
                                    <td class="p-3 font-semibold text-emerald-600">{{ $att->clock_in ?? '-' }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $att->status === 'late' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                            {{ $att->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-400">No staff clock-ins for today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartDates),
                    datasets: [{
                        label: 'Daily Staff Attendance',
                        data: @json($chartAttendanceData),
                        borderColor: '#EB5724',
                        backgroundColor: 'rgba(235, 87, 36, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-admin-layout>
