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

        if($this->rateAverage == 0){
            $rateTitle = 'معمولی';
            $rateName='bronz';
            $rateDescription='هنوز نظری برای این اتاق ثبت نشده است، اولین نفری باشید که برای این اتاق نظر ثبت می کنید';

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
            'description' => $this->description,
            'shortDescription'=>$this->short_description,
            'image' => $img ? $img->path : '',
            'banner' => $banner ? $banner->path : '',
            'teaser'=>$teaser ? $teaser->path:'',
            'price' => $this->price,
            'max_person' => $this->max_person,
            'min_person' => $this->min_person,
            'lat'=>$this->lat,
            'lon'=>$this->lon,
            'room_order'=>$this->room_order,
            'min_age'=>$this->min_age,
            'game_time' => $this->game_time,
            'hardness' => $this->hardness,
            'is_special' => $this->is_special,
            'is_new' => $this->is_new,
            'reservable'=>$this->reservable,
            'has_discount' => $this->discount,
            'type' => $this->type,
            'genres'=>$this->genres()->pluck('title'),
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
                    ->whereDisabled(0)
                    ->where('id', '!=', $this->id)
                    ->get()
                ),
            ],
            'rates' => [
                'rateTitle'=>$rateTitle,
                'rateName'=>$rateName,
                'rateDescription'=>$rateDescription,
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
            'tags'=>$this->tags()->select('id', 'name')->get()
        ];
    }

    public function rateTitle($title)
    {
        return $this->rateTitles->where('variable', $title)->first()->value;

    }
}
