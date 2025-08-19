<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall_cinema extends Model
{
    use HasFactory;
    protected  $fillable =[
        'cinema_name',
        'hall_location_id',
        'status',
        'total_seats',
        'hall_type'

    ];
    public function Hall_location(){
        return $this->belongsTo(Hall_location::class);
    }

   public function showtimes()
    {
        return $this->hasMany(Showtimes::class, 'hall_id');
    }
    public function seats()
    {
        return $this->hasMany(Seats::class, 'hall_id');
    }
}
