@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-topbar">
        <div>
            <h1 class="h3 mb-1">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-muted mb-0">Narito ang buod ng iyong mga bookings sa StayPinas.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card">
                <div class="stat-value">{{ $myTotalBookings }}</div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card">
                <div class="stat-value">{{ $myUpcomingCount }}</div>
                <div class="stat-label">Upcoming Stays</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card">
                <div class="stat-value">{{ $myCompletedCount }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card stat-orange">
                <div class="stat-value">&#8369;{{ number_format($myTotalSpent, 0) }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>
    </div>

    @if ($upcomingBooking)
        <div class="panel shadow-card p-4 mb-4">
            <h6 class="text-uppercase small fw-bold mb-3" style="color: var(--text-faint); letter-spacing:.05em;">Upcoming Booking</h6>
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    @php $img = $upcomingBooking->room->image ? Storage::url($upcomingBooking->room->image) : 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=200&auto=format&fit=crop'; @endphp
                    <img src="{{ $img }}" style="width:70px;height:70px;object-fit:cover;border-radius:10px;" alt="">
                    <div>
                        <div class="fw-semibold">{{ $upcomingBooking->room->room_type }}</div>
                        <div class="text-muted small">Room {{ $upcomingBooking->room->room_number }}</div>
                        <div class="text-muted small">{{ $upcomingBooking->check_in_date->format('M d') }} - {{ $upcomingBooking->check_out_date->format('M d, Y') }} &middot; {{ $upcomingBooking->guests }} Guests</div>
                    </div>
                </div>
                <div class="text-md-end">
                    <div class="fw-bold mb-2" style="color: var(--navy);">&#8369;{{ number_format($upcomingBooking->total_price, 0) }}</div>
                    <a href="{{ route('bookings.show', $upcomingBooking) }}" class="btn btn-navy btn-sm">View Details</a>
                </div>
            </div>
        </div>
    @endif

    <div class="panel shadow-card p-0">
        <div class="d-flex justify-content-between align-items-center p-3 pb-0">
            <h6 class="mb-0">Recent Bookings</h6>
            <a href="{{ route('bookings.index') }}" class="small">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Room</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th class="pe-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentBookings as $booking)
                        @php
                            $badgeClass = match($booking->status) {
                                'completed' => 'badge-completed',
                                'cancelled' => 'badge-cancelled',
                                'confirmed' => 'badge-confirmed',
                                default => 'badge-pending',
                            };
                        @endphp
                        <tr>
                            <td class="ps-3">{{ $booking->room->room_type }}</td>
                            <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                            <td>{{ $booking->guests }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ ucfirst($booking->status) }}</span></td>
                            <td class="pe-3 fw-bold" style="color: var(--navy);">&#8369;{{ number_format($booking->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-3">You haven't made any bookings yet.</p>
                                    <a href="{{ route('bookings.create') }}" class="btn btn-orange btn-sm">Book a Room</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
