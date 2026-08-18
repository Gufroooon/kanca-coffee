<x-admin-layout>
    <div class="space-y-8" x-data="expenseForm()">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Form Input Multi-Item Expense</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Catat transaksi pengeluaran rincian dengan multi-item, kalkulasi otomatis subtotal 1-3, dan unggah invoice digital</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.expenses.index') }}" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 font-bold text-xs hover:bg-gray-200">
                    ← Kembali ke Daftar Expense
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.expenses.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Header Section -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-zinc-800 pb-3 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-rose-500"></i> Identitas Transaksi Pengeluaran
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Transaksi *</label>
                        <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Transaksi *</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Belanja New Ngesti" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nomor Invoice (Optional)</label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" placeholder="INV-2026/08/001" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Supplier (Optional)</label>
                        <select name="supplier_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-semibold">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Pembayaran *</label>
                        <select name="status" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white font-bold">
                            <option value="Lunas">Lunas</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Upload Invoice Digital (PDF / PNG / JPG)</label>
                        <input type="file" name="invoice_file" accept=".pdf,.png,.jpg,.jpeg" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white p-1.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Catatan Spesifik Transaksi</label>
                        <input type="text" name="notes" placeholder="Catatan opsional" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 text-gray-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Dynamic Items Section -->
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-200 dark:border-zinc-800 pb-3">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="layers" class="w-5 h-5 text-rose-500"></i> Rincian Item Komponen Biaya
                    </h3>
                    <button type="button" @click="addItem()" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow">
                        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Item Lagi
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="p-5 rounded-2xl bg-gray-50 dark:bg-zinc-800/60 border border-gray-200 dark:border-zinc-700/60 space-y-4 relative">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-lg bg-zinc-200 dark:bg-zinc-700 text-xs font-extrabold text-gray-700 dark:text-gray-200" x-text="'Item #' + (index + 1)"></span>
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-xs font-bold text-rose-600 hover:underline flex items-center gap-1">
                                <i data-lucide="trash" class="w-3.5 h-3.5"></i> Hapus Item Ini
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Item / Barang *</label>
                                <input type="text" :name="'items['+index+'][item_name]'" x-model="item.item_name" placeholder="Goldenfil Strawberry" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Kode Sub Akun *</label>
                                <select :name="'items['+index+'][financial_sub_account_id]'" x-model="item.financial_sub_account_id" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white font-semibold">
                                    @foreach($subAccounts as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->account->code }}-{{ $sub->code }} ({{ $sub->name }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Item Category</label>
                                <select :name="'items['+index+'][expense_category_id]'" x-model="item.expense_category_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white font-semibold">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Cost Category *</label>
                                <select :name="'items['+index+'][cost_category]'" x-model="item.cost_category" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white font-bold">
                                    <option value="Variable">Variable Cost</option>
                                    <option value="Fixed">Fixed Cost</option>
                                </select>
                            </div>
                        </div>

                        <!-- Quantities & Prices -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Qty *</label>
                                <input type="number" step="0.001" :name="'items['+index+'][qty]'" x-model.number="item.qty" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Harga Satuan (Rp) *</label>
                                <input type="number" step="0.01" :name="'items['+index+'][price]'" x-model.number="item.price" required class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Ongkir (+)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][delivery_fee]'" x-model.number="item.delivery_fee" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Asuransi (+)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][delivery_insurance]'" x-model.number="item.delivery_insurance" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Admin App (+)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][admin_app_fee]'" x-model.number="item.admin_app_fee" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Diskon Item (-)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][item_discount]'" x-model.number="item.item_discount" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Diskon Ongkir (-)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][delivery_discount]'" x-model.number="item.delivery_discount" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">PPN (+)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][ppn]'" x-model.number="item.ppn" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Admin Bank (+)</label>
                                <input type="number" step="0.01" :name="'items['+index+'][bank_admin]'" x-model.number="item.bank_admin" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                            </div>
                            <div class="sm:col-span-2 md:col-span-3">
                                <label class="block text-[10px] font-bold text-gray-500 mb-1">Integrasi Bahan Baku (Update Stok)</label>
                                <div class="flex items-center gap-2">
                                    <select :name="'items['+index+'][ingredient_id]'" x-model="item.ingredient_id" class="w-full text-xs rounded-xl border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white">
                                        <option value="">-- Tidak Terhubung ke Stok --</option>
                                        @foreach($ingredients as $ing)
                                            <option value="{{ $ing->id }}">{{ $ing->name }} (Satuan: {{ $ing->unit }})</option>
                                        @endforeach
                                    </select>
                                    <label class="flex items-center gap-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                        <input type="checkbox" :name="'items['+index+'][update_stock]'" value="1" x-model="item.update_stock" class="rounded border-gray-300 text-rose-600">
                                        +Stok
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Live Calculated Subtotals -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3 rounded-xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 text-xs">
                            <div>
                                <span class="text-gray-500 font-medium">Subtotal 1 (Dasar):</span>
                                <div class="font-bold text-gray-900 dark:text-white">Rp <span x-text="new Intl.NumberFormat('id-ID').format(subtotal1(item))"></span></div>
                            </div>
                            <div>
                                <span class="text-gray-500 font-medium">Subtotal 2 (+ PPN):</span>
                                <div class="font-bold text-gray-900 dark:text-white">Rp <span x-text="new Intl.NumberFormat('id-ID').format(subtotal2(item))"></span></div>
                            </div>
                            <div>
                                <span class="text-gray-500 font-medium">Subtotal 3 (Final + Admin Bank):</span>
                                <div class="font-extrabold text-rose-600 dark:text-rose-400 text-sm">Rp <span x-text="new Intl.NumberFormat('id-ID').format(subtotal3(item))"></span></div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Grand Total Display & Submit -->
                <div class="p-5 rounded-2xl bg-zinc-900 text-white flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-xs uppercase font-bold text-zinc-400">Total Pengeluaran Transaksi (Grand Total Subtotal 3):</p>
                        <h3 class="text-2xl font-black text-rose-400 mt-1">Rp <span x-text="new Intl.NumberFormat('id-ID').format(grandTotal)"></span></h3>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm shadow-lg transition-all">
                        Simpan Transaksi Pengeluaran
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function expenseForm() {
            return {
                items: [
                    {
                        item_name: '',
                        financial_sub_account_id: '{{ $subAccounts->first()?->id ?? 1 }}',
                        expense_category_id: '',
                        cost_category: 'Variable',
                        ingredient_id: '',
                        qty: 1,
                        price: 0,
                        delivery_fee: 0,
                        delivery_insurance: 0,
                        admin_app_fee: 0,
                        item_discount: 0,
                        delivery_discount: 0,
                        ppn: 0,
                        bank_admin: 0,
                        update_stock: false
                    }
                ],
                addItem() {
                    this.items.push({
                        item_name: '',
                        financial_sub_account_id: '{{ $subAccounts->first()?->id ?? 1 }}',
                        expense_category_id: '',
                        cost_category: 'Variable',
                        ingredient_id: '',
                        qty: 1,
                        price: 0,
                        delivery_fee: 0,
                        delivery_insurance: 0,
                        admin_app_fee: 0,
                        item_discount: 0,
                        delivery_discount: 0,
                        ppn: 0,
                        bank_admin: 0,
                        update_stock: false
                    });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                subtotal1(item) {
                    let qty = parseFloat(item.qty) || 0;
                    let price = parseFloat(item.price) || 0;
                    let delivery = parseFloat(item.delivery_fee) || 0;
                    let insurance = parseFloat(item.delivery_insurance) || 0;
                    let admin = parseFloat(item.admin_app_fee) || 0;
                    let itemDisc = parseFloat(item.item_discount) || 0;
                    let delivDisc = parseFloat(item.delivery_discount) || 0;

                    let res = (qty * price) + delivery + insurance + admin - itemDisc - delivDisc;
                    return res < 0 ? 0 : res;
                },
                subtotal2(item) {
                    let st1 = this.subtotal1(item);
                    let ppn = parseFloat(item.ppn) || 0;
                    return st1 + ppn;
                },
                subtotal3(item) {
                    let st2 = this.subtotal2(item);
                    let bankAdmin = parseFloat(item.bank_admin) || 0;
                    return st2 + bankAdmin;
                },
                get grandTotal() {
                    return this.items.reduce((sum, item) => sum + this.subtotal3(item), 0);
                }
            };
        }
    </script>
</x-admin-layout>
