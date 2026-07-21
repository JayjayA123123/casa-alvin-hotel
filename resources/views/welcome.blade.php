@extends('layouts.booking')

@section('title', 'Welcome')

@php
    $stockPhotos = [
        'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=800&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=800&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=800&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?q=80&w=800&auto=format&fit=crop',
    ];
@endphp

@section('hero')
    <div class="row align-items-center py-3">
        <div class="col-lg-8">
            <h1>Find Your Perfect<br>Stay at StayPinas</h1>
            <p class="lead mb-4">Discover comfortable rooms at the best rates and make your stay memorable.</p>
        </div>
    </div>

    <div class="search-bar">
        <form action="{{ route('rooms.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label>Check-in</label>
                <input type="date" name="check_in" class="form-control" value="{{ now()->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label>Check-out</label>
                <input type="date" name="check_out" class="form-control" value="{{ now()->addDays(2)->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label>Guests</label>
                <select name="guests" class="form-select">
                    <option>1 Guest</option>
                    <option selected>2 Guests</option>
                    <option>3 Guests</option>
                    <option>4+ Guests</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-orange w-100 py-2">Search Rooms</button>
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="pt-5 mt-4">
        <div class="d-flex justify-content-between align-items-end mb-4 reveal">
            <div>
                <h2 class="h3 mb-1">Popular Rooms</h2>
                <p class="text-muted mb-0">Handpicked rooms our guests love the most</p>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-navy btn-sm">View All Rooms</a>
        </div>

        <div class="row g-4">
            @forelse ($rooms as $i => $room)
                <div class="col-md-6 col-lg-3">
                    <div class="room-card panel shadow-card reveal reveal-{{ ($i % 4) + 1 }}">
                        @php $img = $room->image ? Storage::url($room->image) : $stockPhotos[$i % count($stockPhotos)]; @endphp
                        <img src="{{ $img }}" class="room-card__img" alt="{{ $room->room_type }}">
                        <div class="room-card__body">
                            <div class="room-card__title">{{ $room->room_type }}</div>
                            <div class="room-card__meta"><i class="bi bi-geo-alt"></i> StayPinas, Pangasinan</div>
                            <div class="room-card__facts">
                                <span><i class="bi bi-people"></i> {{ $room->capacity }} Guests</span>
                                <span><i class="bi bi-door-closed"></i> Room {{ $room->room_number }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="room-card__price">&#8369;{{ number_format($room->price_per_night, 0) }}<small> / night</small></div>
                                <a href="{{ route('bookings.create') }}?room={{ $room->id }}" class="btn btn-orange btn-sm">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="panel p-4 text-center text-muted">No rooms available right now. Please check back soon.</div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="text-center mt-5 pt-4 reveal">
        <h2 class="h3 mb-1">Why Choose StayPinas?</h2>
        <p class="text-muted mb-4">The little details that make a big difference</p>
    </div>

    <div class="row g-4 text-center mb-5">
        <div class="col-md-3 col-6">
            <div class="feature-icon-item reveal reveal-1">
                <span class="icon-wrap"><i class="bi bi-shield-check"></i></span>
                <h4>Best Price Guarantee</h4>
                <p>Get the best rates for your stay.</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="feature-icon-item reveal reveal-2">
                <span class="icon-wrap"><i class="bi bi-calendar2-check"></i></span>
                <h4>Easy Booking</h4>
                <p>Book your stay in just a few clicks.</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="feature-icon-item reveal reveal-3">
                <span class="icon-wrap"><i class="bi bi-lock"></i></span>
                <h4>Trusted &amp; Secure</h4>
                <p>Your security is our top priority.</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="feature-icon-item reveal reveal-4">
                <span class="icon-wrap"><i class="bi bi-headset"></i></span>
                <h4>Local Support</h4>
                <p>We're here to help you anytime.</p>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <div class="text-center mb-4 reveal">
            <h2 class="h3 mb-1">What Our Guests Say</h2>
            <p class="text-muted mb-0">Real reviews from real guests</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card panel shadow-card reveal reveal-1">
                    <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <p class="quote">"Beautiful place and very relaxing! The staff were friendly and accommodating."</p>
                    <div class="author">— Marie D.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card panel shadow-card reveal reveal-2">
                    <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <p class="quote">"Best location for a family getaway. The view was breathtaking!"</p>
                    <div class="author">— John R.</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card panel shadow-card reveal reveal-3">
                    <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <p class="quote">"Clean, comfortable, and worth every penny. Will definitely come back!"</p>
                    <div class="author">— Ana P.</div>
                </div>
            </div>
        </div>
    </div>

    @guest
        <div class="panel shadow-card text-center py-5 px-3 mb-4 reveal">
            <h3 class="mb-2">New here?</h3>
            <p class="text-muted mb-4">Create an account to manage your bookings with ease.</p>
            <a href="{{ route('register') }}" class="btn btn-orange me-2">Create an Account</a>
            <a href="{{ route('login') }}" class="btn btn-outline-navy">Log In</a>
        </div>
    @endguest
@endsection
