<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'task_id',
        'rate'
    ];

    public function assignedRequest()
    {
        return $this->belongsTo(AssignedRequest::class, 'task_id');
    }
}
