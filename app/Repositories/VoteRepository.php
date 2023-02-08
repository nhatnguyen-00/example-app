<?php

namespace App\Repositories;

use App\Models\Vote;
use App\Base\Repository;
use App\Models\Article;
use App\Models\User;

class VoteRepository extends Repository
{
    public function model(): string
    {
        return Vote::class;
    }

    public function upvote(User $user, Article $article): Vote
    {
        $vote = $this->findVoteByArticle($user, $article);
        if (is_null($vote)) {
            $vote = $this->store($user->id, $article->id, Vote::UPVOTE);
        } else {
            $vote = $this->update($vote, Vote::UPVOTE);
        }

        return $vote;
    }

    public function downvote(User $user, Article $article): Vote
    {
        $vote = $this->findVoteByArticle($user, $article);
        if (is_null($vote)) {
            $vote = $this->store($user->id, $article->id, Vote::DOWNVOTE);
        } else {
            $vote = $this->update($vote, Vote::DOWNVOTE);
        }

        return $vote;
    }

    public function resetVote(User $user, Article $article): Vote
    {
        $vote = $this->findVoteByArticle($user, $article);
        if (is_null($vote)) {
            $vote = $this->store($user->id, $article->id, Vote::DEFAULT_VOTE);
        } else {
            $vote = $this->update($vote, Vote::DEFAULT_VOTE);
        }

        return $vote;
    }

    protected function findVoteByArticle(User $user, Article $article): ?Vote
    {
        $vote = $article->votes()->where('user_id', $user->id)->first();

        return $vote;
    }

    protected function store(int $userId, int $articleId, int $value): Vote
    {
        $vote = $this->model->create([
            'user_id' => $userId,
            'article_id' => $articleId,
            'value' => $value,
        ]);

        return $vote;
    }

    protected function update(Vote $vote, int $value): Vote
    {
        if ($vote->value !== $value) {
            $vote->value = $value;
            $vote->save();
        }

        return $vote;
    }
}
