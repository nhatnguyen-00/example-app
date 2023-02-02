<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;

class ArticleRepository
{
    public function model(): string
    {
        return Article::class;
    }

    public function getByAuthor(User $author)
    {
        return $author->articles()->pagination(6);
    }
}
