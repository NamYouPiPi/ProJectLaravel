<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class showtimes extends Model
{
    use HasFactory;

    /** allow create([...]) on these columns **/
    protected $fillable = [
        'movie_id',
        'hall_id',
        'start_time',
        'end_time',
        'base_price',
        'status',
        'is_active'
    ];
    protected $dates = [
        'start_time',
        'end_time',
    ];


    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movies::class);
    }
    public function hall(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hall_cinema::class);
    }
}
