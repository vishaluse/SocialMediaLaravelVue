<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Likes as LikeResource;


class Posts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'body' => $this->body,
            'user_id' => $this->user_id,
            'image' => $this->image,
            'created_at' =>  $this->created_at->diffForHumans(),
            'like' => LikeResource::collection($this->likes),
        ];


    }

}
