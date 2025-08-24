<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'payment_reference',
        'payment_method',
        'payment_time',
        'amount_paid',
        'transaction_id',
        'gateway_response',
        'refund_amount',
        'status',
        'refund_reason',
    ];
    function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
