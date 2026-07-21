<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A user can have many bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * True kung ang account na ito ay may admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * True kung regular guest/customer account.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}
