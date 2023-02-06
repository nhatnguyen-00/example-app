<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Comment;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(CommentStoreRequest $request, Article $article): JsonResponse
    {
        $comment = DB::transaction(function () use ($request, $article) {
            return $this->commentRepository->store($request, $article);
        });

        $resource = new CommentResource($comment);

        return responder()->getSuccess($resource);
    }

    public function update(CommentUpdateRequest $request, Article $article, Comment $comment): JsonResponse
    {
        $comment = $this->commentRepository->update($request, $comment);

        $resource = new CommentResource($comment);

        return responder()->getSuccess($resource);
    }
}
