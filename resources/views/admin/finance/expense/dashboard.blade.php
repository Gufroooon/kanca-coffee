<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dashboard Expense (Pengeluaran)</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Visualisasi eksekutif alokasi biaya per kategori, sifat biaya (Fixed vs Variable), dan status pembayaran</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.expenses.create') }}" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm shadow-md transition-all flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Input Multi-Item Expense
                </a>
            </div>
        </div>

        <!-- Dynamic Time Filter Bar -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <form method="GET" action="{{ route('admin.finance.expense.dashboard') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-zinc-800 p-1.5 rounded-xl">
                    <button type="submit" name="time_filter" value="daily" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'daily' ? 'bg-rose-600 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Harian</button>
                    <button type="submit" name="time_filter" value="monthly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'monthly' ? 'bg-rose-600 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Bulanan</button>
                    <button type="submit" name="time_filter" value="quarterly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'quarterly' ? 'bg-rose-600 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Per 3 Bulan</button>
                    <button type="submit" name="time_filter" value="yearly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'yearly' ? 'bg-rose-600 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Tahunan</button>
                    <button type="submit" name="time_filter" value="custom" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'custom' ? 'bg-rose-600 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Custom</button>
                </div>

                @if($filterType === 'monthly')
                    <div class="flex items-center gap-2">
                        <select name="month" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>Bulan {{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                            @endforeach
                        </select>
                        <select name="year" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            @foreach(range(date('Y')-2, date('Y')+1) as $y)
                                <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif($filterType === 'quarterly')
                    <div class="flex items-center gap-2">
                        <select name="quarter" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            <option value="1" {{ (int)$quarter === 1 ? 'selected' : '' }}>Kuartal 1 (Q1: Jan-Mar)</option>
                            <option value="2" {{ (int)$quarter === 2 ? 'selected' : '' }}>Kuartal 2 (Q2: Apr-Jun)</option>
                            <option value="3" {{ (int)$quarter === 3 ? 'selected' : '' }}>Kuartal 3 (Q3: Jul-Sep)</option>
                            <option value="4" {{ (int)$quarter === 4 ? 'selected' : '' }}>Kuartal 4 (Q4: Okt-Des)</option>
                        </select>
                        <select name="year" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            @foreach(range(date('Y')-2, date('Y')+1) as $y)
                                <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif($filterType === 'yearly')
                    <select name="year" onchange="this.form.submit()" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                        @foreach(range(date('Y')-3, date('Y')+1) as $y)
                            <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                        @endforeach
                    </select>
                @elseif($filterType === 'custom')
                    <div class="flex items-center gap-2">
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        <span class="text-xs text-gray-400">s/d</span>
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-zinc-800 text-white text-xs font-bold">Terapkan</button>
                    </div>
                @endif

                <div class="ml-auto text-xs text-gray-500 font-semibold">
                    Periode Aktif: <span class="text-rose-600 font-bold">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</span>
                </div>
            </form>
        </div>

        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-gradient-to-br from-rose-600 to-red-800 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="trending-down" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-rose-100 tracking-wider">Total Expense Periodik</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-rose-100 mt-2 font-medium">Akumulasi Seluruh Subtotal 3</p>
            </div>

            <div class="bg-gradient-to-br from-amber-600 to-amber-800 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="package" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-amber-100 tracking-wider">Biaya Bahan Baku (OPS-BAH)</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format($totalBahanBaku, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-amber-100 mt-2 font-medium">Pengeluaran Bahan Baku Cafe</p>
            </div>

            <div class="bg-gradient-to-br from-indigo-600 to-violet-800 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="zap" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-indigo-100 tracking-wider">Utilities & Operasional</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format($totalUtilitiesOps, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-indigo-100 mt-2 font-medium">Listrik, Air, Wifi, Stationery, Mtc</p>
            </div>

            <div class="bg-gradient-to-br from-zinc-800 to-zinc-950 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden border border-zinc-700">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="clock" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-zinc-400 tracking-wider">Status Pembayaran</p>
                <div class="mt-2 space-y-1">
                    <p class="text-sm font-bold text-emerald-400">Lunas: Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
                    <p class="text-sm font-bold text-amber-400">Pending: Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Dynamic Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Bar Chart: Category Breakdown -->
            <div class="lg:col-span-2 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-5 h-5 text-rose-500"></i> Pengeluaran per Item Category
                </h3>
                <div class="h-72">
                    <canvas id="expenseCategoryChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart: Cost Category (Fixed vs Variable) -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-indigo-500"></i> Sifat Biaya (Fixed vs Variable)
                </h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="costCategoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Summary Expense Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden space-y-4">
            <div class="p-6 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="table" class="w-5 h-5 text-rose-500"></i> Tabel Summary Expense (Master Pengeluaran)
                </h3>
                <a href="{{ route('admin.expenses.index') }}" class="text-xs font-bold text-rose-600 dark:text-rose-400 hover:underline">Kelola & Input Detail →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Akun Holding</th>
                            <th class="px-6 py-4">Kode Referensi Pengeluaran</th>
                            <th class="px-6 py-4">Invoice #</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Judul Transaksi</th>
                            <th class="px-6 py-4">Supplier</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Jumlah Pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                        @forelse($summaryTable as $idx => $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4 text-gray-500">{{ $summaryTable->firstItem() + $idx }}</td>
                                <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-100 dark:bg-rose-900/40 text-rose-700 dark:text-rose-300">{{ $row->holding_account }}</span></td>
                                <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-gray-100">{{ $row->ref_number }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $row->invoice_number ?: '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $row->title }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $row->supplier?->name ?: '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($row->status === 'Lunas')
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">Lunas</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-extrabold text-rose-600 dark:text-rose-400">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-400">Belum ada data pengeluaran pada periode terpilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($summaryTable->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-zinc-800">
                    {{ $summaryTable->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bar Chart
            const ctxCat = document.getElementById('expenseCategoryChart').getContext('2d');
            const catLabels = {!! json_encode(array_keys($categoryBreakdown)) !!};
            const catValues = {!! json_encode(array_values($categoryBreakdown)) !!};

            new Chart(ctxCat, {
                type: 'bar',
                data: {
                    labels: catLabels,
                    datasets: [{
                        label: 'Total Pengeluaran (Rp)',
                        data: catValues,
                        backgroundColor: '#e11d48',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Pie Chart
            const ctxCost = document.getElementById('costCategoryChart').getContext('2d');
            const costLabels = {!! json_encode(array_keys($costCategoryBreakdown)) !!};
            const costValues = {!! json_encode(array_values($costCategoryBreakdown)) !!};

            new Chart(ctxCost, {
                type: 'pie',
                data: {
                    labels: costLabels,
                    datasets: [{
                        data: costValues,
                        backgroundColor: ['#6366f1', '#f43f5e']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        });
    </script>
</x-admin-layout>
