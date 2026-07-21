@extends('layouts.booking')

@section('title', 'Add Room')

@section('hero')
    <small class="text-uppercase" style="letter-spacing:.15em; color:#C9A227;">StayPinas</small>
    <h1 class="mb-1">Add New Room</h1>
    <p class="mb-0">Set up a new room so guests can start booking it right away.</p>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="reservation-card h-100">
                <div class="reservation-card__stub">
                    <div>
                        <small>Room Form</small>
                        <h1>Add New Room</h1>
                    </div>
                    <span class="brand-font" style="font-size:1.8rem; opacity:.5;">✦</span>
                </div>
                <div class="reservation-card__perforation"></div>

                <div class="reservation-card__body">
                    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data" id="room-form">
                        @csrf

                        <div class="booking-section">
                            <div class="booking-section__title">
                                <span class="booking-section__step">1</span> Room Info
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-door-closed me-1"></i>Room Number</label>
                                    <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-tag me-1"></i>Room Type</label>
                                    <input type="text" name="room_type" id="room_type" value="{{ old('room_type') }}" class="form-control" placeholder="e.g. Private Double, Mixed Dorm" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-card-text me-1"></i>Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="booking-section">
                            <div class="booking-section__title">
                                <span class="booking-section__step">2</span> Capacity &amp; Pricing
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-people me-1"></i>Capacity (pax)</label>
                                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" class="form-control" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><i class="bi bi-cash-coin me-1"></i>Price per Night (₱)</label>
                                    <input type="number" step="0.01" name="price_per_night" id="price_per_night" value="{{ old('price_per_night') }}" class="form-control" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="booking-section">
                            <div class="booking-section__title">
                                <span class="booking-section__step">3</span> Photo &amp; Status
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-image me-1"></i>Room Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                <div class="form-text">JPG, PNG, or WEBP. Max 2MB.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-toggle-on me-1"></i>Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="available">Available</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Save Room</button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="stay-summary sticky-top" style="top: 1.5rem;">
                <div class="stay-summary__image" id="preview-image">
                    <span id="preview-placeholder"><i class="bi bi-image me-1"></i>Room photo preview</span>
                    <span class="stay-summary__badge" id="preview-badge">Available</span>
                </div>
                <div class="stay-summary__body">
                    <div class="stay-summary__eyebrow">StayPinas</div>
                    <div class="stay-summary__title" id="preview-type">New room</div>
                    <div class="stay-summary__subtitle" id="preview-number">Fill in the form to preview the listing.</div>

                    <div class="stay-summary__row">
                        <span><i class="bi bi-people me-1"></i>Capacity</span>
                        <span class="value" id="preview-capacity">—</span>
                    </div>
                    <div class="stay-summary__row">
                        <span><i class="bi bi-tag me-1"></i>Price / night</span>
                        <span class="value" id="preview-price">—</span>
                    </div>

                    <div class="stay-summary__divider"></div>
                    <p class="text-muted small mb-0" id="preview-description">This is how the room will look on the Rooms page.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roomNumber = document.getElementById('room_number');
    const roomType = document.getElementById('room_type');
    const capacity = document.getElementById('capacity');
    const price = document.getElementById('price_per_night');
    const description = document.getElementById('description');
    const statusSelect = document.getElementById('status');
    const imageInput = document.getElementById('image');

    const previewType = document.getElementById('preview-type');
    const previewNumber = document.getElementById('preview-number');
    const previewCapacity = document.getElementById('preview-capacity');
    const previewPrice = document.getElementById('preview-price');
    const previewDescription = document.getElementById('preview-description');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const previewBadge = document.getElementById('preview-badge');

    function peso(amount) {
        return '₱' + Number(amount || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function updatePreview() {
        previewType.textContent = roomType.value || 'New room';
        previewNumber.textContent = roomNumber.value ? 'Room ' + roomNumber.value : 'Fill in the form to preview the listing.';
        previewCapacity.textContent = capacity.value ? capacity.value + ' pax' : '—';
        previewPrice.textContent = price.value ? peso(price.value) + ' / night' : '—';
        previewDescription.textContent = description.value || 'This is how the room will look on the Rooms page.';
        previewBadge.textContent = statusSelect.options[statusSelect.selectedIndex].text;
    }

    [roomNumber, roomType, capacity, price, description, statusSelect].forEach(el => {
        el.addEventListener('input', updatePreview);
        el.addEventListener('change', updatePreview);
    });

    imageInput.addEventListener('change', function () {
        const file = imageInput.files && imageInput.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.style.backgroundImage = "url('" + e.target.result + "')";
            previewPlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    updatePreview();

    document.getElementById('room-form').addEventListener('submit', function () {
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Saving…';
        }
    });
});
</script>
@endpush
