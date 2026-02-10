<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['room_id', 'room_type_id', 'created_by', 'status', 'remarks'];

    public function items()
    {
        return $this->hasMany(ComplaintItem::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
