@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
    <div class="admin-topbar">
        <div>
            <h1 class="h3 mb-1">Bookings</h1>
            <p class="text-muted mb-0">Lahat ng reservations sa buong hotel.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            @foreach (['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                <a href="{{ route('admin.bookings.index', $value === 'all' ? [] : ['status' => $value]) }}"
                   class="btn btn-sm {{ $status === $value ? 'btn-navy' : 'btn-outline-navy' }}">{{ $label }}</a>
            @endforeach
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
                        <th>Total</th>
                        <th>Status</th>
                        <th class="pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="ps-3">{{ $booking->room->room_type }} <span class="text-muted">({{ $booking->room->room_number }})</span></td>
                            <td>
                                {{ $booking->guest_name }}
                                @if ($booking->user)
                                    <span class="text-muted small d-block">{{ $booking->user->email }}</span>
                                @endif
                            </td>
                            <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                            <td>{{ $booking->guests }}</td>
                            <td class="fw-bold" style="color: var(--navy);">&#8369;{{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                @php
                                    $badgeClass = match($booking->status) {
                                        'completed' => 'badge-completed',
                                        'cancelled' => 'badge-cancelled',
                                        'confirmed' => 'badge-confirmed',
                                        default => 'badge-pending',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="pe-3">
                                <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" class="d-flex gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                        @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $option)
                                            <option value="{{ $option }}" @selected($booking->status === $option)>{{ ucfirst($option) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="text-center py-5 text-muted">Walang bookings na tumugma sa filter na ito.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
