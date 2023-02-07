<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Repositories\BookmarkRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{
    protected BookmarkRepository $bookmarkRepository;

    public function __construct(BookmarkRepository $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    public function bookmark(Request $request, Article $article)
    {
        DB::transaction(function () use ($request, $article) {
            return $this->bookmarkRepository->bookmark($request->user(), $article);
        });

        return responder()->getSuccess();
    }

    public function unBookmark(Request $request, Article $article)
    {
        DB::transaction(function () use ($request, $article) {
            return $this->bookmarkRepository->unBookmark($request->user(), $article);
        });

        return responder()->getSuccess();
    }
}
