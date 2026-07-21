@extends('layouts.booking')

@section('title', 'Rooms')

@php
    $stockPhotos = [
        'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?q=80&w=500&auto=format&fit=crop',
    ];
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Available Rooms</h1>
            <p class="text-muted mb-0">{{ $rooms->count() }} {{ Str::plural('room', $rooms->count()) }} found</p>
        </div>
        @auth
            <a href="{{ route('rooms.create') }}" class="btn btn-outline-navy btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Room</a>
        @endauth
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <form method="GET" action="{{ route('rooms.index') }}">
                <div class="filter-block panel shadow-card">
                    <h6>Price Range (per night)</h6>
                    <div class="d-flex gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control form-control-sm" placeholder="Min">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control form-control-sm" placeholder="Max">
                    </div>
                </div>

                <div class="filter-block panel shadow-card">
                    <h6>Room Type</h6>
                    @foreach ($roomTypes as $type)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="types[]" value="{{ $type }}" id="type-{{ $loop->index }}"
                                {{ in_array($type, (array) request('types', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="type-{{ $loop->index }}">{{ $type }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="filter-block panel shadow-card">
                    <h6>Minimum Guests</h6>
                    <select name="capacity" class="form-select form-select-sm">
                        <option value="">Any</option>
                        <option value="1" {{ request('capacity') == 1 ? 'selected' : '' }}>1+</option>
                        <option value="2" {{ request('capacity') == 2 ? 'selected' : '' }}>2+</option>
                        <option value="3" {{ request('capacity') == 3 ? 'selected' : '' }}>3+</option>
                        <option value="4" {{ request('capacity') == 4 ? 'selected' : '' }}>4+</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-orange w-100 btn-sm">Apply Filters</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-navy w-100 btn-sm mt-2">Clear</a>
            </form>
        </div>

        <div class="col-lg-9">
            <div class="d-flex flex-column gap-3">
                @forelse ($rooms as $i => $room)
                    @php $img = $room->image ? Storage::url($room->image) : $stockPhotos[$i % count($stockPhotos)]; @endphp
                    <div class="panel shadow-card p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <img src="{{ $img }}" class="w-100 rounded-3" style="height: 120px; object-fit: cover;" alt="{{ $room->room_type }}">
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-1">{{ $room->room_type }}</h5>
                                <div class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> StayPinas &middot; Room {{ $room->room_number }}</div>
                                <div class="room-card__facts mb-2">
                                    <span><i class="bi bi-people"></i> {{ $room->capacity }} Guests</span>
                                    <span><i class="bi bi-wifi"></i> Free Wi-Fi</span>
                                    <span><i class="bi bi-cup-hot"></i> Breakfast</span>
                                </div>
                                <span class="badge {{ $room->status === 'available' ? 'badge-completed' : 'badge-cancelled' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <div class="room-card__price mb-2">&#8369;{{ number_format($room->price_per_night, 0) }}<small> / night</small></div>
                                <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}" class="btn btn-orange btn-sm w-100 mb-2">Book Now</a>
                                @auth
                                    <div class="d-flex justify-content-md-end gap-2">
                                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-outline-navy btn-sm"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Delete this room?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-navy btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="panel shadow-card text-center py-5 text-muted">
                        <i class="bi bi-door-open" style="font-size: 2rem;"></i>
                        <h5 class="mt-3 mb-2">No rooms match your filters</h5>
                        <p class="mb-3">Try adjusting your filters or clearing them.</p>
                        <a href="{{ route('rooms.index') }}" class="btn btn-orange btn-sm">Clear Filters</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
