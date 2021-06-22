<?php

namespace App\Http\Resources\Rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class apiCommentsforRoom extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $roomId = $this->commentable->id;
        return [
            'id'=>$this->id,
            'body' => $this->body,
            'up_rate' => $this->up_rate,
            'down_rate' => $this->down_rate,
            'status' => $this->status,
            'user' => [
                'name' => $this->user->name,
                'rate' =>$this->user->rates()->where('room_id', $roomId)->first()
            ],
        ];
    }
}
