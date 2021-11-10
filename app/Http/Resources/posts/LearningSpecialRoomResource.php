<?php

namespace App\Http\Resources\posts;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningSpecialRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $media = $this->mediaType()->first();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'image'=>$media?$media->path:'',
            'district'=>$this->district,
            'min_person'=>$this->min_person,
            'max_person'=>$this->max_person,
            'game_time'=>$this->game_time,
            'price'=>$this->price,
            'hardness'=>$this->hardness,
            'collection'=>[
                'title'=>$this->collection->title
            ],
        ];
    }
}
