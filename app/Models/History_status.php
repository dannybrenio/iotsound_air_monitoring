<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History_status extends Model
{
    protected $table = 'history_status';
    protected $primaryKey = 'history_id';
    protected $fillable = ['status_id', 'sensor_type'];
}
