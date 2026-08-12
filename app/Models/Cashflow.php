<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'transaction_date', 'amount', 'category', 'source', 'description', 'user_id'];
    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2'];
    public function user() { return $this->belongsTo(User::class); }
}
