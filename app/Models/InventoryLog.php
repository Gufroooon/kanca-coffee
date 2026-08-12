<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;
    protected $fillable = ['ingredient_id', 'log_date', 'opening_stock', 'closing_stock', 'usage', 'notes', 'user_id'];
    protected $casts = ['log_date' => 'date', 'opening_stock' => 'decimal:3', 'closing_stock' => 'decimal:3', 'usage' => 'decimal:3'];
    public function ingredient() { return $this->belongsTo(Ingredient::class); }
}
