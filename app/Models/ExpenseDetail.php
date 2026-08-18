<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'item_name',
        'financial_sub_account_id',
        'expense_category_id',
        'cost_category',
        'ingredient_id',
        'qty',
        'price',
        'delivery_fee',
        'delivery_insurance',
        'admin_app_fee',
        'item_discount',
        'delivery_discount',
        'ppn',
        'bank_admin',
        'subtotal_1',
        'subtotal_2',
        'subtotal_3',
    ];

    protected $casts = [
        'qty' => 'decimal:3',
        'price' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'delivery_insurance' => 'decimal:2',
        'admin_app_fee' => 'decimal:2',
        'item_discount' => 'decimal:2',
        'delivery_discount' => 'decimal:2',
        'ppn' => 'decimal:2',
        'bank_admin' => 'decimal:2',
        'subtotal_1' => 'decimal:2',
        'subtotal_2' => 'decimal:2',
        'subtotal_3' => 'decimal:2',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function subAccount()
    {
        return $this->belongsTo(FinancialSubAccount::class, 'financial_sub_account_id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
