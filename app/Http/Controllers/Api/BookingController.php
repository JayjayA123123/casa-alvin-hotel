<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Notifications\BookingCreated;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * GET /api/bookings
     * List only the logged-in user's own bookings.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Booking::class);

        $bookings = $request->user()
            ->bookings()
            ->with('room')
            ->latest()
            ->get();

        return response()->json([
            'data' => $bookings,
        ]);
    }

    /**
     * POST /api/bookings
     * Create a new booking for the logged-in user.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Booking::class);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if ($validated['guests'] > $room->capacity) {
            return response()->json([
                'message' => 'Number of guests exceeds room capacity.',
                'errors' => ['guests' => ["Max capacity is {$room->capacity}."]],
            ], 422);
        }

        if (! $room->isAvailable($validated['check_in_date'], $validated['check_out_date'])) {
            return response()->json([
                'message' => 'Room is not available for the selected dates.',
                'errors' => ['check_in_date' => ['This room is already booked for the selected dates.']],
            ], 422);
        }

        $nights = \Carbon\Carbon::parse($validated['check_in_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['check_out_date']));

        $booking = $request->user()->bookings()->create([
            'room_id' => $room->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests' => $validated['guests'],
            'total_price' => $nights * $room->price_per_night,
            'status' => 'pending',
        ]);

        // Send a notification to the user who made the booking
        $request->user()->notify(new BookingCreated($booking));

        return response()->json([
            'message' => 'Booking created successfully.',
            'data' => $booking->load('room'),
        ], 201);
    }

    /**
     * GET /api/bookings/{booking}
     * Route model binding resolves {booking} automatically.
     */
    public function show(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        return response()->json([
            'data' => $booking->load('room'),
        ]);
    }

    /**
     * PUT/PATCH /api/bookings/{booking}
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'check_in_date' => 'sometimes|date',
            'check_out_date' => 'sometimes|date|after:check_in_date',
            'guests' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
        ]);

        if (isset($validated['check_in_date']) || isset($validated['check_out_date'])) {
            $checkIn = $validated['check_in_date'] ?? $booking->check_in_date;
            $checkOut = $validated['check_out_date'] ?? $booking->check_out_date;

            if (! $booking->room->isAvailable($checkIn, $checkOut, $booking->id)) {
                return response()->json([
                    'message' => 'Room is not available for the selected dates.',
                ], 422);
            }

            $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut));
            $validated['total_price'] = $nights * $booking->room->price_per_night;
        }

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully.',
            'data' => $booking->fresh('room'),
        ]);
    }

    /**
     * DELETE /api/bookings/{booking}
     */
    public function destroy(Request $request, Booking $booking)
    {
        $this->authorize('delete', $booking);

        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully.',
        ]);
    }
}
