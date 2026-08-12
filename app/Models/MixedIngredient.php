<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixedIngredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'output_quantity', 'is_active'];
    protected $casts = ['output_quantity' => 'decimal:3', 'is_active' => 'boolean'];
    public function items() { return $this->hasMany(MixedIngredientItem::class); }
    public function productions() { return $this->hasMany(MixedIngredientProduction::class); }
}
