<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'img',
        'role',
        'name',
        'email',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            //'password' => 'hashed',
            'last_seen' => 'datetime',
        ];
    }

    public function MisStaff()
    {
        return $this->hasOne(MisStaff::class, 'misStaff_id');
    }

    public function TechnicalStaff()
    {
        return $this->hasOne(TechnicalStaff::class, 'technicalStaff_id');
    }

    public function Faculty()
    {
        return $this->hasOne(Faculty::class, 'faculty_id');
    }


    public function isOnline() : bool
    {
        return $this->last_seen && $this->last_seen->gt(now()->subSecond(10));
    }
}
