<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalStaff extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tatalTask', 'totalRate'];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
