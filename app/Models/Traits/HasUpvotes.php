<?php

namespace App\Models\Traits;

use App\Models\Upvote;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasUpvotes
{

    public function upvotes(): MorphMany
    {
        return $this->morphMany(Upvote::class, 'upvoteable');
    }

    public function upvoters(): Builder
    {
        return User::whereHas('upvotes', function ($query) {
            $query->where('upvoteable_type', self::class)
                ->where('upvoteable_id', $this->id);
        });
    }

    public function queryUpvoteOf(int|User $user): MorphMany
    {
        return $this->upvotes()
            ->whereHas('user', function ($query) use ($user) {
                if ($user instanceof User) {
                    return $query->whereUserId($user->id);
                }

                return $query->whereUserId($user);
            });
    }


    public function upvoteOf(int|User $user): Upvote | null
    {
        return $this->queryUpvoteOf($user)->first();
    }

    public function wasUpvotedBy(int|User $user): bool
    {
        return $this->queryUpvoteOf($user)->exists();
    }

    public function toggleUpvoteBy(int|User $user): Upvote | Model
    {
        if ($this->wasUpvotedBy($user)) {
            $upvote = $this->upvoteOf($user);
            $upvote->delete();
            return $upvote;
        }

        $user_id = $user instanceof User ? $user->id : $user;
        $upvote = ($this->upvotes()->create(compact('user_id')));

        return $upvote;
    }
}
