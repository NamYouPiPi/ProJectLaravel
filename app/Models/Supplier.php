<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Supplier extends Model
{
    use HasFactory;
//    protected $table = 'suppliers';
    protected $fillable = [
       'name',
        'email',
        'phone',
        'address',
        'contact_person',
        'supplier_type',
        'status',
    ];
    public function inventory()
    {
    return $this->hasMany(Inventory::class);
    }
    public function movies()
    {
        return $this->hasMany(Movies::class);
    }


}
