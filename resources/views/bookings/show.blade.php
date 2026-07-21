@extends('layouts.booking')

@section('title', 'Booking Confirmation')

@section('hero')
    <small class="text-uppercase" style="letter-spacing:.15em; color:#C9A227;">StayPinas</small>
    <h1 class="mb-1">Booking Summary</h1>
    <p class="mb-0">Everything about reservation #{{ $booking->id }}, at a glance.</p>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="reservation-card h-100">
                <div class="reservation-card__stub">
                    <div>
                        <small>Booking Details</small>
                        <h1>#{{ $booking->id }} &middot; {{ $booking->guest_name }}</h1>
                    </div>
                    <span class="badge bg-{{ match($booking->status) {
                        'confirmed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    } }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <div class="reservation-card__perforation"></div>

                <div class="reservation-card__body">
                    <div class="booking-section">
                        <div class="booking-section__title"><i class="bi bi-person"></i> Guest</div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-person"></i>Name</span>
                            <span class="info-list__value">{{ $booking->guest_name }}</span>
                        </div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-envelope"></i>Email</span>
                            <span class="info-list__value">{{ $booking->guest_email }}</span>
                        </div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-telephone"></i>Phone</span>
                            <span class="info-list__value">{{ $booking->guest_phone ?: '—' }}</span>
                        </div>
                    </div>

                    <div class="booking-section">
                        <div class="booking-section__title"><i class="bi bi-door-open"></i> Stay</div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-key"></i>Room</span>
                            <span class="info-list__value">{{ $booking->room->room_number }} — {{ $booking->room->room_type }}</span>
                        </div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-box-arrow-in-right"></i>Check-in</span>
                            <span class="info-list__value">{{ $booking->check_in_date->format('F d, Y') }}</span>
                        </div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-box-arrow-left"></i>Check-out</span>
                            <span class="info-list__value">{{ $booking->check_out_date->format('F d, Y') }}</span>
                        </div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-moon-stars"></i>Nights</span>
                            <span class="info-list__value">{{ $booking->nights }}</span>
                        </div>
                        <div class="info-list__row">
                            <span class="info-list__label"><i class="bi bi-people"></i>Guests</span>
                            <span class="info-list__value">{{ $booking->guests }} pax</span>
                        </div>
                    </div>

                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Back to All Bookings</a>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="stay-summary sticky-top" style="top: 1.5rem;">
                @if ($booking->room->image)
                    <div class="stay-summary__image" style="background-image:url('{{ Storage::url($booking->room->image) }}');">
                @else
                    <div class="stay-summary__image">
                        <span><i class="bi bi-image me-1"></i>No photo yet</span>
                @endif
                    <span class="stay-summary__badge">{{ ucfirst($booking->status) }}</span>
                </div>
                <div class="stay-summary__body">
                    <div class="stay-summary__eyebrow">StayPinas</div>
                    <div class="stay-summary__title">{{ $booking->room->room_type }}</div>
                    <div class="stay-summary__subtitle">Room {{ $booking->room->room_number }}</div>

                    <div class="stay-summary__row">
                        <span><i class="bi bi-people me-1"></i>Guests</span>
                        <span class="value">{{ $booking->guests }} pax</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-tag me-1"></i>Price / night</span>
                        <span class="value">₱{{ number_format($booking->room->price_per_night, 2) }}</span>
                    </div>

                    <div class="stay-summary__divider"></div>

                    <div class="stay-summary__row">
                        <span><i class="bi bi-box-arrow-in-right me-1"></i>Check-in</span>
                        <span class="value">{{ $booking->check_in_date->format('M d, Y') }}</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-box-arrow-left me-1"></i>Check-out</span>
                        <span class="value">{{ $booking->check_out_date->format('M d, Y') }}</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-moon-stars me-1"></i>Nights</span>
                        <span class="value">{{ $booking->nights }}</span>
                    </div>

                    <div class="stay-summary__total">
                        <span>Total</span>
                        <span>₱{{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
