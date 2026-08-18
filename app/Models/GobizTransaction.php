<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GobizTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'gross_sales', 'commission_fee', 'promo_fee', 'ads_fee', 'discount_fee', 'net_sales', 'notes', 'user_id'
    ];

    protected $casts = [
        'date' => 'date',
        'gross_sales' => 'decimal:2',
        'commission_fee' => 'decimal:2',
        'promo_fee' => 'decimal:2',
        'ads_fee' => 'decimal:2',
        'discount_fee' => 'decimal:2',
        'net_sales' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
