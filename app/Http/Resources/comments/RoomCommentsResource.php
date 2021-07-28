<?php

namespace App\Http\Resources\comments;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomCommentsResource extends JsonResource
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
        $userRate = $this->user
        ->rates()
        ->where('room_id', $roomId)
        ->first();

        return [
            'id'=>$this->id,
            'body' => $this->body,
            'up_rate' => $this->agreements()->whereStatus('agree')->count(),
            'down_rate' => $this->agreements()->whereStatus('disagree')->count(),
            'status' => $this->status,
            'room'=>$this->commentable->name,
            'roomId'=>$this->commentable->id,
            'date'=> \Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y'),
            'user' => [
                'name' => $this->user->name,
                'rate' => $userRate ? $userRate-> rateAveragePercent : 0
            ],
        ];
    }
}
