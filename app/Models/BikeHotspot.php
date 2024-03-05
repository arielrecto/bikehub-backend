<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeHotspot extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'location',
        'image',
        'uploader_id'
    ];


    public function uploader(){
        return $this->belongsTo(User::class);
    }
}
