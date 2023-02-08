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
        $comment = $article->comments()
            ->create($request->only(['content', 'author_id', 'parent_id']))
            ->load(['author:id,name,email']);

        return $comment;
    }

    public function update(Request $request, Comment $comment): Comment
    {
        $comment = $comment->fill($request->only(['content']));
        $comment->save();

        return $comment;
    }
}
