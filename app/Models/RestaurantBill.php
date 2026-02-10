<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantBill extends Model
{
    protected $fillable = [
        'transaction_id',
        'user_id',
        'item_name',
        'quantity',
        'unit_price',
        'total_price',
        'status',
        'notes',
        'ordered_at',
        'completed_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the transaction associated with the bill
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the user who created the bill
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

