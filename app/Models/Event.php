<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'capacity',
        'registered_count',
        'poster',
        'price',
        'speaker_name',
        'speaker_title',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function getAvailableSeatsAttribute()
    {
        return max(0, $this->capacity - $this->registered_count);
    }

    public function getIsFullAttribute()
    {
        return $this->registered_count >= $this->capacity;
    }
}
