<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'category_id',
        'concerns',
        'priotrityLevel',
        'progress',
        'status'
 
    ];

    public function Faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function Task()
    {
        return $this->hasOne(Task::class);
    }

    public function Category(){

        return $this->belongsTo(Category::class);
    }
}
