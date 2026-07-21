<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with current stats.
     */
    public function index()
    {
        $user = auth()->user();

        // Admin accounts get their own dashboard with hotel-wide stats.
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $totalBookings = Booking::count();
        $totalUsers = User::count();
        $myBookings = $user->bookings()->with('room')->latest()->get();

        $myTotalBookings = $myBookings->count();
        $myUpcomingCount = $myBookings->whereIn('status', ['pending', 'confirmed'])->count();
        $myCompletedCount = $myBookings->where('status', 'completed')->count();
        $myTotalSpent = $myBookings->whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        $upcomingBooking = $myBookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->sortBy('check_in_date')
            ->first();

        $recentBookings = $myBookings->take(5);

        return view('dashboard', compact(
            'totalBookings',
            'totalUsers',
            'myTotalBookings',
            'myUpcomingCount',
            'myCompletedCount',
            'myTotalSpent',
            'upcomingBooking',
            'recentBookings'
        ));
    }

    /**
     * JSON endpoint the dashboard polls to keep the stats "live"
     * without a full page refresh.
     */
    public function stats()
    {
        return response()->json([
            'totalBookings' => Booking::count(),
            'totalUsers' => User::count(),
        ]);
    }
}
