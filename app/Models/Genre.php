<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $fillable= [
        'main_genre',
        'sub_genre',
        'description',
        'status',
    ];
    public function movies(){
        return $this->hasMany(Movies::class);
    }
}
