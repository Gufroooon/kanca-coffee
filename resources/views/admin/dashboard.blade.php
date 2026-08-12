<x-admin-layout>
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div><p class="text-sm text-kanca-orange font-bold uppercase tracking-wider">Operational Overview</p><h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Dashboard Cafe</h2><p class="text-sm text-gray-500">Ringkasan inventory dan keuangan per {{ now()->format('d M Y') }}.</p></div>
            <div class="flex flex-wrap gap-2"><a href="{{ route('admin.ingredients.index') }}" class="px-3 py-2 rounded-xl bg-kanca-orange text-white text-xs font-bold">Kelola Bahan</a><a href="{{ route('admin.cashflows.index', 'income') }}" class="px-3 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold">Tambah Pemasukan</a><a href="{{ route('admin.cashflows.index', 'expense') }}" class="px-3 py-2 rounded-xl bg-rose-600 text-white text-xs font-bold">Tambah Pengeluaran</a></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-gray-100 dark:border-zinc-800"><p class="text-xs uppercase font-bold text-gray-500">Total Bahan</p><p class="text-2xl font-extrabold mt-2">{{ $totalIngredients }}</p><p class="text-xs text-gray-400 mt-1">{{ number_format((float) $totalStock, 3, ',', '.') }} unit stok tersedia</p></div>
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-gray-100 dark:border-zinc-800"><p class="text-xs uppercase font-bold text-gray-500">Usage Hari Ini</p><p class="text-2xl font-extrabold mt-2 text-kanca-orange">{{ number_format((float) $todayUsage, 3, ',', '.') }}</p><p class="text-xs text-gray-400 mt-1">{{ $todayInventoryLogs }} inventory log</p></div>
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-gray-100 dark:border-zinc-800"><p class="text-xs uppercase font-bold text-gray-500">Pemasukan Hari Ini</p><p class="text-2xl font-extrabold mt-2 text-emerald-600">Rp {{ number_format((float) $todayIncome, 0, ',', '.') }}</p><p class="text-xs text-gray-400 mt-1">{{ $todayTransactions }} transaksi</p></div>
            <div class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-gray-100 dark:border-zinc-800"><p class="text-xs uppercase font-bold text-gray-500">Profit Hari Ini</p><p class="text-2xl font-extrabold mt-2 {{ $todayIncome - $todayExpense >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">Rp {{ number_format((float) ($todayIncome - $todayExpense), 0, ',', '.') }}</p><p class="text-xs text-gray-400 mt-1">Pengeluaran Rp {{ number_format((float) $todayExpense, 0, ',', '.') }}</p></div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800"><div class="flex justify-between items-center mb-4"><div><h3 class="font-bold">Trend Keuangan 7 Hari</h3><p class="text-xs text-gray-400">Income vs expense berdasarkan database</p></div><a href="{{ route('admin.finance.summary') }}" class="text-xs font-bold text-kanca-teal">Detail</a></div><div class="h-64"><canvas id="financeChart"></canvas></div></div>
            <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 border border-gray-100 dark:border-zinc-800"><div class="flex justify-between items-center mb-4"><h3 class="font-bold">Low Stock Alert</h3><a href="{{ route('admin.ingredients.index', ['status' => 'active']) }}" class="text-xs font-bold text-kanca-orange">Inventory</a></div><div class="space-y-3">@forelse($lowStockIngredients as $ingredient)<div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-rose-50 dark:bg-rose-900/20"><div><p class="font-bold text-sm">{{ $ingredient->name }}</p><p class="text-xs text-gray-500">Min. {{ $ingredient->minimum_stock }} {{ $ingredient->unit }}</p></div><span class="text-xs font-extrabold text-rose-600">{{ $ingredient->current_stock }} {{ $ingredient->unit }}</span></div>@empty<p class="text-sm text-gray-500">Semua stok berada di atas batas minimum.</p>@endforelse</div></div>
        </div>
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
            const finance = document.getElementById('financeChart');
            if (finance) new Chart(finance.getContext('2d'), { type: 'bar', data: { labels: @json($financialDates), datasets: [{ label: 'Income', data: @json($incomeTrend), backgroundColor: '#28A096' }, { label: 'Expense', data: @json($expenseTrend), backgroundColor: '#EB5724' }] }, options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } } });
        });
    </script>
</x-admin-layout>
