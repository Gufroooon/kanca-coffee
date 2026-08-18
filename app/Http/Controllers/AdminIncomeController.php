<?php

namespace App\Http\Controllers;

use App\Models\GobizTransaction;
use App\Models\Income;
use App\Models\MajooCash;
use App\Models\MajooEdcTransaction;
use App\Models\MajooQrisCetak;
use App\Models\MajooTransfer;
use App\Services\ExcelImportService;
use App\Services\FinancialAggregationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminIncomeController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'cash');
        $dateFrom = $request->get('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->get('date_to', now()->toDateString());

        $cashData = MajooCash::whereBetween('date', [$dateFrom, $dateTo])->orderBy('date', 'desc')->paginate(15, ['*'], 'page_cash');
        $transferData = MajooTransfer::whereBetween('date', [$dateFrom, $dateTo])->orderBy('date', 'desc')->paginate(15, ['*'], 'page_transfer');
        $qrisCetakData = MajooQrisCetak::whereBetween('date', [$dateFrom, $dateTo])->orderBy('date', 'desc')->paginate(15, ['*'], 'page_qris');
        $edcData = MajooEdcTransaction::whereBetween('trx_date', [$dateFrom, $dateTo])->orderBy('trx_date', 'desc')->paginate(15, ['*'], 'page_edc');
        $gobizData = GobizTransaction::whereBetween('date', [$dateFrom, $dateTo])->orderBy('date', 'desc')->paginate(15, ['*'], 'page_gobiz');
        
        $masterIncomes = Income::whereBetween('date', [$dateFrom, $dateTo])->orderBy('date', 'desc')->paginate(15, ['*'], 'page_income');

        return view('admin.finance.income.database', compact(
            'tab', 'dateFrom', 'dateTo', 'cashData', 'transferData', 'qrisCetakData', 'edcData', 'gobizData', 'masterIncomes'
        ));
    }

    public function storeCash(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'cashier_amount' => ['required', 'numeric', 'min:0'],
            'actual_amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $cashier = (float)$data['cashier_amount'];
        $actual = (float)$data['actual_amount'];
        $difference = $actual - $cashier;

        DB::transaction(function () use ($data, $cashier, $actual, $difference) {
            MajooCash::updateOrCreate(
                ['date' => $data['date']],
                [
                    'cashier_amount' => $cashier,
                    'actual_amount' => $actual,
                    'difference' => $difference,
                    'notes' => $data['notes'] ?? null,
                    'user_id' => auth()->id(),
                ]
            );

            FinancialAggregationService::syncMajooIncome($data['date']);
        });

        return back()->with('success', 'Data Kas Majoo berhasil disimpan & selisih harian dihitung otomatis.');
    }

    public function storeTransfer(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($data) {
            MajooTransfer::updateOrCreate(
                ['date' => $data['date']],
                [
                    'amount' => $data['amount'],
                    'notes' => $data['notes'] ?? null,
                    'user_id' => auth()->id(),
                ]
            );

            FinancialAggregationService::syncMajooIncome($data['date']);
        });

        return back()->with('success', 'Data Bank Transfer Majoo berhasil disimpan.');
    }

    public function storeQrisCetak(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($data) {
            MajooQrisCetak::updateOrCreate(
                ['date' => $data['date']],
                [
                    'amount' => $data['amount'],
                    'notes' => $data['notes'] ?? null,
                    'user_id' => auth()->id(),
                ]
            );

            FinancialAggregationService::syncMajooIncome($data['date']);
        });

        return back()->with('success', 'Data QRIS Cetak Majoo berhasil disimpan.');
    }

    public function storeGobiz(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'gross_sales' => ['required', 'numeric', 'min:0'],
            'commission_fee' => ['nullable', 'numeric', 'min:0'],
            'promo_fee' => ['nullable', 'numeric', 'min:0'],
            'ads_fee' => ['nullable', 'numeric', 'min:0'],
            'discount_fee' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $gross = (float)$data['gross_sales'];
        $comm = (float)($data['commission_fee'] ?? 0);
        $promo = (float)($data['promo_fee'] ?? 0);
        $ads = (float)($data['ads_fee'] ?? 0);
        $disc = (float)($data['discount_fee'] ?? 0);

        $netSales = $gross - ($comm + $promo + $ads + $disc);
        if ($netSales < 0) $netSales = 0;

        DB::transaction(function () use ($data, $gross, $comm, $promo, $ads, $disc, $netSales) {
            $gobiz = GobizTransaction::updateOrCreate(
                ['date' => $data['date']],
                [
                    'gross_sales' => $gross,
                    'commission_fee' => $comm,
                    'promo_fee' => $promo,
                    'ads_fee' => $ads,
                    'discount_fee' => $disc,
                    'net_sales' => $netSales,
                    'notes' => $data['notes'] ?? null,
                    'user_id' => auth()->id(),
                ]
            );

            FinancialAggregationService::syncGobizIncome($gobiz);
        });

        return back()->with('success', 'Data GoBiz berhasil disimpan. Penjualan bersih dihitung otomatis.');
    }

    public function importSpreadsheet(Request $request)
    {
        $request->validate([
            'edc_type' => ['required', 'in:qris_edc,debit,credit'],
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:10240'],
        ]);

        $res = ExcelImportService::importEdcSpreadsheet($request->file('file'), $request->edc_type);

        if ($res['error']) {
            return back()->with('error', $res['error']);
        }

        return back()->with('success', "Impor selesai! Berhasil: {$res['success']} transaksi, Duplikat (diabaikan): {$res['duplicate']}, Gagal: {$res['failed']}.");
    }
}
