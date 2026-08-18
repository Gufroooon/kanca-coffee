<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Models\Income;
use App\Models\JournalEntry;
use App\Models\MajooEdcTransaction;

use App\Services\FinancialAggregationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFinancialDashboardController extends Controller
{
    public function incomeDashboard(Request $request)
    {
        $filterType = $request->get('time_filter', 'monthly');
        $year = $request->get('year', date('Y'));
        $quarter = $request->get('quarter');
        $month = $request->get('month', date('n'));
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        [$from, $to] = FinancialAggregationService::parseTimeFilter($filterType, $year, $quarter, $month, $dateFrom, $dateTo);

        // KPI Cards
        $totalIncome = Income::whereBetween('date', [$from, $to])->sum('amount');
        $totalMajoo = Income::where('type', 'MJO')->whereBetween('date', [$from, $to])->sum('amount');
        $totalGobiz = Income::where('type', 'GBZ')->whereBetween('date', [$from, $to])->sum('amount');
        $totalExpense = Expense::whereBetween('date', [$from, $to])->sum('total_amount');
        $netCashflow = $totalIncome - $totalExpense;

        // Line Chart: Majoo vs GoBiz Trend
        $dailyMajoo = Income::select('date', DB::raw('SUM(amount) as total'))
            ->where('type', 'MJO')
            ->whereBetween('date', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $dailyGobiz = Income::select('date', DB::raw('SUM(amount) as total'))
            ->where('type', 'GBZ')
            ->whereBetween('date', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $allDates = Income::whereBetween('date', [$from, $to])
            ->distinct()
            ->orderBy('date')
            ->pluck('date')
            ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->toArray();

        if (empty($allDates)) {
            $allDates = [$from, $to];
        }

        $majooLineData = [];
        $gobizLineData = [];
        foreach ($allDates as $d) {
            $majooLineData[] = (float)($dailyMajoo[$d] ?? 0);
            $gobizLineData[] = (float)($dailyGobiz[$d] ?? 0);
        }

        // Doughnut Chart: Majoo 6 Channels Breakdown
        $cashTotal = DB::table('majoo_cash')->whereBetween('date', [$from, $to])->sum('actual_amount');
        $transferTotal = DB::table('majoo_transfers')->whereBetween('date', [$from, $to])->sum('amount');
        $qrisCetakTotal = DB::table('majoo_qris_cetaks')->whereBetween('date', [$from, $to])->sum('amount');
        $qrisEdcTotal = MajooEdcTransaction::where('edc_type', 'qris_edc')->whereBetween('trx_date', [$from, $to])->sum('nett_amount');
        $debitTotal = MajooEdcTransaction::where('edc_type', 'debit')->whereBetween('trx_date', [$from, $to])->sum('nett_amount');
        $creditTotal = MajooEdcTransaction::where('edc_type', 'credit')->whereBetween('trx_date', [$from, $to])->sum('nett_amount');

        $channelBreakdown = [
            'Cash' => (float)$cashTotal,
            'Bank Transfer' => (float)$transferTotal,
            'QRIS Cetak' => (float)$qrisCetakTotal,
            'QRIS EDC' => (float)$qrisEdcTotal,
            'Kartu Debit' => (float)$debitTotal,
            'Kartu Kredit' => (float)$creditTotal,
        ];

        // Income Summary Table
        $summaryTable = Income::whereBetween('date', [$from, $to])
            ->orderBy('date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.finance.income.dashboard', compact(
            'filterType', 'year', 'quarter', 'month', 'dateFrom', 'dateTo', 'from', 'to',
            'totalIncome', 'totalMajoo', 'totalGobiz', 'netCashflow',
            'allDates', 'majooLineData', 'gobizLineData', 'channelBreakdown', 'summaryTable'
        ));
    }

    public function expenseDashboard(Request $request)
    {
        $filterType = $request->get('time_filter', 'monthly');
        $year = $request->get('year', date('Y'));
        $quarter = $request->get('quarter');
        $month = $request->get('month', date('n'));
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        [$from, $to] = FinancialAggregationService::parseTimeFilter($filterType, $year, $quarter, $month, $dateFrom, $dateTo);

        // KPI Cards
        $totalExpense = Expense::whereBetween('date', [$from, $to])->sum('total_amount');
        $totalBahanBaku = ExpenseDetail::whereHas('expense', fn($q) => $q->whereBetween('date', [$from, $to]))
            ->whereHas('subAccount', fn($q) => $q->where('code', 'BAH'))
            ->sum('subtotal_3');

        $totalUtilitiesOps = ExpenseDetail::whereHas('expense', fn($q) => $q->whereBetween('date', [$from, $to]))
            ->whereHas('subAccount', fn($q) => $q->whereIn('code', ['UTI', 'LIS', 'AIR', 'WIF', 'STA']))
            ->sum('subtotal_3');

        $totalPending = Expense::where('status', 'Pending')->whereBetween('date', [$from, $to])->sum('total_amount');
        $totalLunas = Expense::where('status', 'Lunas')->whereBetween('date', [$from, $to])->sum('total_amount');

        // Bar Chart: Expense per Item Category
        $categoryBreakdown = ExpenseDetail::whereHas('expense', fn($q) => $q->whereBetween('date', [$from, $to]))
            ->leftJoin('expense_categories', 'expense_details.expense_category_id', '=', 'expense_categories.id')
            ->select(DB::raw("COALESCE(expense_categories.name, 'Lain-lain') as cat_name"), DB::raw('SUM(subtotal_3) as total'))
            ->groupBy('cat_name')
            ->orderBy('total', 'desc')
            ->pluck('total', 'cat_name')
            ->toArray();

        // Pie Chart: Fixed vs Variable Cost
        $costCategoryBreakdown = ExpenseDetail::whereHas('expense', fn($q) => $q->whereBetween('date', [$from, $to]))
            ->select('cost_category', DB::raw('SUM(subtotal_3) as total'))
            ->groupBy('cost_category')
            ->pluck('total', 'cost_category')
            ->toArray();

        // Expense Summary Table
        $summaryTable = Expense::with('supplier')
            ->whereBetween('date', [$from, $to])
            ->orderBy('date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.finance.expense.dashboard', compact(
            'filterType', 'year', 'quarter', 'month', 'dateFrom', 'dateTo', 'from', 'to',
            'totalExpense', 'totalBahanBaku', 'totalUtilitiesOps', 'totalPending', 'totalLunas',
            'categoryBreakdown', 'costCategoryBreakdown', 'summaryTable'
        ));
    }
}
