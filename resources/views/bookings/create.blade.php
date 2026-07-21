@extends('layouts.booking')

@section('title', 'Book a Room')

@push('styles')
<style>
    .summary-img-box {
        height: 170px;
        border-radius: 12px 12px 0 0;
        background-size: cover;
        background-position: center;
        background-color: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-faint);
        font-size: .85rem;
        position: relative;
    }
    .summary-badge {
        position: absolute;
        top: 10px; right: 10px;
        background: var(--success);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        padding: .25em .7em;
        border-radius: 999px;
    }
    .summary-row { display: flex; justify-content: space-between; font-size: .9rem; padding: .4rem 0; color: var(--text-muted); }
    .summary-row strong { color: var(--ink); font-weight: 600; }
    .summary-total-row { display: flex; justify-content: space-between; font-size: 1.15rem; font-weight: 800; color: var(--navy); padding-top: .8rem; margin-top: .5rem; border-top: 1px solid var(--line); }
    .booking-step-num {
        width: 26px; height: 26px; border-radius: 50%; background: var(--orange); color: #fff; font-size: .82rem;
        display: inline-flex; align-items: center; justify-content: center; font-weight: 700; margin-right: .5rem;
    }
    #booking-calendar { background: #fff; }
    .date-chip { flex: 1; background: var(--bg); border-radius: 8px; padding: .5rem .7rem; text-align: center; }
    .date-chip__label { display: block; font-size: .68rem; text-transform: uppercase; color: var(--text-faint); font-weight: 700; }
    .date-chip__value { font-size: .85rem; font-weight: 700; color: var(--navy); }
    .date-chip__value--empty { color: var(--text-faint); font-weight: 500; }
</style>
@endpush

@section('content')
    <h1 class="h3 mb-4">Reserve Your Stay</h1>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="panel shadow-card p-4">
                <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                    @csrf

                    <div class="mb-4">
                        <h6 class="mb-3"><span class="booking-step-num">1</span>Choose Your Room</h6>
                        <select name="room_id" id="room_id" class="form-select" required>
                            <option value="">-- Choose a Room --</option>
                            @foreach ($rooms as $room)
                                <option
                                    value="{{ $room->id }}"
                                    data-type="{{ $room->room_type }}"
                                    data-number="{{ $room->room_number }}"
                                    data-capacity="{{ $room->capacity }}"
                                    data-price="{{ $room->price_per_night }}"
                                    data-image="{{ $room->image ? Storage::url($room->image) : '' }}"
                                    {{ old('room_id', $selectedRoomId) == $room->id ? 'selected' : '' }}
                                >
                                    {{ $room->room_number }} — {{ $room->room_type }} (&#8369;{{ number_format($room->price_per_night, 2) }}/night, max {{ $room->capacity }} pax)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <h6 class="mb-3"><span class="booking-step-num">2</span>Guest Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guest Name</label>
                                <input type="text" name="guest_name" value="{{ old('guest_name') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Number of Guests</label>
                                <input type="number" name="guests" id="guests" value="{{ old('guests', 1) }}" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="guest_email" value="{{ old('guest_email') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <h6 class="mb-3"><span class="booking-step-num">3</span>Pick Your Dates</h6>
                        <div class="alert alert-info py-2 px-3 mb-2 small">
                            <i class="bi bi-info-circle me-1"></i>Click a start date, then click an end date. Dates shaded red are already booked.
                        </div>
                        <div id="booking-calendar" class="border rounded-3 p-2"></div>
                        <div id="calendar-debug" class="small text-muted mt-2">Calendar status: loading…</div>

                        <div class="d-flex gap-2 mt-3">
                            <div class="date-chip">
                                <span class="date-chip__label">Check-in</span>
                                <span class="date-chip__value date-chip__value--empty" id="checkin-chip-text">Not selected</span>
                            </div>
                            <div class="date-chip">
                                <span class="date-chip__label">Check-out</span>
                                <span class="date-chip__value date-chip__value--empty" id="checkout-chip-text">Not selected</span>
                            </div>
                            <div class="date-chip">
                                <span class="date-chip__label">Nights</span>
                                <span class="date-chip__value date-chip__value--empty" id="nights-chip-text">—</span>
                            </div>
                        </div>

                        <input type="hidden" name="check_in_date" id="check_in_date" value="{{ old('check_in_date') }}" required>
                        <input type="hidden" name="check_out_date" id="check_out_date" value="{{ old('check_out_date') }}" required>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-orange"><i class="bi bi-check2-circle me-1"></i>Confirm Booking</button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-navy">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="panel shadow-card sticky-top" style="top: 1.5rem;">
                <div class="summary-img-box" id="summary-image">
                    <span id="summary-image-placeholder"><i class="bi bi-image me-1"></i>Pick a room to preview</span>
                    <span class="summary-badge" id="summary-badge" style="display:none;">Available</span>
                </div>
                <div class="p-4">
                    <div class="text-uppercase small fw-bold" style="color: var(--orange-dark); letter-spacing:.05em;">Booking Summary</div>
                    <h5 class="mb-1" id="summary-room-type">Your Stay</h5>
                    <div class="text-muted small mb-3" id="summary-room-number">Choose a room on the left to see details here.</div>

                    <div class="summary-row"><span>Capacity</span><strong id="summary-capacity">—</strong></div>
                    <div class="summary-row"><span>Price / night</span><strong id="summary-price">—</strong></div>
                    <hr>
                    <div class="summary-row"><span>Check-in</span><strong id="summary-checkin">—</strong></div>
                    <div class="summary-row"><span>Check-out</span><strong id="summary-checkout">—</strong></div>
                    <div class="summary-row"><span>Nights</span><strong id="summary-nights">—</strong></div>

                    <div class="summary-total-row"><span>Total</span><span id="summary-total">₱0.00</span></div>

                    <div class="mt-3 small text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Your booking will be marked <strong>Pending</strong> until the front desk confirms it — no payment is taken here.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-md-3 col-sm-6">
            <div class="feature-icon-item">
                <span class="icon-wrap"><i class="bi bi-shield-check"></i></span>
                <h4 class="h6">Best Price Guarantee</h4>
                <p class="small">Get the best rates when you book direct.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="feature-icon-item">
                <span class="icon-wrap"><i class="bi bi-calendar2-check"></i></span>
                <h4 class="h6">Flexible Booking</h4>
                <p class="small">Free cancellation up to 24 hours before check-in.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="feature-icon-item">
                <span class="icon-wrap"><i class="bi bi-headset"></i></span>
                <h4 class="h6">24/7 Support</h4>
                <p class="small">We're here to help you anytime, anywhere.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="feature-icon-item">
                <span class="icon-wrap"><i class="bi bi-lock"></i></span>
                <h4 class="h6">Secure Payment</h4>
                <p class="small">Your payment information is always protected.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('booking-form').addEventListener('submit', function (e) {
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Confirming…';
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    const debugEl = document.getElementById('calendar-debug');

    const roomSelect = document.getElementById('room_id');
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');

    const summaryImage = document.getElementById('summary-image');
    const summaryImagePlaceholder = document.getElementById('summary-image-placeholder');
    const summaryBadge = document.getElementById('summary-badge');
    const summaryRoomType = document.getElementById('summary-room-type');
    const summaryRoomNumber = document.getElementById('summary-room-number');
    const summaryCapacity = document.getElementById('summary-capacity');
    const summaryPrice = document.getElementById('summary-price');
    const summaryCheckin = document.getElementById('summary-checkin');
    const summaryCheckout = document.getElementById('summary-checkout');
    const summaryNights = document.getElementById('summary-nights');
    const summaryTotal = document.getElementById('summary-total');

    const checkinChipText = document.getElementById('checkin-chip-text');
    const checkoutChipText = document.getElementById('checkout-chip-text');
    const nightsChipText = document.getElementById('nights-chip-text');

    function peso(amount) {
        return '₱' + Number(amount).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function formatPretty(dateStr) {
        if (!dateStr) return null;
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
    }

    function getSelectedRoomData() {
        const opt = roomSelect.options[roomSelect.selectedIndex];
        if (!opt || !opt.value) return null;
        return {
            type: opt.dataset.type,
            number: opt.dataset.number,
            capacity: opt.dataset.capacity,
            price: parseFloat(opt.dataset.price || 0),
            image: opt.dataset.image,
        };
    }

    function updateSummary() {
        const room = getSelectedRoomData();

        if (room) {
            summaryRoomType.textContent = room.type;
            summaryRoomNumber.textContent = 'Room ' + room.number;
            summaryCapacity.textContent = room.capacity + ' pax';
            summaryPrice.textContent = peso(room.price) + ' / night';

            if (room.image) {
                summaryImage.style.backgroundImage = "url('" + room.image + "')";
                summaryImagePlaceholder.style.display = 'none';
            } else {
                summaryImage.style.backgroundImage = '';
                summaryImagePlaceholder.style.display = 'inline';
                summaryImagePlaceholder.innerHTML = '<i class="bi bi-image me-1"></i>No photo yet';
            }
            summaryBadge.style.display = 'inline-block';
        } else {
            summaryRoomType.textContent = 'Your Stay';
            summaryRoomNumber.textContent = 'Choose a room on the left to see details here.';
            summaryCapacity.textContent = '—';
            summaryPrice.textContent = '—';
            summaryImage.style.backgroundImage = '';
            summaryImagePlaceholder.style.display = 'inline';
            summaryImagePlaceholder.innerHTML = '<i class="bi bi-image me-1"></i>Pick a room to preview';
            summaryBadge.style.display = 'none';
        }

        const ci = checkInDate.value;
        const co = checkOutDate.value;
        const prettyCi = formatPretty(ci);
        const prettyCo = formatPretty(co);

        summaryCheckin.textContent = prettyCi || '—';
        summaryCheckout.textContent = prettyCo || '—';
        checkinChipText.textContent = prettyCi || 'Not selected';
        checkinChipText.classList.toggle('date-chip__value--empty', !prettyCi);
        checkoutChipText.textContent = prettyCo || 'Not selected';
        checkoutChipText.classList.toggle('date-chip__value--empty', !prettyCo);

        let nights = 0;
        if (ci && co) {
            nights = Math.round((new Date(co) - new Date(ci)) / 86400000);
        }

        summaryNights.textContent = nights > 0 ? nights : '—';
        nightsChipText.textContent = nights > 0 ? nights : '—';
        nightsChipText.classList.toggle('date-chip__value--empty', !(nights > 0));

        const total = room && nights > 0 ? room.price * nights : 0;
        summaryTotal.textContent = peso(total);
    }

    roomSelect.addEventListener('change', updateSummary);
    updateSummary();

    try {
        if (typeof FullCalendar === 'undefined') {
            debugEl.textContent = 'Calendar status: FullCalendar library did not load (check internet connection).';
            document.getElementById('booking-calendar').innerHTML =
                '<div class="alert alert-danger mb-0">Calendar failed to load. Please check your internet connection and refresh the page.</div>';
            return;
        }

        debugEl.textContent = 'Calendar status: library loaded, building calendar…';

        const calendarEl = document.getElementById('booking-calendar');

        let pendingStart = null;
        let bookedRanges = [];

        const selectionEventId = 'selected-range';

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 500,
            validRange: {
                start: new Date().toISOString().slice(0, 10),
            },
            events: [],
            dateClick: function (info) {
                debugEl.textContent = 'Calendar status: click detected on ' + info.dateStr;

                if (!roomSelect.value) {
                    alert('Please select a room first.');
                    return;
                }

                const clickedDate = info.date;

                if (isDateBooked(clickedDate)) {
                    alert('That date is already booked. Please choose another date.');
                    return;
                }

                if (!pendingStart) {
                    pendingStart = clickedDate;
                    setCheckIn(clickedDate);
                    setCheckOut(null);
                    clearSelectionEvent();
                } else {
                    if (clickedDate <= pendingStart) {
                        pendingStart = clickedDate;
                        setCheckIn(clickedDate);
                        setCheckOut(null);
                        clearSelectionEvent();
                        return;
                    }

                    if (rangeOverlapsBooked(pendingStart, clickedDate)) {
                        alert('Your selected range overlaps an already booked date. Please choose different dates.');
                        return;
                    }

                    setCheckOut(clickedDate);
                    highlightSelection(pendingStart, clickedDate);
                    pendingStart = null;
                }
            },
        });

        calendar.render();
        debugEl.textContent = 'Calendar status: rendered successfully. Click a date to test.';

        roomSelect.addEventListener('change', loadBookedDates);
        if (roomSelect.value) {
            loadBookedDates();
        }

        function loadBookedDates() {
            pendingStart = null;
            setCheckIn(null);
            setCheckOut(null);
            clearSelectionEvent();
            bookedRanges = [];

            calendar.getEvents().forEach(e => e.remove());

            if (!roomSelect.value) {
                return;
            }

            fetch('/rooms/' + roomSelect.value + '/booked-dates')
                .then(res => res.json())
                .then(data => {
                    data.forEach(ev => {
                        calendar.addEvent(ev);
                        bookedRanges.push({
                            start: new Date(ev.start),
                            end: new Date(ev.end),
                        });
                    });
                })
                .catch(() => {});
        }

        function isDateBooked(date) {
            return bookedRanges.some(r => date >= r.start && date < r.end);
        }

        function rangeOverlapsBooked(start, end) {
            return bookedRanges.some(r => start < r.end && end > r.start);
        }

        function highlightSelection(start, end) {
            const displayEnd = new Date(end);
            displayEnd.setDate(displayEnd.getDate() + 1);

            calendar.addEvent({
                id: selectionEventId,
                start: formatDate(start),
                end: formatDate(displayEnd),
                display: 'background',
                color: '#f5941f',
            });
        }

        function clearSelectionEvent() {
            const existing = calendar.getEventById(selectionEventId);
            if (existing) {
                existing.remove();
            }
        }

        function setCheckIn(date) {
            checkInDate.value = date ? formatDate(date) : '';
            updateSummary();
        }

        function setCheckOut(date) {
            checkOutDate.value = date ? formatDate(date) : '';
            updateSummary();
        }

        function formatDate(date) {
            return date.toISOString().slice(0, 10);
        }
    } catch (err) {
        debugEl.textContent = 'Calendar status: JS ERROR — ' + err.message;
    }
});
</script>
@endpush
