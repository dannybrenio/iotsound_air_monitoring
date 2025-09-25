<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $primaryKey = 'hardware_id';  
    protected $fillable = ['hardware_info', 'hardware_location'];
}
