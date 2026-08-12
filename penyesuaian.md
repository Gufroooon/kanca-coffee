# PROMPT IMPLEMENTASI ROLE ADMIN — SISTEM MANAJEMEN INVENTORI & KEUANGAN CAFE

Saya ingin menambahkan dan menyempurnakan fitur **Role Admin** pada project web yang sedang berjalan.

**WAJIB:** Sebelum melakukan perubahan kode, pelajari terlebih dahulu seluruh struktur project yang sudah ada. Jangan membuat ulang project dari awal. Pertahankan arsitektur, database, UI, routing, komponen, dan fitur yang sudah berjalan kecuali memang diperlukan untuk mendukung fitur Admin.

Gunakan **Project Brief: Sistem Informasi Manajemen Inventori & Dashboard Keuangan Cafe** sebagai acuan utama.

Framework utama:

* Laravel
* Blade
* TailwindCSS atau Bootstrap sesuai stack project yang sudah ada
* MySQL/MariaDB
* Chart.js atau ApexCharts
* Laravel Excel untuk Excel
* DomPDF/Snappy untuk PDF

---

# 1. ROLE & ACCESS CONTROL ADMIN

Buat role-based access control yang jelas.

Role:

* Admin
* Staff

Untuk halaman Admin, hanya user dengan role `admin` yang boleh mengakses.

Implementasikan middleware/authorization yang sesuai dengan struktur project.

Admin memiliki akses penuh terhadap:

* Dashboard
* Master bahan baku
* Mixed/composite ingredients
* Inventory
* Inventory logs
* Pemasukan
* Pengeluaran
* Rekap keuangan
* Grafik
* Laporan
* Export PDF
* Export Excel
* Pengaturan data yang berkaitan dengan sistem

Staff tidak boleh mendapatkan akses penuh terhadap menu Admin.

Pastikan jika Staff mencoba mengakses URL Admin secara langsung, sistem mengembalikan response unauthorized/forbidden atau redirect yang sesuai.

---

# 2. ADMIN DASHBOARD

Buat dashboard Admin sebagai halaman utama setelah login.

Dashboard harus memberikan overview kondisi cafe secara real-time berdasarkan data database.

Tampilkan summary cards:

### Inventory

* Total bahan baku
* Total stok tersedia
* Total penggunaan bahan hari ini
* Jumlah bahan yang stoknya rendah

### Keuangan

* Total pemasukan hari ini
* Total pengeluaran hari ini
* Profit/selisih hari ini
* Total pemasukan bulan berjalan
* Total pengeluaran bulan berjalan
* Profit/selisih bulan berjalan

### Aktivitas

* Jumlah transaksi hari ini
* Jumlah inventory log hari ini
* Aktivitas terakhir

---

# 3. INVENTORY / MASTER BAHAN BAKU

Admin dapat mengelola master bahan baku.

Buat halaman:

`Admin → Bahan Baku`

CRUD lengkap:

### Tambah bahan

Field minimal:

* Nama bahan
* Satuan
* Stok minimum
* Status aktif/nonaktif

Contoh:

* Kopi — Liter
* Susu — Liter
* Krimer — Liter
* Gula — Kg

Gunakan satuan yang fleksibel seperti:

* ml
* liter
* gram
* kg
* pcs

Pastikan sistem memiliki validasi agar satuan dan data stok konsisten.

Database master bahan mengikuti konsep `ingredients` pada project brief.

Fitur:

* Search
* Filter status
* Edit
* Delete
* Detail
* Pagination
* Sorting

Jangan izinkan bahan yang sudah memiliki histori transaksi/inventory dihapus secara sembarangan. Gunakan soft delete/nonaktifkan jika diperlukan agar histori tetap aman.

---

# 4. MIXED / COMPOSITE INGREDIENTS

Admin harus dapat membuat bahan gabungan dari beberapa bahan dasar.

Contoh:

Bahan:

* Krimer
* Susu

Dibuat menjadi:

`Krimer + Susu 1 Liter`

Buat halaman:

`Admin → Mixed Ingredients`

Fitur:

* Create
* Edit
* View detail
* Delete/nonaktifkan
* Search
* Filter

Saat membuat mixed ingredient:

Field:

* Nama mixed ingredient
* Satuan hasil
* Total quantity hasil
* Daftar bahan dasar
* Quantity masing-masing bahan

Contoh:

Mixed Ingredient:
`Krimer + Susu`

Formula:

* Krimer: 400 ml
* Susu: 600 ml
* Total: 1.000 ml

Ketika mixed ingredient diproduksi/digunakan, sistem harus dapat menghitung pengurangan bahan dasar secara proporsional.

Jangan membuat sistem yang hanya menyimpan nama campuran. Formula harus benar-benar tersimpan di database.

Konsep ini harus mengikuti brief yang menyebutkan bahwa mixed ingredient dibuat dari beberapa bahan dasar dan sistem harus menghitung pemotongan stok bahan mentah asal secara proporsional.

Gunakan database relationship yang rapi, misalnya:

* mixed_ingredients
* mixed_ingredient_items

atau menyesuaikan struktur database existing.

---

# 5. INVENTORY DAILY OPENING & CLOSING

Admin dapat melihat dan mengelola histori stok harian.

Sistem harus mendukung:

### Opening Stock

Saat cafe buka:

Contoh:

Kopi:
`1 Liter`

Susu:
`5 Liter`

Krimer:
`2 Liter`

### Closing Stock

Saat cafe tutup:

Kopi:
`800 ml`

Susu:
`4 Liter`

Krimer:
`1.5 Liter`

Sistem otomatis menghitung:

`Usage = Opening Stock - Closing Stock`

Contoh:

Opening:
1.000 ml

Closing:
800 ml

Usage:
200 ml

Konsep ini merupakan salah satu fitur utama pada brief.

Admin dapat:

* Melihat data opening
* Melihat data closing
* Melihat usage
* Melihat histori per tanggal
* Filter berdasarkan bahan
* Filter berdasarkan periode
* Melihat detail inventory log

Database mengikuti konsep:

`inventory_logs`

yang menyimpan stok pagi, stok malam, dan penggunaan.

Tambahkan validasi:

`closing_stock <= opening_stock`

untuk penggunaan normal.

Jika sistem memang membutuhkan stok masuk/restock, sediakan mekanisme stock adjustment/restock tanpa merusak histori opening/closing.

---

# 6. HALAMAN PEMASUKAN

Buat:

`Admin → Pemasukan`

Admin dapat mencatat pemasukan harian.

Field:

* Tanggal
* Nominal
* Deskripsi/catatan
* Sumber pemasukan jika diperlukan

Contoh:

12 Agustus 2026
Pemasukan:
Rp2.500.000

Catatan:
`Penjualan cafe`

Fitur:

* Tambah
* Edit
* Detail
* Delete
* Search
* Filter tanggal
* Filter bulan
* Pagination

Sesuai brief, pemasukan digunakan untuk mencatat total pendapatan/penjualan harian.

---

# 7. HALAMAN PENGELUARAN

Buat:

`Admin → Pengeluaran`

Field:

* Tanggal
* Nominal
* Kategori
* Deskripsi

Kategori contoh:

* Belanja bahan
* Operasional
* Listrik
* Air
* Transportasi
* Maintenance
* Lainnya

Admin dapat:

* Tambah
* Edit
* Detail
* Delete
* Search
* Filter kategori
* Filter tanggal
* Pagination

Contoh:

12 Agustus 2026

Belanja bahan:
Rp500.000

Deskripsi:
`Pembelian susu dan kopi`

Brief secara khusus membutuhkan pencatatan pengeluaran dengan detail deskripsi dan nominal.

---

# 8. REKAP KEUANGAN

Buat halaman:

`Admin → Keuangan`

Tampilkan:

* Total income
* Total expense
* Net income/profit
* Jumlah transaksi
* Grafik pemasukan
* Grafik pengeluaran
* Grafik profit

Formula:

`Profit = Total Income - Total Expense`

Berikan filter:

* Hari ini
* Minggu ini
* Bulan ini
* Custom date range
* Monthly
* Quarterly
* Yearly

Data transaksi menggunakan konsep `transactions` / `cashflows` seperti pada project brief.

---

# 9. DASHBOARD GRAPHICS

Semua data penting harus divisualisasikan.

Gunakan Chart.js atau ApexCharts sesuai library yang sudah ada.

### Chart 1 — Income vs Expense

Line/Bar Chart.

Menampilkan:

* Income
* Expense
* Profit

### Chart 2 — Inventory Usage

Menampilkan penggunaan bahan.

Contoh:

* Kopi
* Susu
* Krimer
* Gula

### Chart 3 — Inventory Trend

Menampilkan perubahan stok berdasarkan tanggal.

### Chart 4 — Financial Trend

Menampilkan trend pemasukan dan pengeluaran.

Dashboard harus mendukung filter:

* Daily
* Monthly
* Quarterly
* Yearly

Filter harus benar-benar memengaruhi query dan data grafik, bukan hanya mengubah label.

Brief secara eksplisit meminta grafik dinamis dan filter Daily, Monthly, Quarterly, serta Yearly.

---

# 10. LOW STOCK ALERT

Tambahkan sistem peringatan stok rendah.

Setiap bahan memiliki:

`minimum_stock`

Jika:

`current_stock <= minimum_stock`

maka tampilkan:

* Badge Low Stock
* Warning pada dashboard
* Daftar bahan yang perlu direstock

Contoh:

⚠️ Kopi — 500 ml tersisa

Minimum:
1.000 ml

Status:
`LOW STOCK`

---

# 11. REPORT / LAPORAN ADMIN

Buat halaman:

`Admin → Laporan`

Admin dapat memilih jenis laporan:

### Inventory Report

Berisi:

* Tanggal
* Nama bahan
* Opening
* Closing
* Usage
* Satuan

### Financial Report

Berisi:

* Tanggal
* Income
* Expense
* Profit

### Expense Report

Berisi:

* Tanggal
* Kategori
* Deskripsi
* Nominal

### Mixed Ingredient Report

Berisi:

* Nama mixed ingredient
* Formula
* Bahan dasar
* Quantity

---

# 12. EXPORT PDF & EXCEL

Setiap tabel penting harus memiliki tombol:

`Export PDF`

dan

`Export Excel`

Minimal tersedia pada:

* Inventory
* Inventory Logs
* Income
* Expense
* Financial Summary
* Reports

Export harus mengikuti filter yang sedang dipilih.

Contoh:

Jika user memilih:

`1 Agustus 2026 - 12 Agustus 2026`

maka file export hanya berisi data periode tersebut.

Format filename:

`inventory-report-2026-08-12.xlsx`

`financial-report-2026-08-12.pdf`

Project brief memang mensyaratkan export PDF dan Excel pada tabel maupun ringkasan dashboard.

Gunakan library yang sesuai dengan project:

* `maatwebsite/laravel-excel`
* `barryvdh/laravel-dompdf`

atau library yang sudah digunakan project.

---

# 13. ADMIN SIDEBAR / NAVIGATION

Buat navigation Admin yang rapi:

Dashboard

Inventory

* Bahan Baku
* Mixed Ingredients
* Inventory Harian
* Inventory History

Keuangan

* Pemasukan
* Pengeluaran
* Rekap Keuangan

Laporan

* Laporan Inventory
* Laporan Keuangan
* Export

Jika project sudah mempunyai sidebar, integrasikan ke sidebar existing. Jangan membuat layout baru yang menyebabkan UI existing rusak.

---

# 14. DATABASE & RELATIONSHIP

Periksa database existing terlebih dahulu.

Jangan membuat migration/table duplicate.

Pastikan relationship antar data jelas.

Minimal konsep:

`users`

`ingredients`

`mixed_ingredients`

`mixed_ingredient_items`

`inventory_logs`

`transactions` / `cashflows`

Sesuaikan nama tabel dengan database existing.

Gunakan:

* Foreign key
* Index untuk field yang sering difilter
* Timestamps
* Soft delete jika dibutuhkan
* Database transaction untuk proses yang memengaruhi beberapa stok sekaligus

Jangan sampai perubahan stok hanya berhasil di satu tabel tetapi gagal di tabel lainnya.

---

# 15. VALIDATION & DATA INTEGRITY

Tambahkan validasi backend dan frontend.

Contoh:

* Nominal tidak boleh negatif
* Opening stock tidak boleh negatif
* Closing stock tidak boleh negatif
* Closing stock tidak boleh lebih besar dari opening stock untuk penggunaan normal
* Nama bahan wajib diisi
* Satuan wajib diisi
* Formula mixed ingredient wajib memiliki minimal satu bahan
* Quantity formula harus lebih dari 0
* Tanggal wajib valid

Gunakan Laravel Form Request jika struktur project memungkinkan.

---

# 16. SECURITY

Pastikan:

* Admin route dilindungi middleware
* Staff tidak bisa mengakses Admin
* Semua request divalidasi
* Gunakan CSRF protection
* Jangan percaya data dari frontend
* Gunakan authorization pada controller/action penting
* Jangan expose data sensitif
* Gunakan database transaction untuk operasi stok

---

# 17. UI/UX ADMIN

UI Admin harus terlihat seperti dashboard management cafe modern.

Prioritas:

* Clean
* Professional
* Responsive
* Mudah dibaca
* Tidak terlalu ramai
* Desktop friendly
* Tetap usable di tablet/mobile

Gunakan:

* Card summary
* Table
* Badge status
* Modal/form
* Date picker
* Filter
* Chart
* Empty state
* Loading state
* Success notification
* Error notification
* Confirmation dialog sebelum delete

Gunakan format Rupiah:

`Rp 2.500.000`

Gunakan format quantity yang mudah dibaca:

`800 ml`

`1,5 L`

Jika database menyimpan satuan dasar tertentu, lakukan konversi secara konsisten pada UI.

---

# 18. AUDIT / HISTORY

Untuk data penting, usahakan histori tetap dapat dilacak.

Contoh:

Admin mengubah data bahan.

Sistem jangan sampai menghancurkan histori inventory sebelumnya.

Jika project sudah memiliki sistem activity/audit log, integrasikan.

Minimal histori inventory dan transaksi keuangan tidak boleh berubah secara tidak sengaja ketika master bahan diedit.

---

# 19. PERFORMANCE

Jangan mengambil seluruh data database untuk kemudian dihitung di frontend.

Gunakan query/database aggregation untuk:

* SUM income
* SUM expense
* SUM usage
* COUNT transactions
* Group by tanggal/bulan/tahun

Gunakan pagination pada tabel.

Gunakan eager loading untuk relationship yang diperlukan agar tidak terjadi N+1 query.

Untuk grafik, kirim hanya data yang diperlukan.

---

# 20. TESTING

Setelah implementasi selesai, jangan hanya memastikan halaman dapat dibuka.

Test seluruh flow Admin:

### Authentication

* Login Admin
* Login Staff
* Staff mencoba membuka Admin URL

### Inventory

* Tambah bahan
* Edit bahan
* Set minimum stock
* Opening stock
* Closing stock
* Usage calculation
* Low stock

### Mixed Ingredient

* Buat formula
* Tambah bahan
* Hitung proporsi
* Pastikan stok bahan dasar berkurang dengan benar

### Finance

* Tambah income
* Edit income
* Tambah expense
* Edit expense
* Hitung profit

### Dashboard

* Grafik income
* Grafik expense
* Grafik inventory
* Daily
* Monthly
* Quarterly
* Yearly
* Custom date range jika tersedia

### Export

* Export PDF
* Export Excel
* Pastikan filter ikut diterapkan

### Authorization

* Admin bisa mengakses semua menu Admin
* Staff tidak bisa mengakses halaman Admin

---

# 21. JANGAN MERUSAK FITUR EXISTING

Ini sangat penting.

Sebelum coding:

1. Scan seluruh project.
2. Identifikasi route existing.
3. Identifikasi controller.
4. Identifikasi model.
5. Identifikasi migration.
6. Identifikasi middleware.
7. Identifikasi Blade/component.
8. Identifikasi sistem authentication.
9. Identifikasi role system.
10. Identifikasi fitur inventory/finance yang sudah ada.

Jika fitur yang diminta ternyata sudah ada, **jangan membuat duplikat**.

Perbaiki/extend implementasi existing.

Jika ada konflik antara requirement prompt ini dan implementasi existing, prioritaskan:

1. Project architecture existing
2. Database existing
3. Project Brief
4. Requirement tambahan ini

Jangan melakukan `migrate:fresh`, menghapus database, atau menghapus data existing tanpa instruksi eksplisit.

---

# 22. FINAL CHECK

Setelah semua implementasi:

* Jalankan migration yang diperlukan
* Jalankan seeder jika diperlukan
* Pastikan tidak ada duplicate migration
* Pastikan route tidak conflict
* Pastikan semua controller bebas error
* Pastikan Blade tidak error
* Pastikan database relationship benar
* Pastikan authorization berjalan
* Pastikan chart menampilkan data sebenarnya
* Pastikan export PDF berjalan
* Pastikan export Excel berjalan
* Pastikan responsive
* Pastikan tidak ada console error
* Pastikan tidak ada error Laravel log

Jika menemukan bug saat testing, langsung perbaiki sampai flow Admin benar-benar berjalan.

Jangan berhenti hanya karena fitur berhasil dibuat. Lakukan pengecekan end-to-end terhadap seluruh Role Admin.
