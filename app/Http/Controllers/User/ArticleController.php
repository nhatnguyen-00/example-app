<?php

namespace App\Http\Controllers\User;

use App\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Requests\ArticleStoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Models\Article;
use App\Http\Requests\ArticleUpdateRequest;

class ArticleController extends Controller
{

    protected ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index(): JsonResponse
    {
        $articles = $this->articleRepository->getByAuthor(auth()->user());

        return responder()->getPaginator($articles, ArticleResource::class);
    }

    public function store(ArticleStoreRequest $request): JsonResponse
    {
        $article = DB::transaction(function () use ($request) {
            return $this->articleRepository->store($request);
        });

        $resource = new ArticleResource($article);

        return responder()->getSuccess($resource);
    }

    public function show(Article $article): JsonResponse
    {
        $article = $this->articleRepository->show($article);

        $resource = new ArticleResource($article);

        return responder()->getSuccess($resource);
    }

    public function update(ArticleUpdateRequest $request, Article $article): JsonResponse
    {
        $article = DB::transaction(function () use ($request, $article) {
            return $this->articleRepository->update($request, $article);
        });

        $resource = new ArticleResource($article);

        return responder()->getSuccess($resource);
    }

    public function destroy(Article $article): JsonResponse
    {
        $article->delete();

        return responder()->getSuccess();
    }
}
