@extends('layouts.admin')

@section('title', 'Booking Calendar')

@section('content')
    <div class="admin-topbar">
        <div>
            <h1 class="h3 mb-1">Booking Calendar</h1>
            <p class="text-muted mb-0">Tingnan ang occupancy ng lahat ng rooms sa isang view.</p>
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap">
            @foreach ($statusColors as $status => $color)
                <div class="d-flex align-items-center gap-2">
                    <span style="width: 12px; height: 12px; border-radius: 3px; background: {{ $color }}; display: inline-block;"></span>
                    <span class="small text-muted">{{ ucfirst($status) }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="panel shadow-card p-3 p-md-4">
        <div id="booking-calendar"></div>
    </div>

    <!-- Booking details modal, fina-fill in ng JS pag na-click ang isang event -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Room</span><span id="eventRoom" class="fw-semibold"></span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Check-in</span><span id="eventStart" class="fw-semibold"></span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Check-out</span><span id="eventEnd" class="fw-semibold"></span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Guests</span><span id="eventGuests" class="fw-semibold"></span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Status</span><span id="eventStatus" class="fw-semibold"></span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Total</span><span id="eventTotal" class="fw-semibold"></span></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('booking-calendar');
            const modalEl = document.getElementById('eventModal');
            const modal = new bootstrap.Modal(modalEl);

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek',
                },
                events: '{{ route('admin.calendar.events') }}',
                eventClick: function (info) {
                    const props = info.event.extendedProps;
                    document.getElementById('eventRoom').textContent = props.room ?? '';
                    document.getElementById('eventStart').textContent = info.event.startStr;
                    document.getElementById('eventEnd').textContent = info.event.endStr;
                    document.getElementById('eventGuests').textContent = props.guests ?? '';
                    document.getElementById('eventStatus').textContent = (props.status ?? '').charAt(0).toUpperCase() + (props.status ?? '').slice(1);
                    document.getElementById('eventTotal').textContent = '\u20b1' + (props.total ?? '');
                    document.getElementById('eventModalTitle').textContent = info.event.title;
                    modal.show();
                },
            });

            calendar.render();
        });
    </script>
@endpush
