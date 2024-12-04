<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignedRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'technicalStaff_id',
        'status',
    ];

    public function TechnicalStaff()
    {
        return $this->belongsTo(TechnicalStaff::class, 'technicalStaff_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function rate(){
        return $this->hasOne(Rate::class);
    }
}
