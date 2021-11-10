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
            $rateTitle = 'معمولی';
            $rateName='bronz';
            $rateDescription='هنوز نظری برای این اتاق ثبت نشده است';

        }elseif ($this->rateAverage<3.5){
            $rateTitle = 'برنزی';
            $rateName = 'bronz';
            $rateDescription='اتاق هایی که مجموع نظرهای ثبت شده برای آنها کمتر از 3.5 باشد در دسته اتاق های برنزی قرار می گیرند';
        }else{
            $rateTitle = $this->rateAverage<4.5 ? 'نقره ای':'طلایی';
            $rateName = $this->rateAverage<4.5 ? 'silver':'gold';
            $rateDescription=$this->rateAverage<4.5?
                'اتاق هایی که مجموع نظرهای ثبت شده برای آنها بیشتر از 3.5 و کمتر از 4.5 باشد در دسته اتاق های نقره ای قرار می گیرند':
                'اتاق هایی که مجموع نظرهای ثبت شده برای آنها بیشتر از 4.5 باشد در دسته اتاق های طلایی قرار می گیرند';
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
