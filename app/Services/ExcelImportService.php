<?php

namespace App\Services;

use App\Models\MajooEdcTransaction;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ExcelImportService
{
    /**
     * Import EDC / Debit / Credit Spreadsheet (XLSX, XLS, CSV)
     */
    public static function importEdcSpreadsheet(UploadedFile $file, string $edcType): array
    {
        $path = $file->getRealPath();
        
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, true, true, true);
            
            // Convert to 0-indexed array with numeric keys for compatibility
            $rows = array_map(function($row) {
                return array_values($row);
            }, array_values($rows));
        } catch (\Exception $e) {
            return ['success' => 0, 'duplicate' => 0, 'failed' => 0, 'error' => 'Gagal membaca berkas Excel: ' . $e->getMessage()];
        }

        if (empty($rows)) {
            return ['success' => 0, 'duplicate' => 0, 'failed' => 0, 'error' => 'File kosong atau format tidak terbaca.'];
        }

        // Identify Header Row
        $headerIndex = -1;
        $headerMap = [];
        foreach ($rows as $index => $row) {
            $rowUpper = array_map(fn($cell) => strtoupper(trim((string)$cell)), $row);
            if (in_array('AMOUNT', $rowUpper) || in_array('CARD NO', $rowUpper) || in_array('AUTH', $rowUpper) || in_array('TRX DATE', $rowUpper)) {
                $headerIndex = $index;
                foreach ($rowUpper as $colIdx => $colName) {
                    $headerMap[$colName] = $colIdx;
                }
                break;
            }
        }

        if ($headerIndex === -1) {
            return ['success' => 0, 'duplicate' => 0, 'failed' => 0, 'error' => 'Header kolom (TRX DATE / AMOUNT / AUTH / CARD NO) tidak ditemukan.'];
        }

        $successCount = 0;
        $duplicateCount = 0;
        $failedCount = 0;
        $affectedDates = [];

        for ($i = $headerIndex + 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (empty(array_filter($row))) continue;

            $getVal = fn($key) => isset($headerMap[$key], $row[$headerMap[$key]]) ? trim((string)$row[$headerMap[$key]]) : null;

            $trxDateRaw = $getVal('TRX DATE') ?: $getVal('PROC DATE');
            $amountRaw = $getVal('AMOUNT');
            $auth = $getVal('AUTH');
            $cardNo = $getVal('CARD NO');
            $seq = $getVal('SEQ');
            $tid = $getVal('TID');
            $nettAmountRaw = $getVal('NETT AMOUNT') ?: $amountRaw;

            if (!$trxDateRaw || $amountRaw === null) {
                $failedCount++;
                continue;
            }

            try {
                $trxDate = Carbon::parse(str_replace('/', '-', $trxDateRaw))->toDateString();
            } catch (\Exception $e) {
                $failedCount++;
                continue;
            }

            $amount = (float)preg_replace('/[^0-9.]/', '', $amountRaw);
            $nettAmount = (float)preg_replace('/[^0-9.]/', '', $nettAmountRaw);

            // Compute unique fingerprint
            $fingerprint = hash('sha256', "{$edcType}|{$trxDate}|{$amount}|{$auth}|{$cardNo}|{$tid}|{$seq}");

            $exists = MajooEdcTransaction::where('fingerprint_hash', $fingerprint)->exists();
            if ($exists) {
                $duplicateCount++;
                continue;
            }

            MajooEdcTransaction::create([
                'edc_type' => $edcType,
                'proc_date' => $getVal('PROC DATE') ? Carbon::parse(str_replace('/', '-', $getVal('PROC DATE')))->toDateString() : null,
                'mid' => $getVal('MID'),
                'ob' => $getVal('OB'),
                'gb' => $getVal('GB'),
                'seq' => $seq,
                'type' => $getVal('TYPE'),
                'trx_date' => $trxDate,
                'auth' => $auth,
                'card_no' => $cardNo,
                'amount' => $amount,
                'tid' => $tid,
                'jenis_trx' => $getVal('JENIS TRX'),
                'ptr' => $getVal('PTR'),
                'rate' => (float)$getVal('RATE'),
                'disc_amount' => (float)$getVal('DISC AMOUNT'),
                'air_fare' => (float)$getVal('AIR FARE'),
                'plan' => $getVal('PLAN'),
                'ss_amount' => (float)$getVal('SS AMOUNT'),
                'ss_fee_type' => $getVal('SS FEE TYPE'),
                'flag' => $getVal('FLAG'),
                'nett_amount' => $nettAmount,
                'merchant_account' => $getVal('MERCHANT ACCOUNT'),
                'merchant_name' => $getVal('MERCHANT NAME'),
                'fingerprint_hash' => $fingerprint,
                'user_id' => auth()->id(),
            ]);

            $affectedDates[$trxDate] = true;
            $successCount++;
        }

        // Sync Majoo summary for affected dates
        foreach (array_keys($affectedDates) as $date) {
            FinancialAggregationService::syncMajooIncome($date);
        }

        return [
            'success' => $successCount,
            'duplicate' => $duplicateCount,
            'failed' => $failedCount,
            'error' => null
        ];
    }
}
