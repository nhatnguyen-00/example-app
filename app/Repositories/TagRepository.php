<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository extends Repository
{
    public function model(): string
    {
        return Tag::class;
    }

    public function index(): Collection
    {
        return $this->model->get();
    }

    public function insertIfNotExists(array $names): void
    {
        $existingTags = $this->index()->pluck('name')->toArray();

        $diffTags = array_diff(
            array_map('strtolower', $names),
            array_map('strtolower', $existingTags)
        );

        foreach ($diffTags as $tagName) {
            $this->model->create(['name' => $tagName]);
        }
    }

    public function findTagByNames(array $names): Collection
    {
        return $this->model->whereIn('name', $names)->get();
    }

}
