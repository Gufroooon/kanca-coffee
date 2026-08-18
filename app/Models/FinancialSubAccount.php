<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialSubAccount extends Model
{
    use HasFactory;

    protected $fillable = ['financial_account_id', 'code', 'name', 'is_active'];

    public function account()
    {
        return $this->belongsTo(FinancialAccount::class, 'financial_account_id');
    }
}
