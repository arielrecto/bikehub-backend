<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'user_id',
        'destination',
        'meetup_location'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function participants(){
        return $this->hasMany(RideBuddy::class);
    }
}
