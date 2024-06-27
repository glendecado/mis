<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'faculties_id',
        'category',
        'concern',
        'status',
    ];

    public function Faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
