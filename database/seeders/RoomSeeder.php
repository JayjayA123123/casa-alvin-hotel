<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['room_number' => 'D-101', 'room_type' => 'Mixed Dorm (6-bed)', 'capacity' => 6, 'price_per_night' => 450.00, 'description' => 'Budget-friendly shared dorm with lockers and reading lights.'],
            ['room_number' => 'D-102', 'room_type' => 'Female Dorm (4-bed)', 'capacity' => 4, 'price_per_night' => 500.00, 'description' => 'Female-only dorm with private curtains and lockers.'],
            ['room_number' => 'P-201', 'room_type' => 'Private Single', 'capacity' => 1, 'price_per_night' => 900.00, 'description' => 'Cozy private room with a single bed and fan.'],
            ['room_number' => 'P-202', 'room_type' => 'Private Double', 'capacity' => 2, 'price_per_night' => 1300.00, 'description' => 'Private room with a double bed, ideal for couples.'],
            ['room_number' => 'T-301', 'room_type' => 'Twin Room', 'capacity' => 2, 'price_per_night' => 1200.00, 'description' => 'Two single beds, air-conditioned, great for friends.'],
            ['room_number' => 'F-401', 'room_type' => 'Family Room', 'capacity' => 5, 'price_per_night' => 2200.00, 'description' => 'Spacious room for families, with extra bedding available.'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
