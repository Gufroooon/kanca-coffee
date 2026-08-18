<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kanca Coffee</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #18181b; margin: 0; padding: 0; }
        .header { text-align: center; border-bottom: 2px solid #ea580c; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; text-transform: uppercase; margin: 0; color: #ea580c; font-weight: 800; }
        .header p { margin: 4px 0 0 0; font-size: 10px; color: #71717a; }
        .meta-table { width: 100%; margin-bottom: 16px; font-size: 10px; }
        .meta-table td { padding: 3px 0; }
        .report-title { font-size: 13px; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; background-color: #f4f4f5; padding: 6px 10px; border-radius: 4px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #e4e4e7; padding: 6px 8px; text-align: left; }
        table.data-table th { background-color: #f4f4f5; text-transform: uppercase; font-size: 9px; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .footer-sig { width: 100%; margin-top: 40px; }
        .footer-sig td { text-align: center; vertical-align: top; width: 50%; }
        .sig-space { height: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KANCA COFFEE</h1>
        <p>Laporan Resmi Operasional & Dashboard Keuangan (V2)</p>
        <p>Kanca Coffee House & Management System</p>
    </div>

    <table class="meta-table">
        <tr>
            <td width="15%"><strong>Tipe Laporan:</strong></td>
            <td width="35%">Laporan {{ strtoupper($reportType) }}</td>
            <td width="15%"><strong>Dicetak Pada:</strong></td>
            <td width="35%">{{ now()->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Periode Data:</strong></td>
            <td>{{ \Carbon\Carbon::parse($from)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</td>
            <td><strong>Pencetak:</strong></td>
            <td>{{ auth()->user()->name ?? 'Administrator' }}</td>
        </tr>
    </table>

    <div class="report-title">
        Detail Data Laporan {{ strtoupper($reportType) }}
    </div>

    @if($reportType === 'income')
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="10%">Holding</th>
                    <th width="25%">Kode Referensi Pemasukan</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Channel</th>
                    <th width="25%" class="text-right">Jumlah Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomeRows as $idx => $row)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-center">{{ $row->holding_account }}</td>
                        <td class="font-bold">{{ $row->ref_number }}</td>
                        <td>{{ $row->date->format('d/m/Y') }}</td>
                        <td>{{ $row->type === 'MJO' ? 'Majoo POS (6-Ch)' : 'GoBiz Online' }}</td>
                        <td class="text-right font-bold">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right font-bold">TOTAL PEMASUKAN:</td>
                    <td class="text-right font-bold" style="color: #16a34a;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @elseif($reportType === 'expense')
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="25%">Kode Referensi Pengeluaran</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Judul Transaksi</th>
                    <th width="15%">Status</th>
                    <th width="15%" class="text-right">Total Subtotal 3</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenseRows as $idx => $row)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="font-bold">{{ $row->ref_number }}</td>
                        <td>{{ $row->date->format('d/m/Y') }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->status }}</td>
                        <td class="text-right font-bold">Rp {{ number_format($row->total_amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right font-bold">TOTAL PENGELUARAN:</td>
                    <td class="text-right font-bold" style="color: #dc2626;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @elseif($reportType === 'journal')
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Kode Referensi</th>
                    <th width="10%">Holding</th>
                    <th width="20%" class="text-right">Debit</th>
                    <th width="25%" class="text-right">Kredit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($journalRows as $idx => $row)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td>{{ $row->entry_date->format('d/m/Y') }}</td>
                        <td class="font-bold">{{ $row->ref_number }}</td>
                        <td class="text-center">{{ $row->holding_account }}</td>
                        <td class="text-right">Rp {{ number_format($row->debit, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($row->credit, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right font-bold">NET CASHFLOW:</td>
                    <td colspan="2" class="text-right font-bold" style="color: #2563eb;">Rp {{ number_format($netCashflow, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="15%">Tanggal</th>
                    <th width="35%">Bahan Baku</th>
                    <th width="15%">Opening</th>
                    <th width="15%">Closing</th>
                    <th width="15%">Konsumsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventoryLogs as $idx => $row)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td>{{ $row->log_date->format('d/m/Y') }}</td>
                        <td class="font-bold">{{ $row->ingredient?->name }}</td>
                        <td>{{ number_format($row->opening_stock, 2) }} {{ $row->ingredient?->unit }}</td>
                        <td>{{ number_format($row->closing_stock, 2) }} {{ $row->ingredient?->unit }}</td>
                        <td class="font-bold" style="color: #dc2626;">{{ number_format($row->usage, 2) }} {{ $row->ingredient?->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <table class="footer-sig">
        <tr>
            <td>
                <p>Disiapkan Oleh,</p>
                <div class="sig-space"></div>
                <p><strong>( Finance / Staff )</strong></p>
            </td>
            <td>
                <p>Disetujui Oleh,</p>
                <div class="sig-space"></div>
                <p><strong>( Manager / Owner Kanca Coffee )</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
