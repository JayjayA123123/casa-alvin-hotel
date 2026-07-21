<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * List every booking sa buong hotel (hindi lang sa isang guest),
     * may optional status filter galing sa query string.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $bookings = Booking::with(['room', 'user'])
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    /**
     * Palitan lang ang status ng isang booking (pending/confirmed/completed/cancelled).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update($validated);

        return back()->with('success', "Booking #{$booking->id} updated to \"{$validated['status']}\".");
    }
}
