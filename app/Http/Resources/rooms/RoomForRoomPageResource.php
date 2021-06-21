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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'banner' => $this->banner,
            'price' => $this->price,
            'max_person' => $this->max_person,
            'min_person' => $this->min_person,
            'game_time' => $this->game_time,
            'hardness' => $this->hardness,
            'type' => $this->type,
            'contact_infos'=>[
                'phone' => $this->phone,
                'mobile' => $this->mobile,
                'address' => $this->address,
                'website' => $this->website,
            ],
            'collection' => [
                'title' => $this->collection->title,
                'image' => $this->collection->image,
                'rooms' => $this->collection->rooms()->select('name', 'district')->get()
            ],
            'rates' => [
                'total' => $this->rate_percent,
                'rate_count' => $this->rates->count(),
                'rate_average' => $this->rateAverage,
                'items' => [
                    'scariness' => [
                        'value' => $this->rates->avg('scariness') * 100 / 5,
                        'title' => 'درجه ترس',
                    ],
                    'room_decoration' => [
                        'value' => $this->rates->avg('room_decoration') * 100 / 5,
                        'title' => 'طراحی اتاق',
                    ],
                    'hobbiness' => [
                        'value' => $this->rates->avg('hobbiness') * 100 / 5,
                        'title' => 'سرگرمی',
                    ],
                    'creativeness' => [
                        'value' => $this->rates->avg('creativeness') * 100 / 5,
                        'title' => 'خلاقیت',
                    ],
                    'mysteriness' => [
                        'value' => $this->rates->avg('mysteriness') * 100 / 5,
                        'title' => 'داستانی',
                    ],
                ],
            ],
        ];
    }
}
