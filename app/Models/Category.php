<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function TaskList()
    {
        return $this->hasMany(TaskList::class);
    }

    public function Request()
    {
        return $this->hasMany(Request::class);
    }
}
