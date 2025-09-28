<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pending_hardware extends Model
{
    protected $table = 'pending_hardware';
    protected $primaryKey = 'pending_id';  
    protected $fillable = ['hardware_info', 'longitude', 'latitude'];
}
