<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'media',
        'media_type',
        'user_id'
    ];

    protected $with = ['user'];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function tags(){
        return $this->hasMany(ThreadTag::class)->with(['tag']);
    }
}
