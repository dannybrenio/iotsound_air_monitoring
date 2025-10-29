<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'report_id';
    protected $fillable = ['user_id', 'alert_body', 'image_path'];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
