<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'avatar',
        'message',
        'rating',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
