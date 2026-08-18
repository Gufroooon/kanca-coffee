<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\JournalEntry;
use App\Services\FinancialAggregationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminJournalController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->get('time_filter', 'monthly');
        $year = $request->get('year', date('Y'));
        $quarter = $request->get('quarter');
        $month = $request->get('month', date('n'));
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        [$from, $to] = FinancialAggregationService::parseTimeFilter($filterType, $year, $quarter, $month, $dateFrom, $dateTo);

        $entries = JournalEntry::whereBetween('entry_date', [$from, $to])
            ->orderBy('entry_date', 'asc')
            ->paginate(20)
            ->withQueryString();

        $totalDebit = JournalEntry::whereBetween('entry_date', [$from, $to])->sum('debit');
        $totalCredit = JournalEntry::whereBetween('entry_date', [$from, $to])->sum('credit');

        $totalIncome = Income::whereBetween('date', [$from, $to])->sum('amount');
        $totalExpense = Expense::whereBetween('date', [$from, $to])->sum('total_amount');
        $netCashflow = $totalIncome - $totalExpense;

        return view('admin.finance.journal.index', compact(
            'entries', 'totalDebit', 'totalCredit', 'totalIncome', 'totalExpense', 'netCashflow',
            'filterType', 'year', 'quarter', 'month', 'dateFrom', 'dateTo', 'from', 'to'
        ));
    }
}
