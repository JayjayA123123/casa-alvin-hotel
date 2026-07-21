@extends('layouts.booking')

@section('title', 'My Bookings')

@section('content')
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">My Bookings</h1>
            <p class="text-muted mb-0">Every reservation made on StayPinas, in one place.</p>
        </div>
        <a href="{{ route('bookings.create') }}" class="btn btn-orange"><i class="bi bi-plus-lg me-1"></i>New Booking</a>
    </div>

    <div class="panel shadow-card p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <ul class="nav nav-tabs" id="booking-tabs">
                <li class="nav-item"><button class="nav-link active" data-filter="all">All Bookings</button></li>
                <li class="nav-item"><button class="nav-link" data-filter="upcoming">Upcoming</button></li>
                <li class="nav-item"><button class="nav-link" data-filter="completed">Completed</button></li>
                <li class="nav-item"><button class="nav-link" data-filter="cancelled">Cancelled</button></li>
            </ul>
            <div style="max-width: 260px; width: 100%;">
                <input type="text" id="booking-search" class="form-control form-control-sm" placeholder="Search by guest name...">
            </div>
        </div>
    </div>

    <div class="panel shadow-card p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Room</th>
                        <th>Guest</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        @php
                            $group = match($booking->status) {
                                'completed' => 'completed',
                                'cancelled' => 'cancelled',
                                default => 'upcoming',
                            };
                            $badgeClass = match($booking->status) {
                                'completed' => 'badge-completed',
                                'cancelled' => 'badge-cancelled',
                                'confirmed' => 'badge-confirmed',
                                default => 'badge-pending',
                            };
                        @endphp
                        <tr data-status="{{ $group }}" data-guest="{{ strtolower($booking->guest_name) }}">
                            <td class="ps-3">
                                <div class="fw-semibold">{{ $booking->room->room_type }}</div>
                                <div class="text-muted small">Room {{ $booking->room->room_number }}</div>
                            </td>
                            <td>
                                #CAH-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                                <div class="text-muted small">{{ $booking->guest_name }}</div>
                            </td>
                            <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                            <td>{{ $booking->guests }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ ucfirst($booking->status) }}</span></td>
                            <td class="fw-bold" style="color: var(--navy);">&#8369;{{ number_format($booking->total_price, 2) }}</td>
                            <td class="pe-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-navy btn-sm" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-outline-navy btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Cancel/delete this booking?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-navy btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                    <h5 class="mt-3 mb-2">No bookings yet</h5>
                                    <p class="mb-3">Make your first reservation to see it here.</p>
                                    <a href="{{ route('bookings.create') }}" class="btn btn-orange btn-sm"><i class="bi bi-plus-lg me-1"></i>New Booking</a>
                                </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('#booking-tabs .nav-link');
        const rows = document.querySelectorAll('tbody tr[data-status]');
        const search = document.getElementById('booking-search');
        let activeFilter = 'all';

        function applyFilters() {
            const term = search.value.trim().toLowerCase();
            rows.forEach(function (row) {
                const matchesTab = activeFilter === 'all' || row.dataset.status === activeFilter;
                const matchesSearch = !term || row.dataset.guest.includes(term);
                row.style.display = (matchesTab && matchesSearch) ? '' : 'none';
            });
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                activeFilter = tab.dataset.filter;
                applyFilters();
            });
        });

        search.addEventListener('input', applyFilters);
    });
</script>
@endpush
