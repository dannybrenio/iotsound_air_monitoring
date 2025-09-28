<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table = 'hardware';
    protected $primaryKey = 'hardware_id';  
    protected $fillable = ['hardware_info', 'longitude', 'latitude', 'status'];
}
