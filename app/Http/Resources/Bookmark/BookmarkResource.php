<?php

namespace App\Http\Resources\Bookmark;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Article\ArticleResource;

class BookmarkResource extends JsonResource
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
            'id' => $this->id,
        ];
        if ($this->relationLoaded('article')) {
            $data['article'] = new ArticleResource($this->article);
        }

        return $data;
    }
}
