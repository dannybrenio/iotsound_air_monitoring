<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $table = 'predictions';

    protected $fillable = [
        'hardware_id',
        'aqi_next_hour_avg',
        'noise_next_hour_avg',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];
}
