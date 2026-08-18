<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseDetail;
use App\Models\FinancialSubAccount;
use App\Models\Ingredient;
use App\Models\Supplier;
use App\Services\FinancialAggregationService;
use App\Services\ReferenceGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['supplier', 'details.subAccount', 'details.category']);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('ref_number', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $expenses = $query->orderBy('date', 'desc')->latest()->paginate(15)->withQueryString();

        return view('admin.finance.expense.index', compact('expenses'));
    }

    public function create()
    {
        $subAccounts = FinancialSubAccount::with('account')->where('is_active', true)->get();
        $categories = ExpenseCategory::where('is_active', true)->orderBy('name')->get();
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();
        $ingredients = Ingredient::where('is_active', true)->orderBy('name')->get();

        return view('admin.finance.expense.create', compact('subAccounts', 'categories', 'suppliers', 'ingredients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:150'],
            'invoice_number' => ['nullable', 'string', 'max:80'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'status' => ['required', 'in:Lunas,Pending'],
            'invoice_file' => ['nullable', 'file', 'mimes:pdf,png,jpg,jpeg', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string', 'max:150'],
            'items.*.financial_sub_account_id' => ['required', 'exists:financial_sub_accounts,id'],
            'items.*.expense_category_id' => ['nullable', 'exists:expense_categories,id'],
            'items.*.cost_category' => ['required', 'in:Fixed,Variable'],
            'items.*.ingredient_id' => ['nullable', 'exists:ingredients,id'],
            'items.*.qty' => ['required', 'numeric', 'gt:0'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.delivery_fee' => ['nullable', 'numeric', 'min:0'],
            'items.*.delivery_insurance' => ['nullable', 'numeric', 'min:0'],
            'items.*.admin_app_fee' => ['nullable', 'numeric', 'min:0'],
            'items.*.item_discount' => ['nullable', 'numeric', 'min:0'],
            'items.*.delivery_discount' => ['nullable', 'numeric', 'min:0'],
            'items.*.ppn' => ['nullable', 'numeric', 'min:0'],
            'items.*.bank_admin' => ['nullable', 'numeric', 'min:0'],
            'items.*.update_stock' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $data) {
            $invoicePath = null;
            if ($request->hasFile('invoice_file')) {
                $invoicePath = $request->file('invoice_file')->store('invoices', 'public');
            }

            // Generate Ref Number using first item's sub account
            $firstSubAccountId = $data['items'][0]['financial_sub_account_id'];
            $refNumber = ReferenceGenerator::generateExpenseRef($data['date'], $firstSubAccountId);

            $expense = Expense::create([
                'date' => $data['date'],
                'holding_account' => 'EXP',
                'ref_number' => $refNumber,
                'invoice_number' => $data['invoice_number'] ?? null,
                'title' => $data['title'],
                'supplier_id' => $data['supplier_id'] ?? null,
                'status' => $data['status'],
                'invoice_path' => $invoicePath,
                'notes' => $data['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);

            foreach ($data['items'] as $item) {
                $calc = FinancialAggregationService::calculateExpenseDetailAmounts($item);

                ExpenseDetail::create(array_merge([
                    'expense_id' => $expense->id,
                    'item_name' => $item['item_name'],
                    'financial_sub_account_id' => $item['financial_sub_account_id'],
                    'expense_category_id' => $item['expense_category_id'] ?? null,
                    'cost_category' => $item['cost_category'],
                    'ingredient_id' => $item['ingredient_id'] ?? null,
                ], $calc));

                // If ingredient stock update is requested
                if (!empty($item['ingredient_id']) && !empty($item['update_stock'])) {
                    Ingredient::whereKey($item['ingredient_id'])->increment('current_stock', (float)$calc['qty']);
                }
            }

            FinancialAggregationService::syncExpenseJournal($expense);
        });

        return redirect()->route('admin.expenses.index')->with('success', 'Transaksi pengeluaran multi-item berhasil disimpan & referensi dibuat otomatis.');
    }

    public function show(Expense $expense)
    {
        $expense->load(['supplier', 'user', 'details.subAccount.account', 'details.category', 'details.ingredient']);
        return view('admin.finance.expense.show', compact('expense'));
    }

    public function toggleStatus(Expense $expense)
    {
        $newStatus = $expense->status === 'Lunas' ? 'Pending' : 'Lunas';
        $expense->update(['status' => $newStatus]);
        return back()->with('success', "Status pengeluaran {$expense->ref_number} diperbarui menjadi {$newStatus}.");
    }

    public function destroy(Expense $expense)
    {
        DB::transaction(function () use ($expense) {
            if ($expense->invoice_path) {
                Storage::disk('public')->delete($expense->invoice_path);
            }
            DB::table('journal_entries')->where('source_type', 'expense')->where('source_id', $expense->id)->delete();
            $expense->delete();
        });

        return back()->with('success', 'Transaksi pengeluaran berhasil dihapus.');
    }

    public function downloadInvoice(Expense $expense)
    {
        if (!$expense->invoice_path || !Storage::disk('public')->exists($expense->invoice_path)) {
            abort(404, 'File invoice tidak ditemukan.');
        }

        return Storage::disk('public')->download($expense->invoice_path);
    }
}
