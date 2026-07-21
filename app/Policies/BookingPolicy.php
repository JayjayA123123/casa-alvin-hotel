<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Any logged-in user can view the booking list (filtered to their own
     * bookings in the controller).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * A user can view a specific booking only if they own it.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * Any logged-in user can create a booking.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * A user can update a booking only if they own it.
     */
    public function update(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * A user can delete a booking only if they own it.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }
}
