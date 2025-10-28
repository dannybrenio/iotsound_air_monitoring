<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History_status extends Model
{
    protected $table = 'history_status';
    protected $primaryKey = 'history_id';
    protected $fillable = ['status_id', 'sensor_type', 'sensor_status'];

     public function device_status()
    {
        // belongsTo with custom FK and owner key, plus withDefault to avoid null errors
        return $this->belongsTo(Device_status::class, 'status_id', 'status_id')->withDefault();
    }
}
