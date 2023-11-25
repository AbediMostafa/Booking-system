<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminUpdateRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $img = $this->mediaType()->first();
        $banner = $this->mediaType('banner')->first();
        $video = $this->mediaType('video')->first();

        $genres = $this->genres()->select('id', 'title as text')->get();
        $tags = $this->tags()->select('id', 'name')->get();

        return [
            'room' => [
                'id' => $this->id,
                'name' => $this->name,
                'game_time' => $this->game_time,
                'price' => $this->price,
                'hardness' => $this->hardness,
                'min_person' => $this->min_person,
                'max_person' => $this->max_person,
                'lat' => $this->lat,
                'lon' => $this->lon,
                'room_order' => $this->room_order,
                'min_age' => $this->min_age,
                'phone' => $this->phone,
                'mobile' => $this->mobile,
                'address' => $this->address,
                'district' => $this->district,
                'description' => $this->description,
                'short_description' => $this->short_description,
                'is_special' => $this->is_special ? 1 : 0,
                'is_new' => $this->is_new ? 1 : 0,
                'collection_id' => $this->collection_id,
                'city_id' => $this->city_id,
                'hour_type_id' => '',
                'holiday_type_id' => '',
                'ticket_count'=>$this->ticket_count
            ],

            'selectedTags'=>$tags,
            'hour_type' => $this->hourType()->select('id', 'name as text')->first(),
            'holiday_type' => $this->holidayType()->select('id', 'name as text')->first(),
            'genreIds' => $genres->pluck('id'),
            'selectedGenres' => $genres,
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
