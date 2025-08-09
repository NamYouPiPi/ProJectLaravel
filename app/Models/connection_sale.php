<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class connection_sale extends Model
{
    use HasFactory;
protected  $fillable =[
    'quantity',
    'price',
    'total_price',
    'inventory_id',
];
public function Inventory(){
    return $this->belongsTo(Inventory::class, 'inventory_id');
}
}
