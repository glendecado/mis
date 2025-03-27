<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPerRequest extends Model
{
    protected $fillable = [
        'request_id',
        'status',
        'task',
        'isCheck'
    ];
}
