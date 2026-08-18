<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Summary & Entry Expense Detail</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Daftar transaksi pengeluaran rincian, status pembayaran (Lunas/Pending), dan unggahan invoice digital</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.expenses.create') }}" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm shadow-md transition-all flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Input Expense Multi-Item Baru
                </a>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white dark:bg-zinc-900 p-5 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <form method="GET" action="{{ route('admin.expenses.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-center">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, ref, atau invoice #..." class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                </div>
                <div>
                    <select name="status" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                        <option value="">-- Semua Status --</option>
                        <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                </div>
                <div>
                    <button type="submit" class="w-full py-2 rounded-xl bg-zinc-800 hover:bg-zinc-900 text-white font-bold text-xs shadow">Filter Data</button>
                </div>
            </form>
        </div>

        <!-- Expenses Table -->
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase font-bold text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Kode Referensi</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Judul Transaksi</th>
                            <th class="px-6 py-4">Supplier</th>
                            <th class="px-6 py-4">Rincian Item</th>
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Status Pembayaran</th>
                            <th class="px-6 py-4 text-right">Total Subtotal 3</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                        @forelse($expenses as $exp)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-gray-900 dark:text-white">
                                    <a href="{{ route('admin.expenses.show', $exp) }}" class="text-rose-600 hover:underline">{{ $exp->ref_number }}</a>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ $exp->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    {{ $exp->title }}
                                    @if($exp->invoice_number)
                                        <div class="text-[11px] font-mono text-gray-400 font-normal">Inv: {{ $exp->invoice_number }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $exp->supplier?->name ?: '-' }}</td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    <span class="px-2 py-0.5 rounded bg-gray-100 dark:bg-zinc-800 font-bold text-gray-700 dark:text-gray-300">{{ $exp->details->count() }} Item</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($exp->invoice_path)
                                        <a href="{{ route('admin.expenses.download-invoice', $exp) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100">
                                            <i data-lucide="paperclip" class="w-3.5 h-3.5"></i> Invoice
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 font-normal">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.expenses.toggle-status', $exp) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded-full text-xs font-extrabold shadow-sm transition-transform active:scale-95 {{ $exp->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' }}">
                                            {{ $exp->status }} ⟲
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right font-extrabold text-rose-600 dark:text-rose-400 whitespace-nowrap">
                                    Rp {{ number_format($exp->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.expenses.show', $exp) }}" class="p-1.5 rounded-lg bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.expenses.destroy', $exp) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi pengeluaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-100">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-400">Belum ada transaksi pengeluaran. Klik button "Input Expense Multi-Item Baru" untuk menambah data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($expenses->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-zinc-800">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
