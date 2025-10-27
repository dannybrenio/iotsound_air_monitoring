<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Hardware_data extends Model
{
     use  HasFactory;
     
     protected $table = 'hardware_data'; 
     protected $primaryKey = 'data_id';
     protected $fillable = ['hardware_id', 'pm2_5', 'pm10', 'co', 'no2', 'decibels', 'realtime_stamp'];
}
