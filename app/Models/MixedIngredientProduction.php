<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixedIngredientProduction extends Model
{
    use HasFactory;
    protected $fillable = ['mixed_ingredient_id', 'quantity', 'produced_at', 'notes', 'user_id'];
    protected $casts = ['quantity' => 'decimal:3', 'produced_at' => 'date'];
    public function mixedIngredient() { return $this->belongsTo(MixedIngredient::class); }
}
