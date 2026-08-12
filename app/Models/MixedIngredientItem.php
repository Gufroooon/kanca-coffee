<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixedIngredientItem extends Model
{
    use HasFactory;
    protected $fillable = ['mixed_ingredient_id', 'ingredient_id', 'quantity'];
    protected $casts = ['quantity' => 'decimal:3'];
    public function mixedIngredient() { return $this->belongsTo(MixedIngredient::class); }
    public function ingredient() { return $this->belongsTo(Ingredient::class); }
}
