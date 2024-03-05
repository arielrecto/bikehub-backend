<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideBuddy extends Model
{
    use HasFactory;


    protected $fillable = [
        'ride_id',
        'participant_id'
    ];


    public function ride(){
        return $this->belongsTo(Ride::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
