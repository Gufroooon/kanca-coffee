<x-admin-layout>
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Master Akun Keuangan & Konfigurasi Referensi</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pengelolaan master sub-akun finansial (BAH, UTI, AST, PAY, LIS, AIR, dll), kategori pengeluaran, dan daftar supplier</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Sub Akun -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-kanca-orange"></i> Tambah Sub-Akun Referensi
                </h3>
                <form method="POST" action="{{ route('admin.master-finance.store-sub-account') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Akun Main/Holding *</label>
                        <select name="financial_account_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}">{{ $acc->holding_type }} / {{ $acc->code }} - {{ $acc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kode Sub Akun (Contoh: BAH, UTI, LIS) *</label>
                        <input type="text" name="code" placeholder="BAH" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Sub Akun *</label>
                        <input type="text" name="name" placeholder="Bahan Baku Bar" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                    </div>
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-kanca-orange hover:bg-amber-600 text-white font-bold text-xs shadow">Simpan Sub Akun</button>
                </form>
            </div>

            <!-- Form Category & Supplier -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Expense Category</h3>
                    <form method="POST" action="{{ route('admin.master-finance.store-category') }}" class="space-y-3">
                        @csrf
                        <div>
                            <input type="text" name="name" placeholder="Nama Kategori (contoh: Operasional Kitchen)" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="w-full py-2 rounded-xl bg-zinc-800 text-white font-bold text-xs">Simpan Kategori</button>
                    </form>
                </div>

                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Tambah Supplier</h3>
                    <form method="POST" action="{{ route('admin.master-finance.store-supplier') }}" class="space-y-3">
                        @csrf
                        <div>
                            <input type="text" name="name" placeholder="Nama Supplier (contoh: Solution Horeca)" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <input type="text" name="phone" placeholder="No. Telepon (Optional)" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                        </div>
                        <button type="submit" class="w-full py-2 rounded-xl bg-zinc-800 text-white font-bold text-xs">Simpan Supplier</button>
                    </form>
                </div>
            </div>

            <!-- List Sub Accounts Table -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden space-y-4">
                <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Sub Akun Finansial Terdaftar</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-zinc-800 uppercase font-bold text-gray-500 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">Main / Sub Code</th>
                                <th class="px-4 py-3">Nama Sub Akun</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 font-medium">
                            @foreach($accounts as $acc)
                                @foreach($acc->subAccounts as $sub)
                                    <tr>
                                        <td class="px-4 py-2 font-mono font-bold text-kanca-orange">{{ $acc->code }}-{{ $sub->code }}</td>
                                        <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $sub->name }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
