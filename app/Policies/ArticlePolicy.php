<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    public function show(User $user, Article $article): bool
    {
        return optional($user)->id === $article->author_id;
    }

    public function destroy(User $user, Article $article): bool
    {
        return optional($user)->id === $article->author_id;
    }
}
