<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeShopService extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'price',
        'bike_shop_id',
    ];


    public function shop(){
        return $this->belongsTo(BikeShop::class);
    }
}
