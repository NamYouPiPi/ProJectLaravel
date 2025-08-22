<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
protected $fillable = [
    'name',
    'email',
    'phone',
    'age',
    'address',
    'gender',
    'dob',
    'hire_date',
    'termination_date',
    'status',
    'salary',
    'position'
];
}
