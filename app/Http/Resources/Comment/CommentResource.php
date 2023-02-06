<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        if ($this->relationLoaded('comments')) {
            $data['comments'] = CommentResource::collection($this->comments);
        }
        if ($this->relationLoaded('author')) {
            $data['author'] = new UserResource($this->author);
        }

        return $data;
    }
}
