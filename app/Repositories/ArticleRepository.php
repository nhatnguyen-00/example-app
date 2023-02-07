<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Base\Repository;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;
use App\Models\Comment;

class ArticleRepository extends Repository
{

    protected TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;

        parent::__construct();
    }

    public function model(): string
    {
        return Article::class;
    }

    public function getByAuthor(User $author): LengthAwarePaginator
    {
        return $author->articles()->paginate(config('config.limit'));
    }

    public function store(Request $request): Article
    {
        /** @var Article $article */
        $article = $this->model->create($request->only(['title', 'content', 'status', 'author_id']));

        $tagsName = $request->get('tags');
        $this->tagRepository->insertIfNotExists($tagsName);

        $tagsId = $this->tagRepository->findTagByNames($tagsName)->pluck('id');
        $article->tags()->attach($tagsId);

        return $article;
    }

    public function show(Article $article): Article
    {
        return $article->load([
            'comments' => function ($query) {
                return $query->where('parent_id', Comment::PARENT_COMMENT_DEFAULT)
                    // max 3 generations
                    ->with('children.children.children');
            }
        ]);
    }

    public function update(Request $request, Article $article): Article
    {
        $article->tags()->detach();
        $article = $article->fill($request->only(['title', 'content', 'status', 'author_id']));
        $article->save();

        $tagsName = $request->get('tags');
        $this->tagRepository->insertIfNotExists($tagsName);

        $tagsId = $this->tagRepository->findTagByNames($tagsName)->pluck('id');
        $article->tags()->attach($tagsId);

        return $article;
    }
}
