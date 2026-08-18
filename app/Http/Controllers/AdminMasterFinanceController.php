<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\FinancialAccount;
use App\Models\FinancialSubAccount;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminMasterFinanceController extends Controller
{
    public function index()
    {
        $accounts = FinancialAccount::with('subAccounts')->get();
        $categories = ExpenseCategory::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.finance.master.index', compact('accounts', 'categories', 'suppliers'));
    }

    public function storeSubAccount(Request $request)
    {
        $data = $request->validate([
            'financial_account_id' => ['required', 'exists:financial_accounts,id'],
            'code' => ['required', 'string', 'max:20', 'unique:financial_sub_accounts,code'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        $data['is_active'] = true;
        FinancialSubAccount::create($data);

        return back()->with('success', 'Sub-akun finansial berhasil ditambahkan.');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:expense_categories,name'],
        ]);

        $data['is_active'] = true;
        ExpenseCategory::create($data);

        return back()->with('success', 'Kategori pengeluaran berhasil ditambahkan.');
    }

    public function storeSupplier(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $data['is_active'] = true;
        Supplier::create($data);

        return back()->with('success', 'Supplier berhasil ditambahkan.');
    }
}
