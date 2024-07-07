<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'technicalStaff_id',
    ];

    public function TechnicalStaff(){
        return $this->belongsTo(TechnicalStaff::class);
    }

    public function request()
    {
        return $this->hasOne(Request::class);
    }
}
