<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class AdminUpdateRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $img = $this->medias()->where('place', 'front')->first();
        $banner = $this->medias()->where('place', 'banner')->first();
        $video = $this->medias()->where('place', 'video')->first();

        $startedAt = $this->discount ?
            Jalalian::forge($this->discount->started_at)->format('Y/m/d') : '';

        $endedAt = $this->discount ?
            Jalalian::forge($this->discount->ended_at)->format('Y/m/d') : '';


        return [
            'room' => [
                'id' => $this->id,
                'name' => $this->name,
                'game_time' => $this->game_time,
                'price' => $this->price,
                'hardness' => $this->hardness,
                'min_person' => $this->min_person,
                'max_person' => $this->max_person,
                'phone' => $this->phone,
                'mobile' => $this->mobile,
                'address' => $this->address,
                'district' => $this->district,
                'description' => $this->description,
                'is_special' => $this->is_special ? 1 : 0,
                'is_new' => $this->is_new ? 1 : 0,
                'collection_id' => $this->collection_id,
                'city_id' => $this->city_id,
            ],
            'hasDiscount' => $this->discount ? true : false,
            'discount' => [
                'amount' => $this->discount ? $this->discount->amount : '',
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
            ],
            'medias' => [
                'front' => [
                    'background' => $img ? $img->path : '',
                    'id' => $img ? $img->id : '',
                    'place' => $img ? $img->place : '',
                    'type' => $img ? $img->type : '',
                ],
                'banner' => [
                    'background' => $banner ? $banner->path : '',
                    'id' => $banner ? $banner->id : '',
                    'place' => $banner ? $banner->place : '',
                    'type' => $banner ? $banner->type : '',
                ],
                'video' => [
                    'background' => $video ? $video->path : '',
                    'id' => $video ? $video->id : '',
                    'place' => $video ? $video->place : '',
                    'type' => $video ? $video->type : '',
                ],
            ]
        ];
    }
}
