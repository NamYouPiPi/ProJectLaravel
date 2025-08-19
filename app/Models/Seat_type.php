<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat_type extends Model
{
    use HasFactory;
    protected  $fillable=[
        'name',
        'price',
        'status'
    ];
    public function seats()
    {
        return $this->hasMany(Seats::class, 'seat_type_id');
    }

}
