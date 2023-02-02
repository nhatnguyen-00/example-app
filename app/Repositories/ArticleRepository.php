<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Base\Repository;

class ArticleRepository extends Repository
{
    public function model(): string
    {
        return Article::class;
    }

    public function getByAuthor(User $author): LengthAwarePaginator
    {
        return $author->articles()->paginate(config('config.limit'));
    }
}
