<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;
    protected  $fillable= [
        'title',
        'duration_minnutes',
        'description',
        'author',
        'rating',
        'language',
        'poster_url',
        'trailer_url',
        'release_date',
        'status',
        'classification_id',
        'genre_id',
        'supplier_id'
    ];
    public function Classification(){
        return $this->belongsTo(Classification::class);
    }
    public function genre(){
        return $this->belongsTo(genre::class);
    }
    public function Supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
