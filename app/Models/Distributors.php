<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributors extends Model
{
    use HasFactory;
protected $fillable =[
    'name',
    'address',
    'email',
    'phone',
    'contract_start_date',
    'contract_end_date',
    'contract_amount',
    'commission_rate',
    'status',
    ];
}
