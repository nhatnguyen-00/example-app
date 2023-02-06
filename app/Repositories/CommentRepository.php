<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentRepository extends Repository
{
    public function model(): string
    {
        return Comment::class;
    }

    public function store(Request $request, Article $article): Comment
    {
        $comment = $article->comments()->create($request->all())->load(['author:id,name,email']);

        return $comment;
    }
}
