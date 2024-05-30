<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Upvote extends MorphPivot
{
    //

    protected $fillable = [
    'user_id'
    ];

    protected $table = 'upvotes';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function upvoteable(){
        return $this->morphTo();
    }
}
