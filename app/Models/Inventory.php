<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';
    protected $fillable = [
       'supplier_id',
        'item_type',
        'item_name',
        'quantity',
        'unit_price',
    ];
    public function supplier():HasMany
    {
    return $this->hasMany(Supplier::class);
    }
}
