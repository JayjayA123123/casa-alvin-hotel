<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        $users = User::all();

        $sampleBookings = [
            ['guest_name' => 'Alvin Jay Cornejo', 'guest_email' => 'alvin@example.com', 'guest_phone' => '09171234567', 'check_in' => now()->addDays(2), 'check_out' => now()->addDays(5), 'guests' => 1, 'status' => 'confirmed'],
            ['guest_name' => 'Juan Dela Cruz', 'guest_email' => 'juan@example.com', 'guest_phone' => '09179876543', 'check_in' => now()->addDays(7), 'check_out' => now()->addDays(9), 'guests' => 2, 'status' => 'pending'],
            ['guest_name' => 'Maria Santos', 'guest_email' => 'maria@example.com', 'guest_phone' => '09181112222', 'check_in' => now()->subDays(3), 'check_out' => now()->subDays(1), 'guests' => 1, 'status' => 'completed'],
        ];

        foreach ($sampleBookings as $index => $data) {
            $room = $rooms[$index % $rooms->count()];
            $nights = $data['check_in']->diffInDays($data['check_out']);

            Booking::create([
                'room_id' => $room->id,
                'user_id' => $users[$index % $users->count()]->id,
                'guest_name' => $data['guest_name'],
                'guest_email' => $data['guest_email'],
                'guest_phone' => $data['guest_phone'],
                'check_in_date' => $data['check_in'],
                'check_out_date' => $data['check_out'],
                'guests' => $data['guests'],
                'total_price' => $nights * $room->price_per_night,
                'status' => $data['status'],
            ]);
        }
    }
}
