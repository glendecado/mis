<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalStaff extends Model
{
    use HasFactory;

    protected $primaryKey = 'technicalStaff_id';
    protected $fillable = ['technicalStaff_id'];
    public function User()
    {
        return $this->belongsTo(User::class, 'technicalStaff_id');
    }

     public function assignedRequest()
    {
        return $this->hasMany(AssignedRequest::class, 'technicalStaff_id');
    }
}
