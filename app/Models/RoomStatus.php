<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatus extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'date', 'status', 'booking_id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
