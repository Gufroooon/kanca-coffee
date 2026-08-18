<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajooTransfer extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'amount', 'notes', 'user_id'];
    protected $casts = ['date' => 'date', 'amount' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
