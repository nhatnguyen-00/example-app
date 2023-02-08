<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Repositories\VoteRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    protected VoteRepository $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }

    public function upvote(Request $request, Article $article): JsonResponse
    {
        DB::transaction(function () use ($request, $article) {
            return $this->voteRepository->upvote($request->user(), $article);
        });

        return responder()->getSuccess();
    }

    public function downvote(Request $request, Article $article): JsonResponse
    {
        DB::transaction(function () use ($request, $article) {
            return $this->voteRepository->downvote($request->user(), $article);
        });

        return responder()->getSuccess();
    }

    public function resetVote(Request $request, Article $article): JsonResponse
    {
        DB::transaction(function () use ($request, $article) {
            return $this->voteRepository->resetVote($request->user(), $article);
        });

        return responder()->getSuccess();
    }
}
