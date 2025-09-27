<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pending_hardware extends Model
{
    protected $primaryKey = 'pending_id';  
    protected $fillable = ['hardware_info', 'longitude', 'latitude'];
}
