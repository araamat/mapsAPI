<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Lubab postituse haldamist (edit, delete) ainult autorile või adminile.
     */
    public function manage(User $user, Post $post): bool
    {
        return $user->is_admin || $user->id === $post->user_id;
    }
}
