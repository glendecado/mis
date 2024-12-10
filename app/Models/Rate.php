<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'assignedRequest_id',
        'rate'
    ];

    public function assignedRequest()
    {
        return $this->belongsTo(AssignedRequest::class, 'assignedRequest_id');
    }
}
