<?php

namespace App\Http\Resources;

use App\Http\Resources\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class Room extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            'image'=> $this->image,
            'banner'=> $this->banner,
            'is_special'=> $this->is_special,
            'type'=> $this->type,
            'description'=> $this->description,
            'district'=> $this->district,
            'collection'=>Collection::collection($this->collection),
            'rate'=>$this->rates,
        ];
    }
}
