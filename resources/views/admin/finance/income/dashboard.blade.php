<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dashboard Income (Pemasukan)</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Visualisasi eksekutif performa omset Majoo POS (6 Channel) & GoBiz Online Delivery</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.income.index') }}" class="px-4 py-2.5 rounded-xl bg-kanca-orange hover:bg-amber-600 text-white font-bold text-sm shadow-md transition-all flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Input Data Income
                </a>
            </div>
        </div>

        <!-- Dynamic Time Filter Bar -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <form method="GET" action="{{ route('admin.finance.income.dashboard') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-zinc-800 p-1.5 rounded-xl">
                    <button type="submit" name="time_filter" value="daily" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'daily' ? 'bg-kanca-orange text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Harian</button>
                    <button type="submit" name="time_filter" value="monthly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'monthly' ? 'bg-kanca-orange text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Bulanan</button>
                    <button type="submit" name="time_filter" value="quarterly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'quarterly' ? 'bg-kanca-orange text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Per 3 Bulan</button>
                    <button type="submit" name="time_filter" value="yearly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'yearly' ? 'bg-kanca-orange text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Tahunan</button>
                    <button type="submit" name="time_filter" value="custom" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'custom' ? 'bg-kanca-orange text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Custom</button>
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
                    Periode Aktif: <span class="text-kanca-orange font-bold">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</span>
                </div>
            </form>
        </div>

        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-700 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="dollar-sign" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-emerald-100 tracking-wider">Total Income Periodik</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-emerald-100 mt-2 font-medium">Gabungan Majoo POS & GoBiz</p>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="store" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-amber-100 tracking-wider">Total Omset Majoo POS</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format($totalMajoo, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-amber-100 mt-2 font-medium">6 Channel Pembayaran Kasir</p>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-indigo-800 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="truck" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-blue-100 tracking-wider">Total Omset GoBiz</p>
                <h3 class="text-2xl font-black mt-2">Rp {{ number_format($totalGobiz, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-blue-100 mt-2 font-medium">Penjualan Bersih Online Delivery</p>
            </div>

            <div class="bg-gradient-to-br from-zinc-800 to-zinc-950 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden border border-zinc-700">
                <div class="absolute -right-4 -bottom-4 opacity-20"><i data-lucide="scale" class="w-32 h-32"></i></div>
                <p class="text-xs uppercase font-bold text-zinc-400 tracking-wider">Net Cashflow</p>
                <h3 class="text-2xl font-black mt-2 {{ $netCashflow >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">Rp {{ number_format($netCashflow, 0, ',', '.') }}</h3>
                <p class="text-[11px] text-zinc-400 mt-2 font-medium">Income Dikurangi Expense Periodik</p>
            </div>
        </div>

        <!-- Dynamic Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Line Chart: Majoo vs GoBiz -->
            <div class="lg:col-span-2 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="line-chart" class="w-5 h-5 text-kanca-orange"></i> Tren Omset (Majoo vs GoBiz)
                    </h3>
                </div>
                <div class="h-72">
                    <canvas id="incomeTrendChart"></canvas>
                </div>
            </div>

            <!-- Doughnut Chart: Majoo 6 Channels -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-5 h-5 text-amber-500"></i> Kontribusi Channel Majoo
                </h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="channelDoughnutChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Summary Income Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden space-y-4">
            <div class="p-6 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="table" class="w-5 h-5 text-emerald-500"></i> Tabel Summary Income (Master Pemasukan)
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4">No.</th>
                            <th class="px-6 py-4">Akun Holding</th>
                            <th class="px-6 py-4">Kode Referensi Pemasukan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Tipe Channel</th>
                            <th class="px-6 py-4 text-right">Jumlah Pemasukan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                        @forelse($summaryTable as $idx => $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4 text-gray-500">{{ $summaryTable->firstItem() + $idx }}</td>
                                <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300">{{ $row->holding_account }}</span></td>
                                <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-gray-100">{{ $row->ref_number }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($row->type === 'MJO')
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">Majoo POS (6-Ch)</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300">GoBiz Online</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada data pemasukan pada periode terpilih.</td>
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
            // Line Chart
            const ctxTrend = document.getElementById('incomeTrendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: {!! json_encode($allDates) !!},
                    datasets: [
                        {
                            label: 'Majoo POS',
                            data: {!! json_encode($majooLineData) !!},
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'GoBiz Online',
                            data: {!! json_encode($gobizLineData) !!},
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Doughnut Chart
            const ctxChannel = document.getElementById('channelDoughnutChart').getContext('2d');
            const channelLabels = {!! json_encode(array_keys($channelBreakdown)) !!};
            const channelValues = {!! json_encode(array_values($channelBreakdown)) !!};

            new Chart(ctxChannel, {
                type: 'doughnut',
                data: {
                    labels: channelLabels,
                    datasets: [{
                        data: channelValues,
                        backgroundColor: [
                            '#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#ec4899', '#64748b'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } } }
                }
            });
        });
    </script>
</x-admin-layout>
