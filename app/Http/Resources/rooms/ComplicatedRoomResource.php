<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplicatedRoomResource extends JsonResource
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
        return [
            'id' => $this->id,
            'image' => $img ? $img->path : '',
            'name' => $this->name,
            'district' => $this->district,
            'collectionName' => $this->collection ? $this->collection->title : '',
            'rate_percent'=>$this->rate_percent,
            'min_person'=>$this->min_person,
            'max_person'=>$this->max_person,
            'game_time'=>$this->game_time,
            'hardness'=>$this->hardness,
            'price'=>$this->price,
            'rates_count'=>$this->rates_count
        ];
    }
}
