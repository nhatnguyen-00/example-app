<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\User;

class BookmarkRepository extends Repository
{
    public function model(): string
    {
        return Bookmark::class;
    }

    public function bookmark(User $user, Article $article): Bookmark
    {
        $bookmark = $this->findBookmarkByArticle($user, $article);
        if (is_null($bookmark)) {
            $bookmark = $this->store($user->id, $article->id, Bookmark::BOOKMARK_STATUS);
        } else {
            $bookmark = $this->update($bookmark, Bookmark::BOOKMARK_STATUS);
        }

        return $bookmark;
    }

    public function unBookmark(User $user, Article $article): Bookmark
    {
        $bookmark = $this->findBookmarkByArticle($user, $article);
        if (is_null($bookmark)) {
            $bookmark = $this->store($user->id, $article->id, Bookmark::UN_BOOKMARK_STATUS);
        } else {
            $bookmark = $this->update($bookmark, Bookmark::UN_BOOKMARK_STATUS);
        }

        return $bookmark;
    }

    protected function findBookmarkByArticle(User $user, Article $article): ?Bookmark
    {
        $bookmark = $article->bookmarks()->where('user_id', $user->id)->first();

        return $bookmark;
    }

    protected function store(int $userId, int $articleId, int $status): Bookmark
    {
        $bookmark = $this->model->create([
            'user_id' => $userId,
            'article_id' => $articleId,
            'status' => $status,
        ]);

        return $bookmark;
    }

    protected function update(Bookmark $bookmark, int $status): Bookmark
    {
        if ($bookmark->status !== $status) {
            $bookmark->status = $status;
            $bookmark->save();
        }

        return $bookmark;
    }
}
