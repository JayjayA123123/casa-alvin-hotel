@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="admin-topbar">
        <div>
            <h1 class="h3 mb-1">Admin Dashboard</h1>
            <p class="text-muted mb-0">Overview ng buong StayPinas.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card">
                <div class="stat-value">{{ $totalRooms }}</div>
                <div class="stat-label">Total Rooms</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card">
                <div class="stat-value">{{ $totalBookings }}</div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card">
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="panel shadow-card stat-card stat-orange">
                <div class="stat-value">&#8369;{{ number_format($totalRevenue, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-7">
            <div class="panel shadow-card p-4 h-100">
                <h6 class="text-uppercase small fw-bold mb-3" style="color: var(--text-faint); letter-spacing:.05em;">Bookings Overview ({{ now()->year }})</h6>
                <canvas id="bookingsChart" height="140"></canvas>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="panel shadow-card p-4 h-100">
                <h6 class="text-uppercase small fw-bold mb-3" style="color: var(--text-faint); letter-spacing:.05em;">Quick Links</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-navy text-start"><i class="bi bi-journal-check me-2"></i>Manage Bookings</a>
                    <a href="{{ route('admin.calendar') }}" class="btn btn-outline-navy text-start"><i class="bi bi-calendar3 me-2"></i>View Booking Calendar</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-navy text-start"><i class="bi bi-people-fill me-2"></i>Manage Users</a>
                    <a href="{{ route('rooms.create') }}" class="btn btn-orange text-start"><i class="bi bi-plus-lg me-2"></i>Add New Room</a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel shadow-card p-0">
        <div class="d-flex justify-content-between align-items-center p-3 pb-0">
            <h6 class="mb-0">Recent Bookings</h6>
            <a href="{{ route('admin.bookings.index') }}" class="small">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Room</th>
                        <th>Guest</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
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
                            <td>{{ $booking->guest_name }}</td>
                            <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ ucfirst($booking->status) }}</span></td>
                            <td class="pe-3 fw-bold" style="color: var(--navy);">&#8369;{{ number_format($booking->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center py-5 text-muted">Wala pang bookings.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('bookingsChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Bookings',
                    data: @json($chartData),
                    borderColor: '#f5941f',
                    backgroundColor: 'rgba(245, 148, 31, 0.12)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#f5941f',
                }],
            },
            options: {
                animation: {
                    duration: 900,
                    easing: 'easeOutQuart',
                },
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#e7e9ee' } },
                    x: { grid: { display: false } },
                },
            },
        });
    </script>
@endpush
