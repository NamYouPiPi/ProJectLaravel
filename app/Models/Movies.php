<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;

    protected $fillable = [
          'title',
        'duration_minutes',
        'director',
        'description',
        'language',
        'poster',
        'trailer',
        'release_date',
        'status',
        'classification_id',
        'genre_id',
        'supplier_id'
    ];




    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function showtimes()
    {
        return $this->hasMany(Showtimes::class, 'movie_id');
    }


}
