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
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->mediaType()->first();
        $video = $this->mediaType('video')->first();
        $user = $this->user->type === 'admin' || $this->user->type === 'manager' ?

        return [
            'post' => [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'image' => $image ? $image->path : '',
                'video' => $video ? $video->path : '',
                'user' => $user,
            ],
            'tags'=>$this->tags()->select('id', 'name')->get(),
            'special_rooms'=> LearningSpecialRoomResource::collection(Room::where('is_special', 1)->whereDisabled(0)->get())
        ];
    }
}
