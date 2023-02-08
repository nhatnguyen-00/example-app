<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Repositories\BookmarkRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Bookmark\BookmarkResource;

class BookmarkController extends Controller
{
    protected BookmarkRepository $bookmarkRepository;

    public function __construct(BookmarkRepository $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    public function bookmark(Request $request, Article $article): JsonResponse
    {
        DB::transaction(function () use ($request, $article) {
            return $this->bookmarkRepository->bookmark($request->user(), $article);
        });

        return responder()->getSuccess();
    }

    public function unBookmark(Request $request, Article $article): JsonResponse
    {
        DB::transaction(function () use ($request, $article) {
            return $this->bookmarkRepository->unBookmark($request->user(), $article);
        });

        return responder()->getSuccess();
    }

    public function listByUser(Request $request): JsonResponse
    {
        $bookmarks = $this->bookmarkRepository->listByUser($request->user());

        return responder()->getPaginator($bookmarks, BookmarkResource::class);
    }
}
