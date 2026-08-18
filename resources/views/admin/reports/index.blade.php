<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Pelaporan & Dynamic Filter</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Modul pelaporan terpadu Kanca Coffee dengan opsi filter waktu fleksibel dan ekspor resmi (PDF Siap Cetak & Excel .xlsx/.xls)</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs flex items-center gap-2 shadow">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Ekspor PDF Siap Cetak
                </a>
                <a href="{{ route('admin.reports.export.excel', request()->all()) }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 shadow">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> Ekspor Excel Spreadsheet
                </a>
            </div>
        </div>

        <!-- Filter Controls Bar -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-center">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tipe Laporan</label>
                    <select name="report_type" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-bold">
                        <option value="income" {{ $reportType === 'income' ? 'selected' : '' }}>Laporan Pemasukan (Income)</option>
                        <option value="expense" {{ $reportType === 'expense' ? 'selected' : '' }}>Laporan Pengeluaran (Expense)</option>
                        <option value="journal" {{ $reportType === 'journal' ? 'selected' : '' }}>Laporan Jurnal Keuangan</option>
                        <option value="inventory" {{ $reportType === 'inventory' ? 'selected' : '' }}>Laporan Inventori & Konsumsi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Opsi Waktu Filter</label>
                    <select name="time_filter" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-bold">
                        <option value="daily" {{ $filterType === 'daily' ? 'selected' : '' }}>Harian (Daily)</option>
                        <option value="monthly" {{ $filterType === 'monthly' ? 'selected' : '' }}>Bulanan (Monthly)</option>
                        <option value="quarterly" {{ $filterType === 'quarterly' ? 'selected' : '' }}>Per 3 Bulan (Quarterly Q1-Q4)</option>
                        <option value="yearly" {{ $filterType === 'yearly' ? 'selected' : '' }}>Tahunan (Yearly)</option>
                        <option value="custom" {{ $filterType === 'custom' ? 'selected' : '' }}>Custom Date Range</option>
                    </select>
                </div>

                @if($filterType === 'monthly')
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pilih Bulan</label>
                        <select name="month" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif($filterType === 'quarterly')
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pilih Kuartal</label>
                        <select name="quarter" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            <option value="1" {{ (int)$quarter === 1 ? 'selected' : '' }}>Q1 (Jan - Mar)</option>
                            <option value="2" {{ (int)$quarter === 2 ? 'selected' : '' }}>Q2 (Apr - Jun)</option>
                            <option value="3" {{ (int)$quarter === 3 ? 'selected' : '' }}>Q3 (Jul - Sep)</option>
                            <option value="4" {{ (int)$quarter === 4 ? 'selected' : '' }}>Q4 (Okt - Des)</option>
                        </select>
                    </div>
                @else
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tahun / Sampai Tgl</label>
                    @if(in_array($filterType, ['monthly', 'quarterly', 'yearly']))
                        <select name="year" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            @foreach(range(date('Y')-3, date('Y')+1) as $y)
                                <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-bold opacity-0 mb-1">Submit</label>
                    <button type="submit" class="w-full py-2 rounded-xl bg-kanca-orange hover:bg-amber-600 text-white font-bold text-xs shadow">Tampilkan Laporan</button>
                </div>
            </form>
        </div>

        <!-- Report Table Section -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden space-y-4">
            <div class="p-6 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white uppercase tracking-tight">Pratinjau Laporan: {{ strtoupper($reportType) }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Periode Laporan: <span class="font-bold text-kanca-orange">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</span></p>
                </div>
            </div>

            <div class="overflow-x-auto">
                @if($reportType === 'income')
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">No.</th>
                                <th class="px-6 py-4">Akun Holding</th>
                                <th class="px-6 py-4">No. Referensi</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Tipe Channel</th>
                                <th class="px-6 py-4 text-right">Jumlah Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @forelse($incomeRows as $idx => $row)
                                <tr>
                                    <td class="px-6 py-4 text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">{{ $row->holding_account }}</span></td>
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-white">{{ $row->ref_number }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">{{ $row->type === 'MJO' ? 'Majoo POS (6-Ch)' : 'GoBiz Online' }}</td>
                                    <td class="px-6 py-4 text-right font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data pemasukan pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @elseif($reportType === 'expense')
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">No.</th>
                                <th class="px-6 py-4">Akun Holding</th>
                                <th class="px-6 py-4">No. Referensi</th>
                                <th class="px-6 py-4">Invoice #</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Judul Transaksi</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Total Subtotal 3</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @forelse($expenseRows as $idx => $row)
                                <tr>
                                    <td class="px-6 py-4 text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-800">{{ $row->holding_account }}</span></td>
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-white">{{ $row->ref_number }}</td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $row->invoice_number ?: '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $row->title }}</td>
                                    <td class="px-6 py-4">{{ $row->status }}</td>
                                    <td class="px-6 py-4 text-right font-extrabold text-rose-600 dark:text-rose-400">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-400">Tidak ada data pengeluaran pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @elseif($reportType === 'journal')
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">No.</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Kode Referensi</th>
                                <th class="px-6 py-4">Akun Holding</th>
                                <th class="px-6 py-4 text-right">Debit (Expense)</th>
                                <th class="px-6 py-4 text-right">Kredit (Income)</th>
                                <th class="px-6 py-4">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @forelse($journalRows as $idx => $row)
                                <tr>
                                    <td class="px-6 py-4 text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->entry_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-white">{{ $row->ref_number }}</td>
                                    <td class="px-6 py-4 font-bold">{{ $row->holding_account }}</td>
                                    <td class="px-6 py-4 text-right text-rose-600 font-bold">Rp {{ number_format($row->debit, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-emerald-600 font-bold">Rp {{ number_format($row->credit, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $row->description }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada jurnal pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">No.</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Bahan Baku</th>
                                <th class="px-6 py-4">Opening Stock</th>
                                <th class="px-6 py-4">Closing Stock</th>
                                <th class="px-6 py-4">Usage (Konsumsi)</th>
                                <th class="px-6 py-4">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @forelse($inventoryLogs as $idx => $row)
                                <tr>
                                    <td class="px-6 py-4 text-gray-500">{{ $idx + 1 }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->log_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $row->ingredient?->name }}</td>
                                    <td class="px-6 py-4">{{ number_format($row->opening_stock, 2) }}</td>
                                    <td class="px-6 py-4">{{ number_format($row->closing_stock, 2) }}</td>
                                    <td class="px-6 py-4 font-bold text-rose-600">{{ number_format($row->usage, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $row->ingredient?->unit }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Tidak ada histori stok pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
