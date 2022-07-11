<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Likes extends JsonResource
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
            'count' => $this->count,
            'user_id' => $this->user_id,
//            'post_id' => $this->post_id,
        ];


    }

//    public function with($request) {
//        return [
//            'version' => '1.0.0',
//            'author_url' => url('http://traversymedia.com')
//        ];
//    }
}
