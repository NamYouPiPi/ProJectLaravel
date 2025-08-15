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
       'item_name',
        'category',
        'quantity',
        'unit',
        'cost_price',
        'sale_price',
        'stock_level',
        'reorder_level',
        'stock',
        'image',
        'status',
    ];
    public function Supplier()
    {
    return $this->belongsTo(Supplier::class);
    }
    public function connection_sale()
    {
        return $this->hasMany(connection_sale::class , 'inventory_id');
    }
}
