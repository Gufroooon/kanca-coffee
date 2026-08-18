<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Models\GobizTransaction;
use App\Models\Income;
use App\Models\Ingredient;
use App\Models\InventoryLog;
use App\Models\JournalEntry;
use App\Models\MajooCash;
use App\Models\MajooEdcTransaction;
use App\Models\MajooQrisCetak;
use App\Models\MajooTransfer;
use App\Services\FinancialAggregationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->get('report_type', 'income');
        $filterType = $request->get('time_filter', 'monthly');
        $year = $request->get('year', date('Y'));
        $quarter = $request->get('quarter');
        $month = $request->get('month', date('n'));
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        [$from, $to] = FinancialAggregationService::parseTimeFilter($filterType, $year, $quarter, $month, $dateFrom, $dateTo);

        $incomeRows = Income::whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();
        $expenseRows = Expense::with(['supplier', 'details.subAccount', 'details.category'])->whereBetween('date', [$from, $to])->orderBy('date', 'desc')->get();
        $journalRows = JournalEntry::whereBetween('entry_date', [$from, $to])->orderBy('entry_date', 'asc')->get();
        $inventoryLogs = InventoryLog::with('ingredient')->whereBetween('log_date', [$from, $to])->orderBy('log_date', 'desc')->get();

        $totalIncome = Income::whereBetween('date', [$from, $to])->sum('amount');
        $totalExpense = Expense::whereBetween('date', [$from, $to])->sum('total_amount');
        $netCashflow = $totalIncome - $totalExpense;

        return view('admin.reports.index', compact(
            'reportType', 'filterType', 'year', 'quarter', 'month', 'dateFrom', 'dateTo', 'from', 'to',
            'incomeRows', 'expenseRows', 'journalRows', 'inventoryLogs',
            'totalIncome', 'totalExpense', 'netCashflow'
        ));
    }

    public function exportPdf(Request $request)
    {
        $reportType = $request->get('report_type', 'income');
        $filterType = $request->get('time_filter', 'monthly');
        $year = $request->get('year', date('Y'));
        $quarter = $request->get('quarter');
        $month = $request->get('month', date('n'));
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        [$from, $to] = FinancialAggregationService::parseTimeFilter($filterType, $year, $quarter, $month, $dateFrom, $dateTo);

        $incomeRows = Income::whereBetween('date', [$from, $to])->orderBy('date', 'asc')->get();
        $expenseRows = Expense::with(['supplier', 'details.subAccount', 'details.category'])->whereBetween('date', [$from, $to])->orderBy('date', 'asc')->get();
        $journalRows = JournalEntry::whereBetween('entry_date', [$from, $to])->orderBy('entry_date', 'asc')->get();
        $inventoryLogs = InventoryLog::with('ingredient')->whereBetween('log_date', [$from, $to])->orderBy('log_date', 'asc')->get();

        $totalIncome = Income::whereBetween('date', [$from, $to])->sum('amount');
        $totalExpense = Expense::whereBetween('date', [$from, $to])->sum('total_amount');
        $netCashflow = $totalIncome - $totalExpense;

        $pdf = Pdf::loadView('admin.reports.financial-pdf', compact(
            'reportType', 'filterType', 'from', 'to', 'incomeRows', 'expenseRows', 'journalRows', 'inventoryLogs',
            'totalIncome', 'totalExpense', 'netCashflow'
        ));

        return $pdf->download("laporan-{$reportType}-kanca-coffee-{$from}-sd-{$to}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $reportType = $request->get('report_type', 'income');
        $filterType = $request->get('time_filter', 'monthly');
        $year = $request->get('year', date('Y'));
        $quarter = $request->get('quarter');
        $month = $request->get('month', date('n'));
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        [$from, $to] = FinancialAggregationService::parseTimeFilter($filterType, $year, $quarter, $month, $dateFrom, $dateTo);

        $headers = [];
        $rows = [];

        if ($reportType === 'income') {
            $headers = ['No.', 'Akun Holding', 'No. Ref Pemasukan', 'Tanggal', 'Tipe', 'Jumlah Pemasukan'];
            $incomes = Income::whereBetween('date', [$from, $to])->orderBy('date', 'asc')->get();
            foreach ($incomes as $idx => $inc) {
                $rows[] = [$idx + 1, $inc->holding_account, $inc->ref_number, $inc->date->format('Y-m-d'), $inc->type, $inc->amount];
            }
        } elseif ($reportType === 'expense') {
            $headers = ['No.', 'Akun Holding', 'No. Ref Pengeluaran', 'Invoice', 'Tanggal', 'Judul', 'Supplier', 'Status', 'Total Subtotal 3'];
            $expenses = Expense::with('supplier')->whereBetween('date', [$from, $to])->orderBy('date', 'asc')->get();
            foreach ($expenses as $idx => $exp) {
                $rows[] = [$idx + 1, $exp->holding_account, $exp->ref_number, $exp->invoice_number, $exp->date->format('Y-m-d'), $exp->title, $exp->supplier?->name, $exp->status, $exp->total_amount];
            }
        } elseif ($reportType === 'journal') {
            $headers = ['No.', 'Tanggal', 'Nomor Referensi', 'Akun Holding', 'Debit', 'Kredit', 'Keterangan'];
            $journals = JournalEntry::whereBetween('entry_date', [$from, $to])->orderBy('entry_date', 'asc')->get();
            foreach ($journals as $idx => $j) {
                $rows[] = [$idx + 1, $j->entry_date->format('Y-m-d'), $j->ref_number, $j->holding_account, $j->debit, $j->credit, $j->description];
            }
        } else {
            $headers = ['No.', 'Tanggal', 'Bahan Baku', 'Stok Awal', 'Stok Akhir', 'Konsumsi / Usage', 'Satuan'];
            $logs = InventoryLog::with('ingredient')->whereBetween('log_date', [$from, $to])->orderBy('log_date', 'asc')->get();
            foreach ($logs as $idx => $log) {
                $rows[] = [$idx + 1, $log->log_date->format('Y-m-d'), $log->ingredient?->name, $log->opening_stock, $log->closing_stock, $log->usage, $log->ingredient?->unit];
            }
        }

        $html = '<table border="1"><tr>' . collect($headers)->map(fn($h) => '<th>' . e($h) . '</th>')->implode('') . '</tr>';
        foreach ($rows as $r) {
            $html .= '<tr>' . collect($r)->map(fn($cell) => '<td>' . e((string)$cell) . '</td>')->implode('') . '</tr>';
        }
        $html .= '</table>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"laporan-{$reportType}-kanca-coffee-{$from}-sd-{$to}.xls\""
        ]);
    }
}
