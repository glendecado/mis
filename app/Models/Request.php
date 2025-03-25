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
        'status',
        'location',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function assignedRequest()
    {
        return $this->hasMany(AssignedRequest::class);
    }

    public function categories()
    {
        return $this->hasMany(Categories::class, 'request_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
