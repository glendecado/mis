<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MisStaff extends Model
{
    use HasFactory;
    protected $primaryKey = 'misStaff_id';
    protected $fillable = ['misStaff_id'];

    public function User()
    {
        return $this->belongsTo(User::class, 'misStaff_id');
    }
}
