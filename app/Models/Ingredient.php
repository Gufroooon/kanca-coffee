<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'unit', 'minimum_stock', 'current_stock', 'is_active'];

    protected $casts = [
        'minimum_stock' => 'decimal:3',
        'current_stock' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    public function inventoryLogs() { return $this->hasMany(InventoryLog::class); }
    public function mixedIngredientItems() { return $this->hasMany(MixedIngredientItem::class); }
    public function getIsLowStockAttribute(): bool { return (float) $this->current_stock <= (float) $this->minimum_stock; }
}
