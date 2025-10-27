<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pending_hardware_data extends Model
{
   protected $table = 'pending_hardware_data';
   protected $primaryKey = 'pending_hardware_data_id';
   protected $fillable = ['pending_hardware_info', 'pm2_5', 'pm10', 'co', 'no2', 'decibels', 'realtime_stamp'];
}
