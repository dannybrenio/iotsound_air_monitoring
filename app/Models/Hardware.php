<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table = 'hardware';
    protected $primaryKey = 'hardware_id';  
    protected $fillable = ['hardware_info', 'location_name', 'longitude', 'latitude', 'status'];

    protected static function booted()
    {
        static::creating(function ($hardware) {
            $hardware->public_hash = Str::random(16);
        });
    }
}
