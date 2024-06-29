<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $primaryKey = 'faculties_id'; // Assuming 'faculties_id' is your primary key

    protected $fillable = ['faculties_id', 'college', 'building', 'room'];

    public function user()
    {
        return $this->belongsTo(User::class, 'faculties_id'); // Adjust the foreign key column name if necessary
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'faculties_id'); // Adjust the foreign key column name if necessary
    }
}
