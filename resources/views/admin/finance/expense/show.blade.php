<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Detail Transaksi Pengeluaran</h2>
                <p class="text-xs font-mono font-bold text-rose-600 dark:text-rose-400 mt-1">{{ $expense->ref_number }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.expenses.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 font-bold text-xs hover:bg-gray-200">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Header Info Card -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <span class="text-xs text-gray-400 font-bold uppercase">Tanggal Transaksi</span>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">{{ $expense->date->format('d M Y') }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-bold uppercase">Judul Transaksi</span>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">{{ $expense->title }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-bold uppercase">Nomor Invoice</span>
                    <p class="text-sm font-mono font-bold text-gray-900 dark:text-white mt-1">{{ $expense->invoice_number ?: '-' }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 font-bold uppercase">Supplier</span>
                    <p class="text-sm font-bold text-gray-900 dark:text-white mt-1">{{ $expense->supplier?->name ?: '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-gray-200 dark:border-zinc-800 items-center">
                <div>
                    <span class="text-xs text-gray-400 font-bold uppercase">Status Pembayaran</span>
                    <div class="mt-1">
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold {{ $expense->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' }}">
                            {{ $expense->status }}
                        </span>
                    </div>
                </div>

                <div>
                    <span class="text-xs text-gray-400 font-bold uppercase">Lampiran Invoice Digital</span>
                    <div class="mt-1">
                        @if($expense->invoice_path)
                            <a href="{{ route('admin.expenses.download-invoice', $expense) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400 text-xs font-bold hover:bg-blue-100">
                                <i data-lucide="paperclip" class="w-4 h-4"></i> Unduh / Preview Invoice
                            </a>
                        @else
                            <span class="text-xs text-gray-400 font-normal">Tidak ada lampiran invoice</span>
                        @endif
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-xs text-gray-400 font-bold uppercase">Total Subtotal 3 (Final)</span>
                    <p class="text-xl font-black text-rose-600 dark:text-rose-400 mt-1">Rp {{ number_format($expense->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden space-y-4">
            <div class="p-6 border-b border-gray-200 dark:border-zinc-800">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="list" class="w-5 h-5 text-rose-500"></i> Rincian Item Pengeluaran
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Nama Item</th>
                            <th class="px-4 py-3">Kode Sub Akun</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Cost Category</th>
                            <th class="px-4 py-3">Qty x Harga</th>
                            <th class="px-4 py-3">Subtotal 1</th>
                            <th class="px-4 py-3">PPN</th>
                            <th class="px-4 py-3">Subtotal 2</th>
                            <th class="px-4 py-3">Admin Bank</th>
                            <th class="px-4 py-3 text-right">Subtotal 3</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                        @foreach($expense->details as $item)
                            <tr>
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">
                                    {{ $item->item_name }}
                                    @if($item->ingredient)
                                        <div class="text-[10px] text-emerald-500 font-normal">Linked Stok: {{ $item->ingredient->name }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-mono font-bold text-gray-700 dark:text-gray-300">
                                    {{ $item->subAccount?->account?->code }}-{{ $item->subAccount?->code }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $item->category?->name ?: '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $item->cost_category === 'Fixed' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $item->cost_category }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ number_format($item->qty, 2) }} x Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($item->subtotal_1, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-500">Rp {{ number_format($item->ppn, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($item->subtotal_2, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-500">Rp {{ number_format($item->bank_admin, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-extrabold text-rose-600 dark:text-rose-400">Rp {{ number_format($item->subtotal_3, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
