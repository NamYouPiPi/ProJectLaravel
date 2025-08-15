<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    protected  $fillable= [
        'code',
        'name',
        'country',
        'age_limit',
        'description',
        'status',
    ];
    public function Movies(){
        return $this->hasMany(Movies::class);
    }
}
