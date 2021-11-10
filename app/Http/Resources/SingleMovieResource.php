<?php

namespace App\Http\Resources;

use App\Http\Resources\posts\LearningSpecialRoomResource;
use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleMovieResource extends JsonResource
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
            'ادمین' : $this->user->name;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $image ? $image->path : '',
            'video' => $video ? $video->path : '',
            'user' => $user,
            'date' => \Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y'),
            'tags'=>$this->tags()->select('id', 'name')->get()
        ];
    }
}
