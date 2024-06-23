<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'college', 'building', 'room'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
