<?php

namespace App\Models;

use App\Models\Traits\HasUpvotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUpvotes;


    protected $fillable = [
        'content',
        'thread_id',
        'replied_id',
        'user_id'
    ];


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inReplyTo()
    {
        return $this->belongsTo(Comment::class, 'replied_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'replied_id');
    }
}
