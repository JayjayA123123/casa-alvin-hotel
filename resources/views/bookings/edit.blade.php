@extends('layouts.booking')

@section('title', 'Edit Booking')

@section('hero')
    <small class="text-uppercase" style="letter-spacing:.15em; color:#C9A227;">StayPinas</small>
    <h1 class="mb-1">Edit Booking #{{ $booking->id }}</h1>
    <p class="mb-0">Update the stay dates, guest count, or status for this reservation.</p>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="reservation-card h-100">
                <div class="reservation-card__stub">
                    <div>
                        <small>Booking Form</small>
                        <h1>Edit Reservation</h1>
                    </div>
                    <span class="brand-font" style="font-size:1.8rem; opacity:.5;">✦</span>
                </div>
                <div class="reservation-card__perforation"></div>

                <div class="reservation-card__body">
                    <form action="{{ route('bookings.update', $booking) }}" method="POST" id="edit-booking-form">
                        @csrf
                        @method('PUT')

                        <div class="booking-section">
                            <div class="booking-section__title"><i class="bi bi-door-open"></i> Room &amp; Guest</div>
                            <div class="info-list__row">
                                <span class="info-list__label"><i class="bi bi-key"></i>Room</span>
                                <span class="info-list__value">{{ $booking->room->room_number }} — {{ $booking->room->room_type }}</span>
                            </div>
                            <div class="info-list__row">
                                <span class="info-list__label"><i class="bi bi-person"></i>Guest</span>
                                <span class="info-list__value">{{ $booking->guest_name }} ({{ $booking->guest_email }})</span>
                            </div>
                        </div>

                        <div class="booking-section">
                            <div class="booking-section__title">
                                <span class="booking-section__step">1</span> Stay Dates
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-box-arrow-in-right me-1"></i>Check-in Date</label>
                                    <input type="date" name="check_in_date" value="{{ old('check_in_date', $booking->check_in_date->format('Y-m-d')) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-box-arrow-left me-1"></i>Check-out Date</label>
                                    <input type="date" name="check_out_date" value="{{ old('check_out_date', $booking->check_out_date->format('Y-m-d')) }}" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="booking-section">
                            <div class="booking-section__title">
                                <span class="booking-section__step">2</span> Guests &amp; Status
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-people me-1"></i>Number of Guests</label>
                                    <input type="number" name="guests" value="{{ old('guests', $booking->guests) }}" class="form-control" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-flag me-1"></i>Status</label>
                                    <select name="status" class="form-select" required>
                                        @foreach (['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                                            <option value="{{ $status }}" {{ old('status', $booking->status) === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Update Booking</button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
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
                        <span><i class="bi bi-tag me-1"></i>Price / night</span>
                        <span class="value">₱{{ number_format($booking->room->price_per_night, 2) }}</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-moon-stars me-1"></i>Current nights</span>
                        <span class="value">{{ $booking->nights }}</span>
                    </div>

                    <div class="stay-summary__note">
                        <i class="bi bi-info-circle"></i>
                        <span>Changing the dates here won't recalculate the total automatically — double-check it against the price above.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('edit-booking-form').addEventListener('submit', function () {
    const btn = this.querySelector('button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Saving…';
    }
});
</script>
@endpush
