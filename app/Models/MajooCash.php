<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajooCash extends Model
{
    use HasFactory;
    protected $table = 'majoo_cash';
    protected $fillable = ['date', 'cashier_amount', 'actual_amount', 'difference', 'notes', 'user_id'];
    protected $casts = ['date' => 'date', 'cashier_amount' => 'decimal:2', 'actual_amount' => 'decimal:2', 'difference' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
