<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'request_id',
        'feedBack'
    ];

    public function Request(){
        return $this->belongsTo(Request::class);
    }
}
