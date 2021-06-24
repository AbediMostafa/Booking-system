<?php

namespace App\Http\Resources\Rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentComments extends JsonResource
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
            'id'=>$this->id,
            'body'=>$this->body,
            'up_rate'=>$this->up_rate,
            'down_rate'=>$this->down_rate,
            'created_at'=>$this->created_at,
            'user'=>$this->user->name,
        ];
    }
}
