<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'pm25',
        'pm10',
        'no2',
        'co',
        'rtc',
        'decibel',
    ];
}
