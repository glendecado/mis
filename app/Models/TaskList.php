<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'category_id',
        'task',
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }
}
