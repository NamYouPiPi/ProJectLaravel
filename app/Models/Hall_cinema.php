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
}
