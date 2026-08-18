<x-admin-layout>
    <div class="space-y-8" x-data="{ activeTab: '{{ $tab }}' }">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Database & Entry Income</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pencatatan rincian 6 channel pembayaran Majoo POS & Form Entry Penjualan Bersih GoBiz</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.finance.income.dashboard') }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 font-bold text-xs hover:bg-gray-200">
                    ← Kembalil ke Dashboard Income
                </a>
            </div>
        </div>

        <!-- Filter Date Bar -->
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-wrap items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.income.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="tab" :value="activeTab">
                <span class="text-xs font-bold text-gray-500">Filter Tanggal:</span>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                <span class="text-xs text-gray-400">s/d</span>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                <button type="submit" class="px-3 py-1.5 rounded-xl bg-kanca-orange text-white text-xs font-bold shadow">Terapkan Filter</button>
            </form>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 dark:border-zinc-800 pb-2">
            <button @click="activeTab = 'cash'" :class="activeTab === 'cash' ? 'bg-kanca-orange text-white shadow-lg' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i data-lucide="banknote" class="w-4 h-4"></i> 1. Cash Kasir
            </button>
            <button @click="activeTab = 'transfer'" :class="activeTab === 'transfer' ? 'bg-kanca-orange text-white shadow-lg' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i data-lucide="arrow-right-left" class="w-4 h-4"></i> 2. Bank Transfer
            </button>
            <button @click="activeTab = 'qris_cetak'" :class="activeTab === 'qris_cetak' ? 'bg-kanca-orange text-white shadow-lg' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i data-lucide="qr-code" class="w-4 h-4"></i> 3. QRIS Cetak
            </button>
            <button @click="activeTab = 'edc'" :class="activeTab === 'edc' ? 'bg-kanca-orange text-white shadow-lg' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4"></i> 4,5,6. EDC (QRIS/Debit/Kredit) & Impor
            </button>
            <button @click="activeTab = 'gobiz'" :class="activeTab === 'gobiz' ? 'bg-kanca-orange text-white shadow-lg' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i data-lucide="shopping-bag" class="w-4 h-4"></i> GoBiz Online
            </button>
            <button @click="activeTab = 'summary'" :class="activeTab === 'summary' ? 'bg-kanca-orange text-white shadow-lg' : 'bg-white dark:bg-zinc-900 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                <i data-lucide="layers" class="w-4 h-4"></i> Master Income Summary
            </button>
        </div>

        <!-- TAB 1: CASH MAJOO -->
        <div x-show="activeTab === 'cash'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Input Cash -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5 text-emerald-500"></i> Entry Cash Kasir vs Aktual
                    </h3>
                    <form method="POST" action="{{ route('admin.income.store-cash') }}" class="space-y-4" x-data="{ cashier: 0, actual: 0, get diff() { return (parseFloat(this.actual)||0) - (parseFloat(this.cashier)||0); } }">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Transaksi</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Jumlah Kasir (Rp)</label>
                            <input type="number" step="0.01" name="cashier_amount" x-model="cashier" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Jumlah Aktual Kas (Rp)</label>
                            <input type="number" step="0.01" name="actual_amount" x-model="actual" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <!-- Live Difference Display -->
                        <div class="p-3 rounded-xl bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-500">Selisih Harian:</span>
                            <span class="text-sm font-extrabold" :class="diff === 0 ? 'text-gray-600' : (diff > 0 ? 'text-emerald-500' : 'text-rose-500')">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(diff)"></span>
                            </span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Catatan (Optional)</label>
                            <input type="text" name="notes" placeholder="Catatan kasir shift pagi/malam" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all">Simpan Rekap Cash</button>
                    </form>
                </div>

                <!-- Table Cash -->
                <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Database Cash Majoo (Kasir vs Aktual)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Jumlah Kasir</th>
                                    <th class="px-4 py-3">Jumlah Aktual</th>
                                    <th class="px-4 py-3">Selisih Harian</th>
                                    <th class="px-4 py-3">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                                @forelse($cashData as $row)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold">{{ $row->date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">Rp {{ number_format($row->cashier_amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">Rp {{ number_format($row->actual_amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 font-bold">
                                            @if($row->difference == 0)
                                                <span class="text-gray-500">Rp 0 (Balance)</span>
                                            @elseif($row->difference > 0)
                                                <span class="text-emerald-500">+Rp {{ number_format($row->difference, 0, ',', '.') }} (Plus)</span>
                                            @else
                                                <span class="text-rose-500">-Rp {{ number_format(abs($row->difference), 0, ',', '.') }} (Minus)</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-400">{{ $row->notes ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada data cash pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: BANK TRANSFER MAJOO -->
        <div x-show="activeTab === 'transfer'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Entry Bank Transfer Majoo</h3>
                    <form method="POST" action="{{ route('admin.income.store-transfer') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Transaksi</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Total Pemasukan Transfer (Rp)</label>
                            <input type="number" step="0.01" name="amount" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Catatan (Optional)</label>
                            <input type="text" name="notes" placeholder="No. Rekening / Bank Transfer" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition-all">Simpan Transfer</button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Database Bank Transfer Majoo</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Jumlah Transfer</th>
                                    <th class="px-4 py-3">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                                @forelse($transferData as $row)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold">{{ $row->date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-gray-400">{{ $row->notes ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400">Belum ada data transfer pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: QRIS CETAK -->
        <div x-show="activeTab === 'qris_cetak'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Entry QRIS Cetak Majoo</h3>
                    <form method="POST" action="{{ route('admin.income.store-qris-cetak') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Transaksi</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Total QRIS Cetak (Rp)</label>
                            <input type="number" step="0.01" name="amount" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Catatan (Optional)</label>
                            <input type="text" name="notes" placeholder="Catatan QRIS Cetak stiker" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md transition-all">Simpan QRIS Cetak</button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Database QRIS Cetak Majoo</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Jumlah QRIS Cetak</th>
                                    <th class="px-4 py-3">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                                @forelse($qrisCetakData as $row)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold">{{ $row->date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 font-bold text-purple-600 dark:text-purple-400">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-gray-400">{{ $row->notes ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-400">Belum ada data QRIS cetak pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4,5,6: EDC (QRIS EDC, DEBIT, KREDIT) & IMPORT SPREADSHEET -->
        <div x-show="activeTab === 'edc'" class="space-y-6">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 dark:border-zinc-800 pb-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i data-lucide="file-spread-sheet" class="w-5 h-5 text-amber-500"></i> Impor Spreadsheet Transaksi EDC (QRIS EDC, Debit, Kredit)
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Mendukung format file .xlsx, .xls, .csv dengan validasi header dan otomatis deteksi duplikat transaksi.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.income.import-spreadsheet') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tipe Channel EDC</label>
                        <select name="edc_type" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                            <option value="qris_edc">QRIS EDC</option>
                            <option value="debit">Kartu Debit EDC</option>
                            <option value="credit">Kartu Kredit EDC</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Upload File Spreadsheet (.xlsx / .csv)</label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv,.txt" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white p-1.5">
                    </div>
                    <div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-kanca-orange hover:bg-amber-600 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                            <i data-lucide="upload-cloud" class="w-4 h-4"></i> Impor Transaksi EDC
                        </button>
                    </div>
                </form>
            </div>

            <!-- Database EDC Table -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Database Detail Transaksi EDC (QRIS EDC / Debit / Kredit)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Tipe</th>
                                <th class="px-4 py-3">TRX Date</th>
                                <th class="px-4 py-3">AUTH</th>
                                <th class="px-4 py-3">Card No</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Nett Amount</th>
                                <th class="px-4 py-3">TID</th>
                                <th class="px-4 py-3">Jenis TRX</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @forelse($edcData as $row)
                                <tr>
                                    <td class="px-4 py-3 uppercase">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200">{{ $row->edc_type }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-semibold">{{ $row->trx_date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-500">{{ $row->auth ?: '-' }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-500">{{ $row->card_no ?: '-' }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($row->nett_amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-500">{{ $row->tid ?: '-' }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $row->jenis_trx ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada transaksi EDC terdaftar pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB GOBIZ -->
        <div x-show="activeTab === 'gobiz'" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4" x-data="{ gross: 0, comm: 0, promo: 0, ads: 0, disc: 0, get net() { let res = (parseFloat(this.gross)||0) - ((parseFloat(this.comm)||0) + (parseFloat(this.promo)||0) + (parseFloat(this.ads)||0) + (parseFloat(this.disc)||0)); return res < 0 ? 0 : res; } }">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="plus-circle" class="w-5 h-5 text-blue-500"></i> Form Entry GoBiz Online
                    </h3>
                    <form method="POST" action="{{ route('admin.income.store-gobiz') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Transaksi</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Penjualan Kotor (Gross Sales)</label>
                            <input type="number" step="0.01" name="gross_sales" x-model="gross" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Biaya Komisi (-)</label>
                                <input type="number" step="0.01" name="commission_fee" x-model="comm" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Biaya Promo (-)</label>
                                <input type="number" step="0.01" name="promo_fee" x-model="promo" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Biaya Iklan (-)</label>
                                <input type="number" step="0.01" name="ads_fee" x-model="ads" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1">Biaya Diskon (-)</label>
                                <input type="number" step="0.01" name="discount_fee" x-model="disc" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                            </div>
                        </div>
                        
                        <!-- Calculated Net Sales Box -->
                        <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 flex justify-between items-center">
                            <span class="text-xs font-bold text-blue-800 dark:text-blue-200">Penjualan Bersih (Otomatis):</span>
                            <span class="text-sm font-black text-blue-600 dark:text-blue-400">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(net)"></span>
                            </span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Catatan (Optional)</label>
                            <input type="text" name="notes" placeholder="Catatan GoBiz harian" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition-all">Simpan Entry GoBiz</button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Database Transaksi GoBiz</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Kotor</th>
                                    <th class="px-4 py-3">Komisi+Promo+Iklan+Diskon</th>
                                    <th class="px-4 py-3">Penjualan Bersih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                                @forelse($gobizData as $row)
                                    <tr>
                                        <td class="px-4 py-3 font-semibold">{{ $row->date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">Rp {{ number_format($row->gross_sales, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-rose-500">-Rp {{ number_format($row->commission_fee + $row->promo_fee + $row->ads_fee + $row->discount_fee, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($row->net_sales, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada transaksi GoBiz pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB SUMMARY MASTER INCOME -->
        <div x-show="activeTab === 'summary'" class="space-y-6">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Master Summary Income (Majoo + GoBiz Auto-Aggregated)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Akun Holding</th>
                                <th class="px-4 py-3">Kode Referensi Pemasukan</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Tipe</th>
                                <th class="px-4 py-3 text-right">Jumlah Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @forelse($masterIncomes as $row)
                                <tr>
                                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $row->holding_account }}</span></td>
                                    <td class="px-4 py-3 font-mono font-bold">{{ $row->ref_number }}</td>
                                    <td class="px-4 py-3">{{ $row->date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if($row->type === 'MJO')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">Majoo POS</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">GoBiz</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada summary income terdaftar.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
