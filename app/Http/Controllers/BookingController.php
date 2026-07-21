<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * List all bookings.
     */
    public function index()
    {
        $bookings = Booking::with('room')->latest()->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the room selection + booking form.
     * If a room is pre-selected via ?room_id=, preselect it in the dropdown.
     */
    public function create(Request $request)
    {
        $rooms = Room::where('status', 'available')->get();
        $selectedRoomId = $request->query('room_id');

        return view('bookings.create', compact('rooms', 'selectedRoomId'));
    }

    /**
     * Store a new booking after checking availability.
     */
    public function store(Request $request)
    {
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

        // Capacity check
        if ($validated['guests'] > $room->capacity) {
            return back()->withInput()->withErrors([
                'guests' => "Ang room na ito ay para lang sa max na {$room->capacity} guests.",
            ]);
        }

        // Availability check (no overlapping bookings)
        if (! $room->isAvailable($validated['check_in_date'], $validated['check_out_date'])) {
            return back()->withInput()->withErrors([
                'check_in_date' => 'Hindi available ang room na ito sa napiling petsa. Pumili ng ibang date o room.',
            ]);
        }

        $nights = \Carbon\Carbon::parse($validated['check_in_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['check_out_date']));

        $booking = Booking::create([
            'room_id' => $room->id,
            'user_id' => auth()->id(), // null kung walang naka-login
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests' => $validated['guests'],
            'total_price' => $nights * $room->price_per_night,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking submitted! Naka-pending pa ito habang hinihintay ang confirmation.');
    }

    /**
     * Show a single booking's summary/confirmation.
     * Route model binding resolves $booking automatically.
     */
    public function show(Booking $booking)
    {
        $booking->load('room');

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::where('status', 'available')->get();

        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        if (! $booking->room->isAvailable($validated['check_in_date'], $validated['check_out_date'], $booking->id)) {
            return back()->withInput()->withErrors([
                'check_in_date' => 'Hindi available ang room sa bagong petsa.',
            ]);
        }

        $nights = \Carbon\Carbon::parse($validated['check_in_date'])
            ->diffInDays(\Carbon\Carbon::parse($validated['check_out_date']));

        $validated['total_price'] = $nights * $booking->room->price_per_night;

        $booking->update($validated);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled/deleted.');
    }

    /**
     * AJAX-friendly endpoint: check room availability for given dates.
     */
    public function checkAvailability(Request $request, Room $room)
    {
        $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $available = $room->isAvailable($request->check_in_date, $request->check_out_date);

        return response()->json(['available' => $available]);
    }

    /**
     * JSON feed of a room's booked date ranges, consumed by the FullCalendar
     * widget on the booking form so users can only pick free dates.
     */
    public function bookedDates(Room $room)
    {
        $events = $room->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'title' => 'Booked',
                    'start' => $booking->check_in_date->toDateString(),
                    // FullCalendar's "end" is exclusive, so add a day to
                    // correctly shade the full checkout date too.
                    'end' => $booking->check_out_date->copy()->addDay()->toDateString(),
                    'display' => 'background',
                    'color' => '#dc3545',
                ];
            });

        return response()->json($events);
    }
}
