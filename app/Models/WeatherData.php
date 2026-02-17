<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $fillable = [
        'weather_timestamp',
        'temperature_2m',
        'relative_humidity_2m',
        'windspeed_10m',
        'winddirection_10m',
        'pressure_msl',
        'precipitation',
        'weather_code',
    ];

}
