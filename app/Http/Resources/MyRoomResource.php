<?php

namespace App\Http\Resources;

use App\Http\Resources\rooms\CollectionRoomResource;
use App\Models\SiteVariables;
use Illuminate\Http\Resources\Json\JsonResource;

class MyRoomResource extends JsonResource
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

        if($this->rateAverage == 0){
            $rateTitle = 'Ordinary';
            $rateName='bronz';

        }elseif ($this->rateAverage<3.5){
            $rateName = 'bronz';
        }else{
            $rateName = $this->rateAverage<4.5 ? 'silver':'gold';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $img ? $img->path : '',
            'price' => $this->price,
            'max_person' => $this->max_person,
            'min_person' => $this->min_person,
            'game_time' => $this->game_time,
            'hardness' => $this->hardness,
            'type' => $this->type,
            'collection' => [
                'name' => $this->collection->title,
                'image' => $collectionMedia?$collectionMedia->path:'',
            ],
            'rates' => [
                'rateTitle'=>$rateTitle,
                'rateName'=>$rateName,
                'rateDescription'=>$rateDescription,
                'total' => $this->rate_percent,
                'rate_count' => $this->rates->count(),
                'rate_average' => $this->rateAverage,
                'items' => [
                     [
                        'value' => $this->rates->avg('scariness'),
                        'title' =>$this->rateTitle('rate_scariness'),
                    ],
                    [
                        'value' => $this->rates->avg('room_decoration'),
                        'title' =>$this->rateTitle('rate_room_decoration'),
                    ],
                    [
                        'value' => $this->rates->avg('hobbiness'),
                        'title' =>$this->rateTitle('rate_hobbiness'),
                    ],
                    [
                        'value' => $this->rates->avg('creativeness'),
                        'title' =>$this->rateTitle('rate_creativeness'),
                    ],
                    [
                        'value' => $this->rates->avg('mysteriness'),
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
