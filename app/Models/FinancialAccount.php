<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialAccount extends Model
{
    use HasFactory;

    protected $fillable = ['holding_type', 'code', 'name', 'is_active'];

    public function subAccounts()
    {
        return $table = $this->hasMany(FinancialSubAccount::class);
    }
}
