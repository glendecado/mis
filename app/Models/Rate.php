<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'task_id',
        'rate'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
