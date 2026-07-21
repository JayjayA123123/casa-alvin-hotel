<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type',
        'capacity',
        'price_per_night',
        'description',
        'image',
        'status',
    ];

    /**
     * A room can have many bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if the room is available for a given date range.
     * Overlap logic: a conflict exists if existing.check_in < new.check_out
     * AND existing.check_out > new.check_in.
     */
    public function isAvailable($checkIn, $checkOut, $ignoreBookingId = null)
    {
        if ($this->status !== 'available') {
            return false;
        }

        $query = $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in_date', '<', $checkOut)
            ->where('check_out_date', '>', $checkIn);

        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        return $query->doesntExist();
    }
}
