<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'seat_id',
        'price',
        'status'
    ];

    /**
     * Get the booking that owns the seat.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the seat associated with the booking seat.
     */
    public function seat()
    {
        return $this->belongsTo(Seats::class, 'seat_id');
    }
}

