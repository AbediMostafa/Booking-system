<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomForRoomPageResource extends JsonResource
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
            'name'=>$this->name,
            'description'=>$this->description,
            'image'=>$this->image,
            'banner'=>$this->banner,
            'price'=>$this->price,
            'max_person'=>$this->max_person,
            'min_person'=>$this->min_person,
            'game_time'=>$this->game_time,
            'hardness'=>$this->hardness,
            'type'=>$this->type,
            'phone'=>$this->phone,
            'mobile'=>$this->mobile,
            'address'=>$this->address,
            'collection'=>[
                'name'=>$this->collection->title,
                'image'=>$this->collection->image,
                'rooms'=>$this->collection->rooms()->select('name', 'district')->get()
            ],
            'rates'=>[
                'total'=>$this->rate_percent,
                'scariness'=>$this->rates->avg('scariness')*100/5,
                'room_decoration'=>$this->rates->avg('room_decoration')*100/5,
                'hobbiness'=>$this->rates->avg('hobbiness')*100/5,
                'creativeness'=>$this->rates->avg('creativeness')*100/5,
                'mysteriness'=>$this->rates->avg('mysteriness')*100/5,
            ],
        ];
    }
}
