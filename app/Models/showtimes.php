<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class showtimes extends Model
{
    use HasFactory;

    protected $table = 'showtimes'; // Ensure this matches your table name

    protected $fillable = [
        'movie_id',
        'hall_id',
        'start_time',
        'end_time',
        'status',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationship to Movie
    public function movie()
    {
        return $this->belongsTo(Movies::class, 'movie_id');
    }

    // Relationship to Hall
    public function hall()
    {
        return $this->belongsTo(Hall_cinema::class, 'hall_id'); // Adjust if Hall model is named differently
    }
}
