<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Comment\CommentResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
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
        if ($this->relationLoaded('tags')) {
            $data['tags'] = TagResource::collection($this->tags);
        }
        if ($this->relationLoaded('author')) {
            $data['author'] = new UserResource($this->author);
        }
        if ($this->relationLoaded('comments')) {
            $data['comments'] = CommentResource::collection($this->comments);
        }

        return $data;
    }
}
