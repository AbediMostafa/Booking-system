<?php

namespace App\Http\Resources\posts;

use App\Http\Resources\rooms\SpecialRoomsResource;
use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;

class PostWithSpecialRoomResource extends JsonResource
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
            'post'=>[
                'id'=>$this->id,
                'title'=>$this->title,
                'description'=>$this->description,
                'image'=>$this->image,
                'user'=>$this->user->name,
                'date'=> \Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y'),
            ],
            'special_rooms'=> LearningSpecialRoomResource::collection(Room::where('is_special', 1)->get())
        ];
    }
}
