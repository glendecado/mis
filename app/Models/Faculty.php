<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $primaryKey = 'faculty_id'; // Assuming 'faculties_id' is your primary key

    protected $fillable = [
        'faculty_id',
        'site',
        'officeOrBuilding',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'faculty_id'); // Adjust the foreign key column name if necessary
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'request_id'); // Adjust the foreign key column name if necessary
    } 
}
