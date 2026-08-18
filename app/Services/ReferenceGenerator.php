<?php

namespace App\Services;

use App\Models\FinancialSubAccount;
use App\Models\ReferenceSequence;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReferenceGenerator
{
    /**
     * Generate automatic reference code for Expense
     * Format: EXP/DDMMYY-DailySeq-MonthlySeq/AccountCode-SubAccountCode
     * Example: EXP/010826-01-01/OPS-BAH
     */
    public static function generateExpenseRef(string|Carbon $date, int $subAccountId): string
    {
        $carbonDate = is_string($date) ? Carbon::parse($date) : $date;
        $ddmmyy = $carbonDate->format('dmy');
        $dateKey = $carbonDate->format('Y-m-d');
        $monthKey = $carbonDate->format('Y-m');

        $subAccount = FinancialSubAccount::with('account')->find($subAccountId);
        $accountCode = $subAccount?->account?->code ?? 'OPS';
        $subAccountCode = $subAccount?->code ?? 'OTH';

        return DB::transaction(function () use ($dateKey, $monthKey, $ddmmyy, $accountCode, $subAccountCode) {
            // Get or create daily sequence lock
            $dailySeqRecord = ReferenceSequence::where('date_key', $dateKey)
                ->where('holding_type', 'EXP')
                ->lockForUpdate()
                ->first();

            $dailySeq = $dailySeqRecord ? $dailySeqRecord->daily_sequence + 1 : 1;

            if ($dailySeqRecord) {
                $dailySeqRecord->update(['daily_sequence' => $dailySeq]);
            } else {
                ReferenceSequence::create([
                    'date_key' => $dateKey,
                    'holding_type' => 'EXP',
                    'daily_sequence' => $dailySeq,
                    'monthly_sequence' => 0
                ]);
            }

            // Get or create monthly sequence lock
            $monthlySeqRecord = ReferenceSequence::where('date_key', $monthKey)
                ->where('holding_type', 'EXP_MONTHLY')
                ->lockForUpdate()
                ->first();

            $monthlySeq = $monthlySeqRecord ? $monthlySeqRecord->monthly_sequence + 1 : 1;

            if ($monthlySeqRecord) {
                $monthlySeqRecord->update(['monthly_sequence' => $monthlySeq]);
            } else {
                ReferenceSequence::create([
                    'date_key' => $monthKey,
                    'holding_type' => 'EXP_MONTHLY',
                    'daily_sequence' => 0,
                    'monthly_sequence' => $monthlySeq
                ]);
            }

            $dailyStr = str_pad((string)$dailySeq, 2, '0', STR_PAD_LEFT);
            $monthlyStr = str_pad((string)$monthlySeq, 2, '0', STR_PAD_LEFT);

            return "EXP/{$ddmmyy}-{$dailyStr}-{$monthlyStr}/{$accountCode}-{$subAccountCode}";
        });
    }

    /**
     * Generate automatic reference code for Income
     * Format: INC/{DDMMYY}/{MJO|GBZ}
     * Example: INC/010826/MJO
     */
    public static function generateIncomeRef(string|Carbon $date, string $type): string
    {
        $carbonDate = is_string($date) ? Carbon::parse($date) : $date;
        $ddmmyy = $carbonDate->format('dmy');
        $typeCode = strtoupper($type) === 'GOBIZ' || strtoupper($type) === 'GBZ' ? 'GBZ' : 'MJO';

        return "INC/{$ddmmyy}/{$typeCode}";
    }
}
