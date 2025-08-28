<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory;
    protected  $fillable = [
         'hall_id',
        'seat_type_id',
        'seat_number',
        'seat_row',
        'status'
    ];

    public  function hall(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hall_cinema::class, 'hall_id');
    }
    public  function  seatType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Seat_type::class, 'seat_type_id');
    }

}
