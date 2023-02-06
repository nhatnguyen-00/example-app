<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(Request $request, Article $article)
    {
        $comment = DB::transaction(function () use ($request, $article) {
            return $this->commentRepository->store($request, $article);
        });

        $resource = new CommentResource($comment);

        return responder()->getSuccess($resource);
    }
}
