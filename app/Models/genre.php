<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genre extends Model
{
    use HasFactory;
    protected $fillable= [
        'main_genre',
        'sub_genre',
        'description',
        'status',
    ];
}
