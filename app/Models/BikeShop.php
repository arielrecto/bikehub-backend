<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeShop extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'location',
    ];



    public function services(){
        return $this->hasMany(BikeShopService::class);
    }
}
