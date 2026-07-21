<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class CalendarController extends Controller
{
    /**
     * Status -> color mapping. Ginagamit parehong dito at sa legend
     * ng calendar view, para laging magka-tugma ang mga kulay.
     */
    public const STATUS_COLORS = [
        'pending' => '#f5941f',
        'confirmed' => '#2f6fe0',
        'completed' => '#1c8a52',
        'cancelled' => '#d1483a',
    ];

    /**
     * Ipakita ang standalone calendar page, may legend ng status colors.
     */
    public function index()
    {
        return view('admin.calendar.index', [
            'statusColors' => self::STATUS_COLORS,
        ]);
    }

    /**
     * JSON feed ng lahat ng bookings (lahat ng rooms), kinukuha ng
     * FullCalendar widget sa calendar page. Kulay ang bawat event
     * base sa status nito para madaling makita ang occupancy.
     */
    public function events()
    {
        $events = Booking::with('room')
            ->get()
            ->map(function (Booking $booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->room->room_type.' — '.$booking->guest_name,
                    'start' => $booking->check_in_date->toDateString(),
                    // FullCalendar's "end" ay exclusive, kaya dagdagan ng
                    // isang araw para masakop ang buong checkout date.
                    'end' => $booking->check_out_date->copy()->addDay()->toDateString(),
                    'color' => self::STATUS_COLORS[$booking->status] ?? '#97a0b0',
                    'extendedProps' => [
                        'room' => $booking->room->room_number,
                        'status' => $booking->status,
                        'guests' => $booking->guests,
                        'total' => number_format($booking->total_price, 2),
                    ],
                ];
            });

        return response()->json($events);
    }
}
