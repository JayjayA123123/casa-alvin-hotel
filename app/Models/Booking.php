<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in_date',
        'check_out_date',
        'guests',
        'total_price',
        'status',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    /**
     * A booking belongs to a room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A booking may belong to a registered user (nullable for guest bookings).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Number of nights being booked.
     */
    public function getNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }
}
