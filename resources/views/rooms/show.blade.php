@extends('layouts.booking')

@section('title', 'Room Details')

@section('hero')
    <small class="text-uppercase" style="letter-spacing:.15em; color:#C9A227;">StayPinas</small>
    <h1 class="mb-1">{{ $room->room_type }}</h1>
    <p class="mb-0">Room {{ $room->room_number }} &middot; full details and booking history.</p>
@endsection

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="reservation-card h-100">
                <div class="reservation-card__stub">
                    <div>
                        <small>Room Details</small>
                        <h1>{{ $room->room_type }} — {{ $room->room_number }}</h1>
                    </div>
                    <span class="badge bg-{{ $room->status === 'available' ? 'success' : 'secondary' }}">{{ ucfirst($room->status) }}</span>
                </div>
                <div class="reservation-card__perforation"></div>

                <div class="reservation-card__body">
                    <p class="text-muted">{{ $room->description ?: 'No description added yet.' }}</p>

                    <div class="info-list__row">
                        <span class="info-list__label"><i class="bi bi-people"></i>Capacity</span>
                        <span class="info-list__value">{{ $room->capacity }} pax</span>
                    </div>
                    <div class="info-list__row">
                        <span class="info-list__label"><i class="bi bi-cash-coin"></i>Price</span>
                        <span class="info-list__value">₱{{ number_format($room->price_per_night, 2) }} / night</span>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}" class="btn btn-success"><i class="bi bi-calendar-check me-1"></i>Book This Room</a>
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit</a>
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="stay-summary h-100">
                <div class="stay-summary__image" @if($room->image) style="background-image:url('{{ Storage::url($room->image) }}');" @endif>
                    @unless($room->image)
                        <span><i class="bi bi-image me-1"></i>No photo yet</span>
                    @endunless
                    <span class="stay-summary__badge">{{ ucfirst($room->status) }}</span>
                </div>
                <div class="stay-summary__body">
                    <div class="stay-summary__eyebrow">StayPinas</div>
                    <div class="stay-summary__title">{{ $room->room_type }}</div>
                    <div class="stay-summary__subtitle">Room {{ $room->room_number }}</div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-people me-1"></i>Capacity</span>
                        <span class="value">{{ $room->capacity }} pax</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-tag me-1"></i>Price / night</span>
                        <span class="value">₱{{ number_format($room->price_per_night, 2) }}</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-journal-check me-1"></i>Total bookings</span>
                        <span class="value">{{ $room->bookings->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="h5 mb-3"><i class="bi bi-clock-history me-1"></i>Booking History</h2>
    <div class="bookings-table-wrap">
        <table class="table table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th><i class="bi bi-person me-1"></i>Guest</th>
                    <th><i class="bi bi-box-arrow-in-right me-1"></i>Check-in</th>
                    <th><i class="bi bi-box-arrow-left me-1"></i>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($room->bookings as $booking)
                    <tr>
                        <td>{{ $booking->guest_name }}</td>
                        <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                        <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                        <td>
                            <span class="badge bg-{{ match($booking->status) {
                                'confirmed' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'secondary',
                            } }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="bookings-empty">
                                <i class="bi bi-calendar-x"></i>
                                No bookings yet for this room.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
