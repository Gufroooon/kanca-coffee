# PROMPT IMPLEMENTASI SISTEM KEUANGAN KANCA COFFEE

## ROLE

Anda bertindak sebagai **Senior Laravel Full-Stack Developer, System Analyst, Database Architect, Financial Dashboard Engineer, dan QA Engineer**.

Saya memiliki project web **Kanca Coffee** yang sudah berjalan. Tugas Anda adalah **mengubah, memperbaiki, dan mengintegrasikan modul keuangan Kanca Coffee** berdasarkan dua sumber utama:

1. **Project Brief Dashboard Keuangan Kanca Coffee V2**
2. **Template Keuangan Kanca Coffee.xlsx**

Kedua sumber tersebut adalah **acuan utama dan wajib diikuti**.

Jangan membuat sistem keuangan generik. Sistem harus merepresentasikan kebutuhan operasional Kanca Coffee sebagaimana dijelaskan pada brief dan template Excel.

---

# 1. TUJUAN UTAMA

Bangun ulang / revisi modul keuangan Kanca Coffee agar:

* seluruh struktur keuangan dari template Excel berpindah ke sistem web;
* seluruh requirement Project Brief V2 terimplementasi;
* data tidak lagi bergantung pada spreadsheet manual;
* seluruh kalkulasi dilakukan otomatis oleh backend;
* dashboard menampilkan data secara real-time;
* Income dan Expense saling terhubung dengan Summary dan Jurnal;
* Income Majoo memiliki 6 channel;
* GoBiz memiliki kalkulasi penjualan bersih otomatis;
* Expense mendukung multi-item dalam satu transaksi;
* Expense mendukung invoice;
* Expense mendukung status pembayaran;
* Reference Number dibuat otomatis;
* tersedia filter harian, bulanan, quarterly, dan tahunan;
* tersedia export PDF dan Excel;
* sistem tetap terintegrasi dengan modul Inventory;
* jangan menghapus fitur lama yang masih dibutuhkan project.

---

# 2. WAJIB AUDIT PROJECT TERLEBIH DAHULU

Sebelum melakukan perubahan kode:

1. Periksa struktur project Laravel yang sekarang.
2. Periksa routes.
3. Periksa controllers.
4. Periksa models.
5. Periksa migrations.
6. Periksa database/schema.
7. Periksa Blade views/components.
8. Periksa middleware dan authentication.
9. Periksa role/permission jika sudah tersedia.
10. Periksa modul Inventory yang sudah ada.
11. Periksa modul Income/Expense lama jika ada.
12. Periksa dashboard yang sudah ada.
13. Periksa chart dan library yang digunakan.
14. Periksa fitur export yang sudah ada.
15. Periksa apakah ada data dummy/seed yang perlu dipertahankan.
16. Jangan melakukan rewrite total project jika tidak diperlukan.

Gunakan struktur project yang sudah ada sebagai fondasi.

**Prioritas:**

* reuse kode yang masih baik;
* refactor kode yang bermasalah;
* migrate struktur lama secara aman;
* hindari duplicate logic;
* jangan membuat dua sistem keuangan berbeda di dalam project.

---

# 3. SUMBER KEBUTUHAN YANG HARUS DIIMPLEMENTASIKAN

Project Brief V2 mendefinisikan sistem sebagai integrasi:

### Modul 1

Manajemen Inventory / Bahan Baku

### Modul 2

Income / Pemasukan

### Modul 3

Expense / Pengeluaran

### Modul 4

Dynamic Reporting & Filter

### Modul 5

Export PDF & Excel

### Modul 6

Jurnal / financial aggregation

Semua modul harus saling terhubung.

---

# 4. STRUKTUR HALAMAN

Implementasikan minimal struktur berikut:

## A. Dashboard Income

Halaman utama untuk melihat performa pemasukan.

Tampilkan:

### KPI Cards

* Total Income periode terpilih
* Total Omset Majoo
* Total Omset GoBiz
* Jika memungkinkan: Net Cashflow

### Chart

1. Line Chart:

   * Majoo
   * GoBiz
   * berdasarkan periode aktif

2. Doughnut Chart:

   * kontribusi channel Majoo
   * Cash
   * Transfer
   * QRIS Cetak
   * QRIS EDC
   * Kartu Debit
   * Kartu Kredit

### Summary Table

Kolom:

* No.
* Akun Holding
* Tanggal
* Jumlah Pemasukan

Gunakan format Rupiah.

---

# 5. DATABASE & ENTRY INCOME

Buat halaman khusus:

**Database Income**

Sistem harus memiliki:

## Majoo

6 channel:

1. Cash
2. Bank Transfer
3. QRIS Cetak
4. QRIS EDC
5. Kartu Debit
6. Kartu Kredit

Jangan menggabungkan keenam channel menjadi satu input.

Setiap channel harus dapat memiliki data transaksi/rekap sendiri.

---

# 6. CASH MAJOO

Template Excel memiliki:

* Tanggal
* Jumlah Kasir
* Jumlah Aktual
* Notes
* Selisih Harian

Implementasikan semuanya.

### Formula:

```text
Selisih Harian = Jumlah Aktual - Jumlah Kasir
```

Tampilkan indikator:

* Selisih positif
* Selisih negatif
* Balance / 0

Tambahkan validasi input nominal.

Cash harus masuk ke Summary Majoo.

---

# 7. BANK TRANSFER MAJOO

Field minimal:

* Tanggal
* Jumlah
* Notes

Data masuk otomatis ke Summary Majoo.

---

# 8. QRIS CETAK

Field minimal:

* Tanggal
* Jumlah
* Notes

Data masuk otomatis ke Summary Majoo.

---

# 9. QRIS EDC

Template memiliki data transaksi detail seperti:

* PROC DATE
* MID
* OB
* GB
* SEQ
* TYPE
* TRX DATE
* AUTH
* CARD NO
* AMOUNT
* TID
* JENIS TRX
* PTR
* RATE
* DISC AMOUNT
* AIR FARE
* PLAN
* SS AMOUNT
* SS FEE TYPE
* FLAG
* NETT AMOUNT
* MERCHANT ACCOUNT
* MERCHANT NAME

Implementasikan struktur yang relevan di database.

Jangan menghilangkan data penting dari template.

Jika sistem menggunakan import Excel, sediakan:

### Import QRIS EDC

* upload .xlsx/.xls
* validasi header
* preview sebelum import
* validasi tanggal
* validasi nominal
* deteksi duplicate transaction
* import hanya data valid
* tampilkan jumlah:

  * berhasil
  * duplicate
  * gagal

Untuk dashboard, gunakan **NETT AMOUNT** sebagai nominal pemasukan yang masuk ke Summary Majoo jika sesuai dengan logic template.

---

# 10. KARTU DEBIT

Template memiliki struktur transaksi EDC:

* PROC DATE
* MID
* OB
* GB
* SEQ
* TYPE
* TRX DATE
* AUTH
* CARD NO
* AMOUNT
* TID
* JENIS TRX
* PTR
* RATE
* DISC AMOUNT
* AIR FARE
* PLAN
* SS AMOUNT
* SS FEE TYPE
* FLAG
* NETT AMOUNT
* MERCHANT ACCOUNT
* MERCHANT NAME

Implementasikan.

Gunakan **NETT AMOUNT** untuk agregasi pemasukan apabila mengikuti template.

Sediakan import Excel dengan validasi dan duplicate detection.

---

# 11. KARTU KREDIT

Implementasikan struktur yang sama seperti Debit:

* PROC DATE
* MID
* OB
* GB
* SEQ
* TYPE
* TRX DATE
* AUTH
* CARD NO
* AMOUNT
* TID
* JENIS TRX
* PTR
* RATE
* DISC AMOUNT
* AIR FARE
* PLAN
* SS AMOUNT
* SS FEE TYPE
* FLAG
* NETT AMOUNT
* MERCHANT ACCOUNT
* MERCHANT NAME

Sediakan import Excel.

Gunakan NETT AMOUNT untuk Summary Majoo sesuai template.

---

# 12. SUMMARY MAJOO

Buat summary otomatis dengan kolom:

* No.
* No. Ref Pemasukan
* Tanggal
* Cash
* Transfer
* QRIS Cetak
* QRIS EDC
* Kartu Debit
* Kartu Kredit
* Total

Formula:

```text
Total Majoo =
Cash
+ Transfer
+ QRIS Cetak
+ QRIS EDC
+ Kartu Debit
+ Kartu Kredit
```

Jangan meminta user menghitung total secara manual.

---

# 13. GOBIZ

Buat halaman/form khusus GoBiz.

Field:

* Tanggal
* Penjualan Kotor
* Biaya Komisi
* Biaya Promo
* Biaya Iklan
* Biaya Diskon
* Penjualan Bersih

Formula:

```text
Penjualan Bersih =
Penjualan Kotor
- Biaya Komisi
- Biaya Promo
- Biaya Iklan
- Biaya Diskon
```

Penjualan Bersih dihitung otomatis.

User tidak boleh memasukkan Penjualan Bersih secara manual.

---

# 14. MASTER INCOME

Buat master Income yang menggabungkan:

* Majoo
* GoBiz

Field minimal:

* Date
* Akun Holding
* No. Ref Pemasukan
* Jumlah
* Tipe

Tipe:

```text
MJO
GBZ
```

Reference Income:

```text
INC/{DDMMYY}/MJO
INC/{DDMMYY}/GBZ
```

Contoh:

```text
INC/010826/MJO
INC/010826/GBZ
```

Reference harus dibuat otomatis.

---

# 15. SUMMARY INCOME

Buat summary:

* No.
* Akun Holding
* Tanggal
* Jumlah Pemasukan

Summary harus mengambil data dari master Income.

Jangan menyimpan summary sebagai data manual yang dapat menyebabkan inkonsistensi.

Gunakan aggregation/query backend.

---

# 16. DASHBOARD EXPENSE

Buat dashboard Expense terpisah.

### KPI

* Total Expense periode
* Total Biaya Bahan Baku
* Total Utilities & Operasional

### Chart

1. Bar Chart:

   * Expense berdasarkan Item Category

2. Pie/Doughnut Chart:

   * Fixed Cost
   * Variable Cost

### Summary Table

Kolom:

* No.
* Akun Holding
* Tanggal
* Jumlah Pengeluaran

---

# 17. EXPENSE ENTRY

Expense harus mendukung struktur transaksi seperti template Excel.

Field:

### Identitas

* Date
* Akun Holding
* Nomor Invoice
* No. Ref Pengeluaran
* Title
* Item Name
* Supplier
* Item Category
* Cost Category

### Komponen Biaya

* Qty
* Price
* Delivery Fee
* Delivery Insurance
* Admin/App Fee
* Item Discount
* Delivery Discount
* PPN
* Bank Admin

---

# 18. MULTI ITEM EXPENSE

Satu transaksi Expense dapat mempunyai banyak item.

Contoh:

```text
Expense:
Belanja New Ngesti

Item:
- Goldenfil Strawberry
- Zoda
- Marjan Strawberry
```

Jangan membuat user harus membuat transaksi baru untuk setiap item jika sebenarnya berada dalam satu invoice/transaksi.

Gunakan:

```text
expenses
expense_details
```

dengan relasi:

```text
Expense hasMany ExpenseDetail
```

---

# 19. FORMULA EXPENSE

Implementasikan formula persis:

### Sub Total 1

```text
(Qty × Price)
+ Delivery Fee
+ Delivery Insurance
+ Admin/App Fee
- Item Discount
- Delivery Discount
```

### Sub Total 2

```text
Sub Total 1 + PPN
```

### Sub Total 3

```text
Sub Total 2 + Bank Admin
```

Semua otomatis.

Jangan membiarkan user mengubah hasil formula secara manual.

---

# 20. STATUS PEMBAYARAN

Expense memiliki status:

```text
Lunas
Pending
```

Gunakan toggle/status badge yang jelas.

Status harus dapat difilter.

Tambahkan:

* total lunas
* total pending

Jika relevan pada dashboard/detail expense.

---

# 21. INVOICE

Expense harus mendukung upload invoice.

Format:

* PDF
* PNG
* JPG/JPEG

Gunakan Laravel Storage.

Jangan menyimpan file langsung sebagai binary database jika tidak diperlukan.

Database menyimpan:

```text
invoice_path
```

Tambahkan:

* preview
* download
* delete dengan authorization
* validasi MIME
* validasi ukuran file

---

# 22. EXPENSE REFERENCE NUMBER

Reference Expense harus dibuat otomatis.

Format:

```text
{Akun Holding}/{DDMMYY}-{Urutan Harian}-{Urutan Bulanan}/{Kode Akun}-{Kode Sub Akun}
```

Contoh:

```text
EXP/010826-01-01/OPS-BAH
EXP/010826-01-01/OPS-UTI
```

Urutan:

### Urutan Harian

Nomor transaksi ke-X pada tanggal tersebut.

### Urutan Bulanan

Nomor transaksi ke-X pada bulan tersebut.

Reference tidak boleh duplicate.

Gunakan database transaction/locking bila diperlukan agar aman ketika dua user membuat transaksi bersamaan.

---

# 23. MASTER KODE REFERENSI

Buat master/reference configuration berdasarkan template.

Kategori yang tersedia:

### OPS

* Bahan Baku → BAH
* Utilities → UTI
* Aset → AST
* Wifi → WIF
* Stationery → STA
* Listrik → LIS
* PDAM → AIR
* Maintenance → MTC
* RnD → RND

### FIN

* Payroll → PAY

### MKT

* Marketing → MKT

### OTH

* Other → OTH

### CSN

* Consignment → CSN

Jangan hardcode seluruh logic di controller.

Simpan sebagai master database agar dapat dikelola admin.

---

# 24. COST CATEGORY

Expense mendukung:

```text
Fixed
Variable
```

Cost Category harus dapat digunakan untuk filtering dan chart.

---

# 25. ITEM CATEGORY

Item Category harus dapat dikelola sebagai master.

Minimal mendukung kategori dari template/brief, termasuk:

* Bahan Baku
* Bahan Baku Bar
* Bahan Baku Kitchen
* Utilities
* Listrik
* Other
* dan kategori lain yang memang digunakan oleh data Kanca Coffee.

Jangan menghapus kategori existing yang sudah digunakan project.

---

# 26. JURNAL KEUANGAN

Template memiliki sheet:

**Jurnal Keuangan - Kanca Coffee**

Struktur:

* Tanggal
* Akun Holding
* Debit
* Kredit

Implementasikan sebagai financial journal/ledger yang dihasilkan otomatis.

Income:

```text
Akun Holding = INC
Kredit = Income
Debit = 0
```

Expense:

```text
Akun Holding = EXP
Debit = Expense
Kredit = 0
```

Jurnal harus berasal dari transaksi aktual.

Jangan membuat user menginput jurnal secara manual untuk transaksi yang sudah tercatat melalui Income/Expense.

---

# 27. INTEGRASI INVENTORY + EXPENSE

Expense kategori Bahan Baku harus dapat terhubung dengan inventory.

Ketika bahan baku dibeli:

* Expense tercatat sebagai pengeluaran;
* stok inventory dapat bertambah jika transaksi memang ditandai sebagai pembelian inventory;
* item bahan baku dapat dikaitkan dengan master ingredient;
* jangan sampai stok dan expense menggunakan data terpisah tanpa relasi.

---

# 28. INTEGRASI INVENTORY + KEUANGAN

Sistem harus mempertahankan modul inventory yang sudah ada.

Inventory memiliki:

### Opening Stock

Stok awal ketika cafe buka.

### Incoming Stock

Stok yang masuk.

### Closing Stock

Stok ketika cafe tutup.

### Consumption

Formula:

```text
Consumption =
Opening Stock + Incoming Stock - Closing Stock
```

Contoh:

```text
Opening Coffee = 1.000 ml
Incoming = 0 ml
Closing = 800 ml

Consumption = 200 ml
```

Jangan merusak fitur ini ketika mengubah modul keuangan.

---

# 29. MIXED / COMPOSITE INGREDIENT

Tetap dukung:

```text
Single Ingredient
+
Single Ingredient
=
Mixed Ingredient
```

Contoh:

```text
Susu 500 ml
+
Krimer 500 gr
=
Krimer-Susu 1 Liter
```

Ketika mixed ingredient dibuat:

* stok bahan dasar dikurangi berdasarkan recipe;
* stok mixed ingredient bertambah;
* histori produksi dicatat;
* tidak boleh terjadi pengurangan stok ganda.

---

# 30. DYNAMIC FILTER

Dashboard harus memiliki filter:

### Daily

Data per hari / periode harian.

### Monthly

Rekap per bulan.

### Quarterly

* Q1
* Q2
* Q3
* Q4

### Yearly

Tren antar tahun.

Filter harus mempengaruhi:

* KPI
* chart
* summary table
* total income
* total expense
* channel breakdown
* cashflow

Jangan hanya mengubah label chart.

Semua angka harus benar-benar berubah berdasarkan filter.

---

# 31. CUSTOM DATE RANGE

Selain filter:

* Daily
* Monthly
* Quarterly
* Yearly

Tambahkan jika tidak bertentangan dengan UI existing:

```text
Custom Date Range
```

Contoh:

```text
01/08/2026 - 18/08/2026
```

Semua data dashboard mengikuti range tersebut.

---

# 32. CASHFLOW

Buat kalkulasi:

```text
Net Cashflow =
Total Income - Total Expense
```

Tampilkan:

* Income
* Expense
* Net Cashflow

Gunakan periode aktif.

---

# 33. EXPORT PDF

Semua laporan penting harus dapat diekspor ke PDF.

Minimal:

### Income Report

* periode
* total income
* Majoo
* GoBiz
* breakdown channel
* detail transaksi

### Expense Report

* periode
* total expense
* breakdown category
* detail expense
* status pembayaran

### Inventory Report

* opening
* incoming
* closing
* consumption

### Cashflow Report

* total income
* total expense
* net cashflow

PDF harus:

* rapi
* profesional
* memiliki nama Kanca Coffee
* memiliki periode laporan
* siap dicetak.

Gunakan Laravel DomPDF/Barryvdh sesuai brief.

---

# 34. EXPORT EXCEL

Gunakan Laravel Excel / Maatwebsite.

Sediakan export:

* Income
* Majoo
* GoBiz
* Expense
* Summary Expense
* Summary Income
* Cash
* Transfer
* QRIS Cetak
* QRIS EDC
* Debit
* Kredit
* Inventory
* Jurnal
* Cashflow

Jika memungkinkan, export report menggunakan struktur kolom yang konsisten dengan template Excel.

---

# 35. IMPORT EXCEL

Karena template memiliki data transaksi EDC/Debit/Kredit yang berbentuk spreadsheet, buat mekanisme import Excel yang aman.

Import harus memiliki:

1. Upload file
2. Validasi extension
3. Validasi header
4. Preview
5. Validasi data
6. Duplicate detection
7. Confirmation
8. Import
9. Summary hasil import

Jangan langsung memasukkan file tanpa validasi.

---

# 36. DUPLICATE DETECTION

Untuk transaksi EDC/Debit/Kredit, gunakan kombinasi field yang relevan seperti:

* tanggal transaksi
* sequence
* auth
* amount
* merchant
* reference/internal identifier

sebagai unique fingerprint bila sesuai dengan struktur data.

Tujuannya agar file yang sama tidak menghasilkan transaksi ganda.

---

# 37. DATABASE

Gunakan database relational yang normal.

Minimal struktur:

```text
income
income_details
income_summaries

majoo_cash
majoo_transfers
majoo_qris_cetak
majoo_qris_edc
majoo_debit
majoo_credit
majoo_summaries

gobiz_transactions

expenses
expense_details

expense_categories
cost_categories
suppliers

financial_accounts
financial_sub_accounts
reference_sequences

journal_entries
journal_entry_details

invoices / atau invoice metadata

ingredients
mixed_ingredients
recipes
inventory_logs
```

Sesuaikan dengan struktur database project existing agar tidak membuat duplicate table yang tidak perlu.

---

# 38. DATABASE RELATIONSHIP

Pastikan relasi:

```text
Income
 ├── Income Details
 ├── Majoo Summary
 └── GoBiz

Expense
 ├── Expense Details
 ├── Supplier
 ├── Category
 ├── Invoice
 └── Inventory (jika pembelian bahan baku)

Journal
 ├── Income
 └── Expense

Inventory
 ├── Ingredient
 ├── Mixed Ingredient
 ├── Recipe
 └── Inventory Log
```

---

# 39. TRANSACTION SAFETY

Gunakan:

```php
DB::transaction()
```

untuk proses:

* create expense
* create expense details
* generate reference
* upload invoice metadata
* update inventory
* create journal

Jika salah satu gagal, transaksi harus rollback.

---

# 40. VALIDASI

Semua form wajib memiliki validation.

Contoh:

### Income

* tanggal wajib
* nominal tidak boleh negatif
* channel wajib
* reference otomatis

### Expense

* tanggal wajib
* category wajib
* cost category wajib
* qty > 0
* price >= 0
* nominal tidak negatif
* invoice sesuai format
* status pembayaran valid

### Inventory

* quantity tidak negatif
* unit wajib
* ingredient wajib

---

# 41. AUTHORIZATION

Jika sistem memiliki role Admin/Staff:

### Admin

Dapat:

* melihat seluruh data
* membuat
* mengedit
* menghapus
* import
* export
* mengelola master category
* mengelola reference
* melihat financial dashboard

### Staff

Sesuaikan dengan permission existing.

Jangan membypass middleware/security.

---

# 42. UI/UX

Jangan membuat dashboard seperti spreadsheet mentah.

Gunakan UI modern dan profesional.

Tetapi struktur data harus tetap mengikuti template.

Dashboard harus memiliki:

* KPI cards
* charts
* tables
* filters
* status badges
* action buttons
* pagination
* search
* sorting
* modal/form yang jelas

Gunakan format Rupiah:

```text
Rp 1.250.000
```

Gunakan format tanggal Indonesia.

Responsive:

* Desktop
* Tablet
* Mobile

---

# 43. PERFORMANCE

Jangan mengambil seluruh database lalu menghitung di frontend.

Gunakan:

* SQL aggregation
* SUM
* GROUP BY
* date filtering
* eager loading
* pagination
* indexes

Untuk dashboard gunakan query yang efisien.

Tambahkan index pada field seperti:

```text
date
transaction_date
reference_number
category_id
cost_category
status
channel
```

sesuai kebutuhan.

---

# 44. CHART

Gunakan Chart.js atau ApexCharts.

Minimal:

### Income

* Line Chart Majoo vs GoBiz
* Doughnut channel Majoo

### Expense

* Bar Chart Item Category
* Pie/Doughnut Fixed vs Variable

### Optional

* Income vs Expense
* Net Cashflow trend
* Inventory consumption trend

Chart harus mengikuti filter aktif.

---

# 45. SEARCH & TABLE

Semua tabel utama sebaiknya memiliki:

* search
* filter
* sorting
* pagination

Untuk transaksi:

* filter tanggal
* channel
* category
* supplier
* status
* cost category

---

# 46. EMPTY STATE

Jika belum ada data:

Jangan tampilkan:

```text
NaN
undefined
null
```

Tampilkan:

```text
Belum ada data pada periode ini.
```

Nominal kosong:

```text
Rp 0
```

Chart kosong harus tetap memiliki empty state yang baik.

---

# 47. ERROR HANDLING

Buat error handling yang jelas.

Jangan menampilkan stack trace Laravel kepada user.

Gunakan:

* validation message
* toast notification
* success message
* error message
* confirmation modal

---

# 48. AUDIT TRAIL

Jika struktur project memungkinkan, tambahkan log:

* created_by
* updated_by
* created_at
* updated_at

Untuk transaksi finansial penting.

Jika transaksi diubah/dihapus, pastikan aman dan tidak merusak summary/journal.

---

# 49. SOFT DELETE

Untuk transaksi keuangan, pertimbangkan soft delete daripada hard delete agar histori tetap aman.

Jika transaksi dihapus:

* summary harus otomatis menyesuaikan;
* journal harus otomatis menyesuaikan;
* inventory harus dikembalikan jika sebelumnya terpengaruh.

---

# 50. KONSISTENSI DATA

Satu transaksi tidak boleh menghasilkan angka berbeda antara:

* Income Detail
* Summary Income
* Summary Majoo
* Dashboard Income
* Jurnal

Demikian juga Expense:

* Expense Detail
* Summary Expense
* Dashboard Expense
* Jurnal
* Cashflow

Semua harus berasal dari sumber data yang sama.

---

# 51. SOURCE OF TRUTH

Jangan membuat:

```text
Dashboard total
```

yang disimpan manual.

Dashboard harus menghitung dari database.

Contoh:

```text
Total Income =
SUM(income)
```

berdasarkan periode.

Bukan:

```text
dashboard_total_income
```

yang diinput manual.

---

# 52. MASTER DATA

Buat halaman/master management jika belum tersedia:

* Income Channel
* Expense Category
* Item Category
* Cost Category
* Supplier
* Financial Account
* Financial Sub Account
* Ingredient
* Unit
* Mixed Ingredient
* Recipe

Gunakan CRUD yang sesuai role.

---

# 53. REFERENCE SEQUENCE

Jangan menggunakan:

```php
$count() + 1
```

secara naif untuk reference number karena rawan duplicate saat concurrent request.

Gunakan mekanisme sequence yang aman.

Contoh:

```text
EXP/010826-01-01/OPS-BAH
```

Artinya:

* EXP = akun holding
* 010826 = DDMMYY
* 01 = urutan harian
* 01 = urutan bulanan
* OPS = account code
* BAH = sub account code

Income:

```text
INC/010826/MJO
INC/010826/GBZ
```

---

# 54. JANGAN MENGHILANGKAN STRUKTUR TEMPLATE

Template Excel memiliki sheet:

```text
Kode Referensi
Jurnal
Expense
Summary Expense
Income
Summary Income
Summary Majoo
Cash
Transfer
QRIS Cetak
QRIS EDC
Debit
Kredit
Gobiz
```

Semua konsep yang terdapat di sheet tersebut harus terwakili dalam sistem web.

Tidak harus dibuat menjadi 14 halaman terpisah.

Namun fungsi dan data pentingnya **tidak boleh hilang**.

---

# 55. MAPPING TEMPLATE KE WEB

Gunakan mapping konseptual:

```text
Kode Referensi
→ Master Financial Account / Reference Generator

Jurnal
→ Journal / Ledger

Expense
→ Expense + Expense Details

Summary Expense
→ Expense Dashboard / Expense Summary

Income
→ Income Master

Summary Income
→ Income Dashboard / Income Summary

Summary Majoo
→ Majoo Dashboard / Summary

Cash
→ Majoo Cash

Transfer
→ Majoo Transfer

QRIS Cetak
→ Majoo QRIS Cetak

QRIS EDC
→ Majoo QRIS EDC

Debit
→ Majoo Debit

Kredit
→ Majoo Kredit

Gobiz
→ GoBiz
```

---

# 56. DATA FLOW

Implementasikan alur:

## Majoo

```text
Input/Import Channel
        ↓
Channel Database
        ↓
Summary Majoo
        ↓
Master Income
        ↓
Summary Income
        ↓
Dashboard Income
        ↓
Journal
```

## GoBiz

```text
Input GoBiz
        ↓
Calculate Net Sales
        ↓
Master Income
        ↓
Summary Income
        ↓
Dashboard Income
        ↓
Journal
```

## Expense

```text
Expense Entry
        ↓
Expense Details
        ↓
Calculate Subtotal
        ↓
Expense Summary
        ↓
Dashboard Expense
        ↓
Journal
        ↓
Inventory jika bahan baku
```

---

# 57. REPORTING

Buat halaman Reporting yang dapat memilih:

```text
Report Type:
- Income
- Expense
- Majoo
- GoBiz
- Cashflow
- Inventory
- Journal
```

Filter:

```text
Daily
Monthly
Quarterly
Yearly
Custom
```

Action:

```text
View
Export PDF
Export Excel
```

---

# 58. DASHBOARD OVERVIEW

Jika project memiliki dashboard utama, tambahkan:

### Financial Overview

* Total Income
* Total Expense
* Net Cashflow
* Total Pending Expense

### Income

* Majoo
* GoBiz

### Expense

* Bahan Baku
* Utilities
* Other
* Fixed
* Variable

### Inventory

* Total bahan
* Low stock
* Consumption

Semua mengikuti periode aktif.

---

# 59. TESTING WAJIB

Setelah implementasi, lakukan testing.

## Income

Test:

* Cash
* Transfer
* QRIS Cetak
* QRIS EDC
* Debit
* Kredit
* GoBiz

## Expense

Test:

* single item
* multiple item
* discount
* delivery
* PPN
* bank admin
* invoice
* pending
* lunas

## Reference

Test:

* transaksi pertama hari itu
* transaksi kedua hari itu
* transaksi bulan berikutnya
* kategori berbeda
* concurrent request

## Dashboard

Test:

* Daily
* Monthly
* Quarterly
* Yearly
* Custom

## Export

Test:

* PDF
* Excel

## Inventory

Test:

* opening
* incoming
* closing
* consumption
* mixed ingredient

---

# 60. TEST CASE FORMULA

Pastikan:

### Inventory

```text
Opening = 1000 ml
Incoming = 0 ml
Closing = 800 ml

Usage = 200 ml
```

### GoBiz

```text
Gross = 1.000.000
Commission = 100.000
Promo = 50.000
Ads = 25.000
Discount = 25.000

Net = 800.000
```

### Expense

```text
Qty = 2
Price = 100.000
Delivery = 10.000
Insurance = 5.000
Admin = 2.000
Item Discount = 5.000
Delivery Discount = 2.000

Subtotal 1 =
(2 × 100.000)
+ 10.000
+ 5.000
+ 2.000
- 5.000
- 2.000
```

Kemudian:

```text
Subtotal 2 = Subtotal 1 + PPN
Subtotal 3 = Subtotal 2 + Bank Admin
```

---

# 61. MIGRATION SAFETY

Jika database sudah memiliki data:

* jangan langsung migrate:fresh;
* jangan menghapus data production;
* buat migration baru;
* lakukan migration secara incremental;
* backup terlebih dahulu jika diperlukan.

Jika ada struktur database lama yang konflik, buat strategi migration yang aman.

---

# 62. BACKWARD COMPATIBILITY

Jika project saat ini sudah memiliki:

* inventory
* income
* expense
* user
* admin
* dashboard

jangan merusaknya.

Perubahan modul keuangan harus tetap kompatibel dengan fitur existing.

---

# 63. IMPLEMENTATION ORDER

Kerjakan dengan urutan:

### STEP 1

Audit project.

### STEP 2

Audit database.

### STEP 3

Audit modul inventory existing.

### STEP 4

Design database financial.

### STEP 5

Migration.

### STEP 6

Model + relationships.

### STEP 7

Reference generator.

### STEP 8

Income/Majoo.

### STEP 9

GoBiz.

### STEP 10

Expense.

### STEP 11

Journal.

### STEP 12

Inventory integration.

### STEP 13

Dashboard Income.

### STEP 14

Dashboard Expense.

### STEP 15

Dynamic filtering.

### STEP 16

Reporting.

### STEP 17

PDF/Excel.

### STEP 18

Import Excel.

### STEP 19

Authorization.

### STEP 20

Testing & debugging.

---

# 64. ATURAN PENTING UNTUK AI CODING AGENT

Jangan hanya membuat UI.

Implementasikan:

```text
Frontend
+
Backend
+
Database
+
Business Logic
+
Validation
+
Authorization
+
Reporting
+
Export
+
Import
+
Testing
```

Jangan membuat dummy calculation di JavaScript.

Semua financial calculation penting harus divalidasi di backend.

Jangan hardcode angka dashboard.

Jangan hardcode total.

Jangan hardcode reference number.

Jangan menyimpan summary manual jika dapat dihitung dari transaksi.

---

# 65. HASIL AKHIR YANG DIHARAPKAN

Setelah selesai, sistem Kanca Coffee harus mampu menggantikan fungsi utama template Excel.

User harus bisa:

1. Input income.
2. Input/import transaksi Majoo.
3. Input GoBiz.
4. Melihat summary Majoo.
5. Melihat summary Income.
6. Input Expense.
7. Menambahkan banyak item dalam satu Expense.
8. Upload invoice.
9. Mengatur status pembayaran.
10. Melihat Summary Expense.
11. Melihat Journal.
12. Melihat Cashflow.
13. Mengelola inventory.
14. Melihat konsumsi bahan.
15. Membuat mixed ingredient.
16. Memfilter data berdasarkan waktu.
17. Melihat chart dinamis.
18. Export PDF.
19. Export Excel.
20. Import data spreadsheet.
21. Memastikan reference number otomatis.
22. Memastikan seluruh angka antar modul konsisten.

---

# 66. FINAL QUALITY CHECK

Sebelum menyatakan pekerjaan selesai, lakukan audit final:

* [ ] Semua requirement Project Brief V2 sudah terimplementasi.
* [ ] Semua fungsi penting Template Keuangan sudah terwakili.
* [ ] 6 channel Majoo tersedia.
* [ ] Cash memiliki Kasir vs Aktual dan Selisih Harian.
* [ ] Transfer tersedia.
* [ ] QRIS Cetak tersedia.
* [ ] QRIS EDC tersedia.
* [ ] Debit tersedia.
* [ ] Kredit tersedia.
* [ ] GoBiz tersedia.
* [ ] GoBiz Net Sales otomatis.
* [ ] Summary Majoo otomatis.
* [ ] Summary Income otomatis.
* [ ] Expense multi-item tersedia.
* [ ] Formula Expense benar.
* [ ] PPN benar.
* [ ] Bank Admin benar.
* [ ] Invoice upload tersedia.
* [ ] Status Lunas/Pending tersedia.
* [ ] Reference Expense otomatis.
* [ ] Reference Income otomatis.
* [ ] Jurnal otomatis.
* [ ] Inventory tetap berjalan.
* [ ] Inventory consumption benar.
* [ ] Mixed Ingredient tetap berjalan.
* [ ] Daily filter berjalan.
* [ ] Monthly filter berjalan.
* [ ] Quarterly filter berjalan.
* [ ] Yearly filter berjalan.
* [ ] Custom date range berjalan jika diimplementasikan.
* [ ] Dashboard Income dinamis.
* [ ] Dashboard Expense dinamis.
* [ ] Cashflow tersedia.
* [ ] PDF export berjalan.
* [ ] Excel export berjalan.
* [ ] Excel import berjalan untuk data yang relevan.
* [ ] Duplicate detection berjalan.
* [ ] Validation berjalan.
* [ ] Authorization berjalan.
* [ ] Responsive.
* [ ] Tidak ada error console.
* [ ] Tidak ada route error.
* [ ] Tidak ada SQL error.
* [ ] Tidak ada undefined/null/NaN pada dashboard.
* [ ] Tidak ada duplicate calculation.
* [ ] Tidak ada fitur existing yang rusak.

---

# 67. OUTPUT SETELAH IMPLEMENTASI

Setelah coding selesai, jangan hanya mengatakan "selesai".

Berikan laporan:

### A. Perubahan Database

Daftar migration/table yang dibuat atau diubah.

### B. Perubahan Backend

Controller, Model, Service, Job, Export/Import, dan logic yang dibuat/diubah.

### C. Perubahan Frontend

Halaman, component, chart, modal, table, filter, dan UI yang dibuat/diubah.

### D. Business Logic

Jelaskan formula dan automation yang diterapkan.

### E. Integration

Jelaskan hubungan Income, Expense, Journal, Cashflow, dan Inventory.

### F. Testing

Tampilkan hasil testing dan masalah yang ditemukan.

### G. Remaining Issue

Jika ada requirement yang tidak dapat diimplementasikan karena keterbatasan source/project, jelaskan secara eksplisit.

Jangan mengklaim fitur selesai jika sebenarnya hanya dibuat UI-nya.

---

# INSTRUKSI TERAKHIR

**Mulai dengan audit project Kanca Coffee yang sedang terbuka.**

Baca dan pahami struktur existing sebelum mengubah kode.

Gunakan **Project Brief V2 dan Template Keuangan Kanca Coffee sebagai source of truth**.

Implementasikan sistem secara bertahap.

Jangan menghapus fitur existing tanpa alasan.

Jangan membuat data dummy sebagai pengganti business logic.

Jangan membuat dashboard palsu.

Jangan berhenti setelah membuat frontend.

Pastikan:

**DATABASE → BACKEND → BUSINESS LOGIC → API/ROUTE → FRONTEND → DASHBOARD → REPORT → EXPORT → INVENTORY**

semuanya terhubung dan berjalan end-to-end.

Jika menemukan conflict antara implementasi lama dengan requirement baru, identifikasi conflict tersebut terlebih dahulu, lalu pilih solusi yang paling aman tanpa kehilangan data dan fitur existing.

**Target akhir: sistem web Kanca Coffee harus dapat menggantikan template Excel Keuangan Kanca Coffee untuk operasional harian, tetapi dengan sistem yang lebih aman, otomatis, terintegrasi, searchable, filterable, dan dapat menghasilkan laporan.**
