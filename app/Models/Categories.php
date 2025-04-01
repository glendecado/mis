<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'request_id',
        'category_id',
        'ifOthers'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
