<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Room;
use App\Models\RoomStatus;
use Carbon\Carbon;

$today = Carbon::today()->toDateString();

// Clear existing data for today
RoomStatus::whereDate('date', $today)->delete();

// Get first 5 rooms
$rooms = Room::limit(5)->get();
$statuses = ['normal_checkout', 'early_checkin', 'early_checkout', 'late_checkout', 'booked'];

foreach ($rooms as $index => $room) {
    RoomStatus::create([
        'room_id' => $room->id,
        'date' => $today,
        'status' => $statuses[$index % 5],
        'booking_id' => null
    ]);
}

echo "✓ Sample room statuses created for today with all 5 colors!\n";
echo "  - Green: Normal CheckOut\n";
echo "  - Yellow: Early CheckIn\n";
echo "  - Light Blue: Early CheckOut\n";
echo "  - Red: Late CheckOut\n";
echo "  - Pink: Booked\n";
