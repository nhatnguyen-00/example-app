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
        $data = [
            'id' => $this->getKey(),
            'status' => $this->status,
            'title' => $this->title,
            'content' => $this->content,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        return $data;
    }
}
