<?php

namespace App\Services;

use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Models\GobizTransaction;
use App\Models\Income;
use App\Models\Ingredient;
use App\Models\JournalEntry;
use App\Models\MajooCash;
use App\Models\MajooEdcTransaction;
use App\Models\MajooQrisCetak;
use App\Models\MajooTransfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialAggregationService
{
    /**
     * Recalculate and update Majoo summary income for a given date
     */
    public static function syncMajooIncome(string|Carbon $date): Income
    {
        $dateStr = is_string($date) ? $date : $date->toDateString();

        $cash = MajooCash::whereDate('date', $dateStr)->value('actual_amount') ?? 0;
        $transfer = MajooTransfer::whereDate('date', $dateStr)->value('amount') ?? 0;
        $qrisCetak = MajooQrisCetak::whereDate('date', $dateStr)->value('amount') ?? 0;

        $qrisEdc = MajooEdcTransaction::where('edc_type', 'qris_edc')->whereDate('trx_date', $dateStr)->sum('nett_amount');
        $debit = MajooEdcTransaction::where('edc_type', 'debit')->whereDate('trx_date', $dateStr)->sum('nett_amount');
        $credit = MajooEdcTransaction::where('edc_type', 'credit')->whereDate('trx_date', $dateStr)->sum('nett_amount');

        $totalMajoo = (float)$cash + (float)$transfer + (float)$qrisCetak + (float)$qrisEdc + (float)$debit + (float)$credit;

        $refNumber = ReferenceGenerator::generateIncomeRef($dateStr, 'MJO');

        $income = Income::updateOrCreate(
            ['date' => $dateStr, 'type' => 'MJO'],
            [
                'holding_account' => 'INC',
                'ref_number' => $refNumber,
                'amount' => $totalMajoo,
                'user_id' => auth()->id(),
            ]
        );

        // Sync Journal Entry
        JournalEntry::updateOrCreate(
            ['source_type' => 'income_mjo', 'source_id' => $income->id],
            [
                'entry_date' => $dateStr,
                'ref_number' => $income->ref_number,
                'holding_account' => 'INC',
                'debit' => 0,
                'credit' => $totalMajoo,
                'description' => "Pemasukan Majoo POS (6 Channel) tanggal {$dateStr}"
            ]
        );

        return $income;
    }

    /**
     * Recalculate and update GoBiz summary income for a given date
     */
    public static function syncGobizIncome(GobizTransaction $gobiz): Income
    {
        $dateStr = $gobiz->date->toDateString();
        $refNumber = ReferenceGenerator::generateIncomeRef($dateStr, 'GBZ');

        $income = Income::updateOrCreate(
            ['date' => $dateStr, 'type' => 'GBZ'],
            [
                'holding_account' => 'INC',
                'ref_number' => $refNumber,
                'amount' => $gobiz->net_sales,
                'user_id' => auth()->id(),
            ]
        );

        // Sync Journal Entry
        JournalEntry::updateOrCreate(
            ['source_type' => 'income_gbz', 'source_id' => $income->id],
            [
                'entry_date' => $dateStr,
                'ref_number' => $income->ref_number,
                'holding_account' => 'INC',
                'debit' => 0,
                'credit' => $gobiz->net_sales,
                'description' => "Pemasukan Bersih GoBiz Online Delivery tanggal {$dateStr}"
            ]
        );

        return $income;
    }

    /**
     * Calculate Detail Subtotals:
     * Subtotal 1 = (Qty * Price) + Delivery Fee + Delivery Insurance + Admin Fee - Item Discount - Delivery Discount
     * Subtotal 2 = Subtotal 1 + PPN
     * Subtotal 3 = Subtotal 2 + Bank Admin
     */
    public static function calculateExpenseDetailAmounts(array $item): array
    {
        $qty = (float)($item['qty'] ?? 1);
        $price = (float)($item['price'] ?? 0);
        $deliveryFee = (float)($item['delivery_fee'] ?? 0);
        $deliveryInsurance = (float)($item['delivery_insurance'] ?? 0);
        $adminAppFee = (float)($item['admin_app_fee'] ?? 0);
        $itemDiscount = (float)($item['item_discount'] ?? 0);
        $deliveryDiscount = (float)($item['delivery_discount'] ?? 0);
        $ppn = (float)($item['ppn'] ?? 0);
        $bankAdmin = (float)($item['bank_admin'] ?? 0);

        $subtotal1 = ($qty * $price) + $deliveryFee + $deliveryInsurance + $adminAppFee - $itemDiscount - $deliveryDiscount;
        if ($subtotal1 < 0) $subtotal1 = 0;

        $subtotal2 = $subtotal1 + $ppn;
        $subtotal3 = $subtotal2 + $bankAdmin;

        return [
            'qty' => $qty,
            'price' => $price,
            'delivery_fee' => $deliveryFee,
            'delivery_insurance' => $deliveryInsurance,
            'admin_app_fee' => $adminAppFee,
            'item_discount' => $itemDiscount,
            'delivery_discount' => $deliveryDiscount,
            'ppn' => $ppn,
            'bank_admin' => $bankAdmin,
            'subtotal_1' => $subtotal1,
            'subtotal_2' => $subtotal2,
            'subtotal_3' => $subtotal3,
        ];
    }

    /**
     * Sync Expense totals & Journal Entry
     */
    public static function syncExpenseJournal(Expense $expense): void
    {
        $totalAmount = $expense->details()->sum('subtotal_3');
        $expense->update(['total_amount' => $totalAmount]);

        JournalEntry::updateOrCreate(
            ['source_type' => 'expense', 'source_id' => $expense->id],
            [
                'entry_date' => $expense->date->toDateString(),
                'ref_number' => $expense->ref_number,
                'holding_account' => 'EXP',
                'debit' => $totalAmount,
                'credit' => 0,
                'description' => "Pengeluaran {$expense->title} ({$expense->ref_number})"
            ]
        );
    }

    /**
     * Date range builder based on filter choice
     */
    public static function parseTimeFilter(string $filterType, ?string $year = null, ?string $quarter = null, ?string $month = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $now = now();
        $selectedYear = $year ?: $now->year;

        switch ($filterType) {
            case 'daily':
                $from = $dateFrom ?: $now->toDateString();
                $to = $dateTo ?: $now->toDateString();
                break;
            case 'monthly':
                $m = $month ?: $now->month;
                $from = Carbon::createFromDate($selectedYear, $m, 1)->startOfMonth()->toDateString();
                $to = Carbon::createFromDate($selectedYear, $m, 1)->endOfMonth()->toDateString();
                break;
            case 'quarterly':
                $q = (int)($quarter ?: ceil($now->month / 3));
                $startMonth = ($q - 1) * 3 + 1;
                $from = Carbon::createFromDate($selectedYear, $startMonth, 1)->startOfMonth()->toDateString();
                $to = Carbon::createFromDate($selectedYear, $startMonth + 2, 1)->endOfMonth()->toDateString();
                break;
            case 'yearly':
                $from = Carbon::createFromDate($selectedYear, 1, 1)->startOfYear()->toDateString();
                $to = Carbon::createFromDate($selectedYear, 12, 31)->endOfYear()->toDateString();
                break;
            case 'custom':
            default:
                $from = $dateFrom ?: $now->startOfMonth()->toDateString();
                $to = $dateTo ?: $now->toDateString();
                break;
        }

        return [$from, $to];
    }
}
