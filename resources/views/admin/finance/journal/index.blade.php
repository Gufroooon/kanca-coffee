<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Jurnal Keuangan & Cashflow</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ledger keuangan otomatis yang mencatat transaksi Pemasukan (Kredit) dan Pengeluaran (Debit)</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports.index') }}?report_type=journal" class="px-4 py-2.5 rounded-xl bg-zinc-800 hover:bg-zinc-900 text-white font-bold text-xs flex items-center gap-2 shadow">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Cetak / Ekspor Jurnal
                </a>
            </div>
        </div>

        <!-- Dynamic Time Filter Bar -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <form method="GET" action="{{ route('admin.finance.journal.index') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2 bg-gray-100 dark:bg-zinc-800 p-1.5 rounded-xl">
                    <button type="submit" name="time_filter" value="daily" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'daily' ? 'bg-zinc-900 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Harian</button>
                    <button type="submit" name="time_filter" value="monthly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'monthly' ? 'bg-zinc-900 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Bulanan</button>
                    <button type="submit" name="time_filter" value="quarterly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'quarterly' ? 'bg-zinc-900 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Per 3 Bulan</button>
                    <button type="submit" name="time_filter" value="yearly" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'yearly' ? 'bg-zinc-900 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Tahunan</button>
                    <button type="submit" name="time_filter" value="custom" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $filterType === 'custom' ? 'bg-zinc-900 text-white shadow' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">Custom</button>
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
                    Periode: <span class="text-gray-900 dark:text-white font-bold">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</span>
                </div>
            </form>
        </div>

        <!-- Cashflow Overview Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase">Total Pemasukan (Kredit)</span>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase">Total Pengeluaran (Debit)</span>
                <p class="text-2xl font-black text-rose-600 dark:text-rose-400 mt-2">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase">Net Cashflow Periodik</span>
                <p class="text-2xl font-black mt-2 {{ $netCashflow >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">Rp {{ number_format($netCashflow, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Journal Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden space-y-4">
            <div class="p-6 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="book-open" class="w-5 h-5 text-indigo-500"></i> Jurnal Keuangan - Kanca Coffee
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Akun Holding</th>
                            <th class="px-6 py-4">Kode Referensi</th>
                            <th class="px-6 py-4">Deskripsi / Keterangan</th>
                            <th class="px-6 py-4 text-right">Debit (Expense)</th>
                            <th class="px-6 py-4 text-right">Kredit (Income)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                        @forelse($entries as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">{{ $row->entry_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $row->holding_account === 'INC' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $row->holding_account }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-white">{{ $row->ref_number }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $row->description }}</td>
                                <td class="px-6 py-4 text-right font-bold text-rose-600 dark:text-rose-400">
                                    {{ $row->debit > 0 ? 'Rp ' . number_format($row->debit, 0, ',', '.') : 'Rp 0' }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-emerald-600 dark:text-emerald-400">
                                    {{ $row->credit > 0 ? 'Rp ' . number_format($row->credit, 0, ',', '.') : 'Rp 0' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada jurnal transaksi pada periode terpilih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-100 dark:bg-zinc-800 font-extrabold text-sm">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right uppercase">Grand Total Jurnal:</td>
                            <td class="px-6 py-4 text-right text-rose-600 dark:text-rose-400">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right text-emerald-600 dark:text-emerald-400">Rp {{ number_format($totalCredit, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @if($entries->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-zinc-800">
                    {{ $entries->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
