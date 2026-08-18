<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenceSequence extends Model
{
    use HasFactory;

    protected $fillable = ['date_key', 'holding_type', 'daily_sequence', 'monthly_sequence'];
}
