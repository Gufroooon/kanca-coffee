<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'clock_in_location',
        'clock_in_latitude',
        'clock_in_longitude',
        'clock_in_accuracy',
        'clock_out_location',
        'clock_out_latitude',
        'clock_out_longitude',
        'clock_out_accuracy',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in_latitude' => 'float',
        'clock_in_longitude' => 'float',
        'clock_in_accuracy' => 'float',
        'clock_out_latitude' => 'float',
        'clock_out_longitude' => 'float',
        'clock_out_accuracy' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}
