<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Main Admin Dashboard: hotel-wide stat cards, bookings-per-month
     * chart (for the current year), and the latest bookings table.
     */
    public function index()
    {
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();

        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        // Bookings created per month, Jan -> Dec, for the current year.
        // Used to draw the "Bookings Overview" line chart.
        // Grouped in PHP (instead of a raw MONTH()/EXTRACT() SQL call) so this
        // works the same on MySQL (local) and PostgreSQL (production).
        $year = now()->year;
        $bookingsPerMonth = Booking::whereYear('created_at', $year)
            ->get(['created_at'])
            ->groupBy(fn ($booking) => (int) $booking->created_at->format('n'))
            ->map->count();

        $chartLabels = [];
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[] = Carbon::create()->month($month)->format('M');
            $chartData[] = $bookingsPerMonth[$month] ?? 0;
        }

        $recentBookings = Booking::with('room')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'totalBookings',
            'totalUsers',
            'totalRevenue',
            'chartLabels',
            'chartData',
            'recentBookings'
        ));
    }
}
