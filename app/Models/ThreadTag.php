<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'tag_id'
    ];



    public function tag(){
        return $this->belongsTo(Tag::class);
    }
    public function thread(){
        return $this->belongsTo(Thread::class);
    }
}
