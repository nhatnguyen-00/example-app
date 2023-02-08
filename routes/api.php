<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\VoteController;
use App\Http\Controllers\User\BookmarkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'user'], function()
{
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function()
{
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'article', 'middleware' => 'auth:user'], function()
    {
        // article
        Route::get('/{article}', [ArticleController::class, 'show'])->middleware(['can:show,article']);
        Route::get('/', [ArticleController::class, 'index']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::put('/{article}', [ArticleController::class, 'update'])->middleware(['can:update,article']);
        Route::delete('/{article}', [ArticleController::class, 'destroy'])->middleware(['can:destroy,article']);

        // comment
        Route::group(['prefix' => '{article}/comment'], function()
        {
            Route::post('/', [CommentController::class, 'store']);
            Route::put('/{comment}', [CommentController::class, 'update'])->middleware(['can:update,comment']);
            Route::delete('/{comment}', [CommentController::class, 'destroy'])->middleware(['can:destroy,comment']);
        });

        // vote
        Route::group(['prefix' => '{article}'], function()
        {
            Route::post('upvote', [VoteController::class, 'upvote']);
            Route::post('downvote', [VoteController::class, 'downvote']);
            Route::post('reset-vote', [VoteController::class, 'resetVote']);
        });

        // bookmark article
        Route::group(['prefix' => '{article}'], function()
        {
            Route::post('bookmark', [BookmarkController::class, 'bookmark']);
            Route::post('un-bookmark', [BookmarkController::class, 'unBookmark']);
        });
    });

    Route::group(['prefix' => 'bookmark', 'middleware' => 'auth:user'], function () {
        Route::get('/', [BookmarkController::class, 'listByUser']);
    });
});
