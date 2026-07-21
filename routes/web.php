<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $rooms = \App\Models\Room::where('status', 'available')->latest()->take(4)->get();

    return view('welcome', compact('rooms'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/stats', [DashboardController::class, 'stats'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.stats');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
| Admin-only area. Guarded by both 'auth' (naka-login) at 'admin'
| (role === 'admin') middleware.
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');

    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');

    Route::get('/calendar', [\App\Http\Controllers\Admin\CalendarController::class, 'index'])->name('calendar');
    Route::get('/calendar/events', [\App\Http\Controllers\Admin\CalendarController::class, 'events'])->name('calendar.events');
});

/*
|--------------------------------------------------------------------------
| Rooms
|--------------------------------------------------------------------------
*/
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

Route::middleware('auth')->group(function () {
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
});

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

// JSON feed of a room's booked date ranges, used by the FullCalendar widget.
Route::get('/rooms/{room}/booked-dates', [BookingController::class, 'bookedDates'])->name('rooms.booked-dates');

Route::middleware('auth')->group(function () {
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});

/*
|--------------------------------------------------------------------------
| Bookings
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
});

Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

Route::middleware('auth')->group(function () {
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});

require __DIR__.'/auth.php';
