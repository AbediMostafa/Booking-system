<?php

namespace App\Http\Resources\Rooms;

use App\Http\Resources\rooms\CollectionRoomResource;
use App\Models\SiteVariables;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomDescriptionResource extends JsonResource
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
        $teaser = $this->medias()->where('place', 'video')->first();

        $collectionMedia = $this->collection->medias()->first();
        $this->rateTitles = SiteVariables::where('variable', 'like', '%rate_%')->get();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $img ? $img->path : '',
            'banner' => $banner ? $banner->path : '',
            'teaser'=>$teaser ? $teaser->path:'',
            'price' => $this->price,
            'max_person' => $this->max_person,
            'min_person' => $this->min_person,
            'game_time' => $this->game_time,
            'hardness' => $this->hardness,
            'is_special' => $this->is_special,
            'is_new' => $this->is_new,
            'has_discount' => $this->discount,
            'type' => $this->type,
            'contact_infos' => [
                'phone' => $this->phone,
                'mobile' => $this->mobile,
                'address' => $this->address,
                'website' => $this->website,
            ],
            'collection' => [
                'name' => $this->collection->title,
                'image' => $collectionMedia?$collectionMedia->path:'',
                'rooms' => CollectionRoomResource::collection(
                    $this->collection
                    ->rooms()
                    ->where('id', '!=', $this->id)
                    ->get()
                ),
            ],
            'rates' => [
                'total' => $this->rate_percent,
                'rate_count' => $this->rates->count(),
                'rate_average' => $this->rateAverage,
                'items' => [
                    'scariness' => [
                        'value' => $this->rates->avg('scariness') * 100 / 5,
                        'title' =>$this->rateTitle('rate_scariness'),
                    ],
                    'room_decoration' => [
                        'value' => $this->rates->avg('room_decoration') * 100 / 5,
                        'title' =>$this->rateTitle('rate_room_decoration'),
                    ],
                    'hobbiness' => [
                        'value' => $this->rates->avg('hobbiness') * 100 / 5,
                        'title' =>$this->rateTitle('rate_hobbiness'),
                    ],
                    'creativeness' => [
                        'value' => $this->rates->avg('creativeness') * 100 / 5,
                        'title' =>$this->rateTitle('rate_creativeness'),
                    ],
                    'mysteriness' => [
                        'value' => $this->rates->avg('mysteriness') * 100 / 5,
                        'title' =>$this->rateTitle('rate_mysteriness'),
                    ],
                ],
            ],
        ];
    }

    public function rateTitle($title)
    {
        return $this->rateTitles->where('variable', $title)->first()->value;

    }
}
