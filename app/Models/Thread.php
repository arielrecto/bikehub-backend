<?php

namespace App\Models;

use App\Models\Traits\HasUpvotes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, HasUpvotes;


    protected $fillable = [
        'title',
        'content',
        'media',
        'media_type',
        'user_id',
        'status'
    ];

    protected $with = ['user'];
    protected $appends = ['is_upvoted_by_user'];
    protected $withCount = ['upvotes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function tags()
    {
        return $this->hasMany(ThreadTag::class)->with(['tag']);
    }
}
