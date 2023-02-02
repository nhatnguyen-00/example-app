<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Article;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Article $article */
        $article = $this->resource;
        $data = [
            'id' => $article->getKey(),
            'title' => $article->title,
            'content' => $article->content,
            'author_id' => $article->author_id,
        ];

        return parent::toArray($data);
    }
}
