<x-admin-layout>
    <div class="space-y-6" x-data="{ edit: null }">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-sm text-kanca-orange font-bold uppercase tracking-wider">Keuangan</p>
                <h1 class="text-2xl font-extrabold">{{ $type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</h1>
                <p class="text-sm text-gray-500 mt-1">Catat, ubah, hapus, dan filter transaksi {{ $type === 'income' ? 'pendapatan' : 'biaya operasional' }}.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.finance.export', request()->query() + ['format' => 'pdf', 'type' => $type]) }}" class="px-3 py-2 rounded-xl bg-rose-600 text-white text-xs font-bold">PDF</a>
                <a href="{{ route('admin.finance.export', request()->query() + ['format' => 'excel', 'type' => $type]) }}" class="px-3 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold">Excel</a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.cashflows.store', $type) }}" class="bg-white dark:bg-zinc-900 rounded-2xl p-5 border border-gray-100 dark:border-zinc-800 grid grid-cols-1 md:grid-cols-6 gap-3">
            @csrf
            <input type="date" name="transaction_date" value="{{ old('transaction_date', now()->toDateString()) }}" required class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
            <input type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount') }}" required placeholder="Nominal" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
            @if($type === 'expense')
                <select name="category" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
                    <option value="">Kategori</option>
                    @foreach($categories as $category)<option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>@endforeach
                </select>
            @else
                <input name="source" value="{{ old('source') }}" placeholder="Sumber pemasukan" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
            @endif
            <input name="description" value="{{ old('description') }}" placeholder="Deskripsi / catatan" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm md:col-span-2">
            <button class="rounded-xl bg-kanca-orange text-white text-sm font-bold">Tambah Transaksi</button>
        </form>

        <form class="bg-white dark:bg-zinc-900 rounded-2xl p-4 border border-gray-100 dark:border-zinc-800 grid grid-cols-1 md:grid-cols-5 gap-3">
            <input name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..." class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
            @if($type === 'expense')
                <select name="category" class="rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800 text-sm">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)<option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>@endforeach
                </select>
            @endif
            <button class="rounded-xl bg-zinc-900 text-white text-sm font-bold">Filter</button>
        </form>

        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-100 dark:border-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800 text-xs uppercase text-gray-500"><tr><th class="p-4">Tanggal</th><th class="p-4">Nominal</th><th class="p-4">Kategori/Sumber</th><th class="p-4">Deskripsi</th><th class="p-4 text-right">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($cashflows as $cashflow)
                            <tr>
                                <td class="p-4">{{ $cashflow->transaction_date->format('d M Y') }}</td>
                                <td class="p-4 font-extrabold {{ $type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">Rp {{ number_format((float) $cashflow->amount, 0, ',', '.') }}</td>
                                <td class="p-4">{{ $cashflow->category ?: $cashflow->source ?: '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $cashflow->description ?: '-' }}</td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <button type="button" @click="edit = {{ $cashflow->toJson() }}; $dispatch('open-modal', 'edit-cashflow')" class="text-kanca-teal font-bold text-xs mr-3">Edit</button>
                                    <form method="POST" action="{{ route('admin.cashflows.destroy', $cashflow) }}" class="inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-rose-600 font-bold text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="p-10 text-center text-gray-500">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $cashflows->links() }}</div>
        </div>

        <div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'edit-cashflow') open = true" x-show="open" x-cloak class="fixed inset-0 z-50 bg-black/50 p-4 flex items-center justify-center">
            <div @click.outside="open = false" class="bg-white dark:bg-zinc-900 rounded-2xl p-6 w-full max-w-lg">
                <div class="flex items-center justify-between mb-4"><h2 class="font-extrabold text-lg">Edit Transaksi</h2><button type="button" @click="open = false" class="text-gray-500 text-xl">&times;</button></div>
                <form method="POST" :action="edit ? '{{ url('admin/cashflows') }}/' + edit.id : '#'" class="space-y-3">
                    @csrf @method('PUT')
                    <input type="date" name="transaction_date" :value="edit?.transaction_date?.substring(0, 10)" required class="w-full rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800">
                    <input type="number" step="0.01" min="0.01" name="amount" :value="edit?.amount" required placeholder="Nominal" class="w-full rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800">
                    @if($type === 'expense')
                        <select name="category" class="w-full rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800"><option value="">Kategori</option>@foreach($categories as $category)<option value="{{ $category }}" :selected="edit?.category === '{{ $category }}'">{{ $category }}</option>@endforeach</select>
                    @else
                        <input name="source" :value="edit?.source" placeholder="Sumber pemasukan" class="w-full rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800">
                    @endif
                    <textarea name="description" x-text="edit?.description || ''" placeholder="Deskripsi / catatan" class="w-full rounded-xl border-gray-200 dark:border-zinc-700 dark:bg-zinc-800"></textarea>
                    <button class="w-full py-3 rounded-xl bg-kanca-teal text-white font-bold">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
