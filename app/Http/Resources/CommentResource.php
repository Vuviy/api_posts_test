<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
            'id' => $this->id,
            'author' => $this->user->name,
            'text' => $this->text,
            'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'post_id' => $this->commentable_id,
            'created_at' => $this->created_at,
            ];
    }
}
