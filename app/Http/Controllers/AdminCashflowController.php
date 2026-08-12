<?php

namespace App\Http\Controllers;

use App\Models\Cashflow;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCashflowController extends Controller
{
    public function index(Request $request, string $type)
    {
        abort_unless(in_array($type, ['income', 'expense'], true), 404);
        $cashflows = $this->filtered($request, $type)->latest('transaction_date')->paginate(15)->withQueryString();
        $categories = ['Belanja bahan', 'Operasional', 'Listrik', 'Air', 'Transportasi', 'Maintenance', 'Lainnya'];
        return view('admin.finance.cashflows.index', compact('cashflows', 'type', 'categories'));
    }

    public function store(Request $request, string $type)
    {
        abort_unless(in_array($type, ['income', 'expense'], true), 404);
        $data = $request->validate([
            'transaction_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['nullable', 'string', 'max:100'],
            'source' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);
        $data['type'] = $type;
        $data['user_id'] = auth()->id();
        Cashflow::create($data);
        return back()->with('success', ucfirst($type).' berhasil dicatat.');
    }

    public function update(Request $request, Cashflow $cashflow)
    {
        $data = $request->validate([
            'transaction_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'category' => ['nullable', 'string', 'max:100'],
            'source' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);
        $cashflow->update($data);
        return back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Cashflow $cashflow)
    {
        $cashflow->delete();
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function summary(Request $request)
    {
        [$from, $to] = $this->dateRange($request);
        $income = Cashflow::where('type', 'income')->whereBetween('transaction_date', [$from, $to])->sum('amount');
        $expense = Cashflow::where('type', 'expense')->whereBetween('transaction_date', [$from, $to])->sum('amount');
        $transactions = Cashflow::whereBetween('transaction_date', [$from, $to])->count();
        $daily = Cashflow::select('transaction_date', 'type', DB::raw('SUM(amount) as total'))
            ->whereBetween('transaction_date', [$from, $to])->groupBy('transaction_date', 'type')->orderBy('transaction_date')->get();
        $chart = collect();
        foreach ($daily as $row) $chart->put($row->transaction_date.'|'.$row->type, (float) $row->total);
        $dates = collect($daily->pluck('transaction_date')->unique()->values());
        return view('admin.finance.summary', compact('from', 'to', 'income', 'expense', 'transactions', 'dates', 'chart'));
    }

    public function export(Request $request)
    {
        [$from, $to] = $this->dateRange($request);
        $type = in_array($request->get('type'), ['income', 'expense'], true) ? $request->get('type') : null;
        $query = Cashflow::whereBetween('transaction_date', [$from, $to]);
        if ($type) {
            $query->where('type', $type);
        }
        $rows = $query->orderBy('transaction_date')->get();
        $data = $rows->map(fn ($row) => [$row->transaction_date->format('Y-m-d'), strtoupper($row->type), $row->category, $row->source, $row->description, $row->amount]);
        if ($request->get('format') === 'pdf') {
            return Pdf::loadView('admin.reports.finance-pdf', ['rows' => $rows, 'from' => $from, 'to' => $to])->download('financial-report-'.now()->format('Y-m-d').'.pdf');
        }
        $html = '<table><tr><th>Tanggal</th><th>Tipe</th><th>Kategori</th><th>Sumber</th><th>Deskripsi</th><th>Nominal</th></tr>';
        foreach ($data as $row) $html .= '<tr>'.collect($row)->map(fn ($cell) => '<td>'.e((string) $cell).'</td>')->implode('').'</tr>';
        return response($html.'</table>', 200, ['Content-Type' => 'application/vnd.ms-excel', 'Content-Disposition' => 'attachment; filename="financial-report-'.now()->format('Y-m-d').'.xls"']);
    }

    private function filtered(Request $request, string $type)
    {
        $query = Cashflow::where('type', $type);
        if ($request->filled('date_from')) $query->whereDate('transaction_date', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('transaction_date', '<=', $request->date_to);
        if ($request->filled('category')) $query->where('category', $request->category);
        if ($request->filled('search')) $query->where(fn ($q) => $q->where('description', 'like', '%'.$request->search.'%')->orWhere('source', 'like', '%'.$request->search.'%'));
        return $query;
    }

    private function dateRange(Request $request): array
    {
        $request->validate(['date_from' => ['nullable', 'date'], 'date_to' => ['nullable', 'date', 'after_or_equal:date_from']]);
        return [$request->date_from ?: now()->startOfMonth()->toDateString(), $request->date_to ?: now()->toDateString()];
    }
}
