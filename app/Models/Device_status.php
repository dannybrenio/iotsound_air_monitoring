<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device_status extends Model
{
    protected $table = 'device_status';
    protected $primaryKey = 'status_id';
    protected $fillable = ['hardware_info', 'pms_status', 'mq135_status', 'mq7_status', 'sound_status', 'timestamp_status']; 
}
