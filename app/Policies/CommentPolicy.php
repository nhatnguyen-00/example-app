<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function update(User $user, Comment $comment): bool
    {
        return optional($user)->id === $comment->author_id;
    }

    public function destroy(User $user, Comment $comment): bool
    {
        return optional($user)->id === $comment->author_id;
    }
}
