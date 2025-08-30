<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'showtime_id',
        'total_amount',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the booking.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the showtime associated with the booking.
     */
    public function showtime()
    {
        return $this->belongsTo(Showtimes::class, 'showtime_id');
    }

    /**
     * Get the seats for the booking.
     */
  public function seats()
{
    return $this->belongsToMany(\App\Models\Seats::class, 'booking_seats', 'booking_id', 'seat_id');
}
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
