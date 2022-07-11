<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;



class Profiles extends JsonResource
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
            'follower_id' => $this->follower_id,
            'following_id' => $this->following_id,
            'user_id' => $this->user_id,
        ];


    }

}
